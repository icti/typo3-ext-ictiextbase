<?php

class Tx_Ictiextbase_ViewHelpers_Widget_LinkViewHelper extends Tx_Fluid_ViewHelpers_Widget_LinkViewHelper {

	/**
	 * Get the URI for a non-AJAX Request.
	 *
	 * @return string the Widget URI
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
		protected function getWidgetUri() {
				$uriBuilder = $this->controllerContext->getUriBuilder();

				$argumentPrefix = $this->controllerContext->getRequest()->getArgumentPrefix();
				$arguments = $this->arguments->hasArgument('arguments') ? $this->arguments['arguments'] : array();
				if ($this->arguments->hasArgument('action')) {
						$arguments['action'] = $this->arguments['action'];
				}
				if ($this->arguments->hasArgument('format') && $this->arguments['format'] !== '') {
						$arguments['format'] = $this->arguments['format'];
				}

				if ($this->arguments->hasArgument('addQueryStringMethod') && $this->arguments['addQueryStringMethod'] !== '') {
						$arguments['addQueryStringMethod'] = $this->arguments['addQueryStringMethod'];
				}

				return $uriBuilder
						->reset()
						->setArguments(array($argumentPrefix => $arguments))
						->setSection($this->arguments['section'])
						->setAddQueryString(TRUE)
						->setArgumentsToBeExcludedFromQueryString(array($argumentPrefix, 'cHash'))
						->setAddQueryStringMethod($arguments['addQueryStringMethod'])
						->setFormat($this->arguments['format'])
						->build();
		}		
}

?>
