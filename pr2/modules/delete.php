<?php
if (!defined('APP')) {
	die('Доступ запрещен');
}

function deletePage()
{
	$message = '';
	$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

	if ($id > 0) {
		$stmt = db()->prepare('SELECT surname, name, lastname FROM contacts WHERE id = ?');
		$stmt->execute([$id]);
		$row = $stmt->fetch();

		if ($row) {
			$delete = db()->prepare('DELETE FROM contacts WHERE id = ?');
			$delete->execute([$id]);
			$message = '<p class="deleted">Запись с фамилией ' . html($row['surname']) . ' удалена</p>';
		}
	}

	$people = db()->query('SELECT id, surname, name, lastname FROM contacts ORDER BY surname, name')->fetchAll();
	if (!$people) {
		return $message . '<p>Записей нет</p>';
	}

	$html = $message . '<div class="record-list">';
	foreach ($people as $person) {
		$initials = substr($person['name'], 0, 2) . '.';
		if ($person['lastname'] != '') {
			$initials .= substr($person['lastname'], 0, 2) . '.';
		}
		$html .= '<a href="index.php?page=delete&id=' . $person['id'] . '">'
			. html($person['surname'] . ' ' . $initials)
			. '</a>';
	}
	$html .= '</div>';

	return $html;
}
