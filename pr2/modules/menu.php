<?php
if (!defined('APP')) {
	die('Доступ запрещен');
}

function menu()
{
	$page = 'view';
	if (isset($_GET['page']) && in_array($_GET['page'], ['view', 'add', 'edit', 'delete'])) {
		$page = $_GET['page'];
	}

	$items = [
		'view' => 'Просмотр',
		'add' => 'Добавление записи',
		'edit' => 'Редактирование записи',
		'delete' => 'Удаление записи',
	];

	$html = '<header><nav class="menu">';
	foreach ($items as $key => $title) {
		$class = '';
		if ($key == $page) {
			$class = ' class="active"';
		}
		$html .= '<a' . $class . ' href="index.php?page=' . $key . '">' . $title . '</a>';
	}
	$html .= '</nav></header>';

	if ($page == 'view') {
		$sort = 'id';
		if (isset($_GET['sort']) && in_array($_GET['sort'], ['id', 'surname', 'date'])) {
			$sort = $_GET['sort'];
		}

		$sorts = [
			'id' => 'По добавлению',
			'surname' => 'По фамилии',
			'date' => 'По дате рождения',
		];

		$html .= '<div class="submenu">';
		foreach ($sorts as $key => $title) {
			$class = '';
			if ($key == $sort) {
				$class = ' class="active"';
			}
			$html .= '<a' . $class . ' href="index.php?page=view&sort=' . $key . '">' . $title . '</a>';
		}
		$html .= '</div>';
	}

	return $html;
}
