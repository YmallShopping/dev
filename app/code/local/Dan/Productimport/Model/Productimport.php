<?php

class Dan_Productimport_Model_Productimport extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productimport/productimport');
    }

    public function getCsvCollection($_item)
    {
		$fileName = Mage::getBaseDir('var') . DS . 'import' . DS . $_item;
		$target_path = $fileName;

		if (file_exists($target_path)) {
		  ini_set("auto_detect_line_endings", 1);
					$current_row = 1;
					$handle = fopen($target_path, "r");
					$csvData = array();

		  while ( ($data = fgetcsv($handle, 10000, ";") ) !== FALSE )
					{
						$number_of_fields = count($data);
						if ($current_row == 1) {    //Header line
							for ($c=0; $c < $number_of_fields; $c++)
							{
								$header_array[$c] = $data[$c];
							}
						} else {    //Data line
							for ($c=0; $c < $number_of_fields; $c++)
							{
								$data_array[$header_array[$c]] = $data[$c];
							}
							$csvData[] = $data_array;
						}
						$current_row++;
					}
			fclose($handle);

			return $csvData;
		} else {
			Mage::getSingleton('adminhtml/session')->addError('CSV upload was unsuccessfully. Please verify the integrity/existence of the CSV file and try again.');
			return;
		}    	
    }

    public function generateRulesJson($_id,$data)
    {
  		$_item = Mage::getModel('productimport/productimport')->load($_id);
		$_collection = $this->getCsvCollection($_item->getFilename());  
		$_rulesArray = array();
		foreach ($_collection as $key => $value) {
			foreach ($value as $keyItem => $item) {
				if($keyItem){
					if($data[$this->formatForId($keyItem)] == 1){
						$_rulesArray[] = $keyItem;
					}
				}
			}
			break;
		}	

		return json_encode($_rulesArray);
    }

    public function generateProductAjax($_website = array(1),$_sku,$_name,$_price,$_specialPrice,$_description,$_shortDescription,$_categories,$_baseImage = null,$_thumbnail = null,$_size = null,$_colors = null)
    {
    		$_skuSplit = explode('/', $_sku);
    		$_fixedName = str_replace($_skuSplit[0], '', $_name);

    		if(trim($_fixedName) == ''){
    			$_fixedName = $_name;
    		}

    		$product = Mage::getModel('catalog/product');
		    $product->setWebsiteIds($_website);
		    $product->setAttributeSetId(9);
		    $product->setTypeId('simple');
		    $product->setCreatedAt(strtotime('now'));
		    $product->setSku($_sku);
		    $product->setName($_fixedName);
		    $product->setWeight(0);
		    $product->setStatus(1);
		    $product->setTaxClassId(0);
		    $product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
		    $product->setPrice($_price);
		    $product->setSpecialPrice($_specialPrice);
		    $product->setDescription($_description);
		    $product->setShortDescription($_shortDescription);

		    $product->setMediaGallery (array('images'=>array (), 'values'=>array ()));
		    if($_baseImage){
		    	$_imgCollection = explode('|', $_baseImage);
		    	$_imgCount = 0;
		    	foreach ($_imgCollection as $_img) {
		    		$_imgCount++;
					$image_url  = $_img; //get external image url from csv
					$image_type = substr(strrchr($image_url,"."),1); //find the image extension
					$filename   = $this->formatForId($_fixedName) .'.'.$image_type; //give a new name, you can modify as per your requirement
					$filepath   = Mage::getBaseDir('media') . DS . 'import'. DS . $filename; //path for temp storage folder: ./media/import/
					file_put_contents($filepath, file_get_contents(trim($image_url))); //store the image from external url to the temp storage folder
					if($_imgCount==1){
						$product->addImageToMediaGallery($filepath, array('image','thumbnail','small_image'), false, false);
					} else {
						$product->addImageToMediaGallery($filepath, null, false, false);
					}
		    	}
		    }
		   
		   	if($_size){
			    $_sizeCollection = explode('|', $_size);
			    $_sizeArray = array();
			    foreach ($_sizeCollection as $size) {
			    	if(trim($size) !='' && trim($size) !=' '){
			    		$_sizeArray[] = $this->getAttributeId('marime',trim($size));	
			    	}
			    }
			    $_sizeValues = implode(',', $_sizeArray);
				$product->addData( array('marime' => $_sizeValues) );
		   	}
		   
		   	if($_colors){
			    $_colorsCollection = explode('|', $_colors);
			    $_colorsArray = array();
			    foreach ($_colorsCollection as $_color) {
			    	if(trim($_color) !='' && trim($_color) !=' '){
			    		$_colorsArray[] = $this->getAttributeId('culoare',trim($_color));	
			    	}
			    }
			    $_colorsValues = implode(',', $_colorsArray);
				$product->addData( array('culoare' => $_colorsValues) );
		   	}

		    $product->setStockData(array(
		                       'use_config_manage_stock' => 1,
		                       'manage_stock'=>1,
		                       'min_sale_qty'=>1,
		                       'max_sale_qty'=>10000,
		                       'is_in_stock' => 1,
		                       'qty' => 20 //qty
		                   )
		    );
		    $product->setCategoryIds($_categories);
			$product->save();

			$this->createCustomOptions($product->getId(),$_sizeCollection,'Marime');
			$this->createCustomOptions($product->getId(),$_colorsCollection,'Culoare');
    }

    public function updateProductAjax($_product,$_name,$_price,$_specialPrice,$_description,$_shortDescription)
    {
		$product = $_product;

		if($_name!==''){
			$product->setName($_name);
			$product->getResource()->saveAttribute($product, 'name');
		}
		if($_price!==''){
			$product->setPrice($_price);
			$product->getResource()->saveAttribute($product, 'price');
		}
	    if($_specialPrice!==''){
		    if($_price == $_specialPrice){
		    	$_specialPrice = '';
		    }
			$product->setSpecialPrice($_specialPrice);
			$product->getResource()->saveAttribute($product, 'special_price');
	    }

		$product->setSpecialFromDate('');
		$product->getResource()->saveAttribute($product, 'special_from_date');
	    $product->setSpecialToDate('');
	    $product->getResource()->saveAttribute($product, 'special_to_date');

		if($_description!==''){
			$product->setDescription($_description);
			$product->getResource()->saveAttribute($product, 'description');
		}    		
		if($_shortDescription!==''){
			$product->setShortDescription($_shortDescription);
			$product->getResource()->saveAttribute($product, 'short_description');
		}
    }    

    public function createCustomOptions($_productId,$_optionsArray,$_optionName){
    	$_product = Mage::getModel('catalog/product')->load($_productId);
		try {
			if(count($_optionsArray) > 0){
				$optionValues = array();
				$_o = 0;
				foreach ($_optionsArray as $_value) { $_o++;
					$optionValues[] = array(
							  'is_delete'     => 0,
				              'title'         => $_value,
				              'price_type'    => 'fixed',
				              'price'         => 0,
				              'sku'           => '',
				              'sort_order'	  => $_o,
				              'option_type_id'=> -1,	
				        );
				}

				$optionData = array(
					'is_delete'         => 0,
				    'is_require'        => true,
				    'previous_group'    => '',
				    'title'             => $_optionName,
				    'type'              => 'drop_down',
				    'price_type'        => 'fixed',
				    'sort_order'        => 0,
				    'values'            => $optionValues
				);

				$opt = Mage::getSingleton('catalog/product_option');
				$opt->setProduct($_product);
				$opt->addOption($optionData)->save();
				$_product->setHasOptions(1)->save();
				Mage::getSingleton('catalog/product_option')->unsetOptions();
				unset($optionData);
				unset($optionValues);
			}

		} catch (Exception $e) {

		}
    }

    public function getCatIdsByName($_name){
    	$_collection = Mage::getModel('catalog/category')->getCollection()->addAttributeToSelect('name');
    	$_arrayCats = array();
    	foreach ($_collection as $cat) {
    		$_arrayCats[trim($cat->getName())] = $cat->getId();
    	}

    	$_catIds = array();
    	$_availableCats = explode('|', $_name);
    	$_availableCats = array_filter($_availableCats);

    	try {
	    	if(count($_availableCats)>0){
		    	foreach ($_availableCats as $avCat) {
		    		if(isset($_arrayCats[trim($avCat)])){
		    			$_catIds[]=$_arrayCats[trim($avCat)];
		    		}
		    	}
	    	}
    	} catch (Exception $e) {
    		
    	}

    	return $_catIds;
    }

	public function updateAttribute($_attrId = null,$_colors){

    	$i==0;
    	foreach ($_colors as $_color) { $i++;
    		$_exits = $this->getAttributeId('culoare',trim($_color));
    		$option = array();

    		if(!$_exits) {
    			// Add attribute option value
				$option['attribute_id'] = $_attrId;
				$option['value']['option_'.$i][0] = trim($_color);

				$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
				$setup->addAttributeOption($option);
    		}
    	}
	}

	public function getAttributeId($_attribute, $_title)	{
		$attributeDetails = Mage::getSingleton("eav/config")->getAttribute("catalog_product", $_attribute);
		$optionId = $attributeDetails->getSource()->getOptionId($_title);

		return $optionId;
	}

    public function formatForId($_item)
    {
    	$_replaceArray = array(' ','-','/');

    	$_newValue = str_replace($_replaceArray, '_', $_item);
    	return strtolower($_newValue);
    }
}