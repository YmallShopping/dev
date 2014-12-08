<?php
class Dan_Slider_Block_Slider extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getSlider()     
    { 
        if (!$this->hasData('slider')) {
            $this->setData('slider', Mage::registry('slider'));
        }
        return $this->getData('slider');
        
    }
	
    public function getImage($_image,$image_width,$image_height)
    {
		$imageUrl = Mage::getBaseUrl('media').$_image->getImage();
		
		if( $image_width == null && $image_heigh==null ){
			return $imageUrl;
		}
		
		if(!file_exists("./media/resized")){
			mkdir("./media/resized",0777);
		}
		$imageName = substr(strrchr($imageUrl,"/"),1);
		$imageResized = Mage::getBaseDir('media').DS."resized".DS.$imageName;
		$dirImg = Mage::getBaseDir().str_replace("/",DS,strstr($imageUrl,'/media'));
		
		if (!file_exists($imageResized)&&file_exists($dirImg)) :
		// if (file_exists($dirImg)) : 
			$imageObj = new Varien_Image($dirImg);
			$imageObj->keepAspectRatio(TRUE);
			$imageObj->keepFrame(TRUE);
			$imageObj->quality(100);
			$imageObj->keepTransparency(true);
			$imageObj->backgroundColor(array(255, 255, 255));
			$imageObj->resize($image_width, $image_height);
			$imageObj->save($imageResized);
		endif;		
		
		$newImageUrl = Mage::getBaseUrl('media')."resized/".$imageName;
		
        return $newImageUrl;
    }

    public function getImageWidth($_image)
    {
    	$imageUrl = Mage::getBaseUrl('media').$_image->getImage();

		$imageName = substr(strrchr($imageUrl,"/"),1);
		$dirImg = Mage::getBaseDir().str_replace("/",DS,strstr($imageUrl,'/media'));

    	list($width, $height) = getimagesize($dirImg); 

    	return $width;
    }
}