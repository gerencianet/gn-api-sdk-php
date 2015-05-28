## Creating charges ##

Charges belong to customers. Customers have many charges. Following this logic, you will have to associate a customer to a charge at some point. But the items, they have to be setted necessarily in the moment that you are creating the charge.

### Setting items to a charge:
`required`
```php
$item = new Item();
$item->name('Item')
     ->value(5000) // The value must be a integer (ex.: R$ 50,00 = 5000)
     ->amount(2);

$response = $apiGN->createCharge()
                  ->addItem($item)
                  ->run()
                  ->response();
```

You have two options to add items into a charge:

* Adding one item at a time:
```php
$response = $apiGN->createCharge()
                  ->addItem($item)
                  ->run()
                  ->response();
```

* Adding many items:
```php
$response = $apiGN->createCharge()
                  ->addItems([$item1, $item2])
                  ->run()
                  ->response();
```

### Setting customer to a charge:
`required`, but you can [set after creation](/docs/CUSTOMER.md)
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
 
 $response = $apiGN->createCharge()
                   ...
                   ->customer($customer)
                   ->run()
                   ->response();
 ```

### Setting shippings to a charge: 
`optional`
```php
$shipping = new Shipping();
$shipping->name('Shipping')
         ->value(2500);

$response = $apiGN->createCharge()
                  ...
                  ->addShipping($shipping)
                  ->run()
                  ->response();
```

As the item, shipping also has two ways to be added:

* Add one shipping at a time:
```php
$response = $apiGN->createCharge()
                  ...
                  ->addShipping($shipping)
                  ->run()
                  ->response();
```

* Add many shippings:
```php
$response = $apiGN->createCharge()
                  ...
                  ->addShippings([$shipping1, $shipping2])
                  ->run()
                  ->response();
```

### Setting metadata to a charge: 
`optional`
```php
$metadata = new Metadata();
$metadata->customId('MyID')
         ->notificationUrl('http://your_domain/your_notification_url');

$response = $apiGN->createCharge()
                  ...
                  ->metadata($metadata)
                  ->run()
                  ->response();
```
