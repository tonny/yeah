<?php

class Events_ManagerController extends Yeah_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $USER;

        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $event = new Events_Empty();
        $tags = '';
        
        $model_events = new Events();
        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $publish = $request->getParam('publish');
            $tags = $request->getParam('tags');
        
            $event = $model_events->createRow();
            $event->label = $request->getParam('name');
            $event->place = $request->getParam('place');
            $event->event = strtotime($request->getParam('event-year') . '-' . $request->getParam('event-month') . '-' . $request->getParam('event-day') . ' ' . $request->getParam('event-hour') . ':' . $request->getParam('event-minute'));
            $interval = $request->getParam('interval');
            $ts_interval = 86400;
            switch ($interval) {
                case 'minute': $ts_interval =      60; break;
                case 'hour':   $ts_interval =    3600; break;
                case 'day':    $ts_interval =   86400; break;
                case 'week':   $ts_interval =  604800; break;
                case 'month':  $ts_interval = 2592000; break;
                default: $ts_interval =   86400;
            }
            $duration = intval($request->getParam('duration'));
            $event->duration = $duration * $ts_interval;
            $event->message = $request->getParam('message');

            $context = new Yeah_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (empty($publish)) {
                $session->messages->addMessage('Usted debe seleccionar un espacio de publicación');
            } else if (in_array($publish, $spaces_valids)) {
                if ($event->event == 0) {
                    $session->messages->addMessage('El evento no describe una fecha correcta');
                } else if ($event->isValid()) {
                    $resource = $model_resources->createRow();
                    $resource->author = $USER->ident;
                    $resource->recipient = $request->getParam('publish');
                    $resource->tsregister = time();
                    $resource->save();

                    $event->resource = $resource->ident;
                    $event->save();

                    $resource->saveContext($request);
                    $model_valorations->addActivity(4);

                    // TAG REGISTER
                    $tags = explode(',', $tags);
                    $saved_tags = array();

                    foreach ($tags as $tagLabel) {
                        $tagLabel = trim(strtolower($tagLabel));

                        if (!in_array($tagLabel, $saved_tags)) {
                            $tag = $model_tags->findByLabel($tagLabel);
                            if ($tag == NULL) {
                                $tag = $model_tags->createRow();
                                $tag->label = $tagLabel;
                                $tag->url = convert($tag->label);
                                $tag->weight = 1;
                                if ($tag->isValid()) {
                                    $tag->tsregister = time();
                                    $tag->save();
                                }
                            } else {
                                $tag->weight = $tag->weight + 1;
                                $tag->save();
                            }

                            if ($tag->ident <> 0) {
                                $assign = $model_tags_resources->createRow();
                                $assign->tag = $tag->ident;
                                $assign->resource = $resource->ident;
                                $assign->save();
                            }

                            $saved_tags[] = $tagLabel;
                        }
                    }

                    $session->messages->addMessage('El evento ha sido creado');
                    $session->url = $note->resource;
                    $this->_redirect($request->getParam('return'));
                } else {
                    foreach ($event->getMessages() as $message) {
                        $session->messages->addMessage($message);
                    }
                }
            } else {
                $session->messages->addMessage('Usted no tiene privilegios para publicar en ese espacio');
            }
        }

        $this->view->event = $event;
        $this->view->tags = $tags;

        history('events/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Eventos'] = $this->view->url(array('filter' => 'events'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}
