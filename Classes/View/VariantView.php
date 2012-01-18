<?php
/*                                                                        *
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
 * Extended Fluid Template View that supports different "variants"
 * Usage:
 * In your controller add following lines:
 *
 * protected function setViewConfiguration(Tx_Extbase_MVC_View_ViewInterface $view) {
 *  parent::setViewConfiguration($view);
 *  $view->setLayoutVariant($this->settings['layoutVariant']);
 * }
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_Ictiextbase_View_VariantView extends Tx_Fluid_View_TemplateView {

	/**
	 * Layout to use for this view.
	 *
	 * @var string
	 */
	protected $layoutVariant = NULL;

	/**
	 * @var string
	 */
	protected $templatePathAndFilenamePattern = '@templateRoot/@controller/@action.@variant.@format';

	/**
	 * @param string $layoutVariant
	 * @return void
	 */
	public function setLayoutVariant($layoutVariant) {
		$this->layoutVariant = $layoutVariant;
	}

	/**
	 * Overwrite/adopted for @variant
	 * Resolves the possible template/layout/partial paths as usual and then replaces "@layout" in the
	 * paths by $this->layoutVariant.
	 * Note: By default, only $templatePathAndFilenamePattern contains this marker, but you can use this for
	 * layouts/partials too by setting $this->layoutPathAndFilenamePattern / partialPathAndFilenamePattern
	 *
	 * @param string $pattern Pattern to be resolved
	 * @param boolean $bubbleControllerAndSubpackage if TRUE, then we successively split off parts from @controller and @subpackage until both are empty.
	 * @param boolean $formatIsOptional if TRUE, then half of the resulting strings will have .@format stripped off, and the other half will have it.
	 * @return array unix style path
	 * @see Tx_Fluid_View_TemplateView::expandGenericPathPattern()
	 */
	protected function expandGenericPathPattern($pattern, $bubbleControllerAndSubpackage, $formatIsOptional) {
		$paths = parent::expandGenericPathPattern($pattern, $bubbleControllerAndSubpackage, $formatIsOptional);
		foreach($paths as &$path) {
			if ($this->layoutVariant !== NULL && $this->layoutVariant !== '') {
				$path = str_replace('@variant', $this->layoutVariant, $path);
			} else {
				$path = str_replace('@variant', '', $path);
				$path = str_replace('..', '.', $path);
			}
		}
		return $paths;
	}
}

?>