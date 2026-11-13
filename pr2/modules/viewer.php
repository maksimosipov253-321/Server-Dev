<?php
if (!defined('APP')) {
	die('Доступ запрещен');
}

function viewer($sort, $page)
{
	$orders = [
		'id' => 'id',
		'surname' => 'surname',
		'date' => 'date',
	];

	if (!isset($orders[$sort])) {
		$sort = 'id';
	}

	$total = db()->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
	if ($total == 0) {
		return '<p>Записей нет</p>';
	}

	$pages = ceil($total / 10);
	if ($page < 1) {
		$page = 1;
	}
	if ($page > $pages) {
		$page = $pages;
	}

	$offset = ($page - 1) * 10;
	$sql = 'SELECT * FROM contacts ORDER BY ' . $orders[$sort] . ' ASC LIMIT 10 OFFSET ' . (int) $offset;
	$rows = db()->query($sql);

	$html = '<table><tr>
		<th>Фамилия</th>
		<th>Имя</th>
		<th>Отчество</th>
		<th>Пол</th>
		<th>Дата рождения</th>
		<th>Телефон</th>
		<th>Адрес</th>
		<th>Email</th>
		<th>Комментарий</th>
	</tr>';

	foreach ($rows as $row) {
		$date = $row['date'];
		$parts = explode('-', $date);
		if (count($parts) == 3) {
			$date = $parts[2] . '.' . $parts[1] . '.' . $parts[0];
		}

		$html .= '<tr>';
		$html .= '<td>' . html($row['surname']) . '</td>';
		$html .= '<td>' . html($row['name']) . '</td>';
		$html .= '<td>' . html($row['lastname']) . '</td>';
		$html .= '<td>' . html($row['gender']) . '</td>';
		$html .= '<td>' . html($date) . '</td>';
		$html .= '<td>' . html($row['phone']) . '</td>';
		$html .= '<td>' . html($row['location']) . '</td>';
		$html .= '<td>' . html($row['email']) . '</td>';
		$html .= '<td>' . html($row['comment']) . '</td>';
		$html .= '</tr>';
	}
	$html .= '</table>';

	if ($total > 10) {
		$html .= '<p class="pagination">';
		for ($i = 1; $i <= $pages; $i++) {
			if ($i == $page) {
				$html .= '<span>' . $i . '</span>';
			} else {
				$html .= '<a href="index.php?page=view&sort=' . $sort . '&p=' . $i . '">' . $i . '</a>';
			}
		}
		$html .= '</p>';
	}

	return $html;
}
