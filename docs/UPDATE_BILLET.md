## Updating banking billet ##

You can update the expiration date of a billet, if it is necessary. For this, it is required that the charge has been paid with billet and its status must be WAITING.

If the charge contemplates these requirements, you just have to provide the charge id and a new expiration date:

```php
$chargeId = ''; // The value returned by createCharge function
$response = $apiGN->updateBillet()
                  ->chargeId($chargeId)
                  ->expireAt('2018-12-31')
                  ->run()
                  ->response();
```

If everything goes well, the return will be just a response with code 200:

```js
{
  "code": 200
}
```
