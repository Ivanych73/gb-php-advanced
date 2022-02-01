-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 25 2022 г., 16:49
-- Версия сервера: 5.7.33
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gallery`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `uuid` varchar(23) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `good_id`, `quantity`, `user_id`, `order_id`, `uuid`) VALUES
(23, 9, 3, 9, 10, NULL),
(25, 8, 2, 9, 10, NULL),
(26, 3, 1, 9, 10, NULL),
(27, 1, 1, 10, 11, NULL),
(28, 5, 2, 10, 11, NULL),
(29, 7, 3, 10, 11, NULL),
(30, 10, 1, 10, 12, NULL),
(31, 3, 1, 10, 12, NULL),
(32, 8, 1, 10, 12, NULL),
(33, 3, 1, 11, 13, NULL),
(34, 7, 1, 11, 13, NULL),
(35, 11, 1, 11, 13, NULL),
(36, 12, 1, 11, 13, NULL),
(39, 3, 1, 10, 14, NULL),
(40, 5, 1, 10, 14, NULL),
(41, 9, 1, 10, 15, NULL),
(42, 7, 1, 10, 15, NULL),
(43, 8, 2, 10, 15, NULL),
(44, 1, 1, 11, 16, NULL),
(45, 7, 1, 11, 16, NULL),
(46, 10, 1, 11, 16, NULL),
(48, 1, 1, 10, 17, NULL),
(49, 9, 1, 10, 17, NULL),
(50, 8, 1, 13, 18, NULL),
(51, 12, 3, 13, 18, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `catalog`
--

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `title` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `catalog`
--

INSERT INTO `catalog` (`id`, `title`, `price`, `description`) VALUES
(1, 'Два толстых котика', 55, 'Два толстых котика удивленно глядят из дверного проема'),
(3, 'Наглый котик \"коровка\"', 48, 'Наглый котик расцветки \"коровка\" оперся передними лапами о другого черного котика'),
(5, 'Толстый полосатый котик', 39, 'Толстый полосатый котик просто зевает'),
(7, 'Рыжий котик', 41, 'Рыжий котик умильно спит'),
(8, 'Два белых котика', 62, 'Два белых котика вылизывают друг дружку.'),
(9, 'Бело-рыжий котенок', 49, 'Бело-рыжий котенок очень серьезно смотрит на Вас'),
(10, 'Британцы в шапочках', 58, 'Два британских котика в смешных шапочках сидят на диване с очень важным видом'),
(11, 'Толстый белый', 42, 'Толстый белый котик, в шапочке, как корона 18 века, сидит враскоряку'),
(12, 'Двое на подоконнике', 82, 'Серый и рыжий котики летним днем наблюдают за чем-то с подоконника');

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `title` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pathbig` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pathsmall` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sizebig` int(11) DEFAULT NULL,
  `sizesmall` int(11) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `good_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `title`, `pathbig`, `pathsmall`, `sizebig`, `sizesmall`, `clicks`, `good_id`) VALUES
(17, '1.jpg', 'img\\big', 'img\\small', 60038, 7930, 51, 1),
(18, '2.jpg', 'img\\big', 'img\\small', 12271, 5568, 9, 3),
(19, '3.jpg', 'img\\big', 'img\\small', 249808, 10706, 20, 5),
(20, '4.jpg', 'img\\big', 'img\\small', 60857, 10830, 19, 7),
(21, '5.jpg', 'img\\big', 'img\\small', 137251, 6901, 8, 8),
(22, '6.jpg', 'img\\big', 'img\\small', 62514, 4433, 8, 9),
(23, '7.jpg', 'img\\big', 'img\\small', 85655, 8818, 14, 10),
(24, '8.jpg', 'img\\big', 'img\\small', 53399, 8685, 5, 11),
(25, '9.jpg', 'img\\big', 'img\\small', 68505, 12133, 6, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_price` int(64) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status_id`, `date`, `total_price`, `name`, `email`, `phone`, `address`, `comments`) VALUES
(10, 9, 1, '2021-12-12', 319, 'Заказчик 1', '1@1.ru', '71234567890', '1001 Rose Bowl Dr, Pasadena, CA 91103, Соединенные Штаты', ''),
(11, 10, 5, '2021-12-12', 256, 'Заказчик 2', '2@2.ru', '80987654321', '1200 East California Boulevard Pasadena, California 91125', ''),
(12, 10, 6, '2021-12-12', 168, 'Заказчик 2', '2@2.ru', '80987654321', '1200 East California Boulevard Pasadena, California 91125', ''),
(13, 11, 3, '2021-12-13', 213, 'Заказчик 3', '3@3.ru', '81231231212', '45 Rockefeller Plaza, New York, NY 10111, Соединенные Штаты', ''),
(14, 10, 5, '2022-01-24', 87, 'Заказчик 2', '2@2.ru', '80987654321', '1200 East California Boulevard Pasadena, California 91125', ''),
(15, 10, 5, '2022-01-24', 214, 'Заказчик 2', '2@2.ru', '80987654321', '1200 East California Boulevard Pasadena, California 91125', ''),
(16, 11, 1, '2022-01-24', 154, 'Заказчик 3', '3@3.ru', '81231231212', '45 Rockefeller Plaza, New York, NY 10111, Соединенные Штаты', ''),
(17, 10, 5, '2022-01-25', 104, 'Заказчик 2', '2222@2.ru', '80987654321', '1200 East California Boulevard Pasadena, California 91125', ''),
(18, 13, 5, '2022-01-25', 308, 'Заказчик 4', '4@4.ru', '89114567890', 'Лос-Анджелес, Калифорния 90027, Соединенные Штаты', '');

-- --------------------------------------------------------

--
-- Структура таблицы `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` int(11) NOT NULL,
  `status` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `status`) VALUES
(1, 'Принят в работу'),
(2, 'Обрабатывается'),
(3, 'Передан службе доставки'),
(4, 'Успешно завершен'),
(5, 'Отменен клиентом'),
(6, 'Отменен магазином');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  `reviewer` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `good_id`, `reviewer`, `text`) VALUES
(4, 1, 'Автор №1', 'Текст первого автора'),
(5, 9, 'Автор №2', 'Текст Текст текст текст'),
(6, 9, 'Автор №3', 'Это отзыв на бело-рыжего котенка'),
(7, 10, 'Автор 10', 'Отзыв автора 10'),
(8, 10, 'Автор 11', 'Отзыв автора 11'),
(9, 5, 'Автор 11', 'Отзыва автора 11'),
(10, 5, 'Автор 12', 'Отзыв автора 12'),
(11, 5, 'автор 13', 'отзыв'),
(12, 1, 'Автор 14', 'Отзыв');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_customer` tinyint(1) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `salt` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `is_customer`, `is_admin`, `salt`, `name`, `phone`, `email`, `address`) VALUES
(9, 'admin1', '02dd87039afaf7124ca9c14e5766a9be', 1, 1, '0GrViTNuNtwvDAT6S6gKJB5PP5CEFDHM6GaD2IIfSGm0nOJ3AuyeJ8UJ59mKMe3', 'Заказчик 1', '71234567890', '1@1.ru', '1001 Rose Bowl Dr, Pasadena, CA 91103, Соединенные Штаты'),
(10, 'user1', 'bdd5a6e01c9d74e0b7f4fb31861d1359', 1, 0, 'KSddjD77QYXY4YLWE5wCJBGbjX6PyvPZwIi02cMvQUctEYi6GZju3X1Q2E9hfYk', 'Заказчик 2', '80987654322', '22@2.ru', '1200 East California Boulevard Pasadena, California 91125'),
(11, 'user2', 'a5c3b9e4deea8f3ade6fb538e335c151', 1, 0, 'odEmuAlgRJb3MTzIyED4my7vWAqZlQl7zDpPYvST8GguQgzEJVDLdqN028VFaLz', 'Заказчик 3', '81231231212', '3@3.ru', '45 Rockefeller Plaza, New York, NY 10111, Соединенные Штаты'),
(13, 'user3', '96834bd51e68daddb54814526e9c9aec', 1, 0, 'Xk3H4umG48LDtlFjogkAkFljfuS9J40vW5a6pFeNHqEEL6J7YIPxwEUGx5JQ8oq', 'Заказчик 4', '89114567890', '4@4.ru', 'Лос-Анджелес, Калифорния 90027, Соединенные Штаты');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `good_id` (`good_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `good_id` (`good_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Индексы таблицы `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `good_id` (`good_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`good_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`good_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `order_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`good_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
