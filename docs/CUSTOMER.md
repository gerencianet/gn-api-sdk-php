## Associating a customer to a charge ##

If you created charges without customers because you didn't know them or was planning to get their info afterwards, no need to panic. You can associate these customers to their respective charges like the following:

```php
$chargeId = ''; // The value returned by createCharge function
$response = $apiGN->createCustomer()
                  ->chargeId($chargeId)
                  ->customer($customer)
                  ->run()
                  ->response();
```
If everything went well, the return is just a response with code 200:

```js
{
  "code": 200
}
```
