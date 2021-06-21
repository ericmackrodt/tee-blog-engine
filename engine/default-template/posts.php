<?php $this->layout(withVariant('layout'), ['title' => 'Posts']) ?>
<center>
  <h2>Posts - Page <?= $page ?></h2>
  <?php $this->insert(withVariant('categories')) ?>
  <br>
  <?php $this->insert(withVariant('post-list'), ['posts' => $posts]) ?>
  <br>
  <?php $this->insert(withVariant('categories')) ?>
</center>