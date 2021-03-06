<?php

class Modules_ModuleController extends Yeah_Action
{
    public function viewAction() {
        global $CONFIG;
        $this->requirePermission('modules', 'view');

        $request = $this->getRequest();

        $url = $request->getParam('mod');
        $model_modules = new Modules();
        $model_pages = new Pages();
        $module = $model_modules->findByUrl($url);

        $this->requireExistence($module, 'mod', 'modules_module_view', 'modules_list');

        $init = $CONFIG->dirroot . 'modules/' . $module->url . '/Init.php';
        $model = null;
        if (file_exists($init)) {
            $class = ucfirst(strtolower($module->url)) . '_Init';
            $model = new $class;
        }
        $this->view->model_modules = $model_modules;
        $this->view->model_pages = $model_pages;
        $this->view->module = $module;
        $this->view->routes = $model;

        history('modules/' . $module->url);
        $breadcrumb = array();
        if ($this->acl('modules', 'list')) {
            $breadcrumb['Modulos'] = $this->view->url(array(), 'modules_list');
        }
        if ($this->acl('modules', array('new', 'lock'))) {
            $breadcrumb['Administrador de modulos'] = $this->view->url(array(), 'modules_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('modules', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('mod');
        $model_modules = new Modules();
        $module = $model_modules->findByUrl($url);

        $this->requireExistence($module, 'mod', 'modules_module_view', 'modules_list');

        $module->status = 'inactive';
        $module->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El modulo {$module->label} ha sido deshabilitado");

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('modules', 'lock');
        $request = $this->getRequest();

        $url = $request->getParam('mod');
        $model_modules = new Modules();
        $module = $model_modules->findByUrl($url);

        $this->requireExistence($module, 'mod', 'modules_module_view', 'modules_list');

        $module->status = 'active';
        $module->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El modulo {$module->label} ha sido habilitado");

        $this->_redirect($this->view->currentPage());
    }
}
