<?php $this->layout('layout', ['title' => $this->e($name)]) ?>
<center>
  <h2>Category: <?= $this->e($name) ?></h2>
  <?php $this->insert('categories') ?>
  <img src="nothing.gif" width="1" height="5"><br><img src="black_pixel.gif" width="100%" height="1"><br><img src="nothing.gif" width="1" height="5">
  <?php $this->insert('post-list', ['posts' => $posts]) ?>
  <img src="nothing.gif" width="1" height="5"><br><img src="black_pixel.gif" width="100%" height="1"><br><img src="nothing.gif" width="1" height="5">
  <?php $this->insert('categories') ?>
</center>