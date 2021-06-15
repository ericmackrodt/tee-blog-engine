<?php $this->layout('layout', []) ?>
<?php
$contentWidth = 600;
if (!empty($this->section('left-content'))) {
  $contentWidth = $contentWidth - 120;
}

if (!empty($this->section('right-content'))) {
  $contentWidth = $contentWidth - 120;
}
?>

<center>
  <table cellspacing="0" cellpadding="0" border="0" width="600">
    <tr>
      <?php if (!empty($this->section('left-content'))) : ?>
        <td valign="top" width="120">
          <?= $this->section('left-content') ?>
        </td>
      <?php endif; ?>

      <td valign="top" width="<?= $contentWidth ?>">
        <font face="arial" size="-1">
          <?= $this->section('content') ?>
        </font>
      </td>

      <?php if (!empty($this->section('right-content'))) : ?>
        <td valign="top" width="120">
          <?= $this->section('right-content') ?>
        </td>
      <?php endif; ?>
    </tr>
  </table>
</center>