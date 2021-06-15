<table width="600">
  <tr>
    <td>
      <?php
      $len = count($posts);
      $i = 0;
      ?>
      <?php foreach ($posts as $post) : ?>
        <?php $isLast = $i == $len - 1; ?>
        <?php $image = $post->full_path . $post->image; ?>
        <table width="600" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td width="143" valign="top">
              <a href="/post/<?= $post->slug ?>">
                <img src="/img.php?p=<?= $image ?>&w=143&fit=cover&aspectRatio=16:9" border="0" /></a>
            </td>
            <td width="10" valign="top">
              <img src="/assets/nothing.gif" width="10" height="1">
            </td>
            <td valign="top" width="397">
              <a href="/post/<?= $post->slug ?>">
                <font size="3" color="#000000" face="arial">
                  <b><?= $post->title ?></b>
                </font>
              </a>
              <br>
              <font face="arial" size="-1" color="#000000">
                <?= $post->description ?>
              </font>
              <br>
              <font size="-1" face="arial" color="#777777">
                <?= $post->date ?>
              </font>
            </td>
          </tr>

          <?php if (!$isLast) : ?>
            <tr>
              <td colspan="3" width="600" valign="top">
                <hr width="600" />
              </td>
            </tr>
          <?php endif; ?>
          <?php $i++ ?>
        </table>
      <?php endforeach; ?>
    </td>
  </tr>
</table>