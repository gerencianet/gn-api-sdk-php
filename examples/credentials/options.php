<?php

$options = [
	"client_id" => "Client_Id",
	"client_secret" => "Client_Secret",
	"certificate" => realpath("/vagrant/www/gn-api-sdk-php/examples/credentials/productionCertificate.p12"), // Absolute path to the certificate in .pem or .p12 format
	"sandbox" => false,
	"debug" => false,
	"timeout" => 30
];
