<table bordercolordark="#000000" width="600" border="0">
  <tr>
    <td>
      <font size="3">
        <b>Categories</b>
      </font>
      <br>

      <?php
      $len = count($categories);
      $i = 0;
      ?>
      <?php foreach ($categories as $id => $category) : ?>
        <?php $isLast = $i == $len - 1; ?>
        <a href="/category?id=<?= $category->id ?>">
          <?= $this->e($category->name) ?>
        </a>
        <?php if (!$isLast) : ?>
          |
        <?php endif; ?>
        <?php $i++ ?>
      <?php endforeach; ?>
    </td>
  </tr>
</table>