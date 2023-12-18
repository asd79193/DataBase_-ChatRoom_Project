-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-12-18 20:20:55
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `chatroom`
--

-- --------------------------------------------------------

--
-- 資料表結構 `dialogue`
--

CREATE TABLE `dialogue` (
  `user_id` int(11) NOT NULL,
  `message` varchar(10000) NOT NULL,
  `time` varchar(32) NOT NULL,
  `IP` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `dialogue`
--

INSERT INTO `dialogue` (`user_id`, `message`, `time`, `IP`) VALUES
(64, '小舟從此逝 滄海寄餘生', '2023-12-03 01:14:55', ''),
(65, '一念心清淨，蓮花處處開', '2023-12-03 01:15:06', ''),
(64, '既是故人，便讓他留在故事裡', '2023-12-03 01:15:34', ''),
(65, '不愛一個人了，也不是需要自責的事情', '2023-12-03 01:15:43', ''),
(64, '這個做人呢，不能總活在別人的期望裡', '2023-12-03 01:15:50', ''),
(65, '人無完人，本當如此。站在光芒底下，怎麼可能没有陰影呢', '2023-12-03 01:15:56', ''),
(64, '信神拜佛的人常說善惡有報，可若真想伸冤，靠的卻都是人', '2023-12-03 01:16:05', ''),
(65, '有時候最簡單的答案，往往才是最正確的答案', '2023-12-03 01:16:13', ''),
(64, '心中有風雨波濤，你就會失去一滴水的智慧，遇事反倒不如回頭想想，那一滴水中的乾坤', '2023-12-03 01:16:21', ''),
(65, '有些人棄劍如遺，有些人終身不負，人的信念總是有所不同', '2023-12-03 01:16:34', ''),
(64, '小舟從此逝 滄海寄餘生', '2023-12-03 01:16:41', ''),
(63, '???', '2023-12-03 13:41:24', ''),
(62, '1233211234567', '2023-12-04 10:23:13', ''),
(63, '早安', '2023-12-05 09:16:41', ''),
(62, '晚安', '2023-12-05 09:16:44', ''),
(64, '好', '2023-12-05 09:19:37', ''),
(65, '早安', '2023-12-05 10:07:15', ''),
(62, '午安', '2023-12-05 10:07:20', ''),
(65, '早安 午安', '2023-12-05 10:35:53', ''),
(64, '你好', '2023-12-05 10:35:58', ''),
(62, 'emo', '2023-12-05 10:36:43', ''),
(63, '好', '2023-12-05 20:31:26', ''),
(62, '早', '2023-12-06 23:53:34', ''),
(62, '早安安安', '2023-12-07 00:00:04', '127.0.0.1'),
(62, '想睡了', '2023-12-07 01:02:17', '127.0.0.1'),
(62, '媽呀 我完成了', '2023-12-07 01:02:24', '127.0.0.1'),
(63, '我期待的不是雪', '2023-12-17 22:45:43', '127.0.0.1'),
(62, '而是有你的冬天', '2023-12-17 22:45:51', '127.0.0.1'),
(63, '我期待的不是月', '2023-12-17 22:46:11', '127.0.0.1');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(16) NOT NULL,
  `user_password` varchar(16) NOT NULL,
  `state_number` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `state_number`) VALUES
(62, 'katty', '9876', 1),
(63, 'kk', '5678', 0),
(64, '李蓮花', '0229', 0),
(65, '方多病', '1015', 0);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `dialogue`
--
ALTER TABLE `dialogue`
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `dialogue`
--
ALTER TABLE `dialogue`
  ADD CONSTRAINT `dialogue_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
