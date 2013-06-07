<?php

/**
 * This ViewHelper cycles through the specified values.
 * This can be often used to specify CSS classes for example.
 *
 * = Examples =
 *
 * 
 * <code>
 *  {namespace ficti=Tx_Ictiextbase_ViewHelpers}
 *	<f:for each={values}" as="value" iteration="iterator">
 *		<ficti:columns colSetClass="col2-set" colSetNames="{0: 'col-1', 1:'col-2'}" iteration="{iterator}">
 *			{value}
 *		</ficti:columns>
 *	</f:for>
 * </code>
 * 
 * <output>
 *	<div class="col2-set">
 *		<div class="col-1">
 *			Val 1
 *		</div>
 *		<div class="col-2">
 *			Val 2
 *		</div>
 *	</div>
 *	<div class="col2-set">
 *		<div class="col-1">
 *			Val 3
 *		</div>
 *	</div>
 *	
 * </output>
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class Tx_Ictiextbase_ViewHelpers_ColumnsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @var array|Tx_Extbase_Persistence_ObjectStorage the values to be iterated through
	 */
	protected $colSetNames = NULL;

	/**
	 * @var integer current values index
	 */
	protected $currentCycleIndex = NULL;

	/**
	 * @param array $colSetNames The array or Tx_Extbase_Persistence_ObjectStorage containing class names to be iterated over
	 * @param string $colSetClass The name of the base colset class
	 * @param string $iteration (pass the one from the <f:for>) The name of the variable to store iteration information (index, cycle, isFirst, isLast, isEven, isOdd)
	 * @return string Rendered result
	 */
	public function render($colSetNames, $colSetClass, $iteration) {
		
		$output = '';
		if ($colSetNames === NULL) {
			return $this->renderChildren();
		}
		if ($this->colSetNames === NULL || $iteration['isFirst'] == true) {
			$this->initializeValues($colSetNames);
		}
		if ($this->currentCycleIndex === NULL || $this->currentCycleIndex >= count($this->colSetNames)) {
			$this->currentCycleIndex = 0;
		}
		
		if($this->currentCycleIndex == 0){
			$output .= '<div class="'.$colSetClass.'">';
		}
		
		$output .= '<div class="'.$this->colSetNames[$this->currentCycleIndex].'">'.$this->renderChildren().'</div>';
		
		if($this->currentCycleIndex == count($this->colSetNames)-1 || $iteration['isLast']){
			
			$output .= '</div>';
		}		

		
		$this->currentCycleIndex ++;

		return $output;
	}

	/**
	 * Sets this->values to the current values argument and resets $this->currentCycleIndex.
	 *
	 * @param array $values The array or Tx_Extbase_Persistence_ObjectStorage to be stored in $this->values
	 * @return void
	 */
	protected function initializeValues($values) {
		if (is_object($values)) {
			if (!$values instanceof Traversable) {
				throw new Tx_Fluid_Core_ViewHelper_Exception('ColumnsViewHelper only supports arrays and objects implementing Traversable interface' , 1324302176);
			}
			$this->colSetNames = iterator_to_array($values, FALSE);
		} else {
			$this->colSetNames = array_values($values);
		}
		$this->currentCycleIndex = 0;
	}
}

?>
