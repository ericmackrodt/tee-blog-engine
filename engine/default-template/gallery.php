<p>
  <?php foreach ($images as $i => $image) : ?>
    <a href="/gallery/<?= $page_slug ?>/<?= $id ?>?img=<?= $i ?>">
      <img src="/img.php?p=<?= $image->url ?>&w=120&fit=cover" border="0" />
    </a>
  <?php endforeach; ?>
</p>