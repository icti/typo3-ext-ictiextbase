<?php

/**
 * This ViewHelper renders limited set of objects.
 *
 * = Examples =
 *
 * <code title="full configuration">
 * <f:widget.objectLimit objects="{blogs}" as="paginatedBlogs" maxItems="5">
 *   // use {paginatedBlogs} as you used {blogs} before, most certainly inside
 *   // a <f:for> loop.
 * </f:widget.objectLimit>
 * </code>
 *
 * = Performance characteristics =
 *
 * In the above examples, it looks like {blogs} contains all Blog objects, thus
 * you might wonder if all objects were fetched from the database.
 * However, the blogs are NOT fetched from the database until you actually use them,
 * so the paginate ViewHelper will adjust the query sent to the database and receive
 * only the small subset of objects.
 * So, there is no negative performance overhead in using the ObjectLimit Widget.
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class Tx_Ictiextbase_ViewHelpers_Widget_ObjectLimitViewHelper extends Tx_Fluid_Core_Widget_AbstractWidgetViewHelper {

	/**
	 * @var Tx_Ictiextbase_ViewHelpers_Widget_Controller_ObjectLimitController
	 */
	protected $controller;

	/**
	 * @param Tx_Ictiextbase_ViewHelpers_Widget_Controller_ObjectLimitController $controller
	 * @return void
	 */
	public function injectController(Tx_Ictiextbase_ViewHelpers_Widget_Controller_ObjectLimitController $controller) {
		$this->controller = $controller;
	}

	/**
	 *
	 * @param Tx_Extbase_Persistence_QueryResultInterface $objects
	 * @param string $as
	 * @param integer $maxItems
	 * @return string
	 */
	public function render(Tx_Extbase_Persistence_QueryResultInterface $objects, $as, $maxItems) {
		return $this->initiateSubRequest();
	}
}

?>
