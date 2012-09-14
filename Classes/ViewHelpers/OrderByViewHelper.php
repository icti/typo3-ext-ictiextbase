<?php

class Tx_Ictiextbase_ViewHelpers_OrderByViewHelper extends Tx_Fluid_ViewHelpers_FormViewHelper {


	/**
	 * Iterates through elements of $each and renders child nodes
	 *
	 * @param array $each The array or Tx_Extbase_Persistence_ObjectStorage to iterated over
	 * @param string $as The name of the iteration variable
	 * @param string $orderBy The name of the variable to store the current array key
	 * @param boolean $reverse If enabled, the iterator will start with the last element and proceed reversely
	 * @return string Rendered string
	 * @api
	 */
	public function render($each, $as, $orderBy = '', $reverse = FALSE) {
		$output = '';
		if ($each === NULL) {
			return '';
		}
		if (is_object($each) && !$each instanceof Traversable) {
			throw new Tx_Fluid_Core_ViewHelper_Exception('OrderByViewHelper only supports arrays and objects implementing Traversable interface' , 1248728393);
		}


    $eachWithOrderKey = array();
    foreach($each as $v){
      $key = $v->_getProperty($orderBy);
      if($key instanceof DateTime){
        $key = $key->format('U');
      }
      $eachWithOrderKey[$key] = $v;
    }

    if($reverse){
      krsort($eachWithOrderKey);
    } else {
      ksort($eachWithOrderKey);
    }

    $this->templateVariableContainer->add($as, $eachWithOrderKey);

		return $this->renderChildren();
	}


}

?>
