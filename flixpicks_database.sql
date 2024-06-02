-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2024 at 05:52 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flixpicks_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `id` int(100) NOT NULL,
  `user_id` int(100) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`id`, `user_id`, `title`, `comment`, `created_at`) VALUES
(1, 2, 'Test from', 'hi from phpmyADMIN', '2024-06-01 16:25:13'),
(2, 2, 'test', 'test comment', '2024-06-01 17:46:21'),
(3, 3, 'knn', 'mjjb', '2024-06-01 17:54:33'),
(4, 3, 'Hi', 'from local', '2024-06-01 17:56:18'),
(5, 3, 'Want to talk about movies!', 'Let\'s look about the matrix. How do you feel about this movie? Do share your thoughts.', '2024-06-01 17:58:16'),
(6, 3, 'Good', 'Morning', '2024-06-01 20:00:00'),
(10, 3, 'From validation', 'Test', '2024-06-02 13:13:14'),
(11, 3, 'Discuss', 'Refresh', '2024-06-02 13:15:37'),
(12, 3, 'Latest Title', 'Latest Comment', '2024-06-02 13:34:24'),
(13, 3, 'night', 'local', '2024-06-02 15:07:25'),
(14, 3, 'Inception', 'This movie is good.', '2024-06-02 15:08:58'),
(15, 3, 'Final merge', 'Test desc', '2024-06-02 15:24:59');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `director` varchar(255) NOT NULL,
  `release_year` year(4) NOT NULL,
  `synopsis` text DEFAULT NULL,
  `poster_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `name`, `director`, `release_year`, `synopsis`, `poster_url`) VALUES
(1, 'Inception', 'Christopher Nolan', '2010', 'A thief who steals corporate secrets through the use of dream-sharing technology.', 'https://image.tmdb.org/t/p/original/edv5CZvWj09upOsy2Y6IwDhK8bt.jpg'),
(2, 'The Matrix', 'Lana Wachowski, Lilly Wachowski', '1999', 'A computer hacker learns about the true nature of his reality and his role in the war against its controllers.', 'https://image.tmdb.org/t/p/original/sRaupdJawe6UTS0t77vwJoLjd7h.jpg'),
(3, 'Interstellar', 'Christopher Nolan', '2014', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.', 'https://posterspy.com/wp-content/uploads/2022/08/Interstellar_poster.jpg'),
(4, 'Parasite', 'Bong Joon Ho', '2019', 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.', 'https://image.tmdb.org/t/p/original/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg'),
(5, 'The Godfather', 'Francis Ford Coppola', '1972', 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', 'https://image.tmdb.org/t/p/original/3bhkrj58Vtu7enYsRolD1fZdja1.jpg'),
(6, 'Pulp Fiction', 'Quentin Tarantino', '1994', 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.', 'https://image.tmdb.org/t/p/original/wZbnRMarWnO4DJRisOaK4QEg1tl.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `review_comment` text DEFAULT NULL,
  `star_rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `user_id`, `movie_id`, `review_comment`, `star_rating`) VALUES
(1, 1, 1, 'Amazing plot and visuals. A masterpiece.', 5),
(2, 1, 1, 'Mind-bending and thrilling from start to finish.', 5),
(3, 2, 2, 'A groundbreaking sci-fi movie that still holds up.', 5),
(4, 2, 2, 'Revolutionary action scenes and a deep storyline.', 4),
(5, 1, 3, 'A visually stunning and thought-provoking film.', 5),
(6, 1, 3, 'Nolan\'s best work to date. A must-watch.', 5),
(7, 2, 4, 'An intense and gripping social commentary.', 5),
(8, 2, 4, 'A brilliantly crafted movie with superb acting.', 5),
(9, 1, 5, 'A timeless classic. One of the greatest films ever made.', 5),
(10, 1, 5, 'Exceptional storytelling and performances.', 5),
(11, 2, 6, 'Tarantino\'s masterpiece. An iconic film.', 5),
(12, 2, 6, 'A unique blend of humor and violence. Brilliant.', 4),
(13, 3, 1, 'Testing review feature', 3),
(14, 3, 1, 'wwww', 3),
(15, 3, 1, 'Test final', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Jieya Zhou', '20754017@student.westernsydney.edu.au', 'password123'),
(2, 'Munjerin Hossain', '22056673@student.westernsydney.edu.au', 'password456'),
(3, 'test User', 'test@test.com', '$2y$10$PBlW7elMYCfznaNNaKOiiO8fP8iz8Hhptk5GXbz5lirwjG9.qfC/C');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`id`, `user_id`, `movie_id`) VALUES
(43, 3, 1),
(44, 3, 2),
(46, 3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
