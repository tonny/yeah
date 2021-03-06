<h1><?= $this->PAGE->label ?></h1>
<?php if (count($this->roles)) { ?>
    <dl>
    <?php foreach ($this->roles as $role) { ?>
        <dt>
            <?php if ($this->acl('roles', 'view')) { ?>
                <a href="<?= $this->url(array('role' => $role->url), 'roles_role_view') ?>"><?= $role->label ?></a>
            <?php } else { ?>
                <?= $role->label ?>
            <?php } ?>
            <?php if ($this->acl('roles', 'edit')) { ?>
                <a href="<?= $this->url(array('role' => $role->url), 'roles_role_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
        </dt>
        <dd><p><?= $role->description ?></p></dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>No existen roles registrados</p>
<?php } ?>
