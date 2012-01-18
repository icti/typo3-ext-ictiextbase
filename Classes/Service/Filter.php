<?php


/**
 * Description of Filter
 *
 * @author jaguerra
 */
class Tx_Ictiextbase_Service_Filter {

	protected $className;
	protected $paramName;
	protected $isMultiple = false;
	
	public function __construct($className, $paramName, $isMultiple = false){
		$this->className = $className;
		$this->paramName = $paramName;
		$this->isMultiple = $isMultiple;
	}
	
	public function getClassName(){
		return $this->className;
	}
	
	public function getParamName(){
		return $this->paramName;
	}
	
	public function getIsMultiple(){
		return $this->isMultiple;
	}
	
	
}

?>
