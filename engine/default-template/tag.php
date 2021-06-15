<?php $this->layout('layout', ['title' => $this->e($name)]) ?>
<center>
  <h2>Tag: <?= $this->e($name) ?></h2>
  <?php $this->insert('categories') ?>
  <br>
  <?php $this->insert('post-list', ['posts' => $posts]) ?>
  <br>
  <?php $this->insert('categories') ?>
</center>