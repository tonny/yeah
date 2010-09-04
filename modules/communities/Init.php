<?php

class modules_communities_Init extends Yeah_Init
{
    public $check = array ('community', 'community_user', 'community_petition', 'community_resource');
    public $install = 'communities';

    public $routes = array (
        'communities_community_edit'             => array('communities/:community/edit',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'community',
                                                        'action'     => 'edit',
                                                    )),
        'communities_community_delete'           => array('communities/:community/delete',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'community',
                                                        'action'     => 'delete',
                                                    )),
        'communities_community_assign_member_lock'    => array('communities/:community/assign/:user/lock',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'member',
                                                        'action'     => 'lock',
                                                    )),
        'communities_community_assign_member_unlock'  => array('communities/:community/assign/:user/unlock',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'member',
                                                        'action'     => 'unlock',
                                                    )),
        'communities_community_assign_member_delete'  => array('communities/:community/assign/:user/delete',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'member',
                                                        'action'     => 'delete',
                                                    )),
        'communities_community_assign'           => array('communities/:community/assign',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'assign',
                                                        'action'     => 'index',
                                                    )),
        'communities_community_view'             => array('communities/:community',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'community',
                                                        'action'     => 'view',
                                                    )),
        'communities_manager'                    => array('communities/manager',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'manager',
                                                        'action'     => 'index',
                                                    )),
        'communities_new'                       => array('communities/new',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                    )),
        'communities_list'                       => array('communities',
                                                    array(
                                                        'module'     => 'communities',
                                                        'controller' => 'index',
                                                        'action'     => 'index',
                                                    )),
    );
}
