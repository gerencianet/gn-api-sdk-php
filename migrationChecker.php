<?php

/**
 * Certifique-se de inserir este arquivo na raiz do seu projeto, para que possa validar todos os arquivos
 * e de inserir corretamente o caminho para os arquivos do autoload do Composer na linha 55.
 */

namespace MyApp;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MigrationChecker
{
	private const REQUIRED_PACKAGES = [
		'guzzlehttp/guzzle' => '^7.4',
		'symfony/cache' => '^5.0 || ^6.0'
	];

	private const CORRECTIONS = [
		'use Gerencianet\Exception\GerencianetException;' => 'use Efi\Exception\EfiException;',
		'use Gerencianet\Gerencianet;' => 'use Efi\EfiPay;',
		'new Gerencianet' => 'new EfiPay',
		'Gerencianet::getInstance' => 'EfiPay::getInstance',
		'catch (GerencianetException' => 'catch (EfiException',
		'oneStep(' => 'createOneStepCharge(',
		'payCharge' => 'definePayMethod',
		'resendBillet' => 'sendBilletEmail',
		'chageLink' => 'defineLinkPayMethod',
		'createChargeBalanceSheet(' => 'defineBalanceSheetBillet(',
		'updateParcel' => 'updateCarnetParcel',
		'cancelParcel' => 'cancelCarnetParcel',
		'resendCarnet' => 'sendCarnetEmail',
		'resendParcel' => 'sendCarnetParcelEmail',
		'getPlans' => 'listPlans',
		'paySubscription' => 'defineSubscriptionPayMethod',
		'pixDevolutionGet' => 'pixDetailDevolution',
		'pixGetWebhook' => 'pixDetailWebhook',
		'pixLocationCreate' => 'pixCreateLocation',
		'pixLocationGet' => 'pixDetailLocation',
		'pixLocationDeleteTxid' => 'pixUnlinkTxidLocation',
		'pixListBalance' => 'getAccountBalance',
		'pixUpdateSettings' => 'updateAccountConfig',
		'pixListSettings' => 'listAccountConfig',
	];

	private $rootDirectory;
	private $composerJson;
	private $installedPackages;

	public function __construct()
	{
		// Insira abaixo o caminho para os arquivos composer.json e installed.json
		$this->rootDirectory = __DIR__;
		$this->composerJson = json_decode(file_get_contents($this->rootDirectory . '/composer.json'), true);
		$this->installedPackages = json_decode(file_get_contents($this->rootDirectory . '/vendor/composer/installed.json'), true);
	}

	public function checkPHPVersion(): array
	{
		$resultPhpVersion = [];
		$phpVersion = PHP_VERSION;
		$resultPhpVersion['version'] = $phpVersion;
		if (version_compare($phpVersion, '7.2.5', '<')) {
			$resultPhpVersion['result'] = "A versão do PHP instalada <b>NÃO ATENDE</b> aos requisitos. <b>Instale o PHP 7.2 ou superior</b>.";
			$resultPhpVersion['icon'] = $this->getIcon('danger');
		} else {
			$resultPhpVersion['result'] = "A versão do PHP instalada atende aos requisitos.";
			$resultPhpVersion['icon'] = $this->getIcon('success');
		}
		return $resultPhpVersion;
	}

	public function checkSDKInstallation(): array
	{
		$resultSdkInfo = [];
		foreach ($this->installedPackages['packages'] as $package) {
			if ($package['name'] === 'efipay/sdk-php-apis-efi' || $package['name'] === 'gerencianet/gerencianet-sdk-php') {
				$packageVersion = $package['version'];
				if ($package['name'] === 'efipay/sdk-php-apis-efi') {
					$resultSdkInfo['result'] = "<kbd>{$package['name']}: $packageVersion</kbd>";
					$resultSdkInfo['icon'] = $this->getIcon('success');
					return $resultSdkInfo;
				} else {
					$resultSdkInfo['result'] = "Atual: <kbd>{$package['name']}: $packageVersion</kbd><hr>Execute o comando abaixo para instalação da nova SDK da Efí:<br><kbd>composer require efipay/sdk-php-apis-efi</kbd>";
					$resultSdkInfo['icon'] = $this->getIcon('danger');
					return $resultSdkInfo;
				}
			}
		}

		if ($this->composerJson['name'] === 'efipay/sdk-php-apis-efi') {
			$resultSdkInfo['result'] = "<kbd class>{$this->composerJson['name']}: {$this->composerJson['version']}</kbd>";
			$resultSdkInfo['icon'] = $this->getIcon('success');
			return $resultSdkInfo;
		}

		return ['result' => '<p class="text-center">A SDK de PHP da Efí não está instalada.</p><hr>Execute o comando abaixo para instalação da nova SDK da Efí:<br><kbd>composer require efipay/sdk-php-apis-efi</kbd>', 'icon' =>  $this->getIcon('danger')];
	}

