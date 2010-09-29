<?php

class modules_comments_Init extends Yeah_Init
{
    public $check = array ();
    public $install = 'comments';

    public $routes = array (
        'comments_drop'                          => array('comments/:comment/drop',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'drop',
                                                    )),
        'notes_note_comment_delete'              => array('notes/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'note',
                                                    )),
        'files_file_comment_delete'              => array('files/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'file',
                                                    )),
        'events_event_comment_delete'            => array('events/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'event',
                                                    )),
        'notes_note_comment'                     => array('notes/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'new',
                                                        'type'       => 'note',
                                                    )),
        'files_file_comment'                     => array('files/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'resource',
                                                        'action'     => 'new',
                                                        'type'       => 'file',
                                                    )),
        'events_event_comment'                   => array('events/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'resource',
                                                        'action'     => 'new',
                                                        'type'       => 'event',
                                                    )),
    );
}
