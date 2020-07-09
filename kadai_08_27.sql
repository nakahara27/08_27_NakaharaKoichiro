-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2020-07-09 10:33:20
-- サーバのバージョン： 10.4.11-MariaDB
-- PHP のバージョン: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `kadai_08_27`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `todo_tbl`
--

CREATE TABLE `todo_tbl` (
  `sn` int(12) NOT NULL,
  `user_id` varchar(16) NOT NULL,
  `todo` varchar(128) NOT NULL,
  `deadline` date NOT NULL,
  `is_eliminated` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `todo_tbl`
--

INSERT INTO `todo_tbl` (`sn`, `user_id`, `todo`, `deadline`, `is_eliminated`, `created_at`, `updated_at`) VALUES
(7, '101', 'Gs講義（サービス＆ＤＢ設計講座）', '2020-07-25', 0, '2020-06-20 15:33:01', '2020-07-09 12:17:57'),
(8, '101', 'Gs講義（ファイルのアップロード）', '2020-07-18', 0, '2020-06-20 15:33:01', '2020-07-09 12:18:36'),
(9, '101', 'Gs講義（RDB実践）', '2020-07-11', 0, '2020-06-20 15:33:01', '2020-07-09 12:06:57'),
(13, '101', 'Gs講義（ＭＶＣフレームワーク②）', '2020-08-08', 0, '2020-06-20 17:01:47', '2020-07-09 12:18:13'),
(17, '101', 'Hack Fes 2020（合宿1日目）', '2020-07-23', 0, '2020-07-06 22:28:33', '2020-07-09 17:28:18'),
(22, '101', 'Gsセミナー（起業ゼミ／就職ゼミ）', '2020-07-12', 0, '2020-07-07 22:06:05', '2020-07-09 12:06:35'),
(23, '101', 'Gs講義（ＭＶＣフレームワーク①）', '2020-08-01', 0, '2020-07-09 00:02:40', '2020-07-09 12:18:04'),
(29, '101', 'Gsセミナー（企画完成ワークショップ）', '2020-08-22', 0, '2020-07-09 14:43:14', '2020-07-09 14:43:14'),
(30, '101', 'Gs課題提出〆（RDB実践）', '2020-07-16', 0, '2020-07-09 14:46:40', '2020-07-09 14:46:40'),
(31, '101', 'Gs課題提出〆（ファイルのアップロード）', '2020-07-23', 0, '2020-07-09 14:47:36', '2020-07-09 14:47:52'),
(32, '101', 'Gs課題提出〆（ＭＶＣフレームワーク①）', '2020-08-06', 0, '2020-07-09 14:48:33', '2020-07-09 14:48:58'),
(33, '101', 'Gs課題提出〆（サービス＆ＤＢ設計講座）', '2020-07-30', 0, '2020-07-09 14:50:09', '2020-07-09 14:50:09'),
(34, '101', 'Gs課題提出〆（ＭＶＣフレームワーク②）', '2020-08-13', 1, '2020-07-09 14:50:48', '2020-07-09 14:50:48'),
(35, '101', '★予定', '2020-07-13', 1, '2020-07-09 14:58:11', '2020-07-09 14:58:11'),
(36, '101', 'Gsセミナー（企画完成ワークショップ）２', '2020-08-25', 1, '2020-07-09 15:20:40', '2020-07-09 15:20:40'),
(37, '101', 'Hack Fes 2020（合宿2日目）', '2020-07-24', 0, '2020-07-09 17:27:40', '2020-07-09 17:28:27');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `is_admin` int(1) NOT NULL,
  `user_name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `password`, `is_admin`, `user_name`) VALUES
('101', '111', 1, '大名 一郎'),
('102', '222', 0, '警固 二郎');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `todo_tbl`
--
ALTER TABLE `todo_tbl`
  ADD PRIMARY KEY (`sn`),
  ADD KEY `idex_user_id` (`user_id`),
  ADD KEY `is_eliminated` (`is_eliminated`);

--
-- テーブルのインデックス `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `is_admin` (`user_id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `todo_tbl`
--
ALTER TABLE `todo_tbl`
  MODIFY `sn` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
