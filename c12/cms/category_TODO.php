<?php
// @TODO
?>
<?php include 'includes/header.php'; ?>
<main class="container" id="content">
  <section class="header">
    <h1><?= html_escape($category['name']) ?></h1>
    <p><?= html_escape($category['description']) ?></p>
  </section>
  <section class="grid">
  <?php foreach ($articles as $article) { ?>
    <article class="summary">
      <a href="article.php?id=<?= $article['id'] ?>">
        <img src="uploads/<?= html_escape($article['image_file'] ?? 'blank.png') ?>"
             alt="<?= html_escape($article['image_alt']) ?>">
        <h2><?= html_escape($article['title']) ?></h2>
        <p><?= html_escape($article['summary']) ?></p>
      </a>
      <p class="credit">
        Posted in <a href="category.php?id=<?= $article['category_id'] ?>">
        <?= html_escape($article['category']) ?></a>
        by <a href="member.php?id=<?= $article['member_id'] ?>">
        <?= html_escape($article['author']) ?></a>
      </p>
    </article>
  <?php } ?>
  </section>
</main>
<?php include 'includes/footer.php'; ?>