<h1><?= $this->groupset->label ?>
<strong class="task">
<?php if ($this->groupset->author == $this->USER->ident) { ?>
    <a href="<?= $this->url(array('groupset' => $this->groupset->ident), 'groupsets_groupset_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<h2>Grupos asignados</h2>
<?php if (count($this->subjects)) { ?>
    <?php foreach ($this->subjects as $subject) { ?>
        <?php $groups = array(); ?>
        <?php foreach ($this->groups[$subject->ident] as $group) { ?>
            <?php foreach ($this->groupset_groups as $groupset_group) { ?>
                <?php if ($group->ident == $groupset_group->ident) { ?>
                    <?php $groups[] = '<a href="' . $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">Grupo ' . $group->label . '</a>'; ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <dl>
        <?php if (count($groups) <> 0) { ?>
            <dt><a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?= $subject->label ?></a></dt>
            <dd><ul><li><?= implode('</li><li>', $groups) ?></li></ul></dd>
        <?php } ?>
        </dl>
    <?php } ?>
<?php } else { ?>
    <p>No existen asignaciones suyas en ninguna materia.</p>
<?php } ?>
