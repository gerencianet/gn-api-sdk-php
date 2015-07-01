## Creating carnets ##

Carnet is the payment form that you generate a set of charges with the payment method defined.

To generate a carnet, you have to set the items, a customer and the number of repeats (or parcels).

If you want, you can send additional informations, defining:

- The metadata information (like in the banking billet), with notification_url and/or custom_id
- The expiration date to the first charge;
- If the carnet must be send by post office service (choosing, inclusive, if you or your client must receive it);
- If the total value must be split among every charges or if each charge must have the value;
- The instructions to the carnet (At most 4 lines).

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
         ->cpf('04267484171')
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

### Setting the expiration date to the first charge:
`optional`

The defaut value is today + 8 days.

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
$postOfficeService->sendTo('customer'); //or seller

$response = $apiGN->createCarnet()
                  ...
                  ->postOfficeService($postOfficeService)
                  ->run()
                  ->response();
```

### Setting the split value information
`optional`

The value defaut is false.

```php
$response = $apiGN->createCarnet()
                  ...
                  ->splitItems(true)
                  ->run()
                  ->response();
```

### Setting instructions
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