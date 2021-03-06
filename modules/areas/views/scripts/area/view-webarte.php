<h1><?= $this->area->label ?>
<strong class="task">
<?php if ($this->acl('areas', 'edit')) { ?>
    <a href="<?= $this->url(array('area' => $this->area->url), 'areas_area_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<p><?= $this->area->description ?></p>

<h2>Materias registradas</h2>
<?php if (count($this->subjects)) { ?>
<ul>
<?php foreach ($this->subjects as $subject) { ?>
    <li>
        <span class="mark"><?= $subject->code ?></span>
        <a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?= $subject->label ?></a>
    </li>
<?php } ?>
</ul>
<?php } else { ?>
<p>No se registraron materias aún.</p>
<?php } ?>

<?= $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
