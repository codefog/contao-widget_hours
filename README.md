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

### Support us
We put a lot of effort to make our extensions useful and reliable. If you like our work, please support us by liking our [Facebook profile](http://facebook.com/Codefog), following us on [Twitter](https://twitter.com/codefog) and watching our [Github activities](http://github.com/codefog). Thank you!

### Copyright
The extension was developed by [Codefog Ltd](http://codefog.pl) and is distributed under the Lesser General Public License (LGPL). Feel free to contact us using the [website](http://codefog.pl) or directly at info@codefog.pl.