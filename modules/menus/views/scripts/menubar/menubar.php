<?php 

global $MENUBAR;
global $PAGE;
global $USER;

$model_pages = new Pages();
$items = $model_pages->selectByMenutype('menubar');

foreach ($items as $item) {
    $perms = explode('|', $item->privilege);
    $bool = false;
    foreach ($perms as $perm) {
        if ($perm == '') {
            $bool |= true;
        } else {
            $bool |= $USER->hasPermission($item->module, $perm);
        }
    }

    if ($bool) {
	    $MENUBAR->items[] = array (
	        'link'  => $this->moduleToUrl($item->module, $item->controller, $item->action),
	        'label' => ucfirst($item->title),
	    );
    }
}
