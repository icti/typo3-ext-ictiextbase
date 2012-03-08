<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');


require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/Tca.php');
require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/TcaObject.php');
require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/TcaStiObject.php');
require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/Exception.php');
require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/Exception/TableNotInTCA.php');


//$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest'][] = 'EXT:ictiextbase/Classes/Helpers/PreprocessRequestHook.php:Tx_Ictiextbase_Helpers_PreprocessRequestHook->preprocessRequest';
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc'][] = 'EXT:ictiextbase/Classes/Helpers/PreprocessRequestHook.php:Tx_Ictiextbase_Helpers_PreprocessRequestHook->checkAlternativeIdMethodsPostProc';
?>