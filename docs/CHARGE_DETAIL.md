## Detailing charges

To get information about a charge, you can use:
```php
$response = $apiGN->detailCharge()
                  ->chargeId($chargeId)
                  ->run()
                  ->response();
```

As response, you will receive all information about the charge (including if it belongs to a subscription or carnet).

```php
{
  "code": 200,
  "data": {
    "charge_id": 1000,
    "total": 5000,
    "status": "new",
    "custom_id": "my_id",
    "created_at": "2015-07-02 12:03:00",
    "notification_url": "http://your.domain/your_notification_url",
    "items": [
      {
        "name": "Item 1",
        "value": 500,
        "amount": 2
      }
    ],
    "history": [
      {
        "status": "new",
        "created_at": "2015-07-02 12:03:00"
      }
    ]
  }
}
```