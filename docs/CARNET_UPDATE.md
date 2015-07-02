## Updating charges

### Changing the metadata

You can update the `custom_id` or the `notification_url` of a carnet at any time you want. 

Is important to know that it updates all the charges of the carnet. If you want to update only one parcel, see (Updating charges)[/docs/CHARGE_UPDATE.md].

```php
$charge = $apiGN->updateCarnetMetadata()
                ->carnetId($carnetId)
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

### Updating the expiration date of a parcel

To update or set an expiration date to a parcel, the parcel must have a `waiting` status. You just have to provide the charge id and a new expiration date:

```php
$chargeId = ''; // The value returned by createCarnet function
$response = $apiGN->updateParcel()
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