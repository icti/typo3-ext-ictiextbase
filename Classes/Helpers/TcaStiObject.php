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
class Tx_Ictiextbase_Helpers_TcaStiObject  {

	/*
	 * The class modelling the STI 
	 * 
	 * @var string subClassName
	 */
	protected $subClassName;
	
	/*
	 * TCA's showitem to be configured...
	 * @var string
	 */
	protected $showItem;
	
	/*
	 * Title for the record type selector
	 * @var string
	 */
	protected $title;
	
	
	
	public function __construct($subClassName){
		$this->subClassName = $subClassName;
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function setShowItem($string){
		$this->showItem = $string;
	}
	
	
	public function getSubClassName(){
		return $this->subClassName;
	}

	public function getShowItem(){
		return $this->showItem;
	}
	
	public function getTitle(){
		return $this->title;
	}	
	
	
    
}



?>