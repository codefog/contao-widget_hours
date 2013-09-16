widget_hours Contao Extension
=============================

Contao widget to enter hours for each day of the week.

Usage example:

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
- Contao 3.1

### Available languages
- English
- Polish