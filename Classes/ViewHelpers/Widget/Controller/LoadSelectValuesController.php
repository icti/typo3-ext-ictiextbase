<?php


class Tx_Ictiextbase_ViewHelpers_Widget_Controller_LoadSelectValuesController extends Tx_Fluid_Core_Widget_AbstractWidgetController {

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('parentId', $this->widgetConfiguration['parentId']);
		$this->view->assign('childId', $this->widgetConfiguration['childId']);
		$this->view->assign('childContainerId', $this->widgetConfiguration['childContainerId']);
	}

	/**
	 * @param string $term
	 * @return string
	 */
	public function autocompleteAction($term) {
		
		$uid = $term;
		$output = array();
		
		if($this->widgetConfiguration['withAnyOption']){
			$output[] = array(
				'optionValue' => 0,
				'optionDisplay' => $this->widgetConfiguration['withAnyOption']
			);
		}
		
		if($this->widgetConfiguration['childObjects']!==null){
			$this->getValuesFromChildObjects($output, $uid);
		} else {
			$this->getValuesFromParentObjects($output, $uid);
		}
		
		return json_encode($output);		
		

	}
	
	protected function getValuesFromChildObjects(&$output, $uid){
		$query = $this->widgetConfiguration['childObjects']->getQuery();
		$childObjectsFindProperty = $this->widgetConfiguration['childObjectsFindProperty'];
		$optionLabelField = $this->widgetConfiguration['optionLabelField'];
		
		$query->matching(
			$query->equals($childObjectsFindProperty, $uid)
		);
		
		$results = $query->execute();
		
		foreach ($results as $singleResult) {
			$resultUid = Tx_Extbase_Reflection_ObjectAccess::getProperty($singleResult, 'uid');
			$val = Tx_Extbase_Reflection_ObjectAccess::getProperty($singleResult, $optionLabelField);
			$output[] = array(
				'optionValue' => $resultUid,
				'optionDisplay' => $val,
			);
		}		
	}
	
	protected function getValuesFromParentObjects(&$output, $uid){
		$query = $this->widgetConfiguration['parentOptions']->getQuery();
		$dataProperty = $this->widgetConfiguration['parentOptionsDataProperty'];
		$optionLabelField = $this->widgetConfiguration['optionLabelField'];
		
		$query->matching(
			$query->equals('uid', $uid)
		);
		
		$results = $query->execute();
		
		foreach ($results as $singleResult) {
			
			$dataPropertyValues = Tx_Extbase_Reflection_ObjectAccess::getProperty($singleResult, $dataProperty);
			foreach($dataPropertyValues as $singleValue){
				$resultUid = Tx_Extbase_Reflection_ObjectAccess::getProperty($singleValue, 'uid');
				$val = Tx_Extbase_Reflection_ObjectAccess::getProperty($singleValue, $optionLabelField);
				$output[] = array(
					'optionValue' => $resultUid,
					'optionDisplay' => $val,
				);				
			}
			

		}		
	}	
}

?>