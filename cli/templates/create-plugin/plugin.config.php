<?php 

use SakuraPanel\Library\Plugins\Plugin;

$plugin = new Plugin();

$plugin->initPluginByJson(dirname(__FILE__)."/plugin.config.json");

$plugin->addRoute(
	"member", 
	"__name__" ,
	[
		'url'=>['/#/@','/#/@/','/#/@/:action','/#/@/:action/:params'],
	    'controller'=>"\SakuraPanel\Plugins\\${groupName}\Controllers\__group__",
	    'action'=>1 , 
	    'params'=>2 , 
	    'access' => ['admins' => ['*'] ]
	]
)
->addMenu(
	"__title__",
	"__name__",
	[
		"title"=>"__title__",
		"icon"=>"fas fa-box",
		"url"=>"member/__name__",
		"access"=>"admins",
	]
)
// ->addSql([
// 	'install'=>dirname(__FILE__).'/sql/install.sql',
// 	'delete'=>dirname(__FILE__).'/sql/delete.sql'
// ])
;

return $plugin;