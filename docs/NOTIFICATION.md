# Notifications
Instantiate the module:

```php
require __DIR__.'/../../vendor/autoload.php';
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$options = [
    'client_id' => 'client_id',
    'client_secret' => 'client_secret',
    'sandbox' => true
];

try {
    $api = new Gerencianet($options);

} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
```

Any changes that happen in the charges will trigger an event that notifies the `notification_url` provided at creation time (see [creating charges](/docs/CHARGE.md)).

It's also possible to set or change the `notification_url` for existing charges, see [updating informations](/docs/CHARGE_UPDATE.md).

Given that a charge has a valid `notification_url`, when the notification time comes you'll receive a post with a `token`. This token must be used to get the notification payload data.

The example below assumes that you're using receiving posts at php's $_POST variable.

```php
$params = ['token' => $_POST['notification']];

try {
    $api = new Gerencianet($options);
    $notification = $api->getNotification($params, []);

    print_r($notification);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
```

Response:

```php
Array
(
    [code] => 200
    [data] => Array
        (
            [0] => Array
                (
                    [id] => 1
                    [type] => charge
                    [custom_id] =>
                    [status] => Array
                        (
                            [current] => new
                            [previous] =>
                        )

                    [identifiers] => Array
                        (
                            [charge_id] => 1002
                        )

                )

            [1] => Array
                (
                    [id] => 2
                    [type] => charge
                    [custom_id] =>
                    [status] => Array
                        (
                            [current] => waiting
                            [previous] => new
                        )

                    [identifiers] => Array
                        (
                            [charge_id] => 1002
                        )

                )

            [2] => Array
                (
                    [id] => 3
                    [type] => charge
                    [custom_id] =>
                    [status] => Array
                        (
                            [current] => paid
                            [previous] => waiting
                        )

                    [identifiers] => Array
                        (
                            [charge_id] => 1002
                        )

                    [value] => 2000
                )

            [3] => Array
                (
                    [id] => 4
                    [type] => charge
                    [custom_id] =>
                    [status] => Array
                        (
                            [current] => refunded
                            [previous] => paid
                        )

                    [identifiers] => Array
                        (
                            [charge_id] => 1002
                        )

                )

        )

)
```

Response will be an array with all changes of a token that happened within 6 months, and it contains the following parameters:

* id: Each notification has its own sequence, starting from `1` and the `id` parameter is used to mark this sequence. This is useful if you need to keep track which change you have already processed.

* type: The type of this change. The available values are:
  * `charge` - a charge have changed.
  * `subscription` - a subscription have changed.
  * `carnet` - a carnet have changed.
  * `subscription_charge` - one subscription's parcel have changed.
  * `carnet_charge` - one carnet's parcel have changed.


* custom_id: Your custom_id.

* status: Status of the transaction. It contains the `current` status and `previous` status (before the change) of this transaction.

 p.s.: if there is no `previous` status (i.e.: for new charges), the `previous` value will be null.

* identifiers: Identifiers related to this change. It may have one or more identifier depending on the type:
  * for `charge` type: identifiers will contain only `charge_id`.
  * for `subscription` type: identifiers will contain only `subscription_id`.
  * for `carnet` type: identifiers will contain only `carnet_id`.
  * for `subscription_charge` type: identifiers will contain both `charge_id` and `subscription_id`.
  * for `carnet_charge` type: identifiers will contain both `charge_id` and `carnet_id`.


* value: this parameter will only be shown when the change is about paid charges.

 For more informations about notifications, please, refer to [Gerencianet](https://docs.gerencianet.com.br/#!/charges/notifications).
