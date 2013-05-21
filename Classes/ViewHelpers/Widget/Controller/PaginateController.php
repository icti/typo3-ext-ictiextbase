<?php

/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_Ictiextbase_ViewHelpers_Widget_Controller_PaginateController extends Tx_Fluid_ViewHelpers_Widget_Controller_PaginateController {


		/*
 		 * Backport of http://forge.typo3.org/issues/10823
 		 */
		protected function setViewConfiguration(Tx_Extbase_MVC_View_ViewInterface $view) {
				$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
				$widgetViewHelperClassName = $this->request->getWidgetContext()->getWidgetViewHelperClassName();

				if (isset($extbaseFrameworkConfiguration['view']['widget'][$widgetViewHelperClassName]['templateRootPath'])
						&& strlen($extbaseFrameworkConfiguration['view']['widget'][$widgetViewHelperClassName]['templateRootPath']) > 0
						&& method_exists($view, 'setTemplateRootPath')) {
								$view->setTemplateRootPath(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['widget'][$widgetViewHelperClassName]['templateRootPath']));
						}
 		}

    
	/**
	 * @return void
	 */
	public function initializeAction() {
        
        $this->configuration['showMaxPages'] = 6;
        parent::initializeAction();
	}    
    
	/**
	 * Returns an array with the keys "pages", "current", "numberOfPages", "nextPage" & "previousPage"
	 *
	 * @return array
	 */
	protected function buildPagination() {
		$pages = array();
        
        $paginaInicio = 1;
        $paginaFin = $this->numberOfPages;
        $paginasAMostrar = $this->configuration['showMaxPages'];
        $paginasAMostrarAntes = $paginasAMostrar/2;
        $paginasAMostrarDespues = $paginasAMostrar/2;
        
        if($this->numberOfPages > $paginasAMostrar){

            
            /* 
             * Caso 1: Estamos casi al final y se muestran más páginas por la izquierda que por la derecha
             */
            if(($this->currentPage + $paginasAMostrarDespues) > $this->numberOfPages){
                $delta = ($this->currentPage + $paginasAMostrarDespues) - $this->numberOfPages;
                $paginasAMostrarAntes += $delta;
                $paginasAMostrarDespues -= $delta;
            }
            
            /* 
             * Caso 2: Estamos casi al principio y se muestran más páginas por la derecha que por la izquierda
             */       
            if(($this->currentPage - $paginasAMostrarAntes) < 1){
                $delta = ($this->currentPage - $paginasAMostrarAntes)-1; // Delta es < 0
                $paginasAMostrarAntes += $delta;
                $paginasAMostrarDespues -= $delta;
            }            
            
            $paginaInicio = (int)($this->currentPage - $paginasAMostrarAntes);
            $paginaFin = (int)($this->currentPage + $paginasAMostrarDespues);            
            
        }
        
        
		for ($i = $paginaInicio; $i <= $paginaFin; $i++) {
			$pages[] = array('number' => $i, 'isCurrent' => ($i === $this->currentPage));
		}
		$pagination = array(
			'pages' => $pages,
			'current' => $this->currentPage,
			'numberOfPages' => $this->numberOfPages,
		);
		if ($this->currentPage < $this->numberOfPages) {
			$pagination['nextPage'] = $this->currentPage + 1;
		}
		if ($this->currentPage > 1) {
			$pagination['previousPage'] = $this->currentPage - 1;
		}
		return $pagination;
	}
}

?>
