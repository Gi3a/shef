-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 16 2018 г., 16:58
-- Версия сервера: 5.7.19
-- Версия PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shef`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(150) NOT NULL,
  `code` varchar(50) NOT NULL,
  `photo` tinyint(4) NOT NULL,
  `city` varchar(80) NOT NULL,
  `views` int(11) NOT NULL,
  `date` timestamp NOT NULL,
  `date_end` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` mediumint(9) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `email`, `name`, `phone`, `password`, `role`) VALUES
(1, 'giza@mail.ru', 'Giza', '87015146442', '$2y$10$oNOocNDV9ocGZQ5C4QkcqubXPLV/1EUytSdMU3IF86Ofr5cVpZKoK', 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` mediumint(9) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(7, 'bakery'),
(1, 'breakfast'),
(6, 'dessert'),
(5, 'drink'),
(8, 'salad'),
(4, 'sauce'),
(2, 'snack'),
(3, 'soup');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `offer` int(11) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `email`, `offer`, `description`, `date`) VALUES
(1, 'giza_uteev@mail.ru', 30, 'sad', '2018-07-15 11:01:00');

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` mediumint(9) NOT NULL,
  `type` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `type`, `email`, `title`, `description`, `date`) VALUES
(4, 'profile', 'giza@mail.ru', 'asd', 'sad', '2018-06-05 08:28:00');

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `offer` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL,
  `offer` int(11) DEFAULT NULL,
  `route` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `email`, `description`, `date`, `offer`, `route`) VALUES
