<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');


require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/Tca.php');
require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/TcaObject.php');
require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/TcaStiObject.php');
require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/Exception.php');
require_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Helpers/Exception/TableNotInTCA.php');


?>