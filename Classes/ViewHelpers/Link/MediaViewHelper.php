<?php

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * A view helper for creating links to TYPO3 pages.
 *
 * = Examples =
 *
 * <code title="link to the current page">
 * <f:link.page>page link</f:link.page>
 * </code>
 * <output>
 * <a href="index.php?id=123">page link</f:link.action>
 * (depending on the current page and your TS configuration)
 * </output>
 *
 * <code title="query parameters">
 * <f:link.page pageUid="1" additionalParams="{foo: 'bar'}">page link</f:link.page>
 * </code>
 * <output>
 * <a href="index.php?id=1&foo=bar">page link</f:link.action>
 * (depending on your TS configuration)
 * </output>
 *
 * <code title="query parameters for extensions">
 * <f:link.page pageUid="1" additionalParams="{extension_key: {foo: 'bar'}}">page link</f:link.page>
 * </code>
 * <output>
 * <a href="index.php?id=1&extension_key[foo]=bar">page link</f:link.action>
 * (depending on your TS configuration)
 * </output>
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_Ictiextbase_ViewHelpers_Link_MediaViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'a';

	/**
	 * Arguments initialization
	 *
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('target', 'string', 'Target of link', FALSE);
		$this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document', FALSE);
	}

	/**
	 * @param Tx_Icticontent_Domain_Model_Media $media DAM file to create the link
	 * @param boolean $absolute If set, an absolute URI is rendered
	 * @return string Rendered page URI
	 */
	public function render(Tx_Ictiextbase_Domain_Model_MediaInterface $media) {
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uri = $uriBuilder
			->reset()
			->setTargetPageUid( $this->sanitizeFileUri( $media->getMediaUri() ) )
			->setCreateAbsoluteUri($absolute)
			->build();

		if($absolute !== FALSE){
				$uri = $this->forceAbsoluteUrl($uri);
		}

		$this->tag->addAttribute('href', $uri);
		$this->tag->setContent($this->renderChildren());

		return $this->tag->render();
	}

	protected function forceAbsoluteUrl($url){

			$urlParts = parse_url($url);

			// Set scheme and host if not yet part of the URL:
			if (empty($urlParts['host'])) {
					$url = implode('', array( $this->getSiteUrl(), $url ));
			}

			return $url;

	}

	protected function getSiteUrl(){
			if(!empty($GLOBALS['TSFE']->absRefPrefix)){
					return $GLOBALS['TSFE']->absRefPrefix;
			} else {
					return t3lib_div::getIndpEnv('TYPO3_SITE_URL');
			}
	}
	
	protected function sanitizeFileUri($fileUri){
		return str_replace(' ','%20',$fileUri);
	}
}


?>
