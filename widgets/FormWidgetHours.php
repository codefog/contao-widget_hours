<?php

/**
 * widget_hours extension for Contao Open Source CMS
 *
 * Copyright (C) 2013 Codefog
 *
 * @package widget_hours
 * @author  Codefog <http://codefog.pl>
 * @author  Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 * @license LGPL
 */

namespace Contao;


/**
 * Class FormWidgetHours
 * Form field "hours".
 */
class FormWidgetHours extends WidgetHours
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'form_hours_widget';

    /**
     * Generate the widget and return it as string
     *
     * @throws \BadMethodCallException
     */
    public function generate()
    {
        throw new \BadMethodCallException('Use the parse() method instead!');
    }

    /**
     * Parse the template file and return it as string
     *
     * @param array $attributes An optional attributes array
     *
     * @return string The template markup
     */
    public function parse($attributes = null)
    {
        $this->intWeekOffset = ($this->intWeekOffset === null) ? $GLOBALS['TL_LANG']['MSC']['weekOffset'] : $this->intWeekOffset;

        // Make sure there is at least an empty array
        if (!is_array($this->varValue) || empty($this->varValue)) {
            $this->varValue = array(
                array
                (
                    'from' => '',
                    'to'   => '',
                ),
            );
        }

        return parent::parse($attributes);
    }

    /**
     * Get the table headers
     *
     * @return array
     */
    public function getTableHeaders()
    {
        $headers = [];

        for ($i = 0; $i < 7; $i++) {
            $currentDay = ($i + $this->intWeekOffset) % 7;
            $headers[]  = $GLOBALS['TL_LANG']['DAYS'][$currentDay];
        }

        return $headers;
    }

    /**
     * Get the table body
     *
     * @return array
     */
    public function getTableBody()
    {
        $body = [];

        for ($j = 0; $j < $this->intRows; $j++) {
            for ($i = 0; $i < 7; $i++) {
                $currentDay = ($i + $this->intWeekOffset) % 7;

                $body[] = [
                    'from' => [
                        'id'    => $this->strId.'_'.$j.'_'.$currentDay.'_from',
                        'name'  => $this->strId.'['.$j.']['.$currentDay.'][from]',
                        'value' => is_numeric($this->varValue[$j][$currentDay]['from']) ? $this->parseDate(
                            $GLOBALS['TL_CONFIG']['timeFormat'],
                            $this->varValue[$j][$currentDay]['from']
                        ) : $this->varValue[$j][$currentDay]['from'],
                    ],
                    'to'   => [
                        'id'    => $this->strId.'_'.$j.'_'.$currentDay.'_to',
                        'name'  => $this->strId.'['.$j.']['.$currentDay.'][to]',
                        'value' => is_numeric($this->varValue[$j][$currentDay]['to']) ? $this->parseDate(
                            $GLOBALS['TL_CONFIG']['timeFormat'],
                            $this->varValue[$j][$currentDay]['to']
                        ) : $this->varValue[$j][$currentDay]['to'],
                    ],
                ];
            }
        }

        return $body;
    }
}