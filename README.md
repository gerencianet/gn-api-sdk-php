<h1 align="center">SDK Gerencianet para PHP</h1>

![SDK Gerencianet para PHP](https://media-exp1.licdn.com/dms/image/C4D1BAQH9taNIaZyh_Q/company-background_10000/0/1603126623964?e=2159024400&v=beta&t=coQC_AK70vTYL3NdvbeIaeYts8nKumNHjvvIGCmq5XA)

<p align="center">
  <span><b>Português</b></span> |
  <a href="https://github.com/gerencianet/gn-api-sdk-php/blob/master/README-en.md">Inglês</a>
</p>

---

[![Última versão estável](http://poser.pugx.org/gerencianet/gerencianet-sdk-php/v)](https://packagist.org/packages/gerencianet/gerencianet-sdk-php)
[![Licença](http://poser.pugx.org/gerencianet/gerencianet-sdk-php/license)](https://packagist.org/packages/gerencianet/gerencianet-sdk-php)
[![Total de downloads](http://poser.pugx.org/gerencianet/gerencianet-sdk-php/downloads)](https://packagist.org/packages/gerencianet/gerencianet-sdk-php)
[![Build Status](https://travis-ci.org/gerencianet/gn-api-sdk-php.svg)](https://travis-ci.org/gerencianet/gn-api-sdk-php)
[![Code Climate](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/badges/gpa.svg)](https://codeclimate.com/github/gerencianet/gn-api-sdk-php)
[![Test Coverage](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/badges/coverage.svg)](https://codeclimate.com/github/gerencianet/gn-api-sdk-php/coverage)

SDK em PHP para integração com a API da Gerencianet.
Para mais informações sobre parâmetros e valores, consulte a documentação da [Gerencianet](http://gerencianet.com.br).

Ir para:
* [Requisitos](#requisitos)
* [Testado com](#testado-com)
* [Instalação](#instalação)
* [Começando](#começando)
  * [Como obter as credenciais Client_Id e Client_Secret](#como-obter-as-credenciais-client-id-e-client-secret)
  * [Como gerar um certificado Pix](#como-gerar-um-certificado-pix)
  * [Como converter um certificado Pix](#como-converter-um-certificado-pix)
  * [Como cadastrar as chaves Pix](#como-cadastrar-as-chaves-pix)
* [Executar exemplos](#executar-exemplos)
* [Guia de versão](#guia-de-versão)
* [Documentação Adicional](#documentação-adicional)
* [Licença](#licença)

---

## **Requisitos**
* PHP >= 7.2
* Guzzle >= 7.0
* Extensão ext-simplexml

## **Testado com**
```
PHP 7.2, 7.4 e 8.0
```

## **Instalação**
Clone este repositório e execute o seguinte comando para instalar as dependências
```
$ composer install
```

Se você já tem um projeto gerenciado com [Composer](https://getcomposer.org/), inclua a dependência em seu arquivo `composer.json`:
```
...
"require": {
  "gerencianet/gerencianet-sdk-php": "^4"
},
...
```

Ou baixe este pacote com [Composer](https://getcomposer.org/):
```
$ composer require gerencianet/gerencianet-sdk-php
```

## **Começando**
Requer o módulo e os namespaces:
```php
require __DIR__ . '/vendor/autoload.php';

use Gerencianet\Gerencianet;
```

Embora as respostas dos serviços da web estejam no formato json, a SDK converterá qualquer resposta do servidor em array. O código deve estar dentro de um try-catch, e podem ser tratadas da seguinte forma:

```php
try {
  /* code */
} catch(GerencianetException $e) {
  /* Gerencianet's api errors will come here */
} catch(Exception $ex) {
  /* Other errors will come here */
}
```

Para começar, você deve configurar os parâmetros no arquivo `config.json`. Instancie as informações `client_id`, `client_secret` para autenticação e `sandbox` igual a *true*, se seu ambiente for Homologação, ou *false*, se for Produção. Se você usa cobrança Pix, informe no atributo `pix_cert` o diretório relativo e o nome do seu certificado no formato .pem.

Veja exemplos de configuração a seguir:

### **Para ambiente de homologação**
Instancie os parâmetros do módulo usando client_id, client_secret, sandbox igual a `true` e pix_cert como o nome do certificado de homologação:
```php
$options = [
  'client_id' => 'client_id',
  'client_secret' => 'client_secret',
  'pix_cert' => '../certs/developmentCertificate.pem',
  'sandbox' => true,
  'debug' => false,
  'timeout' => 30
];

$api = new Gerencianet($options);
```

### **Para ambiente de produção**
Instancie os parâmetros do módulo usando client_id, client_secret, sandbox igual a `false` e pix_cert como o nome do certificado de produção:
```php
$options = [
  'client_id' => 'client_id',
  'client_secret' => 'client_secret',
  'pix_cert' => '../certs/productionCertificate.pem',
  'sandbox' => false,
  'debug' => false,
  'timeout' => 30
];

$api = new Gerencianet($options);
```

## **Como obter as credenciais Client-Id e Client-Secret**

### **Crie uma nova aplicação para usar a API Gerencianet:**
1. Acesse o painel da Gerencianet no menu **API**.
2. No canto esquerdo, clique em **Minhas Aplicações** depois em **Nova Aplicação**.
3. Insira um nome para a aplicação, ative a **API de emissões (Boletos e Carnês)** e **API Pix**, e escolha os escopos que deseja liberar em **Produção** e/ou **Homologação** conforme sua necessidade (lembrando que estes podem ser alterados posteriormente).
4. Clique em Criar **Nova aplicação**.

![Crie uma nova aplicação para usar a API Gerencianet](https://t-images.imgix.net/https%3A%2F%2Fapp-us-east-1.t-cdn.net%2F5fa37ea6b47fe9313cb4c9ca%2Fposts%2F603543ff4253cf5983339cf1%2F603543ff4253cf5983339cf1_88071.png?width=1240&w=1240&auto=format%2Ccompress&ixlib=js-2.3.1&s=2f24c7ea5674dbbea13773b3a0b1e95c)


### **Alterar uma aplicação existente para usar a API Pix:**
1. Acesse o painel da Gerencianet no menu **API**.
2. No canto esquerdo, clique em **Minhas Aplicações**, escolha a sua aplicação e clique no botão **Editar** (Botão laranja).
3. Ative **API Pix** e escolha os escopos que deseja liberar em **Produção** e/ou **Homologação** conforme sua necessidade (lembrando que estes podem ser alterados posteriormente)
4. Clique em **Atualizar aplicação**.

![Alterar uma aplicação existente para usar a API Pix](https://app-us-east-1.t-cdn.net/5fa37ea6b47fe9313cb4c9ca/posts/603544082060b2e9b88bc717/603544082060b2e9b88bc717_22430.png)


## **Como gerar um certificado Pix**

Todas as requisições do Pix devem conter um certificado de segurança que será fornecido pela Gerencianet dentro da sua conta, no formato PFX(.p12). Essa exigência está descrita na íntegra no [manual de segurança do PIX](https://www.bcb.gov.br/estabilidadefinanceira/comunicacaodados).

**Para gerar seu certificado:** 
1. Acesse o painel da Gerencianet no menu **API**.
2. No canto esquerdo, clique em **Meus Certificados** e escolha o ambiente em que deseja o certificado: **Produção** ou **Homologação**.
3. Clique em **Novo Certificado**.

![Para gerar seu certificado](https://app-us-east-1.t-cdn.net/5fa37ea6b47fe9313cb4c9ca/posts/603543f7d1778b2d725dea1e/603543f7d1778b2d725dea1e_85669.png)


## **Como converter um certificado Pix**

:warning: Para uso em PHP, o certificado deve ser convertido em formato `.pem`.

Você pode [baixar o conversor de certificados disponibilizado pela Gerencianet](https://pix.gerencianet.com.br/ferramentas/conversorGerencianet.exe). 

Ou utilize do exemplo abaixo, executando o comando OpenSSL para conversão.

### **Comando OpenSSL**
```
// Gerar certificado e chave em único arquivo
openssl pkcs12 -in certificado.p12 -out certificado.pem -nodes
```

## **Como cadastrar as chaves Pix**
O cadastro das chaves Pix pode ser feito através do aplicativo da Gerencianet ou por um endpoint da API. A seguir você encontra os passos de como registrá-las.

### **Cadastrar chave Pix pelo aplicativo mobile:**

Caso ainda não tenha nosso aplicativo instalado, clique em [Android](https://play.google.com/store/apps/details?id=br.com.gerencianet.app) ou [iOS](https://apps.apple.com/br/app/gerencianet/id1443363326), de acordo com o sistema operacional do seu smartphone, para fazer o download.

Para registrar suas chaves Pix por meio do aplicativo:
1. Acesse sua conta através do **app Gerencianet**.
2. No menu lateral, toque em **Pix** para iniciar seu registro.
3. Leia as informações que aparecem na tela e clique em **Registrar Chave**.
    Se este não for mais seu primeiro registro, toque em **Minhas Chaves** e depois no ícone (➕).
4. **Selecione os dados** que você vai cadastrar como Chave do Pix e toque em **avançar** – você deve escolher pelo menos 1 das 4 opções de chaves disponíveis (celular, e-mail, CPF e/ou chave aleatória).
5. Após cadastrar as chaves do Pix desejadas, clique em **concluir**.
6. **Pronto! Suas chaves já estão cadastradas com a gente.**

### **Cadastrar chave Pix através da API:**
O endpoint utilizado para criar uma chave Pix aleatória (evp), é o `POST /v2/gn/evp` ([Criar chave evp](https://dev.gerencianet.com.br/docs/api-pix-endpoints#section-criar-chave-evp)). Um detalhe é que, através deste endpoint é realizado o registro somente de chaves Pix do tipo aleatória.

Para consumí-lo, basta executar o exemplo  `/examples/pix/key/create.php` da nossa SDK. A requisição enviada para esse endpoint não precisa de um body. 

A resposta de exemplo abaixo representa Sucesso (201), apresentando a chave Pix registrada.
```json
{
  "chave": "345e4568-e89b-12d3-a456-006655440001"
}
```


## **Executar exemplos**
Você pode executar usando qualquer servidor web, como Apache ou nginx, ou simplesmente iniciar um servidor php da seguinte forma:

```php
php -S localhost:9000
```

Ou abra qualquer exemplo em seu navegador.

:warning: Alguns exemplos requerem que você altere alguns parâmetros para funcionar, como `examples/charge/oneStepBillet.php` ou `examples/pix/charge/create.php` onde você deve alterar o parâmetro `id`.


## **Guia de versão**

| Versão | Status | Packagist | Repo | Versão PHP |
| --- | --- | --- | --- | --- |
| 1.x | Mantido | `gerencianet/gerencianet-sdk-php` | [v1](https://github.com/gerencianet/gn-api-sdk-php/tree/1.x) | \>= 5.4 |
| 2.x | Mantido | `gerencianet/gerencianet-sdk-php` | [v2](https://github.com/gerencianet/gn-api-sdk-php/tree/2.x) | \>= 5.5 |
| 3.x | Mantido | `gerencianet/gerencianet-sdk-php` | [v3](https://github.com/gerencianet/gn-api-sdk-php/tree/3.x) | \>= 5.6 |
| 4.x | Mantido | `gerencianet/gerencianet-sdk-php` | [v4](https://github.com/gerencianet/gn-api-sdk-php) | \>= 7.2 |

## **Documentação Adicional**

A documentação completa com todos os endpoints e detalhes da API está disponível em https://dev.gerencianet.com.br/.

Se você ainda não tem uma conta digital da Gerencianet, [abra a sua agora](https://sistema.gerencianet.com.br/)!

## **Licença**
[MIT](LICENSE)
