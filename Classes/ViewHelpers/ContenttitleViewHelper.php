<?php

/**
 * This ViewHelper substitutes the page title string directly from the 
 * rendered page output
 *
 * This is the only way to change the global title on USER_INT plugins.
 *
 * To further control the substitution the page title must be enclosed 
 * between "###".
 *
 * = Examples =
 *
 * {namespace ficti=Tx_Ictiextbase_ViewHelpers}
 * <ficti:contenttitle>New title</ficti:contenttitle>
 * 
 * @api
 */
class Tx_Ictiextbase_ViewHelpers_ContenttitleViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

		/**
		 * @return string Rendered string
		 * @api
		 */
		public function render() {

				$newTitle = html_entity_decode($this->renderChildren(), ENT_QUOTES | ENT_XHTML);
				$currentTitle = $GLOBALS['GLOBALS']['TSFE']->page['title'];
				if ( preg_match( '/^###.*###$/', $currentTitle) ) {
						$GLOBALS['GLOBALS']['TSFE']->content = str_replace($currentTitle, $newTitle, $GLOBALS['GLOBALS']['TSFE']->content);
				}

				return '';

		}
}

?>