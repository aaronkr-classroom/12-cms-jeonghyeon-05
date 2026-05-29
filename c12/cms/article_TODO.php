<?php
// @TODO
?>
<?php include 'includes/header.php'; ?>
  <main class="article container" id="content">
    <section class="image">
      <img src="uploads/<?= // @TODO ?>" 
           alt="<?= // @TODO ?>">
    </section>
    <section class="text">
      <h1><?= // @TODO ?></h1>
      <div class="date"><?= // @TODO ?></div>
      <div class="content"><?= // @TODO ?></div>
      <p class="credit">
        Posted in <a href="category.php?id=<?= $article['category_id'] ?>"><?= // @TODO ?></a> by <a href="member.php?id=<?= $article['member_id'] ?>">
          <?= // @TODO ?></a>
      </p>
    </section>
  </main>
<?php include 'includes/footer.php'; ?>