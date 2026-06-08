<?php
//슬라이드 72~73
declare(strict_types =1); // 엄격한 타입 사용
require_once 'includes/database-connection.php'; //PDO객체
require_once 'includes/functions.php';

//--------
$term = filter_input(INPUT_GET, 'term');
$term = filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ?? 3;
$from = filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ?? 0; //아이디 유효성 확인
$count = 0;
$articles = [];

if ($term) {
  $arguments['term1'] = '%' . $term . '%';
  $arguments['term2'] = '%' . $term . '%';
  $arguments['term3'] = '%' . $term . '%';

  $sql = "SELECT COUNT(title) FROM article
          WHERE title     LIKE :term1
             OR summary   LIKE :term2
             OR content   LIKE :term3
            AND published = 1;";
  $count = pdo($pdo, $spl, $arguments)->fetchColumn(); // 개수 변환
  if ($count > 0 ) {
    $arguments['show'] = $show; 
    $arguments['from'] = $from; 

    $sql = "SELECT a.id, a.title, a.summary, a.category_id, a.member_id,
                  c.name        As category,
                  CONCAT(m.forename, ' ', m.surname) AS author,
                  i.file        AS image_file,
                  i.alt         AS image_alt
              FROM article      AS a
              JOIN category     AS c ON a.category_id = c.id
              JOIN member       AS m ON a.member_id   = m.id
            LEFT JOIN image     AS i ON a.image_id    = i.id
            WHERE a.title       LIKE :term1
               OR a.summary     LIKE :term2
               OR a.content     LIKE :term3
              AND publiched = 1
            ORDER BY a.id DESC
            LIMIT :show
            OFFSET :from;"; // 최근 기사 가져오는 SQL
    $article = pdo($pdo, $sql, $arguments)->fetch(); //기사 6개 불러오rl
  }
}

if ($count > $show) {
  $total_pages = ceil($count / $show); //총 페이지 계산
  $current_page = ceil($from / $show) +1; //현재 페이지 계산
}

//-------------

$sql = "SELECT id, name FROM category WHERE navigation = 1;";
$navigation = pdo($pdo, $sql)->fetchall();

$section      = '';
$title        = 'Search results for ' . $term; // HTML <title> tag
$description  = $title . ' On Creative Folk'; //메타 description
?>
<?php include 'includes/header.php'; ?>
  <main class="container" id="content">
    <section class="header">
      <form action="search.php" method="get" class="form-search">
        <label for="search"><span>Search for: </span></label>
        <input type="text" name="term" value="<?= html_escape($term) ?>" 
               id="search" placeholder="Enter search term"  
        /><input type="submit" value="Search" class="btn btn-search" />
      </form>
      <?php if ($term) { ?><p><b>Matches found:</b> <?= $count ?></p><?php } ?>
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

    <?php if ($count > $show) { ?>
    <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
      <ul>
      <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <li>
          <a href="?term=<?= $term ?>&show=<?= $show ?>&from=<?= (($i - 1) * $show) ?>"
            class="btn <?= ($i == $current_page) ? 'active" aria-current="true' : '' ?>">
            <?= $i ?>
          </a>
        </li>
      <?php } ?>
      </ul>
    </nav>
    <?php } ?>

  </main>
<?php include 'includes/footer.php'; ?>