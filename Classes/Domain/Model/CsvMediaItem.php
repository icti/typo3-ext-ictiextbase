<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CsvMediaItem
 *
 * @author jaguerra
 */
class Tx_Ictiextbase_Domain_Model_CsvMediaItem implements Tx_Ictiextbase_Domain_Model_MediaInterface {

	
	public function __construct($fileName, $baseUrl){
		$this->fileName = $fileName;
		$this->baseUrl = $baseUrl;
	}
	
	/**
	 *
	 * @var type 
	 */
	protected $baseUrl;
	
	/**
	 *
	 * @var type 
	 */
	protected $fileName;
	
	/**
	 *
	 * @return type 
	 */
	public function getFileName(){
		return $this->fileName;
	}
	
	/**
	 *
	 * @return type 
	 */
	public function getBaseUrl(){
		return $this->baseUrl;
	}	
	
	/**
	 * Returns the url
	 *
	 * @return string $url
	 */
	public function getMediaUri(){
		if($this->getFileName()){
			return $this->getBaseUrl().$this->getFileName();
		}
	}
}

?>
