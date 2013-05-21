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

		return $uri;
	}
	
	protected function sanitizeFileUri($fileUri){
		return str_replace(' ','%20',$fileUri);
	}

}


?>
