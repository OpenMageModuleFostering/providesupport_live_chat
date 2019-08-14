<?php
$installer = $this;
$installer->startSetup();

$installer->run("
   CREATE TABLE IF NOT EXISTS {$this->getTable('providelivechat')} (
      `id` int(11) NOT NULL auto_increment,
      `title` varchar(100) NOT NULL,
      `content` text NOT NULL,
      PRIMARY KEY  (`id`)
   ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO {$this->getTable('providelivechat')} 
(`id`, `title`, `content`) VALUES
(1, 'Provide Support LiveChat', '{\"account\":{\"accountName\":\"\",\"accountHash\":\"\"},\"settings\":\"null\",\"code\":\"\",\"hiddencode\":\"\"}');
");

$installer->endSetup();
