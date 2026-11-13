<?php
define('APP', true);

require __DIR__ . '/modules/db.php';
require __DIR__ . '/modules/menu.php';
require __DIR__ . '/modules/viewer.php';
require __DIR__ . '/modules/add.php';
require __DIR__ . '/modules/edit.php';
require __DIR__ . '/modules/delete.php';

$page = 'view';
if (isset($_GET['page']) && in_array($_GET['page'], ['view', 'add', 'edit', 'delete'])) {
	$page = $_GET['page'];
}

if ($page === 'add') {
	$content = addPage();
} elseif ($page === 'edit') {
	$content = editPage();
} elseif ($page === 'delete') {
	$content = deletePage();
} else {
	$sort = 'id';
	if (isset($_GET['sort']) && in_array($_GET['sort'], ['id', 'surname', 'date'])) {
		$sort = $_GET['sort'];
	}
	$p = isset($_GET['p']) ? (int) $_GET['p'] : 1;
	$content = viewer($sort, $p);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Notebook</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?= menu() ?>
	<main>
		<?= $content ?>
	</main>
	<footer>
		<p>Notebook</p>
	</footer>
</body>
</html>
