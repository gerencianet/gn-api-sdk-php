## Detailing carnets

To get information about a carnet, you can use:
```php
$response = $apiGN->detailDetail()
                  ->carnetId($carnetId)
                  ->run()
                  ->response();
```

As response, you will receive all information about the carnet:

```php
{
  "code": 200,
  "data": {
    "carnet_id": 1000,
    "status": "active",
    "repeats": 2,
    "cover": "https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CC-99999-99999-LOSI5/99999-99999-LOSI5",
    "value": 6000,
    "split_items": false,
    "charges": [
      {
        "charge_id": 1001,
        "status": "waiting",
        "url": "https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-LOSI5",
        "barcode": "99999.99999 99999.999999 99999.999999 9 99999999999999",
        "parcel": 1
      },
      {
        "charge_id": 1002,
        "status": "waiting",
        "url": "https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-FOHI3",
        "barcode": "99999.99999 99999.999999 99999.999999 9 99999999999999",
        "parcel": 2
      }
    ],
    "created_at": "2015-07-02 12:08:40"
  }
}
```