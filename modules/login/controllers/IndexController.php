<?php

class Login_IndexController extends Yeah_Action
{
    public function inAction() {
        global $CONFIG;
        global $USER;

        if ($USER->role != 1) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $filters = array(
                'username' => array('StringTrim', 'StringToLower'),
            );
            $validators = array(
                'usuario' => array(
                    new Zend_Validate_StringLength(4, 64),
                    'allowEmpty' => false,
                    'presence'   => 'required',
                    'fields'     => 'username',
                    'messages'   => array(
                        'El campo usuario debe tener entre 4 y 64 caracteres',
                    ),
                ),
                'contrase&ntilde;a' => array(
                    new Zend_Validate_StringLength(1, 64),
                    'allowEmpty' => false,
                    'presence'   => 'required',
                    'fields'     => 'password',
                    'messages'   => array(
                        'La contraseña debe tener entre 1 y 25 caracteres',
                    ),
                ),
            );
            $options = array(
                'notEmptyMessage' => 'El campo %rule% no puede estar vacio'
            );
            $input = new Zend_Filter_Input($filters, $validators, $_POST, $options);
            $session = new Zend_Session_Namespace();
            if ($input->isValid()) {
                $model_users = new Users();
                $user = $model_users->findByLogin($input->username, md5($CONFIG->key . $input->password));
                if (!empty($user)) {
                    if ($user->status == 'active') {
                        $session->user = $user;
                        $this->_redirect($request->getParam('return'));
                    } else {
                        $session->messages->addMessage("El usuario {$user->label} ha sido bloqueado, comuniquese con algún encargado");
                    }
                } else {
                    // validation for login forgot process
                    $model_login = new Login();
                    $model_users = new Users();
                    $user = $model_users->findByLabel($input->username);
                    if (!empty($user)) {
                        $forgot = $model_login->selectByUser($user->ident);
                        if (!empty($forgot)) {
                            if ($input->password == $forgot->password) {
                                $now = time();
                                $expiration = $forgot->tsregister + $forgot->tstimeout;
                                $forgot->delete();
                                if ($now < $expiration) {
                                    $session->messages->addMessage('Le recomiendamos que establezca su nueva contraseña');
                                    $session->user = $user;
                                    $this->_redirect($CONFIG->wwwroot);
                                }
                            }
                        }
                    }
                    $session->messages->addMessage('Datos de accesso incorrectos');
                }
            } else {
                foreach($input->getMessages() as $messages) {
                    foreach($messages as $message) {
                        $session->messages->addMessage($message);
                    }
                }
            }
            
            $this->view->values = array('username' => $request->getParam('username'));
        }
        history('login');
        breadcrumb();
    }

    public function outAction() {
        global $CONFIG;

        $session = new Zend_Session_Namespace();
        $user = $session->user;
        if (!empty($user)) {
            $session->user = null;
        }

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('Usted salió del sistema');

        $url = new Zend_View_Helper_Url();
        $this->_redirect($url->url(array(), 'login_in'));
    }
}
