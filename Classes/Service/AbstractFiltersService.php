<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Jose Antonio Guerra <jaguerra@icti.es>, ICTI Internet Passion
*  
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


abstract class Tx_Ictiextbase_Service_AbstractFiltersService implements Tx_Ictiextbase_Service_ServiceInterface {

	
	
	/*
	 * Filter list
	 * 
	 * Configurable on DocComments..
	 * 
	 * Default items:
	 * 
	 * @Ictiextbase\Service\Filters\class Tx_Icticontent_Domain_Model_<propertyName>
	 * @Ictiextbase\Service\Filters\paramName filter<propertyName>
	 * @Ictiextbase\Service\Filters\multiple no
	 * 
	 */
	// protected $filtarVariable;
	
	
	protected $className;
	protected $filterProperties = array();
	
	protected function initReflection(){
		$this->className = get_class($this);
		$propertyNames = $this->reflectionService->getClassPropertyNames($this->className);
		
		foreach($propertyNames as $propertyName){
			if($this->reflectionService->isPropertyTaggedWith($this->className, $propertyName, 'Ictiextbase\Service\Filters\filter')){
				$this->addPropertyToFilters($propertyName);
			}
		}
		
	}
	
	protected function addPropertyToFilters($propertyName){
		
		if($this->reflectionService->isPropertyTaggedWith($this->className, $propertyName, 'Ictiextbase\Service\Filters\class')){
			$value = $this->reflectionService->getPropertyTagValues($this->className, $propertyName, 'Ictiextbase\Service\Filters\class');
			$className = $value[0];			
		} else {
			$className = false;
		}

		
		$value = $this->reflectionService->getPropertyTagValues($this->className, $propertyName, 'Ictiextbase\Service\Filters\multiple');
		if($value[0] == 'yes' || $value[0] == 'true'){
			$isMultiple = true;
		} else {
			$isMultiple = false;
		}
		
		$this->filterProperties[$propertyName] = new Tx_Ictiextbase_Service_Filter($className, $propertyName, $isMultiple);
		
	}
	
	public function getFilterProperties(){
		return $this->filterProperties;
	}
	
	
	
	/**
	 * @var Tx_Extbase_Reflection_Service
	 */
	protected $reflectionService;
	
