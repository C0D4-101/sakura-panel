<?php 
/**
 * Acl For Roles (Admins / Members / Guests)
 */
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Component;
use Phalcon\Acl\Role;

$configs = $di->getConfig();

$acl = new Memory();

$roleAdmins     = new Role('admins', 'Administrator Access');
$roleMembers    = new Role('members', 'Members Access'); 
$roleGuests     = new Role('guests', 'Guests Access'); 

$acl->addRole($roleAdmins);
$acl->addRole($roleMembers);
$acl->addRole($roleGuests);

$acl->setDefaultAction(\Phalcon\Acl\Enum::DENY);

if ($configs->route_groups)
foreach ($configs->route_groups as $prefix => $rgroup) {
    foreach ($rgroup as $name => $page) {
        if (!$page->access)
            break;

        $acl_item = is_object($page->access) ? $page->access : [$page->access];

        foreach ($acl_item as $acl_names => $actions) {
            if (is_int($acl_names)){
                // check if  array is associative or sequential
                $acl_names = $actions;
                $actions = ["*"];
            }
            
            $urls = is_object($page->url) ? $page->url : (object) [$page->url];
            $controller =  str_replace('[M]', 'Sakura\Controllers\Member', $page->controller );
            $roles_alloweds = explode("|", $acl_names ?: "*");

            $actions = is_object($actions) && method_exists($actions , 'toArray') ? $actions->toArray() : $actions;

            $actions = is_array($actions) && !empty($actions) ? $actions : [$actions ?: '*'];

            $acl->addComponent(
                $controller,
                $actions
            );

            foreach ($roles_alloweds as $name)
                $acl->allow($name , $controller , $actions);
        }
    }
}
return $acl;