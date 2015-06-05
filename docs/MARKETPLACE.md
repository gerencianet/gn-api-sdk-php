## Marketplace ##

What if your web store contains products from many different sellers from many different segments? The user can complete a single purchase with products from more than one seller, right? Here enters marketplace.

With some extra attributes, you can define a percentage amount of the purchase total value will be credited to someone else.
```php
$repass = new Repass();
$repass->payeeCode('payee_code_to_repass')
       ->percentage(7000);

$item = new Item();
$item->name('Item')
     ->value(500)
     ->amount(2)
     ->addRepass($repass);
```

You have two options to add repasses in the item:

* Add one repass at a time:
```php
$item = new Item();
$item->name('Item')
     ->value(500)
     ->amount(2)
     ->addRepass($repass);
```

* Add many repasses:
```php
$item = new Item();
$item->name('Item')
     ->value(500)
     ->amount(2)
     ->addRepasses([$repass1, $repass2]);
```

The attribute `payee_code` identifies a Gerencianet account. In order to get someone else's `payee_code` you need to ask the account owner. There is no other way. To visualize yours, log in your Gerencianet account and search for *Identificador de Conta* in the top of your API Page.

The response is the sames as usual:

```js
{
  "code": 200,
  "data": {
    "charge_id": 10001,
    "total": 34725,
    "status": "new",
    "custom_id": "MyID",
    "created_at": "2015-03-26"
  }
}
```

### Shipping Repass ###

You can add as many shipping as you want. And, sometimes, you'll want a shipping cost to be received by another person/account, so, you can repass an specific shipping value to a Gerencianet account by passing its `payee_code`.

For example:
```php
$shipping = new Shipping();
$shipping->name('Shipping')
         ->payeeCode('payee_code_to_repass')
         ->value(2500);

$response = $apiGN->createCharge()
                  ...
                  ->addShipping($shipping)
                  ->run()
                  ->response();
```

If you set at least one shipping repass to another account, the charge will be considered a Marketplace Charge.
