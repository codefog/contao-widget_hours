# Widget Hours – Documentation

## Installation

Install the bundle using Contao Manager or directly via Composer:

```
composer require codefog/contao-widget_hours
```

## Usage example

The following options can be set in the evaluation array:

Property | Description
--- | ---
rows | Number of input rows
weekOffset | Starting day of the week (0=Sunday, 1=Monday, etc.)

For example implementation see below code:

```php
$GLOBALS['TL_DCA']['tl_table']['fields']['openHours'] = [
    'exclude' => true,
    'inputType' => 'hoursWidget',
    'eval' => [
        'mandatory' => true, 
        'rows' => 2, // Number of rows
        'weekOffset' => 1, // Custom week offset
        'storeRaw' => true, // Store raw values and do not convert value to timestamp
        'tl_class' => 'clr',
    ],
    'sql' => ['type' => 'blob', 'notnull' => false],
];
```
