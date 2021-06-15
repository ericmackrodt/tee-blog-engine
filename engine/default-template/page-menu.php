<table cellspacing="0" cellpadding="2" border="0" width="100%">
  <tr>
    <td bgcolor="#1238B3" align="center">
      <font face="arial" size="3">
        <b>Contents</b>
      </font>
    </td>
  </tr>
  <?php foreach ($items as $item) : ?>
    <tr>
      <td>
        <a href="<?= $this->e($item->url) ?>">
          <font face="arial" size="-1">
            <?= trim($item->content); ?>
          </font>
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>