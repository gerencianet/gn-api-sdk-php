## Creating carnets ##

Carnet is the payment form that you generate a set of charges with the payment method defined.

To generate the carnet ids required th send of items, customer and the number of repeats (or parcels). But you can send the metadata, the expiration date of first charge, if the carnet must be send by post office service, if the total value of items must be split among every charges and at most 4 instructions.

### Setting items to a carnet:
`required`
```php
$item = new Item();
$item->name('Item')
     ->value(5000) // The value must be a integer (ex.: R$ 50,00 = 5000)
     ->amount(2);

$response = $apiGN->createCarnet()
                  ->addItem($item)
                  ->run()
                  ->response();
```

You have two options to add items into a carnet:

* Adding one item at a time:
```php
$response = $apiGN->createCarnet()
                  ->addItem($item)
                  ->run()
                  ->response();
```

* Adding many items:
```php
$response = $apiGN->createCarnet()
                  ->addItems([$item1, $item2])
                  ->run()
                  ->response();
```

### Setting customer to a carnet:
`required`
```php
$address = new Address();
$address->street('Street 3')
        ->number('10')
        ->neighborhood('Bauxita')
        ->zipcode('35400000')
        ->city('Ouro Preto')
        ->state('MG');

$customer = new Customer();
$customer->name('Gorbadoc Oldbuck')
         ->email('oldbuck@gerencianet.com.br')
         ->document('04267484171')
         ->birth('1977-01-15')
         ->phoneNumber('5044916523')
         ->address($address); // optional.

$response = $apiGN->createCarnet()
                  ...
                  ->customer($customer)
                  ->run()
                  ->response();
```

### Setting repeats to carnet's charge:
`required`
```php
$response = $apiGN->createCarnet()
                  ...
                  ->repeats(3)
                  ->run()
                  ->response();
```

### Setting metadata to a carnet:
`optional`
```php
$metadata = new Metadata();
$metadata->customId('MyID')
         ->notificationUrl('http://your_domain/your_notification_url');

$response = $apiGN->createCarnet()
                  ...
                  ->metadata($metadata)
                  ->run()
                  ->response();
```

### Setting expiration date to first charge in the carnet:
`optional`

The value defaut is today + 8 days.

```php
$response = $apiGN->createCarnet()
                  ...
                  ->expireAt('2019-12-31')
                  ->run()
                  ->response();
```

### Setting post office service to a carnet:
`optional`
```php
$postOfficeService = new PostOfficeService();
$postOfficeService->sendTo('customer');

$response = $apiGN->createCarnet()
                  ...
                  ->postOfficeService($postOfficeService)
                  ->run()
                  ->response();
```

### Setting split items to a carnet
`optional`

The value defaut is false.

```php
$response = $apiGN->createCarnet()
                  ...
                  ->splitItems(true)
                  ->run()
                  ->response();
```

### Setting instructions to a carnet
`optional`

You have two options to add instructions into a carnet:

* Adding one instruction at a time:
```php
$response = $apiGN->createCarnet()
                  ...
                  ->addInstruction('Instruction 1')
                  ->run()
                  ->response();
```

* Adding many instructions:
```php
$response = $apiGN->createCarnet()
                  ...
                  ->addInstructions(['Instruction 1', 'Instruction 2'])
                  ->run()
                  ->response();
```

### Setting emission rate to a carnet
`optional`

The value must be an integer among 1 and 1000.
```php
$response = $apiGN->createCarnet()
                  ...
                  ->carnetRate(982) // Optional
                  ->run()
                  ->response();
```

As response, you'll receive the carnet info in the callback with the set of charges generated:

```js
{
  "code": 200,
  "data": {
    "carnet_id": 3000,
    "cover": "https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CC-99999-99999-LOSI5/99999-99999-LOSI5",
    "charges": [ {
      "charge_id": 1476,
      "parcel": "1",
      "status": "waiting",
      "value": 10000,
      "expire_at": "2019-12-31",
      "url": "https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-LOSI5",
      "barcode": "99999.99999 99999.999999 99999.999999 9 99999999999999"
    }, {
      "charge_id": 1477,
      "parcel": "2",
      "status": "waiting",
      "value": 10000,
      "expire_at": "2020-01-31",
      "url": "https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-FOHI3",
      "barcode": "99999.99999 99999.999999 99999.999999 9 99999999999999"
    }, {
      "charge_id": 1478,
      "parcel": "3",
      "status": "waiting",
      "value": 10000,
      "expire_at": "2020-02-28",
      "url": "https://boleto.gerencianet.com.br/emissao/99999_9999_CABO1/A5CL-99999-99999-LOSI5/99999-99999-SERMEH7",
      "barcode": "99999.99999 99999.999999 99999.999999 9 99999999999999"
    } ]
  }
}
```