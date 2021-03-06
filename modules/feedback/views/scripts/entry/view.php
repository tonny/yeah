<h1>Sugerencia 
<?php if ($this->resource->amAuthor()) { ?>
    [<i><a href="<?= $this->url(array('entry' => $this->resource->ident), 'feedback_entry_edit') ?>">Editar</a></i>]
<?php } ?>
</h1>

<table width="100%">
    <tr>
        <td valign="top">
            <b>Autor: </b>
            <i>
            <?php if ($this->acl('users', 'view')) { ?>
                <a href="<?= $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') ?>"><?= $this->resource->getAuthor()->label ?></a>
            <?php } else { ?>
                <?= $this->resource->getAuthor()->label ?>
            <?php } ?>
            </i>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <b>Etiquetas: </b>
        <?php foreach ($this->tags as $tag) { ?>
            <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><i><?= $tag->label ?></i></a>&nbsp;
        <?php } ?>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <b>Valoración: </b>
        <?php if ($this->acl('ratings', 'new')) { ?>
            <a href="<?= $this->url(array('resource' => $this->resource->ident), 'feedback_entry_rating_down') ?>"><b>&laquo;</b></a>
        <?php } ?>
                <i><?= $this->resource->ratings ?> / <?= $this->resource->raters ?></i>
        <?php if ($this->acl('ratings', 'new')) { ?>
            <a href="<?= $this->url(array('resource' => $this->resource->ident), 'feedback_entry_rating_up') ?>"><b>&raquo;</b></a>
        <?php } ?>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <b>Fecha: </b><i><?= $this->timestamp($this->resource->tsregister) ?></i>
        </td>
    </tr>
</table>

<p><?= $this->entry->description ?></p>

<?php if ($this->acl('comments', 'view')) { ?>
    <h2>Comentarios</h2>
    <?= $this->partial('comments.php', array('resource' => $this->resource, 'route' => 'feedback_entry_comment')) ?>
    <?php if ($this->acl('comments', 'new')) { ?>
    <?= $this->partial('comment/post.php', array('resource' => $this->resource, 'route' => 'feedback_entry_comment')) ?>
    <?php } ?>
<?php } ?>
