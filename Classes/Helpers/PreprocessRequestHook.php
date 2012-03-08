<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PreprocessRequestHook
 *
 * @author jaguerra
 */
class Tx_Ictiextbase_Helpers_PreprocessRequestHook {
	
	
	/**
	 *
	 * Hook for $TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest'][]
	 * 
	 * @param type $param1
	 * @param type $param2
	 * @return type 
	 */
	public function preprocessRequest($param1, $param2){
		$cHash = $this->generateCHashOnParams($_GET);
		if($cHash){
			$_GET['cHash'] = $cHash;
		}
	}
	
	/**
	 *
	 * Genera cHash si no existe en los procesamientos de realurl, etc...
	 * 
	 * Para que funcione correctamente la extensión debe estar activada después que RealURL y cualquier otra similar...
	 * 
	 * Hook for $TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc'][]
	 * 
	 * @param type $params
	 * @param type $pObj 
	 */
	public function checkAlternativeIdMethodsPostProc($params, $pObj){
		$cHash = $this->generateCHashOnParams(t3lib_div::_GET());
		if($cHash){
			$getArray = array('cHash' => $cHash);
			$pObj->mergingWithGetVars($getArray);
		}
		
	}	
	
	/**
	 *
	 * Genera un cHash para el juego de parámetros si no existe
	 * 
	 * @param type $paramArray Array con GET
	 * @return type 
	 */
	protected function generateCHashOnParams($paramArray){
		if (is_array($paramArray) && !$paramArray['cHash']){
			$cHash_array = t3lib_div::cHashParams(t3lib_div::implodeArrayForUrl('',$paramArray));
			
			$cHash_array = $this->cleanEmptyArrayElements($cHash_array);
			
			//t3lib_div::sysLog('GET '.print_r($paramArray, true), 0);		
			//t3lib_div::sysLog('PR '.print_r($cHash_array, true), 0);		
			
			if(is_array($cHash_array) && count($cHash_array) == 1 && $cHash_array['encryptionKey']){
				/*
				 * Si no hay parámetros para calcular un cHash pues no calculamos nada...
				 */
				return;
			}
			
			$cHash = t3lib_div::calculateCHash($cHash_array);
			
			$message = 'Tx_Ictiextbase_Helpers_PreprocessRequestHook: Generating cHash "'.$cHash.'". The fieldlist used was "'.implode(',',array_keys($cHash_array)).'"';
			
			t3lib_div::sysLog($message, 1);			
			$GLOBALS['TT']->setTSlogMessage($message,1);
			
			return $cHash;
		}	
		
	}
	
	/**
	 *
	 * @param type $dirtyArray
	 * @return type 
	 */
	protected function cleanEmptyArrayElements($dirtyArray){
		$cleanArray = array();
		foreach($dirtyArray as $k=>$v){
			if($k && $v){
				$cleanArray[$k] = $v;
			}
		}
		return $cleanArray;
	}
	
	

	
}

?>
