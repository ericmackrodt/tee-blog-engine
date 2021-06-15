<table bordercolordark="#000000" width="600" border="0">
  <tr>
    <td>
      <font size="3">
        <b>Tags</b>
      </font>
      <br>

      <?php
      $len = count($tags);
      $i = 0;
      ?>
      <?php foreach ($tags as $id => $tag) : ?>
        <?php $isLast = $i == $len - 1; ?>
        <a href="/tag?id=<?= $tag->id ?>">
          <?= $this->e($tag->name) ?> (<?= count($tag->slugs) ?>)
        </a>
        <?php if (!$isLast) : ?>
          |
        <?php endif; ?>
        <?php $i++ ?>
      <?php endforeach; ?>
    </td>
  </tr>
</table>