	private function getIcon($status): string
	{
		if ($status === 'success') {
			return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="green" class="bi bi-check-circle" viewBox="0 0 16 16">
			<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
			<path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
		  	</svg>';
		} else {
			return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" class="bi bi-x-circle" viewBox="0 0 16 16">
			<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
			<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
			</svg>';
		}
	}

	public function checkRequiredPackages(): array
	{
		$missingPackages = $this->getMissingPackages();
		if (empty($missingPackages)) {
			return ['result' => 'Todas as dependências necessárias estão instaladas.', 'icon' => $this->getIcon('success')];
		} else {
			$missingPackagesList = implode('<br>', $missingPackages);
			return ['result' => "<b>$missingPackagesList</b>", 'icon' => $this->getIcon('danger')];
		}
	}

	private function getMissingPackages(): array
	{
		$missingPackages = [];

		foreach (self::REQUIRED_PACKAGES as $package => $version) {
			$packageFound = false;

			foreach ($this->installedPackages['packages'] as $installedPackage) {
				if ($installedPackage['name'] === $package) {
					$installedVersion = $installedPackage['version'];

					// Check if the installed version matches any of the allowed versions
					$allowedVersions = explode(' || ', $version);
					$installedVersion = $this->addVersionPrefix($installedVersion); // Adicionar 'v' se necessário

					foreach ($allowedVersions as $allowedVersion) {
						$allowedVersion = $this->addVersionPrefix($allowedVersion); // Adicionar 'v' se necessário
						if (version_compare($installedVersion, $allowedVersion, '>=')) {
							$packageFound = true;
							break;
						}
					}
				}
			}

			if (!$packageFound) {
				$missingPackages[] = "$package:$version";
			}
		}

		return $missingPackages;
	}

	public function addVersionPrefix($version)
	{
		if (strpos($version, 'v') === false) {
			return 'v' . $version;
		}
		return $version;
	}

	public function checkCodeCorrections(): array
	{
		$corrections = $this->getCorrections();
		if (empty($corrections)) {
			return ['result' => '<p class="text-center">Não foram encontradas correções de código a serem feitas.</p>', 'icon' => $this->getIcon('success')];
		} else {
			$correctionsList = implode('<br>', $corrections);
			return  ['result' => "<p>Foram encontradas as seguintes correções de código a serem feitas:<p>$correctionsList", 'icon' => $this->getIcon('danger')];
		}
	}

	private function getCorrections(): array
	{
		$corrections = [];

		foreach ($this->getPhpFiles() as $filePath) {
			$filename = basename($filePath);

			if (
				strpos($filePath, 'vendor/') !== false || // Ignora arquivos na pasta vendor
				pathinfo($filename, PATHINFO_EXTENSION) !== 'php' || // Verifica extensão do arquivo
				$filename === 'migrationChecker.php' // Ignora arquivo migration_checker.php
			) {
				continue;
			}

			$content = file_get_contents($filePath);
			$lines = explode("\n", $content);

			foreach (self::CORRECTIONS as $incorrect => $correct) {
				$lineNumber = null;

				foreach ($lines as $index => $line) {
					if (strpos($line, $incorrect) !== false) {
						$lineNumber = $index + 1;
						break;
					}
				}

				if ($lineNumber !== null) {
					$corrections[] = "<div class='d-flex text-body-secondary'>
					<div class='pb-1 border-bottom w-100'>
							<span class='text-gray-dark'>Na linha <code>$lineNumber</code>, do arquivo: <code>$filePath</code>.</span>
							<span class='d-block'>Substituir <kbd>$incorrect</kbd> por <kbd>$correct</kbd></span>
						</div>
					</div>";
				}
			}
		}

		return $corrections;
	}

