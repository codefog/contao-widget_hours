<?php

namespace Codefog\WidgetHoursBundle\FormField;

use Codefog\WidgetHoursBundle\Widget\HoursWidget;

class HoursFormField extends HoursWidget
{
    /**
     * @inheritdoc
     */
    protected $strTemplate = 'form_hours_widget';

    /**
     * @inheritdoc
     */
    protected $strPrefix = 'widget widget-hours';

    /**
     * @inheritdoc
     */
    public function generate()
    {
        throw new \BadMethodCallException('Use the parse() method instead!');
    }
}
