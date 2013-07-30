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
 * Extension version
 */
@define('WIDGET_HOURS_VERSION', '1.0');
@define('WIDGET_HOURS_BUILD', '0');


/**
 * Back end form fields
 */
$GLOBALS['BE_FFL']['hoursWidget'] = 'WidgetHours';


/**
 * Front end form fields
 */
$GLOBALS['TL_FFL']['hoursWidget'] = 'FormWidgetHours';
