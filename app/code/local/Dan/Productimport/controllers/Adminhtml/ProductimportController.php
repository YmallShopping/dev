<?php
class Dan_Productimport_Adminhtml_ProductimportController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('productimport/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('productimport/productimport')->load($id);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			Mage::register('productimport_data', $model);
			$this->loadLayout();
			$this->_setActiveMenu('productimport/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('productimport/adminhtml_productimport_edit'))
				->_addLeft($this->getLayout()->createBlock('productimport/adminhtml_productimport_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productimport')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('csv','xml','xls'));
					$uploader->setAllowRenameFiles(true);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('var') . DS . 'import' . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			} else {       
				if(isset($data['filename']['delete']) && $data['filename']['delete'] == 1)
					$data['filename'] = '';
				else
				unset($data['filename']);
			}
	  		
	  		$data['store'] = implode(',', $data['store']);	
	  		//Create JSON string with CSV column rules
			$data['rules'] = Mage::getModel('productimport/productimport')->generateRulesJson($this->getRequest()->getParam('id'),$data);
	  			
			$model = Mage::getModel('productimport/productimport');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productimport')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productimport')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('productimport/productimport');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
    public function massDeleteAction() {
        $productimportIds = $this->getRequest()->getParam('productimport');
        if(!is_array($productimportIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($productimportIds as $productimportId) {
                    $productimport = Mage::getModel('productimport/productimport')->load($productimportId);
                    $productimport->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($productimportIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $productimportIds = $this->getRequest()->getParam('productimport');
        if(!is_array($productimportIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($productimportIds as $productimportId) {
                    $productimport = Mage::getSingleton('productimport/productimport')
                        ->load($productimportId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($productimportIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'productimport.csv';
        $content    = $this->getLayout()->createBlock('productimport/adminhtml_productimport_grid')
            ->getCsv();
        $this->_sendUploadResponse($fileName, $content);
    }
    public function exportXmlAction()
    {
        $fileName   = 'productimport.xml';
        $content    = $this->getLayout()->createBlock('productimport/adminhtml_productimport_grid')
            ->getXml();
        $this->_sendUploadResponse($fileName, $content);
    }
   //  public function importProductAction()
   //  {
   //  	if($this->getRequest()->getParam('id')){
			// $_csv = Mage::getModel('productimport/productimport')->load($this->getRequest()->getParam('id'));  	
			// $_collection = Mage::getModel('productimport/productimport')->getCsvCollection($_csv->getFilename()); 
			// $_it = $this->getRequest()->getParam('el');
			// $_existingProductsSku = Mage::getModel('catalog/product')->getCollection()->getColumnValues('sku');
			// $i=0;
			// $j=0;
			// $_success=0;
			// $_error=0;
			// $_update=0;
			// $_delete=0;
			// $_end = 5;
			// //Only update existing products
			// if($_csv->getImportType() == 1){
			// 	$_end = 500;
			// }
			// //Delete existing products that match the csv sku's
			// if($_csv->getImportType() == 3){
			// 	$_end = 50;
			// }
			// $_ajaxReport = array();
			// $_newStart = ($_end * $_it) + 1; 
			
			// foreach ($_collection as $key => $value) {
			// 	$j++;
			// 	if($j>=$_newStart){
			// 		$i++;
			// 		//Set product values from csv row
			// 		$_website = explode(',', $_csv->getStore());
			// 		if($value['Cod produs']){
			// 			$_sku = trim($value['Cod produs']);
			// 		} else {
			// 			$_sku = Mage::getModel('productimport/productimport')->formatForId($value['Denumire']);
			// 		}
					
			// 		$_name = trim($value['Denumire']);
			// 		$_price = trim($value['Pret']);
			// 		$_specialPrice = '';
			// 		if(trim($value['Pret redus'])>0){
			// 			$_specialPrice = trim($value['Pret redus']);
			// 		}
			// 		$_description = trim($value['Descriere']);
			// 		if(trim($value['Categorii'])!=''){
			// 			$_categories = Mage::getModel('productimport/productimport')->getCatIdsByName(trim($value['Categorii']));
			// 		}
					
			// 		$_baseImage = $value['Imagine'];
			// 		$_size = trim($value['Marime']);
			// 		$_colors = trim($value['Culori']);

			// 		//Handle import
			// 		try {
			// 			// Import new products and update existing ones
			// 			if($_csv->getImportType() == 0){
			// 				if(in_array($_sku, $_existingProductsSku)){
			// 					$_product = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addFieldToFilter('sku',$_sku)->getFirstItem();
			// 					Mage::getModel('productimport/productimport')->updateProductAjax($_product,$_name,$_price,$_specialPrice,$_description,$_shortDescription,$_size,$_colors);
			// 					$_update++;
			// 				} else {
			// 					Mage::getModel('productimport/productimport')->generateProductAjax($_website,$_sku,$_name,$_price,$_specialPrice,$_description,$_shortDescription,$_categories,$_baseImage,$_thumbnail,$_size,$_colors);
			// 					// Mage::log('Sku '.$_sku.' was succesfully added at # : '.now(), null, 'importsuccesslog.log');
			// 					$_success++;
			// 				}							
			// 			}
			// 			//Only update existing products
			// 			if($_csv->getImportType() == 1){
			// 				if(in_array($_sku, $_existingProductsSku)){
			// 					$_product = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addFieldToFilter('sku',$_sku)->getFirstItem();
			// 					Mage::getModel('productimport/productimport')->updateProductAjax($_product,$_name,$_price,$_specialPrice,$_description,$_shortDescription,$_size,$_colors);
			// 					$_update++;
			// 				}							
			// 			}
			// 			//Only Import new products
			// 			if($_csv->getImportType() == 2){
			// 				if(!in_array($_sku, $_existingProductsSku)){
			// 					Mage::getModel('productimport/productimport')->generateProductAjax($_website,$_sku,$_name,$_price,$_specialPrice,$_description,$_shortDescription,$_categories,$_baseImage,$_thumbnail,$_size,$_colors);
			// 					// Mage::log('Sku '.$_sku.' was succesfully added at # : '.now(), null, 'importsuccesslog.log');
			// 					$_success++;
			// 				}							
			// 			}
			// 			//Delete existing products that match the csv sku's
			// 			if($_csv->getImportType() == 3){
			// 				if(in_array($_sku, $_existingProductsSku)){
			// 					$_product = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('sku')->addFieldToFilter('sku',$_sku)->getFirstItem()->delete();
			// 					$_delete++;
			// 				}							
			// 			}
			// 		} catch (Exception $e) {
			// 			Mage::log('Sku '.$_sku.' gave the following error : '.$e->getMessage(), null, 'importerrorlog.log');
			// 			$_error++;
			// 		} 				
			// 	}
			// 	if($i==$_end){   
			// 		$_ajaxReport['success'] = $_success;
			// 		$_ajaxReport['update'] = $_update;
			// 		$_ajaxReport['delete'] = $_delete;
			// 		$_ajaxReport['error'] = $_error;
			// 		echo json_encode($_ajaxReport);
			// 		break; 
			// 	}
			// }  
			// if($j>=count($_collection)){
			// 	$_ajaxReport['success'] = $_success;
			// 	$_ajaxReport['update'] = $_update;
			// 	$_ajaxReport['delete'] = $_delete;
			// 	$_ajaxReport['error'] = $_error;
			// 	$_ajaxReport['finish'] = 'true';
			// 	echo json_encode($_ajaxReport);
			// }	
   //  	}
   //  }   

    public function importProductAction()
    {
    	if($this->getRequest()->getParam('id')){
			$_csv = Mage::getModel('productimport/productimport')->load($this->getRequest()->getParam('id'));  	
			$_collection = json_decode($_csv->getRenderedData(),true); 
			$_newCollection = $_collection; 

			$_existingProductsSku = Mage::getModel('catalog/product')->getCollection()->getColumnValues('sku');

			$i=0;
			$_success=0;
			$_error=0;
			$_update=0;
			$_delete=0;
			$_end = 5;

			//Only update existing products
			if($_csv->getImportType() == 1){
				$_end = 250;
			}
			//Delete existing products that match the csv sku's
			if($_csv->getImportType() == 3){
				$_end = 50;
			}
			$_ajaxReport = array();
			
			foreach ($_collection as $key => $value) {

				$i++;
				//Set product values from csv row
				$_website = explode(',', $_csv->getStore());
				$_sku = null;
				if($value['Cod produs']){
					$_sku = trim($value['Cod produs']);
				}
				// } else {
				// 	$_sku = Mage::getModel('productimport/productimport')->formatForId($value['Denumire']);
				// }
				
				$_name = trim($value['Denumire']);
				$_price = trim($value['Pret']);
				$_specialPrice = '';
				if(trim($value['Pret redus'])>0){
					$_specialPrice = trim($value['Pret redus']);
				}
				$_description = trim($value['Descriere']);
				if(trim($value['Categorii'])!=''){
					$_categories = Mage::getModel('productimport/productimport')->getCatIdsByName(trim($value['Categorii']));
				}
				
				$_baseImage = $value['Imagine'];
				$_size = trim($value['Marime']);
				$_colors = trim($value['Culori']);

				//Handle import
				try {
					// Import new products and update existing ones
					if($_csv->getImportType() == 0){
						if(in_array($_sku, $_existingProductsSku)){
							$_product = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addFieldToFilter('sku',$_sku)->getFirstItem();
							Mage::getModel('productimport/productimport')->updateProductAjax($_product,$_name,$_price,$_specialPrice,$_description,$_shortDescription,$_size,$_colors);
							$_update++;
						} else {
							if($_sku){
								Mage::getModel('productimport/productimport')->generateProductAjax($_website,$_sku,$_name,$_price,$_specialPrice,$_description,$_shortDescription,$_categories,$_baseImage,$_thumbnail,$_size,$_colors);
								// Mage::log('Sku '.$_sku.' was succesfully added at # : '.now(), null, 'importsuccesslog.log');
								$_success++;
							}
						}							
					}
					//Only update existing products
					if($_csv->getImportType() == 1){
						if(in_array($_sku, $_existingProductsSku)){
							$_product = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addFieldToFilter('sku',$_sku)->getFirstItem();
							Mage::getModel('productimport/productimport')->updateProductAjax($_product,$_name,$_price,$_specialPrice,$_description,$_shortDescription,$_size,$_colors);
							$_update++;
						}							
					}
					//Only Import new products
					if($_csv->getImportType() == 2 && $_sku){
						if(!in_array($_sku, $_existingProductsSku)){
							Mage::getModel('productimport/productimport')->generateProductAjax($_website,$_sku,$_name,$_price,$_specialPrice,$_description,$_shortDescription,$_categories,$_baseImage,$_thumbnail,$_size,$_colors);
							// Mage::log('Sku '.$_sku.' was succesfully added at # : '.now(), null, 'importsuccesslog.log');
							$_success++;
						}							
					}
					//Delete existing products that match the csv sku's
					if($_csv->getImportType() == 3){
						if(in_array($_sku, $_existingProductsSku)){
							$_product = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('sku')->addFieldToFilter('sku',$_sku)->getFirstItem()->delete();
							$_delete++;
						}							
					}
				} catch (Exception $e) {
					Mage::log('Sku '.$_sku.' gave the following error : '.$e->getMessage(), null, 'importerrorlog.log');
					$_error++;
				} 

				unset($_newCollection[$key]);				
				if($i==$_end){ break; } 
			}  

			$_ajaxReport['success'] = $_success;
			$_ajaxReport['update'] = $_update;
			$_ajaxReport['delete'] = $_delete;
			$_ajaxReport['error'] = $_error;
			$_ajaxReport['remaining'] = count($_newCollection);

			if(count($_newCollection)<=0){
				$_ajaxReport['finish'] = 'true';
			}
			
			$_csv->setRenderedData(json_encode($_newCollection))->save();
			echo json_encode($_ajaxReport);
    	}
    }    

    public function updateProductAttributesAction()
    {
    	if($this->getRequest()->getParam('id')){
			$_csv = Mage::getModel('productimport/productimport')->load($this->getRequest()->getParam('id'));  	
			$_collection = Mage::getModel('productimport/productimport')->getCsvCollection($_csv->getFilename()); 
		
			$_colorsArray = array();
			foreach ($_collection as $key => $value) {
				// $_colors = trim($value['Culori']);
		  //   	$_colors = explode('|', $_colors);
		  //   	$_colors = array_filter($_colors);
		  //   	$_colorUrl = trim($value['Url culori']);

		  //   	$_colorsArray = array_merge($_colorsArray,$_colors);

		    	$_colorsArray[trim($value['Culori'])] = trim($value['Url culori']);
			}  	

			try {
				Mage::getModel('productimport/productimport')->updateAttribute(135,array_filter(array_unique($_colorsArray)));

				Mage::getSingleton('adminhtml/session')->addSuccess('Product Attributes have been succesfully updated.');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}

			$this->_redirect('*/*/');
    	}
    } 

    public function renderProductInfoAction()
    {
    	if($this->getRequest()->getParam('id')){
			$_csv = Mage::getModel('productimport/productimport')->load($this->getRequest()->getParam('id'));  	

		try {
			$_collection = Mage::getModel('productimport/productimport')->getCsvCollection($_csv->getFilename()); 

			$_productsArray = array();
			foreach ($_collection as $key => $value) {
				$_productsArray[$key] = array();
				foreach ($value as $keyProd => $prod) {
					$_productsArray[$key][$keyProd] = $prod;
				}
			}  	

			$_csv->setRenderedData(json_encode($_productsArray))->save();

			Mage::getSingleton('adminhtml/session')->addSuccess('CSV have been rendered succesfully.');
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}

			$this->_redirect('*/*/');
    	}
    }   

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}