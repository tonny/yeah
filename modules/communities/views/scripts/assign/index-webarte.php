<h1>Miembros: <?= $this->community->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<?php if ($this->community->amAuthor()) { ?><input type="submit" value="Convertir en moderador" name="moderate" /><input type="submit" value="Convertir en miembro" name="unmoderate" /><?php } ?>
<?php if ($this->community->amModerator()) { ?><input type="submit" value="Habilitar" name="unlock" /><input type="submit" value="Deshabilitar" name="lock" /><input type="submit" value="Retirar" name="delete" /><?php } ?>
    </div>

<div id="block">
    <h2>Moderadores</h2>
<?php if (count($this->moderators) != 0) { ?>
    <?php foreach ($this->moderators as $moderator) { ?>
        <?php $assign = $this->community->getAssignement($moderator); ?>
        <div class="member">
            <?php if ($this->community->amModerator() && $moderator->ident <> $this->community->author && $moderator->ident <> $this->USER->ident) { ?>
                <input type="checkbox" name="members[]" value="<?= $moderator->ident ?>" />
            <?php } ?>
                <p><span class="title"><?= $moderator->getFullName() ?></span></p>
            <?php if ($this->acl('users', 'view')) { ?>
                <a href="<?= $this->url(array('user' => $moderator->url), 'users_user_view') ?>"><img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $moderator->getAvatar() ?>" alt="<?= $moderator->getFullName() ?>" title="<?= $moderator->getFullName() ?>" /></a>
            <?php } else { ?>
                <img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $moderator->getAvatar() ?>" alt="<?= $moderator->getFullName() ?>" title="<?= $moderator->getFullName() ?>" />
            <?php } ?>
            <div class="body">
            <?php if ($assign->status == 'active') { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario habilitado" />
            <?php } else { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario deshabilitado" />
            <?php } ?>
            <?php if ($this->community->amModerator() && $this->community->author <> $moderator->ident && $moderator->ident <> $this->USER->ident) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $moderator->url), 'communities_community_assign_member_lock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Deshabilitar" title="Deshabilitar" /></a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $moderator->url), 'communities_community_assign_member_unlock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Habilitar" title="Habilitar" /></a>
                <?php } ?>
                <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $moderator->url), 'communities_community_assign_member_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
            <?php } ?>
                <p><span class="bold">Miembro desde: </span></p>
                <p><?= $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No existe ningun moderador registrado en esta comunidad.</p>
<?php } ?>
    <div class="clear"></div>

    <h2>Miembros</h2>
<?php if (count($this->members) != 0) { ?>
    <?php foreach ($this->members as $member) { ?>
        <?php $assign = $this->community->getAssignement($member); ?>
        <div class="member">
        <?php if ($this->community->amModerator() && $member->ident <> $this->community->author && $member->ident <> $this->USER->ident ) { ?>
            <input type="checkbox" name="members[]" value="<?= $member->ident ?>" />
        <?php } ?>
            <p><span class="title"><?= $member->getFullName() ?></span></p>
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?= $this->url(array('user' => $member->url), 'users_user_view') ?>"><img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $member->getAvatar() ?>" alt="<?= $member->getFullName() ?>" title="<?= $member->getFullName() ?>" /></a>
        <?php } else { ?>
            <img class="photo" src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $member->getAvatar() ?>" alt="<?= $member->getFullName() ?>" title="<?= $member->getFullName() ?>" />
        <?php } ?>
            <div class="body">
            <?php if ($assign->status == 'active') { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Usuario activo" title="Usuario habilitado" />
            <?php } else { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Usuario inactivo" title="Usuario deshabilitado" />
            <?php } ?>
            <?php if ($this->community->amModerator() && $this->community->author <> $member->ident && $member->ident <> $this->USER->ident) { ?>
                <?php if ($assign->status == 'active') { ?>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $member->url), 'communities_community_assign_member_lock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Deshabilitar" title="Deshabilitar" /></a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $member->url), 'communities_community_assign_member_unlock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Habilitar" title="Habilitar" /></a>
                <?php } ?>
                <a href="<?= $this->url(array('community' => $this->community->url, 'user' => $member->url), 'communities_community_assign_member_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Retirar" title="Retirar" /></a>
            <?php } ?>
                <p><span class="bold">Miembro desde: </span></p>
                <p><?= $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No existe ningun miembro registrado en esta comunidad.</p>
<?php } ?>
    <div class="clear"></div>
</div>

    <div>
<?php if ($this->community->amAuthor()) { ?><input type="submit" value="Convertir en moderador" name="moderate" /><input type="submit" value="Convertir en miembro" name="unmoderate" /><?php } ?>
<?php if ($this->community->amModerator()) { ?><input type="submit" value="Habilitar" name="unlock" /><input type="submit" value="Deshabilitar" name="lock" /><input type="submit" value="Retirar" name="delete" /><?php } ?>
    </div>
</form>
