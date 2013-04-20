<?php

/**
 * widget_hours extension for Contao Open Source CMS
 * 
 * Copyright (C) 2013 Codefog
 * 
 * @package widget_hours
 * @link    http://codefog.pl
 * @author  Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 * @license LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Contao\WidgetHours' => 'system/modules/widget_hours/widgets/WidgetHours.php'
));
