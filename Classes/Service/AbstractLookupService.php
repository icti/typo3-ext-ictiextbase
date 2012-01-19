<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LookupService
 *
 * @author jaguerra
 */
abstract class Tx_Ictiextbase_Service_AbstractLookupService implements Tx_Ictiextbase_Service_ServiceInterface {

	
	/**
	 *
	 * @var Tx_Ictiextbase_Service_AbstractFiltersService 
	 */
	protected $filtersService;

	
	public function setFiltersService(Tx_Ictiextbase_Service_AbstractFiltersService $filtersService){
		$this->filtersService = $filtersService;
	}
	
	protected function hasFiltersService(){
		if($this->filtersService && $this->filtersService instanceof Tx_Ictiextbase_Service_AbstractFiltersService){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @var Tx_Extbase_Persistence_QueryFactoryInterface
	 */
	protected $queryFactory;	
	
	/**
	 * @param Tx_Extbase_Persistence_QueryFactory $queryFactory
	 * @return void
	 */
	public function injectQueryFactory(Tx_Extbase_Persistence_QueryFactory $queryFactory) {
		$this->queryFactory = $queryFactory;
	}	
	
	/**
	 * Returns a query for objects of this object type
	 *
	 * @param string $objectType
	 * @return Tx_Extbase_Persistence_QueryInterface
	 */
	protected function createQueryForObjectType($objectType) {
		$query = $this->queryFactory->create($objectType);
		return $query;
	}	
	
	/**
	 * Returns all objects of this object type
	 * 
	 * @param type $objectType
	 * @return type 
	 */
	protected function findAllForObjectType($objectType) {
		$result = $this->createQueryForObjectType($objectType)->execute();
		return $result;		
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
	 * Returns the property value of the given property name. Only for internal use.
	 *
	 * @return boolean TRUE bool true if the property exists, FALSE if it doesn't exist or
	 * NULL in case of an error.
	 */
	protected function _hasProperty($propertyName) {
		
		$repositoryPropertyName = $this->_getRepositoryNameFromPropertyName($propertyName);
		
		if(isset($this->$repositoryPropertyName)){
			return true;
		} else if($this->hasFiltersService() && $this->filtersService->isFilterDefined($propertyName)){
			return true;
		} else {
			return false;
		}
	}	
	
	/**
	 * Returns the QueryResult for the object type
	 * 
	 * It gets the QueryResult from these sources, in order of priority:
	 * 
	 * 1) Defined repository on class (ej: <$propertyName>Repository)
	 * 2) Self-generated repository on object type from propertyName on filtersService (magic!)
	 *
	 * @return Tx_Extbase_Persistence_QueryResultInterface|false 
	 */
	protected function _getProperty($propertyName) {
		$repositoryPropertyName = $this->_getRepositoryNameFromPropertyName($propertyName);
		
		if(isset($this->$repositoryPropertyName)){
			return $this->$repositoryPropertyName->findAll();
		} else if($this->hasFiltersService() && $this->filtersService->isFilterDefined($propertyName)){
			$filter = $this->filtersService->getFilterDefinition($propertyName);
			if($filter->getClassName()){
				return $this->findAllForObjectType($filter->getClassName());
			} else {
				return false;
			}
		} else {
			return false;
		}		
	}	
	
	/**
	 *
	 * @param type $propertyName
	 * @return type 
	 */
	protected function _getRepositoryNameFromPropertyName($propertyName){
		return $propertyName.'Repository';
	}
	
}

?>
