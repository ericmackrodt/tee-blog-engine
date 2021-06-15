<table cellspacing="1" border="0" cellpadding="2" width="470">
  <tr>
    <td bgcolor="#777777">
      <font size="-1" face="arial"><b><a name="<?= $data->id ?>"></a><?= $this->e($data->name) ?></b></font>
    </td>
    <td bgcolor="#777777" align="right" valign="top">
      <a href="<?= $data->url ?>" target="_blank">
        <font size="2" face="arial"><?= $data->file ?></font>
      </a>
    </td>
  </tr>
  <tr>
    <td bgcolor="#777777" colspan="2">
      <font size="-1">
        <?= $data->description ?>
      </font>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <img src="/assets/nothing.gif" width="470" height="2">
    </td>
  </tr>
</table>