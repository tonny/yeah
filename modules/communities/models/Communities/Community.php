<?php

class Communities_Community extends Yeah_Model_Row_Validation
{
    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre de la comunidad no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre de la comunidad debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabel',
                    'options'   => array('Communities'),
                    'message'   => 'El nombre seleccionado para la comunidad ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'url' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'ReservedWord',
                    'options'   => array(),
                    'message'   => 'El nombre seleccionado para la comunidad no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
                array(
                    'validator' => 'UniqueUrl',
                    'options'   => array('Communities'),
                    'message'   => 'El identificador de comunidad ya esta siendo usado',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'mode' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'Debe definir la modalidad de la comunidad',
                ),
                array(
                    'validator' => 'InArray',
                    'options'   => array(array('open', 'close')),
                    'message'   => 'La modalidad seleccionada no es valida',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function amAuthor() {
        global $USER;
        return $this->author == $USER->ident;
    }

    public function getAuthor() {
        $model_users = new Users();
        return $model_users->findByIdent($this->author);
    }

    public function getAvatar() {
        if ($this->avatar) {
            return $this->ident . '.jpg';
        } else {
            return '0.jpg';
        }
    }

    public function delete() {
        // FIXME ??
        global $DB;
        $DB->delete('community_petition', 'community = ' . $this->ident);
        $DB->delete('community_user', 'community = ' . $this->ident);
        parent::delete();
    }

    public function getAssignement($user) {
        global $DB;
        $select = $DB->select()->from('community_user')->where('community = ?' , $this->ident)->where('user = ?', $user->ident);
        $result = $DB->fetchRow($select);

        $obj = new stdClass;
        $obj->type = $result['type'];
        $obj->status = $result['status'];
        $obj->tsregister =  $result['tsregister'];

        return $obj;
    }

    public function getPetition($user) {
        global $DB;
        $select = $DB->select()->from('community_petition')->where('community = ?' , $this->ident)->where('user = ?', $user->ident);
        $result = $DB->fetchRow($select);

        $obj = new stdClass;
        $obj->tsregister =  $result['tsregister'];

        return $obj;
    }

    public function amModerator() {
        global $USER;

        $model_communities_user = new Communities_Users();
        $user = $model_communities_user->findByCommunityAndUser($this->ident, $USER->ident);
        if ($user == NULL) {
            return FALSE;
        }
        return $user->type == 'moderator';
    }

    public function amMember() {
        global $USER;

        $model_communities_user = new Communities_Users();
        $user = $model_communities_user->findByCommunityAndUser($this->ident, $USER->ident);
        if ($user == NULL) {
            return FALSE;
        }
        return $user->type == 'member';
    }

    public function getTags() {
        return $this->findTagsViaTags_Communities();
    }
}
