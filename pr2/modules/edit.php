<?php
if (!defined('APP')) {
	die('Доступ запрещен');
}

function editPage()
{
	$people = db()->query('SELECT id, surname, name FROM contacts ORDER BY surname, name')->fetchAll();
	if (!$people) {
		return '<p>Записей нет</p>';
	}

	$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
	$exists = false;
	foreach ($people as $person) {
		if ($person['id'] == $id) {
			$exists = true;
		}
	}
	if (!$exists) {
		$id = $people[0]['id'];
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$id = (int) $_POST['id'];
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
			$row = [
				'surname' => $surname,
				'name' => $name,
				'lastname' => $lastname,
				'gender' => $gender,
				'date' => $date,
				'phone' => $phone,
				'location' => $location,
				'email' => $email,
				'comment' => $comment,
			];
			return '<p class="error">Ошибка: запись не сохранена</p>' . editLinks($people, $id) . editForm($row, $id);
		}

		$stmt = db()->prepare(
			'UPDATE contacts
			SET surname = ?, name = ?, lastname = ?, gender = ?, date = ?, phone = ?, location = ?, email = ?, comment = ?
			WHERE id = ?'
		);
		$stmt->execute([$surname, $name, $lastname, $gender, $date, $phone, $location, $email, $comment, $id]);
		$people = db()->query('SELECT id, surname, name FROM contacts ORDER BY surname, name')->fetchAll();
	}

	$stmt = db()->prepare('SELECT * FROM contacts WHERE id = ?');
	$stmt->execute([$id]);
	$row = $stmt->fetch();

	return editLinks($people, $id) . editForm($row, $id);
}

function editLinks($people, $currentId)
{
	$html = '<div class="div-edit">';
	foreach ($people as $person) {
		$class = '';
		if ($person['id'] == $currentId) {
			$class = ' class="currentRow"';
		}
		$html .= '<a' . $class . ' href="index.php?page=edit&id=' . $person['id'] . '">'
			. html($person['name'] . ' ' . $person['surname'])
			. '</a>';
	}
	$html .= '</div>';

	return $html;
}

function editForm($row, $id)
{
	$male = $row['gender'] == 'мужской' ? ' selected' : '';
	$female = $row['gender'] == 'женский' ? ' selected' : '';

	return '<form name="form_edit" method="post" action="index.php?page=edit&id=' . $id . '">
		<div class="column">
			<input type="hidden" name="id" value="' . $id . '">
			<div class="add">
				<label>Фамилия</label>
				<input type="text" name="surname" placeholder="Фамилия" value="' . html($row['surname']) . '">
			</div>
			<div class="add">
				<label>Имя</label>
				<input type="text" name="name" placeholder="Имя" value="' . html($row['name']) . '">
			</div>
			<div class="add">
				<label>Отчество</label>
				<input type="text" name="lastname" placeholder="Отчество" value="' . html($row['lastname']) . '">
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
				<input type="date" name="date" value="' . html($row['date']) . '">
			</div>
			<div class="add">
				<label>Телефон</label>
				<input type="text" name="phone" placeholder="Телефон" value="' . html($row['phone']) . '">
			</div>
			<div class="add">
				<label>Адрес</label>
				<input type="text" name="location" placeholder="Адрес" value="' . html($row['location']) . '">
			</div>
			<div class="add">
				<label>Email</label>
				<input type="email" name="email" placeholder="Email" value="' . html($row['email']) . '">
			</div>
			<div class="add">
				<label>Комментарий</label>
				<textarea name="comment" placeholder="Краткий комментарий">' . html($row['comment']) . '</textarea>
			</div>
			<button type="submit" name="button" class="form-btn" value="Сохранить">Сохранить</button>
		</div>
	</form>';
}
