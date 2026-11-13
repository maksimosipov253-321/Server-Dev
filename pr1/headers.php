<?php
$pageTitle = 'Feedback form — заголовки';

$url = 'https://httpbin.org/get';
$headers = get_headers($url);

if ($headers === false) {
	$headersText = 'Не удалось получить заголовки: ' . $url;
} else {
	$headersText = implode("\n", $headers);
}

require __DIR__ . '/includes/header.php';
?>
		<h2>Результат работы функции get_headers</h2>
		<textarea readonly rows="12"><?= htmlspecialchars($headersText, ENT_QUOTES, 'UTF-8') ?></textarea>
		<p><a href="index.php">На первую страницу</a></p>
<?php require __DIR__ . '/includes/footer.php'; ?>
