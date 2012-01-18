<?php

/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 * @scope prototype
 */

require_once(t3lib_extMgm::extPath('flvplayer2').'pi1/class.tx_flvplayer2_pi1.php');

class Tx_Ictiextbase_ViewHelpers_FlvplayerViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Iterates through elements of $each and renders child nodes
	 *
	 * @param string $url The video URL
	 * @param string $width Player width (optional)
	 * @param string $height Player height (optional)
	 * @return string Rendered string
	 * @api
	 */
	public function render($url, $width=null, $height=null) {
		$output = '';
		if ($url === NULL) {
			return '';
		}
		
		$flvplayerConf = array();
		if($width > 0){
			$flvplayerConf['width'] = $width;
		}
		if($height > 0){
			$flvplayerConf['height'] = $height;
		}		
		$flvPlayer = t3lib_div::makeInstance('tx_flvplayer2_pi1');
		$output = $flvPlayer->getVideoCode($url, $flvplayerConf);
		
		return $output;
	}
}

?>
