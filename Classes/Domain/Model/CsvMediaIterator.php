<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CsvMediaIterator
 *
 * @author jaguerra
 */
class Tx_Ictiextbase_Domain_Model_CsvMediaIterator extends ArrayIterator {
	//put your code here
	
	/**
	 * Transform a comma separated list of filenames into an Iterator
	 * structure
	 * 
	 * 
	 * @param type $filesCsv
	 * @param type $baseUrl 
	 */
	public function __construct($filesCsv, $baseUrl, $captionsLsv = null, $altTextsLsv = null){
		
		$this->filesCsv = $filesCsv;
		
		$files = explode(',', $filesCsv);
		
		$captions = explode("\n", $captionsLsv);
		$altTexts = explode("\n", $altTextsLsv);
		
		if(is_array($files) && count($files) > 0){
			$i = 0;
			foreach($files as $file){
				
				if(isset($captions[$i])){
					$caption = trim($captions[$i]);
				} else {
					$caption = null;
				}
				
				if(isset($altTexts[$i])){
					$altText = trim($altTexts[$i]);
				} else {
					$altText = null;
				}				
				
				$this->append( new Tx_Ictiextbase_Domain_Model_CsvMediaItem($file, $baseUrl, $caption, $altText) );
				$i++;
			}
		}
	}
	
	/**
	 * Original field value
	 * 
	 * @var type 
	 */
	protected $filesCsv;
	
	/**
	 * Returns original field value
	 * @return type 
	 */
	public function __toString(){
		return $this->filesCsv;
	}
	
	
}

?>
