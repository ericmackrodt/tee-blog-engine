<?php $this->layout('layout', ['title' => $this->e($name)]) ?>
<center>
  <table width="600" border="0">
    <tr>
      <td>
        <font face="arial" size="-1">
          <font size="2">
            <b>Gallery</b>
          </font><br>
          <font size="5">
            <b><?= $page_title ?></b>
          </font><br>
          <font size="3">
            <b><?= $gallery["title"] ?></b>
          </font><br>
          <hr width="100%" />
          <center>
            <?php if ($previousImage != null) : ?>
              <a href="<?= $previousImage ?>">[previous image]</a>
            <?php endif; ?>
            <?php if ($nextImage != null) : ?>
              <a href="<?= $nextImage ?>">[next image]</a>
            <?php endif; ?>
            <img src="/img.php?p=<?= $currentImage->url ?>&w=600&fit=cover"><br>
            <?php if ($previousImage != null) : ?>
              <a href="<?= $previousImage ?>">[previous image]</a>
            <?php endif; ?>
            <?php if ($nextImage != null) : ?>
              <a href="<?= $nextImage ?>">[next image]</a>
            <?php endif; ?>
          </center>
        </font>
      </td>
    </tr>
  </table>
</center>