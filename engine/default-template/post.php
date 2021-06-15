<?php $this->layout('layout', ['title' => $this->e($data->title)]) ?>
<?php $this->push('seo') ?>
<meta name="description" content="<?= $this->e($data->description); ?>">
<link rel="canonical" href="http://www.theericexperiment.com/post/<?= $this->e($data->slug); ?>" />
<meta property="og:locale" content="en_AU" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?= $this->e($data->title); ?>" />
<meta property="og:description" content="<?= $this->e($data->description); ?>" />
<meta property="og:url" content="http://www.theericexperiment.com/post/<?= $this->e($data->slug); ?>" />
<meta property="og:site_name" content="The Eric Experiment" />
<meta property="article:section" content="Blog" />
<meta property="article:published_time" content="@(model.metadata.date)T12:10:00+00:00" />
<meta property="article:modified_time" content="@(model.metadata.date)T10:05:01+00:00" />
<meta property="og:updated_time" content="@(model.metadata.date)T10:05:01+00:00" />
<meta property="og:image" content="http://www.theericexperiment.com/post/asset/143/143/@image?fit=cover" />
<meta property="og:image:secure_url" content="https://www.theericexperiment.com/post/asset/143/143/@image?fit=cover" />
<meta property="og:image:width" content="143" />
<meta property="og:image:height" content="80" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="<?= $this->e($data->description); ?>" />
<meta name="twitter:title" content="<?= $this->e($data->title); ?>" />
<meta name="twitter:image" content="https://www.theericexperiment.com/post/asset/143/143/@image?fit=cover" />
<?php $this->end() ?>

<img src="/assets/nothing.gif" width="1" height="5"><br><img src="/assets/black_pixel.gif" width="100%" height="1"><br><img src="/assets/nothing.gif" width="1" height="5"><br>
<center>
  <table border="0" width="600">
    <tr>
      <td>
        <font face="arial" size="-1">
          <font size="5">
            <b><?= $this->e($data->title); ?></b>
          </font><br>
          <hr width="100%" />
          <b>Published: </b><?= $this->e($data->date); ?>
          <br />
          <b>Tags: </b>
          <?php foreach ($data->tags as $id => $tag) : ?>
            <?php $isLast = $i == $len - 1; ?>
            <a href="/tag?id=<?= $tag->id ?>">
              <?= $this->e($tag->name) ?>
            </a>
            <?php if (!$isLast) : ?>
              ,
            <?php endif; ?>
            <?php $i++ ?>
          <?php endforeach; ?>
          <?= $data->content ?>
        </font>
      </td>
    </tr>
  </table>
</center>