<?php $this->layout(withVariant('page-content-layout'), ['title' => $this->e($data["title"])]) ?>

<?php if (!empty($data["left-content"])) : ?>      
  <?php $this->push('left-content') ?>
    <?= $data["left-content"] ?>
  <?php $this->end() ?>
<?php endif; ?>

<?= $data["content"] ?>

<?php if (!empty($data["right-content"])) : ?>      
  <?php $this->push('right-content') ?>
    <?= $data["right-content"] ?>
  <?php $this->end() ?>
<?php endif; ?>