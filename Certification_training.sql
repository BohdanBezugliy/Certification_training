-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Час створення: Чрв 06 2024 р., 16:50
-- Версія сервера: 5.7.39
-- Версія PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `Certification_training`
--

-- --------------------------------------------------------

--
-- Структура таблиці `Lecture`
--

CREATE TABLE `Lecture` (
  `id_lecture` int(11) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `rank` varchar(150) DEFAULT NULL,
  `password_hash` varchar(300) NOT NULL,
  `department` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `Lecture`
--

INSERT INTO `Lecture` (`id_lecture`, `full_name`, `position`, `rank`, `password_hash`, `department`) VALUES
(13, 'Ілля', 'Доцент кафедри', 'Старший лектор', '$2y$10$3DAoQsfuof9iegY8snXZ6.MbPnzoHOfwGtY6UGk09cGZLLTSQ8nka', 'Інноваційних технологій'),
(14, 'Роман', 'Декан', 'Професор', '$2y$10$S61cz.09N.QDPHXf2zkAcepJpJ5QqVEHouEjXdqj/qqE0n24.1L02', 'Фінансовий'),
(15, 'Андрій', 'Викладач', 'Доцент', '$2y$10$kws2bUnrDfUykxrE.eHlGeBrcuqGKTaJFq3H/xGXSSOhJUY.IyhVu', 'Менеджмент'),
(16, 'Іван ', 'Викладач', NULL, '$2y$10$01tdtVGe93x0xARmtuvH.eY/zjcDNqKlMmdMhe2YOgeT2wTDUQ7Zq', 'Інноваційні технології'),
(17, 'Іван', 'Декан', 'Лектор', '$2y$10$Yv5Aq6mzGyFnzmaTmHk0i.vuDrCPK.PQxuAOYXk64Y6Nv/JIgzHbq', 'Інноваційних технологій'),
(18, 'Іванов Іван Іванович', 'Завідувач кафедри', 'Старший лектор', '$2y$10$yURr15zf5bXqQD9jifpVJ.EyVw0hs0g6ogqQjMBA6fh/QVy79LI.y', 'Фінансовий'),
(19, 'Романов Роман Романович', 'Декан', 'Старший лектор', '$2y$10$svhIJkOQCxOS.CbdBKAI4eUOEPMJm.ET7cZIREqTX5/PmAxYj1i1G', 'Інноваційних технологій');

-- --------------------------------------------------------

--
-- Структура таблиці `training`
--

CREATE TABLE `training` (
  `ct_id` int(11) NOT NULL,
  `id_lecture` int(11) NOT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `link_to_doc` text,
  `topic` varchar(255) DEFAULT NULL,
  `credit_hours` int(11) DEFAULT NULL,
  `date_begin` date DEFAULT NULL,
  `date_end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `training`
--

INSERT INTO `training` (`ct_id`, `id_lecture`, `institution`, `document_type`, `link_to_doc`, `topic`, `credit_hours`, `date_begin`, `date_end`) VALUES
(1, 17, '1', 'gdagdg', NULL, 'gdsagds', 12, '2024-05-02', '2024-05-17'),
(4, 13, 'hfgds', 'hgfds', NULL, 'gfeds', 23, '2024-05-01', '2024-05-18'),
(7, 13, 'dsbgzsdb', 'апврот', NULL, 'авр', 23, '2024-05-11', '2024-05-17'),
(8, 13, 'bfdcxhn', 'nbgvcmn', NULL, 'nbvcxfn', 23, '2024-05-01', '2024-05-18'),
(9, 13, 'gfdsgh', 'bfdsb', NULL, 'bfds', 23, '2024-05-09', '2024-05-11'),
(10, 13, 'bfdsb', 'bfndsn', NULL, 'ngdsn', 23, '2024-05-09', '2024-05-25'),
(12, 13, 'fgdsg', 'fgdsag', NULL, 'gdfsag', 564, '2024-05-01', '2024-05-10'),
(13, 13, 'gfsadg', 'gfdsag', NULL, 'hfdasgh', 23, '2024-05-01', '2024-05-11'),
(14, 13, 'dsag', 'gdsag', NULL, 'GDSAG', 45, '2024-05-02', '2024-05-19'),
(15, 13, 'оиршоди', 'лдьтжл', NULL, 'шощхдзш', 23, '2024-05-01', '2024-05-02'),
(16, 18, 'Національний університет \"Київська політехніка\"', 'Сертифікат', 'https://gemini.google.com/u/0/app/e746524d2d4cabe1', 'Курс підвищення кваліфікації \"Сучасні методи програмування на С#\"', 12, '2024-06-06', '2024-06-10'),
(17, 18, 'Дніпровський національний університет імені Олеся Гончара', 'Запис для події', 'cdsvdfb', 'Семінар \"Актуальні питання бухгалтерського обліку та оподаткування\"', 9, '2024-05-22', '2024-05-25'),
(18, 18, 'Національний юридичний університет імені Ярослава Мудрого', 'Сертифікат', 'egfdg', 'Цивільне право', 12, '2024-05-01', '2024-05-31'),
(19, 18, 'Київський національний університет імені Тараса Шевченка', 'Диплом про другу вищу освіту', NULL, 'Маркетинг', 2, '2020-09-01', '2022-06-30'),
(20, 18, 'Харківський національний університет імені В.Н. Каразіна', 'Свідоцтво про закінчення курсів', NULL, 'Бухгалтерський облік', 0, '2023-02-15', '2023-03-31'),
(21, 18, 'Дніпровський національний університет імені О. Гончара', 'Сертифікат', NULL, 'Менеджмент', 1, '2022-10-10', '2022-12-20'),
(22, 18, 'Запорізький національний університет', 'Диплом про другу вищу освіту', NULL, 'Інформаційні технології', 2, '2018-09-01', '2020-06-30'),
(23, 18, 'Київський національний економічний університет імені Вадима Гетьмана', 'Свідоцтво про закінчення курсів', NULL, 'Фінанси', 0, '2021-03-01', '2021-04-20'),
(24, 18, 'Національний технічний університет Харківський політехнічний інститут', 'Сертифікат', NULL, 'Охорона праці', 1, '2020-11-15', '2020-12-31'),
(25, 18, 'Донецький національний університет', 'Диплом про другу вищу освіту', NULL, 'Державне управління', 2, '2019-09-01', '2021-06-30'),
(26, 18, 'Львівський національний університет імені Івана Франка', 'Свідоцтво про закінчення курсів', NULL, 'Логістика', 0, '2022-05-05', '2022-06-15'),
(27, 18, 'Одеський національний університет імені І.І. Мечникова', 'Сертифікат', NULL, 'Міжнародне право', 1, '2023-01-20', '2023-03-08'),
(28, 18, 'Київський університет імені Бориса Грінченка', 'Диплом про другу вищу освіту', NULL, 'Педагогіка', 2, '2017-09-01', '2019-06-30'),
(29, 18, 'Національний університет Київська політехніка\" імені Ігоря Сікорського', 'Свідоцтво про закінчення курсів', NULL, 'Програмування', 0, '2021-11-11', '2021-12-24'),
(30, 18, 'Сумський державний університет', 'Сертифікат', NULL, 'Туризм', 1, '2022-04-04', '2022-05-25'),
(31, 18, 'Тернопільський національний економічний університет', 'Свідоцтво про закінчення курсів', NULL, 'Економіка', 0, '2024-01-10', '2024-02-19'),
(32, 18, 'Одеська національна юридична академія', 'Сертифікат', NULL, 'Кримінальне право', 1, '2023-09-12', '2023-11-10'),
(33, 18, 'Дніпровська державна медична академія', 'Диплом про другу вищу освіту', NULL, 'Медицина', 2, '2015-09-01', '2019-06-30'),
(34, 18, 'Ужгородський національний університет', 'Свідоцтво про закінчення курсів', 'https://gemini.google.com/app/6dc2f55c95356b54?hl=uk', 'Іноземні мови', 12, '2020-02-02', '2020-03-20'),
(35, 18, 'Луганський національний університет імені Тараса Шевченка', 'Сертифікат', NULL, 'Психологія', 1, '2021-06-21', '2021-08-09'),
(36, 18, 'Полтавська державна аграрна академія', 'Диплом про другу вищу освіту', 'https://gemini.google.com/app/6dc2f55c95356b54?hl=uk', 'Аграрний менеджмент', 2, '2014-09-01', '2017-06-30');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `Lecture`
--
ALTER TABLE `Lecture`
  ADD PRIMARY KEY (`id_lecture`),
  ADD UNIQUE KEY `password_hash` (`password_hash`);

--
-- Індекси таблиці `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`ct_id`),
  ADD KEY `id_lecture` (`id_lecture`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `Lecture`
--
ALTER TABLE `Lecture`
  MODIFY `id_lecture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблиці `training`
--
ALTER TABLE `training`
  MODIFY `ct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `training`
--
ALTER TABLE `training`
  ADD CONSTRAINT `training_ibfk_1` FOREIGN KEY (`id_lecture`) REFERENCES `Lecture` (`id_lecture`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
