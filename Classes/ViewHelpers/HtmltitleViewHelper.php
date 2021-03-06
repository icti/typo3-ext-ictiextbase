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


class Tx_Ictiextbase_ViewHelpers_HtmltitleViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Render content through stdWrap.bytes
	 *
	 * @return string Rendered string
	 * @api
	 */
	public function render() {

        global $GLOBALS;
		
		$title = html_entity_decode($this->renderChildren(), ENT_QUOTES | ENT_XHTML) . ' : '.$GLOBALS['TSFE']->page['title'];
		
		$GLOBALS['TSFE']->page['title'] = $title;
		$GLOBALS['TSFE']->indexedDocTitle = $title;	

        
        /*
         * Esto en principio con USER no hace falta..sólo aplica en USER_INT
         */
        
		$GLOBALS['TSFE']->content = preg_replace(
		  '@<title>(.+):(.*)</title>@i',
		  '<title>'.$title.' : $2</title>',
		  $GLOBALS['TSFE']->content);	
		return '';

	}
}

?>
