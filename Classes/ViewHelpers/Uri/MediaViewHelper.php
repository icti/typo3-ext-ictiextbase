<?php

class Tx_Ictiextbase_ViewHelpers_Uri_MediaViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {


	/**
	 * @param Tx_Icticontent_Domain_Model_Media $media DAM file to create the link
	 * @param boolean $absolute If set, an absolute URI is rendered
	 * @return string Rendered page URI
	 */
	public function render(Tx_Ictiextbase_Domain_Model_MediaInterface $media, $absolute = FALSE) {
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uri = $uriBuilder
			->reset()
			->setTargetPageUid( $this->sanitizeFileUri( $media->getMediaUri() ) )
			->setCreateAbsoluteUri($absolute)
			->build();

		if($absolute !== FALSE){
				$uri = $this->forceAbsoluteUrl($uri);
		}

		return $uri;
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
