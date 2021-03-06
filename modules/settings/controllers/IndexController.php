<?php

class Settings_IndexController extends Yeah_Action
{
    public function indexAction() {
        global $USER;
        global $CONFIG;

        $request = $this->getRequest();

        $url = $request->getParam('user');
        if ($url != $USER->url) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $model_users = new Users();
        $user = $model_users->findByUrl($url);
        $this->requireExistence($user, 'user', 'profile_view', 'frontpage_user');

        context('user', $user);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $password1 = $request->getParam('password1');
            $password2 = $request->getParam('password2');

            if ($password1 == $password2) {
                $user->password = md5($CONFIG->key . $password1);
                $user->save();

                $session->messages->addMessage("Tu has cambiado tus preferencias correctamente");
                $session->url = $user->url;
                $this->_redirect($request->getParam('return'));
            } else {
                $session->messages->addMessage('Las entradas son diferentes');
            }
        }

        $this->view->model_users = $model_users;
        $this->view->user = $user;

        history('settings/' . $user->url);
        breadcrumb();
    }
}
