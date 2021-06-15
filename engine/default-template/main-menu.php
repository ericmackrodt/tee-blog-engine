<table border="0" cellspacing="5">
  <tr>
    <?php foreach ($mainMenu as $key => $item) : ?>
      <td align="center">
        <a href="<?= $item->path ?>">
          <img src="<?= $item->icon ?>">
          <br>
          <font size="-1"><?= $item->label ?></font>
        </a>
      </td>
    <?php endforeach; ?>
  </tr>
</table>