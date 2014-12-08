<?php

class Dan_Slider_Block_Adminhtml_Layers_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('layersGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('slider/layers')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('slider')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('caption_name', array(
          'header'    => Mage::helper('slider')->__('Title'),
          'align'     =>'left',
          'index'     => 'caption_name',
      ));
  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('slider')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('slider')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
	  
      return parent::_prepareColumns();
  }

    // protected function _prepareMassaction()
    // {
    //     $this->setMassactionIdField('id');
    //     $this->getMassactionBlock()->setFormFieldName('slider');

    //     $this->getMassactionBlock()->addItem('delete', array(
    //          'label'    => Mage::helper('slider')->__('Delete'),
    //          'url'      => $this->getUrl('*/*/massDelete'),
    //          'confirm'  => Mage::helper('slider')->__('Are you sure?')
    //     ));

    //     $statuses = Mage::getSingleton('slider/status')->getOptionArray();

    //     array_unshift($statuses, array('label'=>'', 'value'=>''));
    //     $this->getMassactionBlock()->addItem('status', array(
    //          'label'=> Mage::helper('slider')->__('Change status'),
    //          'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
    //          'additional' => array(
    //                 'visibility' => array(
    //                      'name' => 'status',
    //                      'type' => 'select',
    //                      'class' => 'required-entry',
    //                      'label' => Mage::helper('slider')->__('Status'),
    //                      'values' => $statuses
    //                  )
    //          )
    //     ));
    //     return $this;
    // }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}