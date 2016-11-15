-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 15 2016 г., 23:07
-- Версия сервера: 5.7.15-9-beget-log
-- Версия PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kcmrumve_demo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `registration_questions`
--
-- Создание: Ноя 12 2016 г., 16:22
-- Последнее обновление: Ноя 14 2016 г., 09:31
--

DROP TABLE IF EXISTS `registration_questions`;
CREATE TABLE `registration_questions` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `registration_questions`
--

INSERT INTO `registration_questions` (`id`, `text`) VALUES
(1, 'Дата твоего двадцатого дня рождения.'),
(2, 'Девичья фамилия твоей кошки.'),
(3, 'Встроенная в PHP7 функция, от которой ты без ума.'),
(4, 'Твой первый скачанный с рутрекера фильм.'),
(5, 'Имя, которое ты дал своему гироскутеру.');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `registration_questions`
--
ALTER TABLE `registration_questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `registration_questions`
--
ALTER TABLE `registration_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
