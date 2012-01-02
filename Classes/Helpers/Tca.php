<?php
/***************************************************************
 *  Copyright notice
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Helper functions for TCA configuration
 *
 * @package Ictiextbase
 * @subpackage Helpers
 * @scope prototype
 * @api
 */
class Tx_Ictiextbase_Helpers_Tca  {

	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setRte($table, $column){
        
        global $TCA;
        
        $TCA[$table]['columns'][$column]['wizards'] = array(
                            '_PADDING' => 2,
                            'RTE' => array(
                                'notNewRecords' => 1,
                                'RTEonly'       => 1,
                                'type'          => 'script',
                                'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
                                'icon'          => 'wizard_rte2.gif',
                                'script'        => 'wizard_rte.php',
                            ),
                        );


        foreach($TCA[$table]['types'] as $k => $v){
            $TCA[$table]['types'][$k]['showitem'] = preg_replace('/'.$column.',/', 
                $column.';;;richtext[]:rte_transform[mode=ts],', 
                $TCA[$table]['types'][$k]['showitem']
            );        
        }
		
	}
    
    
	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setForeignTableWhere($table, $column, $orderBy = 'name'){
        
        global $TCA;
        
        $destTable = $TCA[$table]['columns'][$column]['config']['foreign_table'];

        $TCA[$table]['columns'][$column]['config']['foreign_table_where'] = 
                'AND ('.$destTable.'.pid = ###CURRENT_PID### 
                    or '.$destTable.'.pid = ###STORAGE_PID### 
                    or '.$destTable.'.pid IN (###PAGE_TSCONFIG_IDLIST###))
                 ORDER BY '.$destTable.'.'.$orderBy.'';

	}
    
    
    
	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setForeignTableWhereForAuxTable($table, $column, $orderBy = 'name'){
        
        global $TCA;
        
		if(isset($TCA[$table]['columns'][$column]['config']['wizards']['add'])){
            unset($TCA[$table]['columns'][$column]['config']['wizards']['add']);
        }
		if(isset($TCA[$table]['columns'][$column]['config']['wizards']['edit'])){
            unset($TCA[$table]['columns'][$column]['config']['wizards']['edit']);
        }        
        
        $destTable = $TCA[$table]['columns'][$column]['config']['foreign_table'];

        $TCA[$table]['columns'][$column]['config']['foreign_table_where'] = 
                'AND ('.$destTable.'.pid = ###STORAGE_PID### 
                    or '.$destTable.'.pid IN (###PAGE_TSCONFIG_IDLIST###))
                 ORDER BY '.$destTable.'.'.$orderBy.'';
	}    
    
	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setForeignTableWhereForAuxTableWithAddWizard($table, $column, $orderBy = 'name'){
        
        global $TCA;
        
		if(isset($TCA[$table]['columns'][$column]['config']['wizards']['add'])){
            $TCA[$table]['columns'][$column]['config']['wizards']['add']['params']['pid'] = '###STORAGE_PID###';
        }
        
        $destTable = $TCA[$table]['columns'][$column]['config']['foreign_table'];

        $TCA[$table]['columns'][$column]['config']['foreign_table_where'] = 
                'AND ('.$destTable.'.pid = ###STORAGE_PID### 
                    or '.$destTable.'.pid IN (###PAGE_TSCONFIG_IDLIST###))
                 ORDER BY '.$destTable.'.'.$orderBy.'';
        
	}      
    
    
	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setRenderAsGroup($table, $column){
        
        global $TCA;
        
        $destTable = $TCA[$table]['columns'][$column]['config']['foreign_table'];

        $TCA[$table]['columns'][$column]['config']['type'] = 'group';
        $TCA[$table]['columns'][$column]['config']['internal_type'] = 'db';
        $TCA[$table]['columns'][$column]['config']['allowed'] = $destTable;
        unset($TCA[$table]['columns'][$column]['config']['wizards']['add']);

		
	}    
    
	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setRenderAsCheckboxes($table, $column){
        
        global $TCA;
        

        $TCA[$table]['columns'][$column]['config']['renderMode'] = 'checkbox';

		
	}       
    
	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setDefaultItemOnSelect($table, $column){
        
        global $TCA;
        
        $TCA[$table]['columns'][$column]['config']['items'][''] = 0;

		
	}      

	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setInlineSorting($table, $column){
        
        global $TCA;
        
        $TCA[$table]['columns'][$column]['config']['foreign_sortby'] = 'sorting';
        $TCA[$table]['columns'][$column]['config']['appearance']['useSortable'] = '1';

		
	}     
    
	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setSelectTYPO3Pages($table, $column){
        
		Tx_Ictiextbase_Helpers_Tca::setSelectForeignTable($table, $column, 'pages');
	}     
	
	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setSelectForeignTable($table, $column, $foreignTable){
        
        global $TCA;
        
        $TCA[$table]['columns'][$column]['config']['foreign_table'] = $foreignTable;
        unset($TCA[$table]['columns'][$column]['config']['wizards']['add']);
        
		
	}   	
    
    
	/**
	 * configure column in TCA for RTE
	 *
	 * @param	string		Name of the predefined TCA definition.
	 * @param	string		Ident string for MM relations. Has to be set for field definitions that uses MM relations.
	 */	
	static public function setInlineParent($table, $column, $parentTable){
        
        global $TCA;
        
        
        $TCA[$table]['columns'][$column] = array(
            'label' => 'DEV: Parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => $parentTable,
                'foreign_table_where' => 'AND '.$parentTable.'.pid=###CURRENT_PID### ',
            )
        );        
        
        
        $TCA[$table]['types']['1']['showitem'] .= ',--div--;DEV: Parent,'.$column;
		
	}    
    
    
   
    
    
}



?>