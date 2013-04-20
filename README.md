widget_hours Contao Extension
=============================



Usage:

```php
$GLOBALS['TL_DCA']['tl_module']['fields']['openHours'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['openHours'],
	'exclude'                 => true,
	'inputType'               => 'hoursWidget',
	'eval'                    => array('mandatory'=>true, 'rows'=>2, 'weekOffset'=>1, 'tl_class'=>'clr'),
	'sql'                     => "blob NULL"
);
```

### Contao compatibility
- Contao 3.0

### Available languages
- English
- Polish