## Notifications ##

Use this if you want to be informed when your charges get a different status.

Any changes that happen in the charges will trigger an event that notifies the notification_url provided at creation time (see creating charges).

It's also possible to set or change the notification_url for existing charges:
```php
$response = $apiGN->updateChargeMetadata()
                  ->notificationUrl('http://your_domain/your_new_notification_url')
                  ->chargeId($chargeId)
                  ->run()
                  ->response();
```

Response:
```js
{
  "code": 200
}
```

Assuming that a charge has a valid `notification_url`, it will receive a post containing a token when the notification time comes. This token must be used to get the information about what was altered on the charge:
```php
$notificationToken = $_POST['notification'];
$response = $apiGN->detailNotifications()
                  ->notificationToken($notificationToken)
                  ->run()
                  ->response();
```
Response:

```js
{
  "code": 200,
  "data": {
    "charge_id": 10000,
    "total": 34725,
    "status": "waiting",
    "custom_id": "MyID",
    "created_at": "2015-03-26",
    "history": [ {
      "status": "new",
      "timestamp": "2015-03-26 08:46:00"
    }, {
      "status": "waiting",
      "timestamp": "2015-03-26 09:22:15"
    } ]
  }
}
```
