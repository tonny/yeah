<?= $this->doctype() ?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="Content-Language" content="es-BO" />
        <?= $this->headLink()->appendStylesheet($this->TEMPLATE->htmlbase . 'css/style.css'); ?>
        <link rel="icon" type="image/x-icon" href="<?= $this->CONFIG->media_base ?>favicon.ico" />
        <title><?= $this->TITLE->toString() ?></title>
    </head>
    <body>
        <div id="header">
            <div class="tools">
                <?= $this->render('webarte/toolbar.php'); ?>
            </div>
            <div class="menu">
                <?= $this->render('webarte/menubar.php'); ?>
            </div>
        </div>
        <div id="content">
            <div id="primary">
                <?= $this->render('webarte/messages.php') ?>
                <?= $this->render('webarte/breadcrumb.php') ?>
                <div id="main">
                    <?= $this->layout()->content ?>
                </div>
            </div>
            <div id="secondary">
                <?= $this->render('webarte/widgets.php') ?>
            </div>
        </div>
        <div id="footer">
            <?= $this->render('webarte/footer.php'); ?>
        </div>
    </body>
</html>
