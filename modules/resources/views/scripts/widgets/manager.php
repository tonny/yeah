<?php

if (Yeah_Acl::hasPermission('resources', 'new')) {
    echo '<table width="100%"><tr><td>[<a href="' . $this->url(array('filter' => 'notes'), 'resources_filtered') . '">Notas</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'notes_new') . '">Crear</a>]</small></td></tr><tr>';
    echo '<td>[<a href="' . $this->url(array('filter' => 'files'), 'resources_filtered') . '">Archivos</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'files_new') . '">Crear</a>]</small></td></tr><tr>';
    echo '<td>[<a href="' . $this->url(array('filter' => 'events'), 'resources_filtered') . '">Eventos</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'events_new') . '">Crear</a>]</small></td></tr><tr>';
    echo '<td>[<a href="' . $this->url(array('filter' => 'feedback'), 'resources_filtered') . '">Sugerencias</a>]</td>';
    echo '<td align="right"><small>[<a href="' . $this->url(array(), 'feedback_new') . '">Crear</a>]</small></td></tr>';
    if (Yeah_Acl::hasPermission('subjects', 'teach')) {
        echo '<tr><td>[<a href="' . $this->url(array('filter' => 'evaluations'), 'resources_filtered') . '">Evaluaciones</a>]</td>';
        echo '<td align="right"><small>[<a href="' . $this->url(array(), 'evaluations_new') . '">Crear</a>]</small></td></tr><tr>';
        echo '<td>[<a href="' . $this->url(array(), 'groupsets_manager') . '">Conjuntos</a>]</td>';
        echo '<td align="right"><small>[<a href="' . $this->url(array(), 'groupsets_new') . '">Crear</a>]</small></td></tr>';
    }
    echo '<tr><td colspan="2"><center>[<a href="' . $this->url(array(), 'resources_list') . '">Ver todos</a>]</center></td></tr></table>';
}
