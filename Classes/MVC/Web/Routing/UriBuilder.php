<?php

class Tx_Ictiextbase_MVC_Web_Routing_UriBuilder extends Tx_Extbase_MVC_Web_Routing_UriBuilder {

		/**
	 	 * @var string
	 	 */
		protected $addQueryStringMethod = NULL;

		/**
	 	 * Sets the method to get the addQueryString parameters. Defaults undefined
	 	 * which results in using QUERY_STRING.
	 	 *
	 	 * @param string $addQueryStringMethod
	 	 * @return Tx_Extbase_MVC_Web_Routing_UriBuilder the current UriBuilder to allow method chaining
	 	 * @api
	 	 * @see TSref/typolink.addQueryString.method
	 	 */
		public function setAddQueryStringMethod($addQueryStringMethod) {
				$this->addQueryStringMethod = $addQueryStringMethod;
				return $this;
		}

		/**
	 	 * @return string
	 	 * @api
	 	 */
		public function getAddQueryStringMethod() {
				return (string)$this->addQueryStringMethod;
		}

		/**
	 	 * Builds a TypoLink configuration array from the current settings
	 	 *
	 	 * @return array typolink configuration array
	 	 * @see TSref/typolink
	 	 */
		protected function buildTypolinkConfiguration() {
				$typolinkConfiguration = parent::buildTypolinkConfiguration();

				if ($this->addQueryString === TRUE) {
						if ($this->addQueryStringMethod) {
								$typolinkConfiguration['addQueryString.']['method'] = $this->addQueryStringMethod;
						}
				}

				return $typolinkConfiguration;
		}

}