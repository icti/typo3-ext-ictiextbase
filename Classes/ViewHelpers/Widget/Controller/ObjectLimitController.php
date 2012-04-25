<?php

class Tx_Ictiextbase_ViewHelpers_Widget_Controller_ObjectLimitController extends Tx_Fluid_Core_Widget_AbstractWidgetController {

	/**
	 * @var Tx_Extbase_Persistence_QueryResultInterface
	 */
	protected $objects;
	
	/**
	 *
	 * @var integer 
	 */
	protected $maxItems;

	/**
	 * @return void
	 */
	public function initializeAction() {
		$this->objects = $this->widgetConfiguration['objects'];
		$this->maxItems = (integer)$this->widgetConfiguration['maxItems'];
	}

	/**
	 * @return void
	 */
	public function indexAction() {
			// set current page
		$query = $this->objects->getQuery();
		$query->setLimit($this->maxItems);
		$modifiedObjects = $query->execute();

		$this->view->assign('contentArguments', array(
			$this->widgetConfiguration['as'] => $modifiedObjects
		));
	}

}

?>