# clerico-client-php
PHP client for the Clerico API

## Installation ##
```
php composer.php required fivesqrd/clerico-client-php
```

## Setup ##
Vanilla PHP
```
use Clerico\Document;

$pdf = Document::instance('my-token-key')->generic($params);

header('Content-Type: application/pdf');
echo $pdf;
```

In Laravel
```
use Clerico;

$params = [
    //...document params
]

$pdf = Clerico::document($params)->render();
```

## Defining default values ##
```
use Clerico\Document;

$defaults = [
    'template' => '9840mjlep0ou34ko4d',
    'currency' => 'USD',
    'tax'      => [
        'name'      => 'VAT',
        'rate'      => 0.14,
        'reference' => 'V98756799373',
    ]
];

$params = [
    //...document params
];

$pdf = Document::instance('my-token-key', $defaults)
    ->create($params)
    ->render();
```

In Laravel
```
/* todo */
```

## Document from array input ##
```
use Clerico\Document;

$params = [
    'title'     => 'Tax Invoice',
    'date'      => date('Y-m-d'),
    'due'       => date('Y-m-d', time() + 86400 * 30),
    'number'    => 'INVOO1',
    'recipient' => [
        'name'        => 'Acme & Co',
        'address'     => ['102 Main Avenue', 'Jacksonville', 'Mysharona', 'VX975 933'],
        'email'       => 'billing@acmeco.com'
    ],
    'items'     => [
        [
            'description' => 'Monthly subscription ' . date('F Y'),
            'qty'         => 1,
            'amount'      => 20.00,
            'taxable'     => true
        ]
    ]
];

$pdf = Document::instance('my-token-key', $defaults)
    ->create($params);
    ->render();
```

## Document from fluent document builder interface ##
```
use Clerico\Document;

$invoice = Document::builder()
    ->template('9840mjlep0ou34ko4d')
    ->title('Tax Invoice')
    ->currency('USD')
    ->date(date('Y-m-d'))
    ->due(date('Y-m-d', time() + 86400 * 30))
    ->number('INVOO1')
    ->recipient(
        'Acme & Co', ['102 Main Avenue', 'Jacksonville', 'Mysharona', 'VX975 933']
    )
    ->tax('VAT', 0.14, 'V98756799373')
    ->items($items)
    ->item('Monthly subscription ' . date('F Y'), 1, 20.00, true)
    ->item('Priority support add-on', 1, 5.00, true);

$pdf = Document::instance('my-token-key', $defaults)
    ->create($invoice)
    ->render();
```

In Laravel using callable interface
```
use Clerico;

$document = Clerico::document(function ($builder) {
    $builder->title('Tax Invoice')
        ->date(date('Y-m-d'))
        ->due(date('Y-m-d', time() + 86400 * 30))
        ->number('INVOO1')
        ->recipient(
            'Acme & Co', ['102 Main Avenue', 'Jacksonville', 'Mysharona', 'VX975 933']
        )
        ->item('Monthly subscription ' . date('F Y'), 1, 20.00, true)
        ->item('Priority support add-on', 1, 5.00, true);
});

return response()->streamDownload(function () use ($document) {
    echo $document->render();
}, $document->attribute('number') . '.pdf', ['Content-Type' => 'application/pdf']);
```