	/**
	 * @param Tx_Extbase_Reflection_Service $reflectionService
	 * @return void
	 */
	public function injectReflectionService(Tx_Extbase_Reflection_Service $reflectionService) {
		$this->reflectionService = $reflectionService;
		$this->initReflection();
	}
	

	
	/**
	 * Reconstitutes a property. Only for internal use.
	 *
	 * @param string $propertyName
	 * @param string $value
	 * @return void
	 */
	public function _setProperty($propertyName, $propertyValue) {
		if ($this->_hasProperty($propertyName)) {
			
			$propertyClassName = $this->filterProperties[$propertyName]->getClassName();
			if($propertyClassName!==false && $propertyValue instanceof $propertyClassName){
				$this->$propertyName = $propertyValue;
			} else if($propertyClassName!==false) {
				$this->$propertyName = $this->findObjectByUid($propertyValue, $propertyClassName);
			} else {
				$this->$propertyName = $propertyValue;
			}
			
			
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Returns the property value of the given property name. Only for internal use.
	 *
	 * @return mixed The propertyValue
	 */
	public function _getProperty($propertyName) {
		return $this->$propertyName;
	}

	
	/**
	 * Returns the property value of the given property name. Only for internal use.
	 *
	 * @return boolean TRUE bool true if the property exists, FALSE if it doesn't exist or
	 * NULL in case of an error.
	 */
	public function _hasProperty($propertyName) {
		return isset($this->filterProperties[$propertyName]);
	}
	
	/**
	 * Magic setter method for the argument values. Each argument
	 * value can be set by just calling the setArgumentName() method.
	 *
	 * @param string $methodName Name of the method
	 * @param array $arguments Method arguments
	 * @return void
	 */
	public function __call($methodName, array $arguments) {
		
		switch(substr($methodName, 0, 3)){
			case 'set':
				return $this->_magicSet($methodName,$arguments);
				break;
			case 'get':
				return $this->_magicGet($methodName,$arguments);
				break;
			default:
				throw new LogicException('Unknown method "' . $methodName . '".', 1210858451);
		}
	}	
	
	/**
	 *
	 * @param type $methodName
	 * @param array $arguments
	 * @return type 
	 */
	protected function _magicGet($methodName, array $arguments) {
		$firstLowerCaseArgumentName = strtolower($methodName{3}) . substr($methodName, 4);
		$firstUpperCaseArgumentName = ucfirst(substr($methodName, 3));
		if($this->_hasProperty($firstLowerCaseArgumentName)){
			return $this->_getProperty($firstLowerCaseArgumentName);
		} else {
			throw new LogicException('Unknown method "' . $methodName . '".', 1210858451);
		}
	}
	
	/**
	 *
	 * @param type $methodName
	 * @param array $arguments 
	 */
	protected function _magicSet($methodName, array $arguments) {
		$firstLowerCaseArgumentName = strtolower($methodName{3}) . substr($methodName, 4);
		$firstUpperCaseArgumentName = ucfirst(substr($methodName, 3));
		if($this->_hasProperty($firstLowerCaseArgumentName)){
			$this->_setProperty($firstLowerCaseArgumentName,$arguments[0]);
		} else {
			throw new LogicException('Unknown method "' . $methodName . '".', 1210858451);
		}
	}	
	
	
	/* ----- */
	
	
    /**
	 *
	 * @var type 
	 */
    protected $arguments;
	
	/**
	 *
	 * @var type 
	 */
	protected $settings;
    
    /**
	 *
	 * @param type $arguments 
	 */
    public function init($arguments, $settings = null){
        $this->arguments = $arguments;
        $this->settings = $settings;
		
		foreach($this->filterProperties as $filterName => $filterMetaData){
			if($this->hasFilterValue($filterName)){
				$this->_setProperty($filterName, $this->getFilterValue($filterName));
			}
		}
		
        
            
    }
    
 	/**
	 * @var Tx_Extbase_Persistence_QueryFactory
	 */
	protected $queryFactory;
    
	/**
	 * Injects a QueryFactory instance
	 *
	 * @param Tx_Extbase_Persistence_QueryFactoryInterface $queryFactory
	 * @return void
	 */
	public function injectQueryFactory(Tx_Extbase_Persistence_QueryFactoryInterface $queryFactory) {
		$this->queryFactory = $queryFactory;
	}        
    
    


 
    
    /**
	 *
	 * @param type $filterName
	 * @return type 
	 */
    protected function hasFilterValue($filterName){
        
        if($this->settings[$filterName]){
            
            return true;
            
        } else if(!$this->noFiltersFromArguments && $this->arguments->hasArgument($filterName)){
            
            if($this->arguments[$filterName]->getValue() != null){
                return true;
            }
        } 
        
        return false; 
    }    
    
	/**
	 *
	 * @param type $filterName
	 * @return type 
	 */
    protected function getFilterValue($filterName){
        
        $argumentWasSetHere = false;
        
        if($this->settings[$filterName]){
			return $this->settings[$filterName];
        } 
        
        if((!$this->noFiltersFromArguments || $argumentWasSetHere) && $this->arguments->hasArgument($filterName)){
            if($this->arguments[$filterName]->getValue() != null){
                return $this->arguments[$filterName]->getValue();
            }
        }
        
        return null;
    }   
    
	/**
	 * Finds an object from the repository by searching for its technical UID.
	 *
	 * @param int $uid The object's uid
	 * @return object Either the object matching the uid or, if none or more than one object was found, NULL
	 */
	protected function findObjectByUid($uid, $dataType) {
		$query = $this->queryFactory->create($dataType);
		$query->getQuerySettings()->setRespectSysLanguage(FALSE);
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		return $query->matching(
			$query->equals('uid', $uid))
			->execute()
			->getFirst();
	}     

}
?>