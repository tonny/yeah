<?php

class Teams_TeamController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);

        $model_teams = new Teams();
        $url_team = $request->getParam('team');
        $team = $model_teams->findByUrl($group->ident, $url_team);
        $this->requireExistenceTeam($team, $group, $subject);
        $this->requireMemberTeam($team);

        context('team', $team);

        $members = $team->findUsersViaTeams_Users();
        $resources = $team->findResourcesViaTeams_Resources($team->select()->order('tsregister DESC'));

        // PAGINATOR
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->gestion = $gestion;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->team = $team;
        $this->view->members = $members;
        $this->view->resources = $paginator;
        $this->view->route = array (
            'key' => 'teams_team_view',
            'params' => array (
            	'subject' => $subject->url,
                'group' => $group->url,
                'team' => $team->url,
            ),
        );

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/' . $team->url);
        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            if ($group->amTeacher()) {
                $breadcrumb['Equipos'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'teams_manager');
            }
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);

        $model_teams = new Teams();
        $url_team = $request->getParam('team');
        $team = $model_teams->findByUrl($group->ident, $url_team);
        $this->requireExistenceTeam($team, $group, $subject);
        $this->requireMemberTeam($team);

        context('team', $team);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $team->label = $request->getParam('label');
            $team->url = convert($team->label);
            $team->description = $request->getParam('description');

            if ($team->isValid()) {
                $team->save();

                $session->messages->addMessage("El equipo {$team->label} se ha actualizado correctamente");
                $session->url = $team->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($team->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->team = $team;
        
        history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/' . $team->url . '/edit');
        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            if ($group->amTeacher()) {
                $breadcrumb['Equipos'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'teams_manager');
            }
            $breadcrumb[$team->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url, 'team' => $team->url), 'teams_team_view');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $model_teams = new Teams();
        $url_team = $request->getParam('team');
        $team = $model_teams->findByUrl($group->ident, $url_team);
        $this->requireExistenceTeam($team, $group, $subject);

        $team->status = 'inactive';
        $team->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El equipo {$team->label} ha sido desactivado");

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $model_teams = new Teams();
        $url_team = $request->getParam('team');
        $team = $model_teams->findByUrl($group->ident, $url_team);
        $this->requireExistenceTeam($team, $group, $subject);

        $team->status = 'active';
        $team->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El equipo {$team->label} ha sido activado");

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $model_teams = new Teams();
        $url_team = $request->getParam('team');
        $team = $model_teams->findByUrl($group->ident, $url_team);
        $this->requireExistenceTeam($team, $group, $subject);

        $label = $team->label;
        $team->delete();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El equipo {$label} ha sido eliminado");

        $this->_redirect($this->view->currentPage());
    }
}
