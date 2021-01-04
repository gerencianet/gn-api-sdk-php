<?php

namespace Gerencianet;

class Utils
{

    const PayloadFormatIndicator      = '01';
    const PointOfInitiationMethod     = '12';
    const MerchantAccountInfomation   = '00BR.GOV.BCB.PIX';
    const MerchantCategoryCode        = '0000';
    const TransactionCurrency         = '986';
    const CountryCode                 = 'BR';
    const AdditionalFieldTemplateTxId = '05';
    const CRC16                       = '63';

    public static function generateTxid($dynamic)
    {
    	$count  = $dynamic ? 35 : 25;
	    $chars  = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $length = strlen($chars);
	    $txid  = '';
	    for ($i = 0; $i < $count; $i++) {
	        $txid .= $chars[rand(0, $length - 1)];
	    }
	    return $txid;
    }

    public static function generateQrCode($pixContent, $qrCodeData)
    {

        $payloadBrCode = '00' . self::PayloadFormatIndicator;

        if ($qrCodeData['oncePaid'])
        {
            $payloadBrCode .= '01' . self::PointOfInitiationMethod;
        }

        $merchantAccountInfomation = self::MerchantAccountInfomation;
        if ($qrCodeData['dynamic'])
        {
            $merchantAccountInfomation .= '25' . $pixContent['location'];
        } 
        else 
        { 
            $merchantAccountInfomation .= '01' . $pixContent['chave'];
        }

        $payloadBrCode .= '26' . $merchantAccountInfomation;
        $payloadBrCode .= '52' . self::MerchantCategoryCode;
        $payloadBrCode .= '53' . self::TransactionCurrency;
        $payloadBrCode .= '54' . ($qrCodeData['freeValue'] === true) ? '0.00' : $pixContent["valor"]["original"];
        $payloadBrCode .= '58' . self::CountryCode;
        $payloadBrCode .= '59' . $qrCodeData['merchant']['name'];
        $payloadBrCode .= '60' . $qrCodeData['merchant']['city'];
        $payloadBrCode .= '61' . $qrCodeData['merchant']['cep'] ? $qrCodeData['merchant']['cep'] : '';
        $payloadBrCode .= '62' . self::AdditionalFieldTemplateTxId . $qrCodeData['dynamic'] ? '***' : $pixContent['txid'];
        $payloadBrCode .= self::CRC16;
        $payloadBrCode .= self::CRC16Checksum($payloadBrCode);

        $baseUrl = 'https://chart.googleapis.com/chart?cht=qr&choe=UTF-8&chs=350x350&chld=L|0&';
        $baseUrl .= urldecode($payloadBrCode);
        return $baseUrl;
    }

    public static function CRC16Checksum($str)
    {
        $crc = 0xFFFF;
        $strlen = strlen($str);
        for ($c = 0; $c < $strlen; $c++) {
            $crc ^= ord(substr($str, $c, 1)) << 8;
            for ($i = 0; $i < 8; $i++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc = $crc << 1;
                }
            }
        }
        $hex = $crc & 0xFFFF;
        $hex = dechex($hex);
        $hex = strtoupper($hex);

        return $hex;
    }
}
