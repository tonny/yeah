<h1><?= $this->PAGE->label ?></h1>

<?php if ($this->acl('friends', 'contact')) { ?>
<div>
<input type="button" name="list" value="Amigos" onclick="location.href='<?= $this->url(array(), 'friends_friends') ?>'" /><input type="button" name="list" value="Solicitudes" onclick="location.href='<?= $this->url(array(), 'friends_followings') ?>'" /><input type="button" name="list" value="Peticiones" onclick="location.href='<?= $this->url(array(), 'friends_followers') ?>'" />
</div>
<?php } ?>

<?php if (count($this->followers)) { ?>
    <div id="block">
    <?php foreach ($this->followers as $follower) { ?>
    <?php $user = $this->model_users->findByIdent($follower->user); ?>
        <div class="box">
            <div class="title">
                <?php if ($this->acl('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>"><?= $user->getFullName() ?></a>
                <?php } else { ?>
                    <?= $user->getFullName() ?>
                <?php } ?>
            </div>
            <div class="photo">
                <?php if ($this->acl('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>"><img src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?= $user->getFullName() ?>" title="<?= $user->getFullName() ?>" /></a>
                <?php } else { ?>
                    <img src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?= $user->getFullName() ?>" title="<?= $user->getFullName() ?>" />
                <?php } ?>
            </div>
            <div class="tools">
                <?php if ($this->acl('users', 'edit') && $this->USER->hasFewerPrivileges($user)) { ?>
                    <a href="<?= $this->url(array('user' => $user->url), 'users_user_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                <?php } ?>
                <?php if ($this->acl('friends', 'contact')) { ?>
                    <?php if ($this->USER->ident != $user->ident) { ?>
                        <?php if ($this->model_friends->hasContact($this->USER->ident, $user->ident)) { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'friends_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/user_delete.png' ?>" alt="Retirar contacto" title="Retirar contacto" /></a>
                        <?php } else { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'friends_add') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/user_add.png' ?>" alt="Agregar contacto" title="Agregar contacto" /></a>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
            <p>
                <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'activity', 'value' => $user->activity, 'TEMPLATE' => $this->TEMPLATE)) ?>
                <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'participation', 'value' => $user->participation, 'TEMPLATE' => $this->TEMPLATE)) ?>
                <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'sociability', 'value' => $user->sociability, 'TEMPLATE' => $this->TEMPLATE)) ?>
                <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'popularity', 'value' => $user->popularity, 'TEMPLATE' => $this->TEMPLATE)) ?>
            </p>
            <p><span class="bold">Contacto: </span><?= $this->timestamp($follower->tsregister) ?></p>
            <p><span class="bold">Cargo: </span><?= $user->getRole()->label ?></p>
            <p><span class="bold">Carrera: </span><?= $this->none($user->career) ?></p>
            <?php $tags = $user->getTags() ?>
            <?php if (count($tags)) { ?>
            <p>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/tag.png' ?>" alt="Etiquetas" title="Etiquetas" />
                <?php foreach ($tags as $tag) { ?>
                    <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?= $tag->label ?></a>
                <?php } ?>
            </p>
            <?php } ?>
        </div>
    <?php } ?>
    </div>
    <div class="clear"></div>
<?php } else { ?>
<p>No existen peticiones registradas</p>
<?php } ?>

<?php if ($this->acl('friends', 'contact')) { ?>
<div>
<input type="button" name="list" value="Amigos" onclick="location.href='<?= $this->url(array(), 'friends_friends') ?>'" /><input type="button" name="list" value="Solicitudes" onclick="location.href='<?= $this->url(array(), 'friends_followings') ?>'" /><input type="button" name="list" value="Peticiones" onclick="location.href='<?= $this->url(array(), 'friends_followers') ?>'" />
</div>
<?php } ?>