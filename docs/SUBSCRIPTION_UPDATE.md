## Updating subscriptions

### Changing the metadata

You can update the `custom_id` or the `notification_url` of a subscription at any time you want.

Is important to know that it updates all the charges of the subscription. If you want to update only one charge, see [Updating charges](/docs/CHARGE_UPDATE.md).

```php
$charge = $apiGN->updateSubscriptionMetadata()
                ->subscriptionId($subscriptionId)
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
