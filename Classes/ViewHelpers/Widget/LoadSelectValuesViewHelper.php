<?php


class Tx_Ictiextbase_ViewHelpers_Widget_LoadSelectValuesViewHelper extends Tx_Fluid_Core_Widget_AbstractWidgetViewHelper {

	/**
	 * @var bool
	 */
	protected $ajaxWidget = TRUE;

	/**
	 * @var Tx_Ictiextbase_ViewHelpers_Widget_Controller_LoadSelectValuesController
	 */
	protected $controller;

	/**
	 * @param Tx_Ictiextbase_ViewHelpers_Widget_Controller_LoadSelectValuesController $controller
	 * @return void
	 */
	public function injectController(Tx_Ictiextbase_ViewHelpers_Widget_Controller_LoadSelectValuesController $controller) {
		$this->controller = $controller;
	}

	
	/**
	 *
	 * @param string $parentId
	 * @param string $childContainerId
	 * @param string $childId
	 * @param string $optionLabelField
	 * @param string $withAnyOption
	 * @param Tx_Extbase_Persistence_QueryResult $parentOptions
	 * @param string $parentOptionsDataProperty
	 * @param Tx_Extbase_Persistence_QueryResult $childObjects
	 * @param string $childObjectsFindProperty
	 * @return string 
	 */
	public function render(
			$parentId, 
			$childContainerId,
			$childId,
			$optionLabelField,
			$withAnyOption = null,
			Tx_Extbase_Persistence_QueryResult $parentOptions = null, 
			$parentOptionsDataProperty = null,
			Tx_Extbase_Persistence_QueryResult $childObjects = null, 
			$childObjectsFindProperty = null
		) {
		
		if($parentOptions === null && $childObjects === null){
			throw new ErrorException('parentOptions or childObjects must be set!');
		}
		
		if($parentOptions !== null && $childObjects !== null){
			throw new ErrorException('parentOptions and childObjects cannot be set at the same time!');
		}		
		
		return $this->initiateSubRequest();
	}
}
?>
