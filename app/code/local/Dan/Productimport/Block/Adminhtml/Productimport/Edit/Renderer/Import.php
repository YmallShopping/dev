<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Adminhtml AdminNotification Severity Renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Dan_Productimport_Block_Adminhtml_Productimport_Edit_Renderer_Import extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Data_Form_Element_Abstract $element) 
	{			  
		$html = '
			<div style="display:block; color:green; padding:5px 10px; border: 1px solid #999; margin-bottom: 10px;">(<span id="success">0</span>) Products were succesfully imported.</div>
			<div style="display:block; color:orange; padding:5px 10px; border: 1px solid #999; margin-bottom: 10px;">(<span id="update">0</span>) Products were succesfully updated.</div>
			<div style="display:block; color:purple; padding:5px 10px; border: 1px solid #999; margin-bottom: 10px;">(<span id="delete">0</span>) Products were succesfully deleted.</div>
			<div style="display:block; color:red; padding:5px 10px; border: 1px solid #999; margin-bottom: 10px;">(<span id="error">0</span>) Products were un-succesfully imported/updated. ( To check the issues please read the "importerrorlog.log". The file is located in the root magento folder under : "var/log/". )</div>
			<h3 id="finish"></h3>
			<button class="button" type="button" onclick="runImport(0);"><span><span>Run Import</span></span></button>
			<script>
				var successCount = 0;
				var updateCount = 0;
				var deleteCount = 0;
				var errorCount = 0;
				function runImport(elCount){
					new Ajax.Request("'.$this->getUrl('*/*/importProduct', array('_current'=>true)).'el/" + elCount, {
					  	onSuccess: function(response) {
						  	var responseVals = response.responseText.evalJSON();
						  	if(responseVals.success > 0){
						  		successCount = successCount + responseVals.success; 
								$("success").update(successCount);
						  	}
						  	if(responseVals.update > 0){
						  		updateCount = updateCount + responseVals.update; 
								$("update").update(updateCount);
						  	}
						  	if(responseVals.delete > 0){
						  		deleteCount = deleteCount + responseVals.delete; 
								$("delete").update(deleteCount);
						  	}
						  	if(responseVals.error > 0){
						  		errorCount = errorCount + responseVals.error; 
								$("error").update(errorCount);
						  	}				    
					  	},
					  	onFailure: function(response) {
							runImport(elCount);
						},
						onComplete: function(response) {
							var responseVals = response.responseText.evalJSON();
							if(response.status == 200 && responseVals.finish != "true"){
						  		var newCount = elCount + 1;
						  		runImport(newCount);
						  	}
						  	if(responseVals.finish == "true"){
								$("finish").update("The import action is completed!");
						  	}
						}							
					});
				}
			</script>
		';		
		
        return $html;
    }
	 
   
}
