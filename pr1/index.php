<?php
$pageTitle = 'Feedback form';
$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$payload = http_build_query([
		'username' => $_POST['username'] ?? '',
		'email' => $_POST['email'] ?? '',
		'appeal_type' => $_POST['appeal_type'] ?? '',
		'message' => $_POST['message'] ?? '',
		'response' => $_POST['response'] ?? [],
	]);

	$context = stream_context_create([
		'http' => [
			'method' => 'POST',
			'header' => "Content-Type: application/x-www-form-urlencoded\r\nAccept: application/json\r\n",
			'content' => $payload,
			'timeout' => 15,
			'ignore_errors' => true,
		],
	]);

	$response = file_get_contents('https://httpbin.org/post', false, $context);

	if ($response === false) {
		$error = 'Не удалось отправить данные на https://httpbin.org/post';
	} else {
		$decoded = json_decode($response, true);
		$result = $decoded === null
			? $response
			: json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
}

function field(string $name): string
{
	$value = $_POST[$name] ?? '';
	return htmlspecialchars(is_string($value) ? $value : '', ENT_QUOTES, 'UTF-8');
}

function optionSelected(string $value): string
{
	return (($_POST['appeal_type'] ?? '') === $value) ? ' selected' : '';
}

function responseChecked(string $value): string
{
	$selected = $_POST['response'] ?? [];
	if (!is_array($selected)) {
		$selected = [$selected];
	}

	return in_array($value, $selected, true) ? ' checked' : '';
}

require __DIR__ . '/includes/header.php';
?>
		<form action="index.php" method="post">
			<label for="username">Имя пользователя</label>
			<input id="username" name="username" type="text" value="<?= field('username') ?>" required>

			<label for="email">E-mail пользователя</label>
			<input id="email" name="email" type="email" value="<?= field('email') ?>" required>

			<label for="appeal-type">Тип обращения</label>
			<select id="appeal-type" name="appeal_type" required>
				<option value="" disabled<?= (($_POST['appeal_type'] ?? '') === '') ? ' selected' : '' ?>>Выберите тип</option>
				<option value="жалоба"<?= optionSelected('жалоба') ?>>Жалоба</option>
				<option value="предложение"<?= optionSelected('предложение') ?>>Предложение</option>
				<option value="благодарность"<?= optionSelected('благодарность') ?>>Благодарность</option>
			</select>

			<label for="message">Текст обращения</label>
			<textarea id="message" name="message" rows="5" required><?= field('message') ?></textarea>

			<fieldset>
				<legend>Вариант ответа</legend>
				<label>
					<input type="checkbox" name="response[]" value="sms"<?= responseChecked('sms') ?>>
					СМС
				</label>
				<label>
					<input type="checkbox" name="response[]" value="email"<?= responseChecked('email') ?>>
					E-mail
				</label>
			</fieldset>

			<button type="submit">Отправить</button>
			<a class="page-link" href="headers.php">Перейти на 2 страницу</a>
		</form>

		<?php if ($error !== null || $result !== null): ?>
		<div class="result">
			<?php if ($error !== null): ?>
				<h2>Ошибка отправки</h2>
				<p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
			<?php else: ?>
				<h2>Форма отправлена</h2>
				<p>Ответ сервиса https://httpbin.org/post</p>
				<textarea readonly rows="12"><?= htmlspecialchars($result, ENT_QUOTES, 'UTF-8') ?></textarea>
			<?php endif; ?>
		</div>
		<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
