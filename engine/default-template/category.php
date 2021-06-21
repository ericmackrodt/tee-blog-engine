<?php $this->layout(withVariant('layout'), ['title' => $this->e($name)]) ?>
<center>
  <h2>Category: <?= $this->e($name) ?></h2>
  <?php $this->insert(withVariant('categories')) ?>
  <br>
  <?php $this->insert(withVariant('post-list'), ['posts' => $posts]) ?>
  <br>
  <?php $this->insert(withVariant('categories')) ?>
</center>