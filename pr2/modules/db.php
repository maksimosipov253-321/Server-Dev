<?php
if (!defined('APP')) {
	die('Доступ запрещен');
}

function db()
{
	global $db;

	if (!$db) {
		$db = new PDO('sqlite:' . __DIR__ . '/../data/notebook.sqlite');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$db->exec(
			'CREATE TABLE IF NOT EXISTS contacts (
				id INTEGER PRIMARY KEY AUTOINCREMENT,
				surname TEXT NOT NULL,
				name TEXT NOT NULL,
				lastname TEXT NOT NULL DEFAULT "",
				gender TEXT NOT NULL DEFAULT "",
				date TEXT NOT NULL DEFAULT "",
				phone TEXT NOT NULL DEFAULT "",
				location TEXT NOT NULL DEFAULT "",
				email TEXT NOT NULL DEFAULT "",
				comment TEXT NOT NULL DEFAULT ""
			)'
		);
		addStartContacts($db);
	}

	return $db;
}

function html($text)
{
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function addStartContacts($db)
{
	$count = $db->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
	if ($count > 0) {
		return;
	}

	$rows = [
		['Смирнов', 'Алексей', 'Петрович', 'мужской', '1998-03-12', '89001110001', 'Москва, ул. Лесная, 3', 'smirnov@mail.ru', 'Одногруппник'],
		['Иванова', 'Мария', 'Сергеевна', 'женский', '2002-07-01', '89001110002', 'Москва, ул. Садовая, 8', 'ivanova@mail.ru', 'Староста'],
		['Кузнецов', 'Иван', 'Андреевич', 'мужской', '1995-11-23', '89001110003', 'Химки, ул. Мира, 14', 'kuznetsov@mail.ru', ''],
		['Попова', 'Анна', 'Игоревна', 'женский', '2000-01-30', '89001110004', 'Москва, пр. Мира, 20', 'popova@mail.ru', 'Проект'],
		['Соколов', 'Дмитрий', 'Олегович', 'мужской', '1992-05-14', '89001110005', 'Мытищи, ул. Юбилейная, 5', 'sokolov@mail.ru', ''],
		['Лебедева', 'Елена', 'Викторовна', 'женский', '1988-09-09', '89001110006', 'Москва, ул. Тверская, 11', 'lebedeva@mail.ru', 'Преподаватель'],
		['Новиков', 'Павел', 'Николаевич', 'мужской', '2001-12-19', '89001110007', 'Королев, ул. Гагарина, 2', 'novikov@mail.ru', ''],
		['Морозова', 'Ольга', 'Дмитриевна', 'женский', '1999-04-04', '89001110008', 'Москва, ул. Арбат, 17', 'morozova@mail.ru', ''],
		['Волков', 'Артем', 'Ильич', 'мужской', '1996-08-27', '89001110009', 'Зеленоград, корп. 4', 'volkov@mail.ru', 'Секция'],
		['Зайцева', 'Ирина', 'Павловна', 'женский', '2003-02-11', '89001110010', 'Москва, ул. Покровка, 9', 'zaytseva@mail.ru', ''],
		['Петров', 'Сергей', 'Алексеевич', 'мужской', '1990-06-06', '89001110011', 'Москва, Ленинский пр., 25', 'petrov@mail.ru', 'Работа'],
		['Васильева', 'Наталья', 'Юрьевна', 'женский', '1985-10-18', '89001110012', 'Подольск, ул. Кирова, 6', 'vasileva@mail.ru', ''],
		['Орлов', 'Кирилл', 'Максимович', 'мужской', '2004-03-03', '89001110013', 'Москва, ул. Вавилова, 12', 'orlov@mail.ru', ''],
		['Егорова', 'Дарья', 'Романовна', 'женский', '1997-07-21', '89001110014', 'Люберцы, ул. Смирновская, 1', 'egorova@mail.ru', 'Практика'],
		['Федоров', 'Никита', 'Валерьевич', 'мужской', '1993-01-08', '89001110015', 'Москва, ул. Профсоюзная, 30', 'fedorov@mail.ru', ''],
	];

	$stmt = $db->prepare(
		'INSERT INTO contacts (surname, name, lastname, gender, date, phone, location, email, comment)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
	);

	foreach ($rows as $row) {
		$stmt->execute($row);
	}
}
