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
 * 
 *
 * @package Ictiextbase
 * @subpackage Helpers
 * @scope prototype
 * @api
 */
class Tx_Ictiextbase_Helpers_DateTime extends DateTime  {


	
	
	/**
	 *
	 * @return int Last day of the current date's month 
	 */
	public function getLastDayOfMonth() {
		
		$month = $this->format('n');
		$year = $this->format('Y');
		
		$result = strtotime("{$year}-{$month}-01"); 
		$result = strtotime('-1 second', strtotime('+1 month', $result)); 
		return date('d', $result); 
	} 

	public function addMonths($delta) { 
		
		$month = $this->format('n');
		$year = $this->format('Y');
		$day = $this->format('j');
		$hour = $this->format('G');
		$minute = $this->format('i');
		$second = $this->format('s');
		
		$month += $delta;
		
		$monthDate = new Tx_Ictiextbase_Helpers_DateTime;
		$monthDate->setDate($year, $month, 1);
		$monthDate->setTime(0,0);
		
		if($monthDate->getLastDayOfMonth() < $day){
			$day = $monthDate->getLastDayOfMonth();
		}
		
		$this->setDate($year, $month, $day);
		$this->setTime($hour, $minute, $second);
		
	} 	
	
	public function diffMonths(DateTime $diffDate){
		
		if($diffDate instanceof Tx_Ictiextbase_Helpers_DateTime){
			
		} else {
			$diffDate = Tx_Ictiextbase_Helpers_DateTime::copyFromDateTime($diffDate);
		}
		
		$thisDateMonth = clone $this;
		$thisDateMonth->toFirstDayOfMonth();
		
		$diffDateMonth = clone $diffDate;
		$diffDateMonth->toFirstDayOfMonth();
		
		/**
		 * Can't use DateDiff, need to be PHP 5.2 compatible...
		 */
		$diffTstamp =  $diffDateMonth->format('U') - $thisDateMonth->format('U');

		$diffGetDate = getdate($diffTstamp);
		$diffMonths =  ($diffGetDate['year'] - 1970) * 12 + ($diffGetDate['mon'] - 1);		
		return $diffMonths;
		
	}
	
	/**
	 *
	 * @return Tx_Ictiextbase_Helpers_DateTime 
	 */
	public function toFirstDayOfMonth(){
		$month = $this->format('n');
		$year = $this->format('Y');	
		$this->setDate($year, $month, 1);
		$this->setTime(0,0);
		return $this;
	}
	
	public function __toString (){
		return $this->format('c');
	}
	
	
	/**
	 * Creates a Tx_Ictiextbase_Helpers_DateTime object from a DateTime
	 *
	 * @param DateTime $source
	 * @return Tx_Ictiextbase_Helpers_DateTime 
	 */
	static public function copyFromDateTime(DateTime $source){
		$newDateTime = new Tx_Ictiextbase_Helpers_DateTime($source->format('c'));
		return $newDateTime;
	}
	
}
?>