	private function getPhpFiles(): array
	{
		$phpFiles = [];
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->rootDirectory));
		foreach ($iterator as $file) {
			if ($file->isFile() && $file->getExtension() === 'php' && $file->getFilename() !== 'migration_checker.php') {
				$phpFiles[] = $file->getPathname();
			}
		}
		return $phpFiles;
	}
}
$checker = new MigrationChecker();
?>

<!doctype html>
<html lang="pt-br" data-bs-theme="auto">

<head>
	<script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="https://sejaefi.com.br/images/favicon/favicon-16x16.png">
	<meta name="description" content="Validador de Migração da SDK Efí">
	<meta name="author" content="Guilherme Cota">
	<title>SDK PHP Migration Checker</title>

	<link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<meta name="theme-color" content="#f37021">

	<style>
		/*
		* LOADING 
		*/
		body.loading:after {
			content: "";
			position: absolute;
			right: 0;
			top: 0;
			width: 100vw;
			height: 100vh;
			background: #242939;
		}

		body.loading:before {
			content: "";
			position: absolute;
			display: flex;
			width: 100vw;
			height: 100vh;
			align-content: center;
			justify-content: space-around;
			align-items: center;
			background: url('https://raw.githubusercontent.com/efipay/comunidade-discord-efi/main/assets/img/logo-efi-footer.svg') #242939 no-repeat center center;
			background-size: 130px;
			animation: flash 1s linear infinite;
			z-index: 9;
		}

		@keyframes flash {
			50% {
				opacity: 0;
			}
		}

		.hiddenOverflow {
			overflow: hidden;
		}

		/* /LOADING */

		.btn-bd-primary {
			--bd-violet-bg: #f37021;
			--bd-violet-rgb: 206, 101, 37;

			--bs-btn-font-weight: 600;
			--bs-btn-color: var(--bs-white);
			--bs-btn-bg: var(--bd-violet-bg);
			--bs-btn-border-color: var(--bd-violet-bg);
			--bs-btn-hover-color: var(--bs-white);
			--bs-btn-hover-bg: #dd6b26;
			--bs-btn-hover-border-color: #dd6b26;
			--bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
			--bs-btn-active-color: var(--bs-btn-hover-color);
			--bs-btn-active-bg: #ce6525;
			--bs-btn-active-border-color: #ce6525;
		}

		h1 {
			color: #f37021;
		}

		.btn-efi-primary {
			cursor: pointer;
			align-items: center;
			justify-content: center;
			border-radius: 0.8rem;
			--tw-bg-opacity: 1;
			background-color: rgb(0 128 157/1);
			padding: 10px 35px;
			font-weight: 400;
			letter-spacing: 0.5px;
			line-height: 2rem;
			--tw-text-opacity: 1;
			color: rgb(255 255 255/1);
			--tw-shadow: 0px 4px 24px rgba(0, 0, 0, .08), 0px 0px 4px rgba(0, 0, 0, .08), 0px 0px 16px rgba(0, 0, 0, .08);
			--tw-shadow-colored: 0px 4px 24px var(--tw-shadow-color), 0px 0px 4px var(--tw-shadow-color), 0px 0px 16px var(--tw-shadow-color);
			box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
			transition-duration: .15s;
			transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
			transition-timing-function: cubic-bezier(.4, 0, .2, 1);
		}

		.btn-efi-primary:hover {
			background-color: #006177;
			color: rgb(255 255 255/1);
		}

		.btn-efi-outline-primary {
			cursor: pointer;
			align-items: center;
			justify-content: center;
			border-radius: 0.8rem;
			--tw-bg-opacity: 1;
			background-color: rgb(255 255 255/1);
			padding: 10px 35px;
			font-weight: 400;
			letter-spacing: 0.5px;
			line-height: 2rem;
			--tw-text-opacity: 1;
			color: rgb(0 128 157/1);
			--tw-shadow: 0px 4px 24px rgba(0, 0, 0, .08), 0px 0px 4px rgba(0, 0, 0, .08), 0px 0px 16px rgba(0, 0, 0, .08);
			--tw-shadow-colored: 0px 4px 24px var(--tw-shadow-color), 0px 0px 4px var(--tw-shadow-color), 0px 0px 16px var(--tw-shadow-color);
			box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
			transition-duration: .15s;
			transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
			transition-timing-function: cubic-bezier(.4, 0, .2, 1);
		}

		.btn-efi-outline-primary:hover {
			background-color: #006177;
			color: rgb(255 255 255/1);
		}

		.b-divider {
			width: 100%;
			height: 3rem;
			background-color: rgba(0, 0, 0, .1);
			border: solid rgba(0, 0, 0, .15);
			border-width: 1px 0;
			box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
		}
	</style>

	<script>
		window.onload = function() {
			var html = document.querySelector('html');
			var body = document.querySelector('body');

			body.classList.remove("loading");
			html.classList.remove("hiddenOverflow");
		};
	</script>
