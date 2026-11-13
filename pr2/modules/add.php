<?php
if (!defined('APP')) {
	die('Доступ запрещен');
}

function addPage()
{
	$message = '';
	$surname = '';
	$name = '';
	$lastname = '';
	$gender = 'мужской';
	$date = '';
	$phone = '';
	$location = '';
	$email = '';
	$comment = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$surname = trim($_POST['surname']);
		$name = trim($_POST['name']);
		$lastname = trim($_POST['lastname']);
		$gender = $_POST['gender'] == 'женский' ? 'женский' : 'мужской';
		$date = trim($_POST['date']);
		$phone = trim($_POST['phone']);
		$location = trim($_POST['location']);
		$email = trim($_POST['email']);
		$comment = trim($_POST['comment']);

		if ($surname == '' || $name == '') {
			$message = '<p class="error">Ошибка: запись не добавлена</p>';
		} else {
			$stmt = db()->prepare(
				'INSERT INTO contacts (surname, name, lastname, gender, date, phone, location, email, comment)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
			);
			$stmt->execute([$surname, $name, $lastname, $gender, $date, $phone, $location, $email, $comment]);
			$message = '<p class="success">Запись добавлена</p>';
			$surname = '';
			$name = '';
			$lastname = '';
			$gender = 'мужской';
			$date = '';
			$phone = '';
			$location = '';
			$email = '';
			$comment = '';
		}
	}

	$male = $gender == 'мужской' ? ' selected' : '';
	$female = $gender == 'женский' ? ' selected' : '';

	return $message . '
	<form name="form_add" method="post" action="index.php?page=add">
		<div class="column">
			<div class="add">
				<label>Фамилия</label>
				<input type="text" name="surname" placeholder="Фамилия" value="' . html($surname) . '">
			</div>
			<div class="add">
				<label>Имя</label>
				<input type="text" name="name" placeholder="Имя" value="' . html($name) . '">
			</div>
			<div class="add">
				<label>Отчество</label>
				<input type="text" name="lastname" placeholder="Отчество" value="' . html($lastname) . '">
			</div>
			<div class="add">
				<label>Пол</label>
				<select name="gender">
					<option value="мужской"' . $male . '>мужской</option>
					<option value="женский"' . $female . '>женский</option>
				</select>
			</div>
			<div class="add">
				<label>Дата рождения</label>
				<input type="date" name="date" value="' . html($date) . '">
			</div>
			<div class="add">
				<label>Телефон</label>
				<input type="text" name="phone" placeholder="Телефон" value="' . html($phone) . '">
			</div>
			<div class="add">
				<label>Адрес</label>
				<input type="text" name="location" placeholder="Адрес" value="' . html($location) . '">
			</div>
			<div class="add">
				<label>Email</label>
				<input type="email" name="email" placeholder="Email" value="' . html($email) . '">
			</div>
			<div class="add">
				<label>Комментарий</label>
				<textarea name="comment" placeholder="Краткий комментарий">' . html($comment) . '</textarea>
			</div>
			<button type="submit" name="button" class="form-btn" value="Добавить">Добавить</button>
		</div>
	</form>';
}
