<?php
/***************************************************************
 *  Copyright notice
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

/**
 * Helper functions for TCA configuration
 *
 * @package Ictiextbase
 * @subpackage Helpers
 * @scope prototype
 * @api
 */
class Tx_Ictiextbase_Helpers_TcaObject  {

	/**
	 * table referenced by this object
	 *
	 * @var string
	 */	
	protected $tableName;
	
	/**
	 * TCA reference for this table
	 *
	 * @var string
	 */	
	public $tca;	
	
	protected $isFullTCALoaded = false;
	
	public function __construct($tableName){
		
		$this->checkTableNameIsInTCA($tableName);
		$this->tableName = $tableName;
		
		global $TCA;
		$this->tca = &$TCA[$tableName];
	}
	
	protected function checkTableNameIsInTCA($tableName){
		global $TCA;
		if(!isset($TCA[$tableName])){
			throw new Tx_Ictiextbase_Helpers_Exception_TableNotInTCA();
		}
	}
	
	protected function loadFullTCA(){
		if(!$this->isFullTCALoaded){
			t3lib_div::loadTCA($this->tableName);
			$this->isFullTCALoaded = true;
		}
	}
	
	protected function getTypeFieldName(){
		return $this->tca['ctrl']['type'];
	}
	
	protected function columnExists($columnName){
		$this->loadFullTCA();
		if(isset($this->tca['columns'][$columnName])){
			return true;
		} else {
			return false;
		}
	}
	
	/*
	 * Merge columns data from other table into this
	 * Only new columns will be added...
	 * 
	 * @param array $columns
	 * 
	 */
	public function addNewColumns(array $columns){
		foreach($columns as $name => $column){
			if(!$this->columnExists($name)){
				$this->addNewColumn($name, $column);
			}
		}
	}
	
	public function addNewColumn($name, array $column){
		$this->loadFullTCA();
		$this->tca['columns'][$name] = $column;
	}
	
	
	public function registerSTI(Tx_Ictiextbase_Helpers_TcaStiObject $stiObject){
		
		/* Add to the register type selection */
		$this->tca['columns'][$this->getTypeFieldName()]['config']['items'][] = array(
			$stiObject->getTitle(),
			$stiObject->getSubClassName()
		);
				
		/* Add the showItem config for the subclass */
		$this->tca['types'][$stiObject->getSubClassName()] = array(
			'showitem' => $stiObject->getShowItem()
		);
		
		/* Sets default type */
		//$this->tca['types']['1'] = $this->tca['types'][$stiObject->getSubClassName()];
	}
	
    
}



?>