(22, 'default', 'giza_uteev@mail.ru', 'Водитель прибыл чтобы забрать заказ, выносите его', '2018-06-22 08:31:00', NULL, 1),
(28, 'success', 'giza_uteev@mail.ru', 'Ваш заказ взяли, ожидайте доставки', '2018-06-22 08:32:00', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `priority` float NOT NULL DEFAULT '1',
  `cost` mediumint(9) NOT NULL,
  `views` int(11) NOT NULL,
  `photo` tinyint(4) NOT NULL,
  `liked` int(11) NOT NULL,
  `date` timestamp NOT NULL,
  `date_end` timestamp NOT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(80) NOT NULL,
  `type` varchar(80) NOT NULL,
  `status` mediumint(9) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `offers`
--

INSERT INTO `offers` (`id`, `title`, `description`, `category`, `keywords`, `priority`, `cost`, `views`, `photo`, `liked`, `date`, `date_end`, `email`, `city`, `type`, `status`) VALUES
(24, 'Тако', 'Тако', 'bakery', 'тако, мясной,наслаждение', 1, 900, 3, 1, 0, '2018-06-29 10:19:00', '2018-07-15 13:22:00', 'giza_uteev@mail.ru', 'Актобе', 'advert', 0),
(25, 'Test Image', 'Test Image', 'salad', 'spafTest Image', 1, 1500, 22, 1, 0, '2018-07-02 10:40:00', '2018-07-09 10:40:00', 'giza_uteev@mail.ru', 'Aktobe', 'advert', 0),
(26, 'Ленин суп', 'Ленин суп', 'soup', 'суп,мясо,грибы,картошка,ленинсуп', 1, 1200, 19, 1, 0, '2018-07-05 09:05:00', '2018-07-12 09:05:00', 'lena@Mail.ru', 'Россия, Московская область, Пушкино, улица Тургенева, 13 ', 'advert', 0),
(27, 'Шашлычки', 'Шашлычки', 'snack', 'шашлык,лена,шашлычок,лук,помидоры', 1, 1500, 0, 1, 0, '2018-07-05 09:08:00', '2018-07-06 09:08:00', 'lena@Mail.ru', 'Казахстан, Актобе, улица Тургенева 67 ', 'advert', 0),
(29, 'Пицца', 'Пицца', 'bakery', 'пицца', 1, 1500, 12, 1, 0, '2018-07-08 15:54:00', '2018-07-15 15:58:00', 'giza_uteev@mail.ru', 'United States of America, Nevada, Washoe County, USA Parkway ', 'advert', 0),
(30, 'Пицца', 'Пицца', 'bakery', 'пицца', 1, 1500, 78, 1, 0, '2018-07-08 15:55:00', '2018-07-15 15:55:00', 'lawyer_tasma@mail.ru', 'United States of America, Nevada, Washoe County, USA Parkway ', 'advert', 0),
(31, 'Rice Dice', 'Rice', 'bakery', 'rice', 1, 1245, 0, 1, 0, '2018-07-08 15:57:00', '2018-07-23 11:09:00', 'giza_uteev@mail.ru', 'Казахстан, Актобе ', 'advert', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders_executor`
--

CREATE TABLE `orders_executor` (
  `id` mediumint(9) NOT NULL,
  `description` text NOT NULL,
  `cost` mediumint(9) NOT NULL,
  `route` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `offer` int(11) NOT NULL,
  `email_executor` varchar(255) NOT NULL,
  `status` varchar(80) NOT NULL,
  `date` timestamp NOT NULL,
  `date_end` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders_list`
--

CREATE TABLE `orders_list` (
  `id` mediumint(9) NOT NULL,
  `description` text NOT NULL,
  `cost` mediumint(9) NOT NULL,
  `route` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `offer` int(11) NOT NULL,
  `email_executor` varchar(255) NOT NULL,
  `date` timestamp NOT NULL,
  `date_end` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `packages`
--

CREATE TABLE `packages` (
  `id` mediumint(9) NOT NULL,
  `email` varchar(255) NOT NULL,
  `package` varchar(80) NOT NULL DEFAULT 'default',
  `offers` mediumint(9) NOT NULL,
  `date` timestamp NOT NULL,
  `date_end` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `packages`
--

INSERT INTO `packages` (`id`, `email`, `package`, `offers`, `date`, `date_end`) VALUES
(4, 'driver@mail.ru', 'default', 7, '2018-06-14 05:25:00', NULL),
(5, 'company@mail.ru', 'default', 6, '2018-06-14 05:25:00', NULL),
(6, 'giza_uteev@mail.ru', 'default', 0, '2018-06-14 05:25:00', NULL),
(7, 'lawyer_tasma@mail.ru', 'default', 7, '2018-06-14 05:25:00', NULL),
(8, 'user@Mail.ru', 'default', 7, '2018-06-18 18:59:00', NULL),
(9, 'user2@Mail.ru', 'default', 7, '2018-06-18 18:59:00', NULL),
(10, 'asdasd@mail.ru', 'default', 7, '2018-06-18 19:00:00', NULL),
(11, 'asdasd1@mail.ru', 'default', 7, '2018-06-18 19:00:00', NULL),
(12, 'asdasd2@mail.ru', 'default', 7, '2018-06-18 19:00:00', NULL),
(13, 'gas@mail.ru', 'default', 7, '2018-06-21 14:07:00', NULL),
(15, 'sad@mail.ru', 'default', 7, '2018-06-26 15:34:00', NULL),
(16, 'asd12@mail.ru', 'default', 7, '2018-06-26 15:36:00', NULL),
(21, 'lena@Mail.ru', 'default', 5, '2018-07-05 08:58:00', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `problems`
--

CREATE TABLE `problems` (
  `id` mediumint(9) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` tinyint(4) NOT NULL,
  `address` varchar(150) NOT NULL,
  `promocode` varchar(50) DEFAULT NULL,
  `pay` varchar(50) NOT NULL,
  `delivery` varchar(50) NOT NULL,
  `time_delivery` varchar(50) NOT NULL,
  `date` timestamp NOT NULL,
  `offer_email` varchar(255) NOT NULL,
  `offer_customer` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `address`, `promocode`, `pay`, `delivery`, `time_delivery`, `date`, `offer_email`, `offer_customer`, `status`) VALUES
(6, 'Россия, Московская область', NULL, 'money', 'pickup', '21:03', '2018-07-15 12:38:00', 'lawyer_tasma@mail.ru', 'giza_uteev@mail.ru', 'not sent'),
(7, 'Россия, Московская область', NULL, 'money', 'pickup', '21:03', '2018-07-16 11:11:00', 'giza_uteev@mail.ru', 'giza_uteev@mail.ru', 'not sent');

-- --------------------------------------------------------

--
-- Структура таблицы `requests_offer`
--

CREATE TABLE `requests_offer` (
  `id` tinyint(4) NOT NULL,
  `offer_request` tinyint(4) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `requests_offer`
--

INSERT INTO `requests_offer` (`id`, `offer_request`, `offer_id`, `count`, `description`) VALUES
(7, 6, 30, 213, 'asd'),
(8, 7, 29, 123, 'sad');

-- --------------------------------------------------------

--
-- Структура таблицы `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `route_from` varchar(255) NOT NULL,
  `route_to` varchar(255) NOT NULL,
  `cost` int(80) NOT NULL,
  `date` timestamp NOT NULL,
  `date_accept` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `executor_email` varchar(255) DEFAULT NULL,
  `status` varchar(80) NOT NULL,
  `view` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `routes`
--

INSERT INTO `routes` (`id`, `description`, `route_from`, `route_to`, `cost`, `date`, `date_accept`, `date_end`, `client_email`, `executor_email`, `status`, `view`) VALUES
(1, '123', 'sadasd', 'daasd', 213, '2018-06-22 08:00:00', '2018-06-22 08:00:00', '2018-06-22 10:50:00', 'giza_uteev@mail.ru', 'driver@mail.ru', 'do', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(150) NOT NULL,
  `photo` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(150) NOT NULL,
  `company` varchar(150) NOT NULL,
  `working_on` varchar(80) DEFAULT NULL,
  `working_off` varchar(80) DEFAULT NULL,
  `package` varchar(80) NOT NULL,
  `phone` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(80) NOT NULL DEFAULT 'user',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  `token` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `car` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `login`, `photo`, `name`, `company`, `working_on`, `working_off`, `package`, `phone`, `password`, `role`, `date`, `description`, `token`, `status`, `car`) VALUES
(23, 'driver@mail.ru', 'driver', 0, 'Дмитрий', 'none', NULL, NULL, 'default', '8772138812', '$2y$10$Fx8nnOabjlOOgg9GhIugAuQDt4HIIYpom/idHm5wg2PNI/FaQQe.q', 'driver', '2018-05-30 18:16:00', '', '', '1', 'BMW 745i, Black'),
(24, 'company@mail.ru', 'company', 0, 'Mack', 'ООО Mc\'donald', NULL, NULL, 'default', '8712312214123', '$2y$10$H.LpUYW7njBSFNOOFAoLxueMLIuF2ESqvm7pC3Q1JAhAwihwlxhyu', 'company', '2018-05-30 18:17:00', '', '', '1', 'none'),
(25, 'giza_uteev@mail.ru', 'Giza', 1, 'Гизат', 'none', 'Mon-02-21', 'Sun-21-03', 'default', '87475071999', '$2y$10$KJ/pUtz7zb.OCIAHya5zKeO1gkZxU2ItjDE4Xe5ONRNROPD4NTl.6', 'user', '2018-06-01 06:03:00', '', '', '1', 'none'),
(26, 'lawyer_tasma@mail.ru', 'Layla', 0, 'Ляйля', 'none', NULL, NULL, 'default', '87015146442', '$2y$10$vw65mAWndK296QAWHOnJb.CbS6Winn7fb43DKj0dpnjBU6iWvv08W', 'user', '2018-06-01 06:04:00', '', '', '1', 'none'),
(27, 'user@Mail.ru', 'user1', 0, 'user1', 'none', NULL, NULL, 'default', '65132124512', '$2y$10$vrZdojgmI/TM4QS3ODNr.u6m26QnPIg0JGNor94VP/8ydYg2bCcBq', 'user', '2018-06-18 18:59:00', '', '', '1', 'none'),
(28, 'user2@Mail.ru', 'user2', 0, 'user2', 'none', NULL, NULL, 'default', '651321245121', '$2y$10$iYIqaK6ZPN/E/VF12g8GiO0r4N9HWBwo4nUQHy3522CETjF71bulq', 'user', '2018-06-18 18:59:00', '', 'yn9dp6encq', '0', 'none'),
(29, 'asdasd@mail.ru', 'asdasdasd', 0, 'asda', 'none', NULL, NULL, 'default', '1231234', '$2y$10$w83DxbfrP6N5XShv8D2eIO5UFcRSj2aTUU758CuEyb7zNu88KZZWu', 'driver', '2018-06-18 19:00:00', '', 'mk5p91eaao', '0', 'fdad'),
(30, 'asdasd1@mail.ru', 'asdasdasd1', 0, 'asda1', 'none', NULL, NULL, 'default', '12312341', '$2y$10$kuJzQ9cDbtmyLyRjrww0NeEqlVDXsy245Zfklxo6MNgRIDrMB.6te', 'driver', '2018-06-18 19:00:00', '', 'c96slozm8f', '0', 'sad12'),
(31, 'asdasd2@mail.ru', 'asdasdasd2', 0, 'asda1', 'none', NULL, NULL, 'default', '123123414', '$2y$10$Mb.0wxQEiLWECA1vlAY2Ou0l0AG3hzfWMdh5lEYSTGwgbZ4kU9so6', 'driver', '2018-06-18 19:00:00', '', 'em71wi3nfn', '0', 'sad12'),
(32, 'gas@mail.ru', 'gas1', 0, 'gas_sag', 'none', 'Mon-00-15', 'Sat-09-00', 'default', '8771273123', '$2y$10$skj66haMlHQomzdpNi.w0u02lrU/hBgNqE9JPXjaXAEpyDn5qLs3i', 'user', '2018-06-21 14:07:00', 'Я газ', '', '1', 'none'),
(33, 'sad@mail.ru', 'sad', 0, 'asd', 'none', NULL, NULL, 'default', '5748139', '$2y$10$Lgt.G7/wmp8cPbZShvUwV.V7.0pPrcRfox5RklbfdFvGHuH4VzIIy', 'user', '2018-06-26 15:34:00', '', '8uciv6aeyo', '0', 'none'),
(34, 'asd12@mail.ru', 'asdasd', 0, '12sad21', 'none', NULL, NULL, 'default', '12312321', '$2y$10$8EMYhkDuWkpPwu/KCSQIZOh7ME0ZDOD.WET9nElvrf81R.thcKvLK', 'driver', '2018-06-26 15:36:00', '', '0mx5qrekxg', '0', '123sad'),
(39, 'lena@Mail.ru', 'lena', 0, 'Лена', 'none', NULL, NULL, 'default', '874131243', '$2y$10$ZzT56lJB66W4K3RF/hWr2.g5fml7//8FknWPStNCMD9GDADIFuZa2', 'user', '2018-07-05 08:58:00', '', '', '1', 'none');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `code` (`code`);

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `offer` (`offer`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_user` (`email`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offer_like` (`offer`),
  ADD KEY `offer_user` (`user`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_email` (`email`),
  ADD KEY `offer` (`offer`,`route`),
  ADD KEY `notifications_route` (`route`);

--
-- Индексы таблицы `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adverts_email` (`email`),
  ADD KEY `category` (`category`);

--
-- Индексы таблицы `orders_executor`
--
ALTER TABLE `orders_executor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offer_order` (`offer`),
  ADD KEY `executor_order` (`email_executor`),
  ADD KEY `user_order` (`email`);

--
-- Индексы таблицы `orders_list`
--
ALTER TABLE `orders_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_executor` (`email_executor`),
  ADD KEY `offer_id` (`offer`),
  ADD KEY `email_user` (`email`);

--
-- Индексы таблицы `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_package` (`email`);

--
-- Индексы таблицы `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offer_customer` (`offer_customer`),
  ADD KEY `offer_email` (`offer_email`),
  ADD KEY `promocode` (`promocode`);

--
-- Индексы таблицы `requests_offer`
--
ALTER TABLE `requests_offer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offer_request` (`offer_request`),
  ADD KEY `offer_id` (`offer_id`);

--
-- Индексы таблицы `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_email` (`client_email`),
  ADD KEY `executor_email` (`executor_email`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT для таблицы `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT для таблицы `orders_executor`
--
ALTER TABLE `orders_executor`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `orders_list`
--
ALTER TABLE `orders_list`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `packages`
--
ALTER TABLE `packages`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT для таблицы `problems`
--
ALTER TABLE `problems`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `requests_offer`
--
ALTER TABLE `requests_offer`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `email` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_email` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_offer` FOREIGN KEY (`offer`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `offer_like` FOREIGN KEY (`offer`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offer_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_email` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_offer` FOREIGN KEY (`offer`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_route` FOREIGN KEY (`route`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `adverts_category` FOREIGN KEY (`category`) REFERENCES `categories` (`category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adverts_email` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders_executor`
--
ALTER TABLE `orders_executor`
  ADD CONSTRAINT `executor_order` FOREIGN KEY (`email_executor`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offer_order` FOREIGN KEY (`offer`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_order` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders_list`
--
ALTER TABLE `orders_list`
  ADD CONSTRAINT `email_executor` FOREIGN KEY (`email_executor`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `email_user` FOREIGN KEY (`email`) REFERENCES `offers` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offer_id` FOREIGN KEY (`offer`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `email_package` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `offer_customer` FOREIGN KEY (`offer_customer`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offer_email` FOREIGN KEY (`offer_email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `promocode` FOREIGN KEY (`promocode`) REFERENCES `actions` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `requests_offer`
--
ALTER TABLE `requests_offer`
  ADD CONSTRAINT `offer` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offer_id_request` FOREIGN KEY (`offer_request`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `client_email` FOREIGN KEY (`client_email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `executor_email` FOREIGN KEY (`executor_email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
