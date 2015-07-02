## Updating charges

### Changing the metadata

You can update the `custom_id` or the `notification_url` of a charge at any time you want:

```php
$charge = $apiGN->updateChargeMetadata()
                ->chargeId($chargeId)
                ->notificationUrl('http://your.domain/your_new_notification_url')
                ->customId('new_id')
                ->run()
                ->response();
```

If everything goes well, the return will be:

```js
{
  "code": 200
}
```

### Updating the expiration date of a billet

To update or set an expiration date to a charge, the charge must have a `waiting` status, and the payment method choosed must be `banking_billet`.

If the charge contemplates these requirements, you just have to provide the charge id and a new expiration date:

```php
$chargeId = ''; // The value returned by createCharge function
$response = $apiGN->updateBillet()
                  ->chargeId($chargeId)
                  ->expireAt('2018-12-31')
                  ->run()
                  ->response();
```

If everything goes well, the return will be:

```js
{
  "code": 200
}
```