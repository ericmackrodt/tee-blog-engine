<?php $this->layout('layout', []) ?>

<center>
  <table bordercolordark="#000000" width="600" border="0">
    <tr>
      <td>
        <h2>Welcome</h2>
        <font size="-1">
          <?= $intro ?>
        </font>
      </td>
    </tr>
  </table>
  <br>
  <h3>Latest parts of the experiment</h3>
  <?php $this->insert(withVariant('categories')) ?>
  <img src="nothing.gif" width="1" height="5"><br><img src="black_pixel.gif" width="100%" height="1"><br><img src="nothing.gif" width="1" height="5">
  <?php $this->insert(withVariant('post-list'), ['posts' => $posts]) ?>
  <img src="nothing.gif" width="1" height="5"><br><img src="black_pixel.gif" width="100%" height="1"><br><img src="nothing.gif" width="1" height="5">
  <?php $this->insert(withVariant('categories')) ?>
</center>