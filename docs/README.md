# Widget Hours – Documentation

## Usage example

The following options can be set in the evaluation array:

Property | Description
--- | ---
rows | Number of input rows
weekOffset | Starting day of the week (0=Sunday, 1=Monday, etc.)

For example implementation see below code:

```php
$GLOBALS['TL_DCA']['tl_module']['fields']['openHours'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['openHours'],
    'exclude'   => true,
    'inputType' => 'hoursWidget',
    'eval'      => array('mandatory'=>true, 'rows'=>2, 'weekOffset'=>1, 'tl_class'=>'clr'),
    'sql'       => "blob NULL"
);
```