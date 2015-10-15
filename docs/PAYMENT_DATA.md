## Payment data - listing installments

If you ever need to get the total value for a charge, including rates and interests, as well as each installment value, even before the payment itself, you can.

Why would I need this?

Sometimes you need to check the total for making a discount, or simple to show a combobox with the installments for your users.

Stop bragging about. Here is the code:

```php
require __DIR__.'/../../vendor/autoload.php';
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$options = [
    'client_id' => 'client_id',
    'client_secret' => 'client_secret',
    'sandbox' => true
];

$params = ['total' => '2000', 'brand' => 'visa'];

try {
    $api = new Gerencianet($options);
    $installments = $api->getInstallments($params, []);

    print_r($installments);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

And the response:

```php
Array
(
    [code] => 200
    [data] => Array
        (
            [rate] => 0
            [name] => visa
            [installments] => Array
                (
                    [0] => Array
                        (
                            [installment] => 1
                            [has_interest] =>
                            [value] => 20000
                            [currency] => 200,00
                            [interest_percentage] => 199
                        )

                    [1] => Array
                        (
                            [installment] => 2
                            [has_interest] => 1
                            [value] => 10402
                            [currency] => 104,02
                            [interest_percentage] => 199
                        )

                    [2] => Array
                        (
                            [installment] => 3
                            [has_interest] => 1
                            [value] => 7073
                            [currency] => 70,73
                            [interest_percentage] => 199
                        )

                    [3] => Array
                        (
                            [installment] => 4
                            [has_interest] => 1
                            [value] => 5410
                            [currency] => 54,10
                            [interest_percentage] => 199
                        )

                    [4] => Array
                        (
                            [installment] => 5
                            [has_interest] => 1
                            [value] => 4414
                            [currency] => 44,14
                            [interest_percentage] => 199
                        )

                    [5] => Array
                        (
                            [installment] => 6
                            [has_interest] => 1
                            [value] => 3752
                            [currency] => 37,52
                            [interest_percentage] => 199
                        )

                    [6] => Array
                        (
                            [installment] => 7
                            [has_interest] => 1
                            [value] => 3280
                            [currency] => 32,80
                            [interest_percentage] => 199
                        )

                    [7] => Array
                        (
                            [installment] => 8
                            [has_interest] => 1
                            [value] => 2927
                            [currency] => 29,27
                            [interest_percentage] => 199
                        )

                    [8] => Array
                        (
                            [installment] => 9
                            [has_interest] => 1
                            [value] => 2653
                            [currency] => 26,53
                            [interest_percentage] => 199
                        )

                    [9] => Array
                        (
                            [installment] => 10
                            [has_interest] => 1
                            [value] => 2436
                            [currency] => 24,36
                            [interest_percentage] => 199
                        )

                    [10] => Array
                        (
                            [installment] => 11
                            [has_interest] => 1
                            [value] => 2258
                            [currency] => 22,58
                            [interest_percentage] => 199
                        )

                    [11] => Array
                        (
                            [installment] => 12
                            [has_interest] => 1
                            [value] => 2111
                            [currency] => 21,11
                            [interest_percentage] => 199
                        )

                )

        )

)

```
