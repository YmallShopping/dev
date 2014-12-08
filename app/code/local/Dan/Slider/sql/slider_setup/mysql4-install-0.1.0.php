<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('slider')};
CREATE TABLE {$this->getTable('slider')} (
  `slider_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `slider_effect` varchar(255) NOT NULL default '',
  `position` int(11) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('slider_layers')};
CREATE TABLE {$this->getTable('slider_layers')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `slider_id` int(11) NOT NULL default '0',
  `caption_name` varchar(255) NOT NULL default '',
  `text` text NOT NULL default '',
  `layer_animation` varchar(255) NOT NULL default '',
  `data_x` varchar(255) NOT NULL default '',
  `data_y` varchar(255) NOT NULL default '',
  `data_start` int(11) NOT NULL default '0',
  `data_speed` int(11) NOT NULL default '0',
  `data_easing` varchar(255) NOT NULL default '',
  `style` text NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 