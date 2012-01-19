<?php



/**
 * Form view helper. Generates a <form> Tag.
 * 
 * Render the form without the hmac and referrer fields
 *
 * 
 *  */
class Tx_Ictiextbase_ViewHelpers_FormViewHelper extends Tx_Fluid_ViewHelpers_FormViewHelper {



	/**
	 * Renders hidden form fields for referrer information about
	 * the current controller and action.
	 *
	 * @return string Hidden fields with referrer information
	 * @todo filter out referrer information that is equal to the target (e.g. same packageKey)
	 */
	protected function renderHiddenReferrerFields() {
        return "";

	}
    
	/**
	 * Render the request hash field
	 *
	 * @return string the hmac field
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	protected function renderRequestHashField() {
        return "";
    }    

}

?>