</head>

<body class="loading hiddenOverflow">
	<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
		<symbol id="check2" viewBox="0 0 16 16">
			<path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
		</symbol>
		<symbol id="circle-half" viewBox="0 0 16 16">
			<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
		</symbol>
		<symbol id="moon-stars-fill" viewBox="0 0 16 16">
			<path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
			<path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
		</symbol>
		<symbol id="sun-fill" viewBox="0 0 16 16">
			<path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
		</symbol>
	</svg>

	<div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
		<button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
			<svg class="bi my-1 theme-icon-active" width="1em" height="1em">
				<use href="#circle-half"></use>
			</svg>
			<span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
		</button>
		<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
			<li>
				<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
					<svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
						<use href="#sun-fill"></use>
					</svg>
					Light
					<svg class="bi ms-auto d-none" width="1em" height="1em">
						<use href="#check2"></use>
					</svg>
				</button>
			</li>
			<li>
				<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
					<svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
						<use href="#moon-stars-fill"></use>
					</svg>
					Dark
					<svg class="bi ms-auto d-none" width="1em" height="1em">
						<use href="#check2"></use>
					</svg>
				</button>
			</li>
			<li>
				<button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
					<svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
						<use href="#circle-half"></use>
					</svg>
					Auto
					<svg class="bi ms-auto d-none" width="1em" height="1em">
						<use href="#check2"></use>
					</svg>
				</button>
			</li>
		</ul>
	</div>

	<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
		<symbol id="check" viewBox="0 0 16 16">
			<title>Check</title>
			<path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
		</symbol>
	</svg>

	<header>
		<nav class="container d-flex flex-wrap justify-content-center py-3 mb-2">
			<a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
				<img style="height: 40px;" src="https://dev.efipay.com.br/img/logo-efi-pay.svg" alt="Logo Efí Bank">
			</a>

			<div class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
				<a href="https://dev.efipay.com.br/" target="_blank" class="me-3 py-2 link-body-emphasis text-decoration-none">Documentação</a>
				<a href="https://comunidade.sejaefi.com.br/" target="_blank" class="me-3 py-2 link-body-emphasis text-decoration-none">Discord</a>
				<a href="https://github.com/efipay/" target="_blank" class="me-3 py-2 link-body-emphasis text-decoration-none">Github</a>
			</div>
		</nav>

		<div class="b-divider"></div>

		<div class="container pricing-header p-3 pb-md-4 mx-auto text-center">
			<h1>Validador de Migração SDK PHP</h1>
			<p class="fs-5 text-body-secondary">O Validador de Migração da SDK Efí Pay é uma ferramenta
				desenvolvida para facilitar o processo de atualização da sua integração com a nova SDK de PHP da Efí Pay.
				Essa ferramenta analisa o seu código existente em busca de padrões específicos relacionados a
				classes e métodos que foram modificados na nova versão da SDK.</p>
			<button type="button" class="btn btn-efi-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
				Mais detalhes
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
				</svg>
			</button>
			<a href="" onclick="location.reload()" class="btn btn-efi-outline-primary">
				Atualizar resultados <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 18 18">
					<path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
					<path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
				</svg>
			</a>
		</div>
	</header>

	<main class="container">
		<div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
			<div class="col">
				<div class="card mb-4 rounded-3 shadow-sm">
					<?php $resultPhp =  $checker->checkPHPVersion(); ?>
					<div class="card-header py-3">
						<h4 class="my-0 fw-normal">Versão do PHP <?php echo $resultPhp['version']  . ' ' . $resultPhp['icon']; ?></h4>
					</div>
					<div class="card-body">
						<?= $resultPhp['result'] ?>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card mb-4 rounded-3 shadow-sm">
					<?php $resultSdk =  $checker->checkSDKInstallation(); ?>
					<div class="card-header py-3">
						<h4 class="my-0 fw-normal">Versao da SDK <?= $resultSdk['icon'] ?></h4>
					</div>
					<div class="card-body text-cente">
						<?= $resultSdk['result']; ?>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card mb-4 rounded-3 shadow-sm">
					<?php $resultPackages =  $checker->checkRequiredPackages(); ?>
					<div class="card-header py-3">
						<h4 class="my-0 fw-normal">Dependências necessárias <?= $resultPackages['icon'] ?></h4>
					</div>
					<div class="card-body">
						<?= $resultPackages['result'] ?>
					</div>
				</div>
			</div>
		</div>

		<div class="card bg-body rounded shadow-sm border mb-4">
			<?php $resultCorrections =  $checker->checkCodeCorrections(); ?>
			<div class="card-header py-3 d-flex justify-content-between align-items-center">
				<h4 class="card-title my-0 fw-normal text-center flex-grow-1">Resultados <?= $resultCorrections['icon'] ?></h4>
			</div>


			<div class="p-3">
				<?= $resultCorrections['result'] ?>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-4 text-center" id="exampleModalLabel">Validador de migração</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<h5>Como Funciona:</h5>
						<ol>
							<li>
								<strong>Requisitos de Ambiente:</strong> Verifica se o seu ambiente atende aos requisitos
								necessários, como versão do PHP e pacotes instalados.
							</li>
							<li>
								<strong>Verificação de Código:</strong> Varre seus arquivos em busca de trechos de código
								que precisam ser atualizados de acordo com as novas convenções e estruturas da SDK.
							</li>
						</ol>

						<h5>Sobre a Execução do Validador:</h5>
						<ul>
							<li>
								Antes de usar o Validador de Migração, é importante compreender que sua execução não garante automaticamente o funcionamento perfeito da SDK em sua aplicação.
							</li>
							<li>
								O validador ajuda a identificar potenciais problemas de migração e oferece sugestões de correção, mas é essencial lembrar que cada aplicação é única e pode ter peculiaridades que não podem ser abordadas automaticamente.
							</li>
							<li>
								Após realizar as correções sugeridas, é altamente recomendado realizar testes extensivos em sua aplicação para validar o funcionamento adequado da SDK.
							</li>
						</ul>

						<h5>Backup Antes das Modificações:</h5>
						<ul>
							<li>
								Antes de realizar qualquer modificação no código de sua aplicação, é altamente aconselhável fazer um backup completo de todo o projeto.
							</li>
							<li>
								Modificações no código podem ter impactos imprevistos e é essencial ter uma cópia de segurança para restaurar caso algo não ocorra como esperado.
							</li>
							<li>
								Lembre-se de que as modificações de código são de responsabilidade do usuário e não nos responsabilizamos por quaisquer alterações feitas na aplicação.
							</li>
						</ul>

						<h5>Como Usar o Validador:</h5>
						<ol>
							<li>
								Certifique-se de inserir este arquivo <code>migrationChecker.php</code> no diretório raiz do seu projeto.
							</li>
							<li>
								Certifique-se de inserir corretamente o caminho para os arquivos <code>composer.json</code> e <code>installed.json</code>.
							</li>
							<li>
								Execute o Validador de Migração, que analisará seus arquivos em busca de problemas.
							</li>
							<li>
								Revise os resultados apresentados, identificando os trechos de código que precisam ser
								atualizados.
							</li>
							<li>
								Realize as correções recomendadas, seguindo as instruções exibidas.
							</li>
						</ol>
						<p>O Validador de Migração da SDK Efí Pay torna o processo de migração mais suave e <b>eficiente</b>,
							permitindo que você aproveite os novos recursos da SDK de forma mais rápida e segura.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-efi-primary px-5" data-bs-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>

		<script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
