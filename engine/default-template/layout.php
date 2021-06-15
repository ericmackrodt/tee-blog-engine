<html>

<head>
    <meta charset="UTF-8">
    <title>
        <?= $this->e($siteName) ?>
        <?php if ($title) : ?>
            | <?= $title ?>
        <?php endif; ?>
    </title>
    <?= $this->section('seo') ?>
</head>

<body bgcolor="#ffffff" text="#000000">
    <center>
        <h1><?= $this->e($siteName) ?></h1>
        <?php $this->insert('main-menu') ?>
    </center>

    <?= $this->section('content') ?>

    <center>
        <br>
        <?php $this->insert('tags') ?>
        <br>
        Copyright © 1988-2021 Eric Mackrodt
        <br>
    </center>
</body>

</html>