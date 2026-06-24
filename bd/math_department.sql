-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 24 2026 г., 23:49
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `math_department`
--

-- --------------------------------------------------------

--
-- Структура таблицы `announcements`
--

CREATE TABLE `announcements` (
  `id` int NOT NULL,
  `title` varchar(200) NOT NULL,
  `excerpt` varchar(300) NOT NULL,
  `body` text NOT NULL,
  `category_id` int NOT NULL,
  `author_id` int NOT NULL,
  `views` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `excerpt`, `body`, `category_id`, `author_id`, `views`, `created_at`, `updated_at`) VALUES
(1, 'Итоги студенческой олимпиады по математическому анализу', 'Поздравляем победителей! Региональный этап завершён.', 'Уважаемые студенты и преподаватели! На прошлой неделе на базе факультета математики и компьютерных наук прошел региональный этап ежегодной студенческой олимпиады по дисциплине «Математический анализ». В соревновании приняли участие более 40 студентов со всего Северо-Кавказского федерального округа. Рады сообщить, что студенты 3 курса нашей кафедры продемонстрировали выдающиеся результаты и заняли весь пьедестал почета в личном зачете. Список победителей: 1 место — Цаллагов Алан (3 курс, группа М-31); 2 место — Плиева Мадина (3 курс, группа М-32); 3 место — Дзуцев Георгий (3 курс, группа М-31). Поздравляем ребят с заслуженной победой!', 1, 6, 142, '2026-06-24 19:06:23', '2026-06-24 19:06:23'),
(2, 'Открытый семинар «Современные методы топологии»', 'Приглашаются все желающие. Докладчик – профессор из МГУ.', 'Кафедра математики приглашает студентов, аспирантов и преподавателей на открытый научный семинар «Современные методы топологии», который состоится 15 июля в 14:00 в аудитории 305. Докладчик – профессор МГУ им. Ломоносова, доктор физико-математических наук Смирнов А.А. Вход свободный.', 2, 7, 101, '2026-06-24 19:06:23', '2026-06-24 19:58:43'),
(3, 'График пересдач по дифференциальным уравнениям', 'Утверждены даты пересдач для студентов 2-го курса.', 'Уважаемые студенты! Утверждён график ликвидации академических задолженностей по дисциплине «Дифференциальные уравнения». Пересдачи пройдут с 20 по 25 июня. Расписание для каждой группы вывешено на стенде кафедры и в личных кабинетах. Явка строго обязательна.', 3, 8, 310, '2026-06-24 19:06:23', '2026-06-24 19:06:23'),
(4, 'Конкурс научных работ для студентов', 'Приём заявок до 1 сентября. Победители получат гранты.', 'Кафедра математики объявляет конкурс научных работ среди студентов всех курсов. Номинации: «Лучшая научная статья», «Лучший стендовый доклад», «Лучшее прикладное исследование». Победители получат денежные премии и гранты на участие в конференциях. Подробности на сайте кафедры.', 1, 9, 86, '2026-06-24 19:06:23', '2026-06-24 20:11:29'),
(5, 'Встреча с выпускниками кафедры', 'Карьерный форум с успешными выпускниками СОГУ.', 'Приглашаем студентов всех курсов на ежегодную встречу с выпускниками нашей кафедры, которые сегодня работают в ведущих IT-компаниях, научных центрах и преподают в вузах. Мероприятие пройдёт 10 июля в актовом зале. Начало в 16:00. Приходите, будет полезно!', 2, 6, 120, '2026-06-24 19:06:23', '2026-06-24 19:06:23');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `color_class` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `color_class`) VALUES
(1, 'Новости', 'news', 'badge-news'),
(2, 'Мероприятия', 'events', 'badge-event'),
(3, 'Объявления', 'info', 'badge-info');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `announcement_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `announcement_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 1, 'Отличная новость! Поздравляю всех участников.', '2026-06-24 19:06:23'),
(2, 1, 2, 'А когда будут награждения?', '2026-06-24 19:06:23'),
(3, 1, 6, 'Спасибо за тёплые слова. Награждение состоится в пятницу в 14:00.', '2026-06-24 19:06:23'),
(4, 2, 3, 'Обязательно приду! Тема очень интересная.', '2026-06-24 19:06:23'),
(5, 2, 7, 'Докладчик — мой научный руководитель, буду рада видеть всех коллег.', '2026-06-24 19:06:23'),
(6, 3, 5, 'А для группы М-41 когда пересдача?', '2026-06-24 19:06:23'),
(7, 3, 8, 'Для М-41 — 22 июня в 10:00.', '2026-06-24 19:06:23'),
(8, 4, 4, 'А можно подать работу в соавторстве?', '2026-06-24 19:06:23'),
(9, 4, 9, 'Да, соавторство допускается до трёх человек.', '2026-06-24 19:06:23'),
(10, 5, 2, 'Отличная возможность! Буду.', '2026-06-24 19:06:23'),
(11, 5, 6, 'Ждём всех студентов! Будет много полезной информации.', '2026-06-24 19:06:23');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') DEFAULT 'student',
  `group` varchar(20) DEFAULT NULL,
  `status` enum('active','blocked') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `group`, `status`, `created_at`) VALUES
(1, 'Алексей Петров', 'alex@nosu.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'М-31', 'active', '2026-06-24 19:06:23'),
(2, 'Мария Смирнова', 'maria@nosu.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'М-32', 'active', '2026-06-24 19:06:23'),
(3, 'Игорь Козлов', 'igor@nosu.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'ПМ-21', 'active', '2026-06-24 19:06:23'),
(4, 'Елена Васильева', 'elena@nosu.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'КН-11', 'active', '2026-06-24 19:06:23'),
(5, 'Дмитрий Иванов', 'dima@nosu.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'М-41', 'active', '2026-06-24 19:06:23'),
(6, 'Профессор Сергей Николаев', 'prof.nikolaev@nosu.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, 'active', '2026-06-24 19:06:23'),
(7, 'Доцент Анна Викторовна', 'anna.viktorovna@nosu.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, 'active', '2026-06-24 19:06:23'),
(8, 'Старший преподаватель Олег Михайлович', 'oleg.mih@nosu.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NULL, 'active', '2026-06-24 19:06:23'),
(9, 'Главный администратор', 'admin@nosu.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, 'active', '2026-06-24 19:06:23');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id` (`announcement_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
