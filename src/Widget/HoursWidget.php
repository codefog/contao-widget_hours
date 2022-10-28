<?php

namespace Codefog\WidgetHoursBundle\Widget;

use Contao\Config;
use Contao\Date;
use Contao\StringUtil;
use Contao\Widget;

class HoursWidget extends Widget
{
    /**
     * @inheritdoc
     */
    protected $strTemplate = 'be_hours_widget';

    /**
     * @inheritdoc
     */
    protected $blnSubmitInput = true;

    /**
     * Rows
     */
    protected int $numberOfRows = 1;

    /**
     * Week offset
     */
    protected int $weekOffset = 0;

    /**
     * @inheritdoc
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey) {
            case 'rows':
                $this->numberOfRows = $varValue;
                break;

            case 'weekOffset':
                $this->weekOffset = $varValue;
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }

    /**
     * Validate input and set value
     */
    public function validate()
    {
        $mandatory = $this->mandatory;
        $input = StringUtil::deserialize($this->getPost($this->strName), true);

        foreach ($input as $k => $days) {
            foreach ($days as $kk => $day) {
                // Mandatory check
                if ($mandatory && ($day['from'] && $day['to'])) {
                    $mandatory = false;
                }

                if ($day['from'] xor $day['to']) {
                    $mandatory = true;
                }

                // Valid time check
                if (($day['from'] && !preg_match('~^'.Date::getRegexp(Config::get('timeFormat')).'$~i', $day['from'])) || ($day['to'] && !preg_match('~^'.Date::getRegexp(Config::get('timeFormat')).'$~i', $day['to']))) {
                    $this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['time'], Date::getInputFormat(Config::get('timeFormat'))));
                    break 2;
                }

                if (!$this->storeRaw && $day['from'] && $day['to']) {
                    $input[$k][$kk]['from'] = (new Date($day['from'], Config::get('timeFormat')))->tstamp;
                    $input[$k][$kk]['to'] = (new Date($day['to'], Config::get('timeFormat')))->tstamp;
                }
            }
        }

        // Throws an error if the field is mandatory
        if ($mandatory) {
            $this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['mandatory'], $this->strLabel));
        }

        $this->varValue = $input;
    }

    /**
     * Get the table headers
     */
    public function getTableHeaders(): array
    {
        $headers = [];

        for ($i = 0; $i < 7; $i++) {
            $currentDay = ($i + $this->weekOffset) % 7;
            $headers[] = $GLOBALS['TL_LANG']['DAYS'][$currentDay];
        }

        return $headers;
    }

    /**
     * Get the table body
     */
    public function getTableBody(): array
    {
        $body = [];

        for ($j = 0; $j < $this->numberOfRows; $j++) {
            for ($i = 0; $i < 7; $i++) {
                $currentDay = ($i + $this->weekOffset) % 7;

                $body[$j][] = [
                    'from' => [
                        'id' => $this->strId.'_'.$j.'_'.$currentDay.'_from',
                        'name' => $this->strId.'['.$j.']['.$currentDay.'][from]',
                        'value' => is_numeric($this->varValue[$j][$currentDay]['from'] ?? false) ? Date::parse(Config::get('timeFormat'), $this->varValue[$j][$currentDay]['from']) : ($this->varValue[$j][$currentDay]['from'] ?? ''),
                    ],
                    'to' => [
                        'id' => $this->strId.'_'.$j.'_'.$currentDay.'_to',
                        'name' => $this->strId.'['.$j.']['.$currentDay.'][to]',
                        'value' => is_numeric($this->varValue[$j][$currentDay]['to'] ?? false) ? Date::parse(Config::get('timeFormat'), $this->varValue[$j][$currentDay]['to']) : ($this->varValue[$j][$currentDay]['to'] ?? ''),
                    ],
                ];
            }
        }

        return $body;
    }

    /**
     * @inheritdoc
     */
    public function parse($attributes = null)
    {
        $this->weekOffset = ($this->weekOffset === null) ? $GLOBALS['TL_LANG']['MSC']['weekOffset'] : $this->weekOffset;

        // Make sure there is at least an empty array
        if (!is_array($this->varValue) || empty($this->varValue)) {
            $this->varValue = [
                [
                    'from' => '',
                    'to' => '',
                ],
            ];
        }

        return parent::parse($attributes);
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        return $this->parse();
    }
}
