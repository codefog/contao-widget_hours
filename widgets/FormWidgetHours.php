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


namespace Contao;


/**
 * Class FormWidgetHours
 * Form field "hours".
 */
class FormWidgetHours extends \Widget
{

	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

	/**
	 * Rows
	 * @var integer
	 */
	protected $intRows = 1;

	/**
	 * Week offset
	 * @var integer
	 */
	protected $intWeekOffset = null;

	/**
	 * Date object
	 * @var Date
	 */
	protected $Date;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'form_widget';


	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'rows':
				$this->intRows = $varValue;
				break;

			case 'weekOffset':
				$this->intWeekOffset = $varValue;
				break;

			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}



	/**
	 * Initialize the object
	 * @param array
	 */
	public function __construct($arrAttributes=null)
	{
		parent::__construct($arrAttributes);
		$this->Date = new \Date();
	}


	/**
	 * Validate input and set value
	 */
	public function validate()
	{
		$blnMandatory = $this->mandatory;
		$arrInput = deserialize($this->getPost($this->strName), true);

		foreach ($arrInput as $k=>$arrDays)
		{
			foreach ($arrDays as $kk=>&$arrDay)
			{
				// Mandatory check
				if ($blnMandatory && ($arrDay['from'] != '' && $arrDay['to'] != ''))
				{
					$blnMandatory = false;
				}
				if ($arrDay['from'] != '' XOR $arrDay['to'] != '')
				{
					$blnMandatory = true;
				}

				// Valid time check
				if (($arrDay['from'] != '' && !preg_match('~^'. $this->Date->getRegexp($GLOBALS['TL_CONFIG']['timeFormat']) .'$~i', $arrDay['from'])) || ($arrDay['to'] != '' && !preg_match('~^'. $this->Date->getRegexp($GLOBALS['TL_CONFIG']['timeFormat']) .'$~i', $arrDay['to'])))
				{
					$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['time'], $this->Date->getInputFormat($GLOBALS['TL_CONFIG']['timeFormat'])));
					break 2;
				}

				if ($arrDay['from'] != '' && $arrDay['to'] != '')
				{
					$objFrom = new \Date($arrDay['from'], $GLOBALS['TL_CONFIG']['timeFormat']);
					$objTo = new \Date($arrDay['to'], $GLOBALS['TL_CONFIG']['timeFormat']);

					$arrInput[$k][$kk]['from'] = $objFrom->tstamp;
					$arrInput[$k][$kk]['to'] = $objTo->tstamp;
				}
			}
		}

		// Throws an error if the field is mandatory
		if ($blnMandatory)
		{
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['mandatory'], $this->strLabel));
		}

		$this->varValue = $arrInput;
	}


	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		$this->intWeekOffset = ($this->intWeekOffset === null) ? $GLOBALS['TL_LANG']['MSC']['weekOffset'] : $this->intWeekOffset;

		// Make sure there is at least an empty array
		if (!is_array($this->varValue) || empty($this->varValue))
		{
			$this->varValue = array(array
			(
				'from' => '',
				'to'=>''
			));
		}

		// Add stylesheet
		$GLOBALS['TL_CSS']['widget_hours'] = 'system/modules/widget_hours/assets/widgethours.css';

		$strReturn = '<table class="tl_widgethours" id="ctrl_'.$this->strId.'">
  <thead>
    <tr>';

    	// Generate table headers
    	for ($i=0; $i<7; $i++)
    	{
	    	$intCurrentDay = ($i + $this->intWeekOffset) % 7;
    		$strReturn .= '<th>' . $GLOBALS['TL_LANG']['DAYS'][$intCurrentDay] . '</th>';
    	}

		$strReturn .='</tr>
  </thead>
  <tbody>';

  		for ($j=0; $j<$this->intRows; $j++)
  		{
	  		$strReturn .= '<tr class="wh_row">';

			// Morning hours
			for ($i=0; $i<7; $i++)
			{
		    	$intCurrentDay = ($i + $this->intWeekOffset) % 7;
		    	$varFrom = is_numeric($this->varValue[$j][$intCurrentDay]['from']) ? $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], $this->varValue[$j][$intCurrentDay]['from']) : $this->varValue[$j][$intCurrentDay]['from'];
		    	$varTo = is_numeric($this->varValue[$j][$intCurrentDay]['to']) ? $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], $this->varValue[$j][$intCurrentDay]['to']) : $this->varValue[$j][$intCurrentDay]['to'];

				$strReturn .= '<td><span>'.$GLOBALS['TL_LANG']['MSC']['wh_from'].'</span><span>'.$GLOBALS['TL_LANG']['MSC']['wh_to'].'</span><br><input type="text" name="'.$this->strId.'['.$j.']['.$intCurrentDay.'][from]" id="'.$this->strId.'_'.$j.'_'.$intCurrentDay.'_from" class="tl_text" value="'.$varFrom.'">';
				$strReturn .= '-<input type="text" name="'.$this->strId.'['.$j.']['.$intCurrentDay.'][to]" id="'.$this->strId.'_'.$j.'_'.$intCurrentDay.'_from" class="tl_text" value="'.$varTo.'"></td>';
			}

			$strReturn .= '</tr>';
  		}


		return $strReturn . '</tbody></table>';
	}
}
