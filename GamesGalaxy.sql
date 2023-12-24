-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2023 at 04:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamesgalaxy`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `g_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Open World', 'In video games, an open world is a virtual world in which the player can approach objectives freely, as opposed to a world with more linear and structured gameplay.'),
(3, 'First Person Shooter', 'First-person shooter (FPS) is a sub-genre of shooter video games centered on gun and other weapon-based combat in a first-person perspective, with the player experiencing the action through the eyes of a protagonist or antagonist which is armed, and then controlling the player character in a three-dimensional space.[1] The genre shares common traits with other shooter games, and in turn falls under the action game genre. Since the genre\'s inception, advanced 3D and pseudo-3D graphics have challenged hardware development, and multiplayer gaming has been integral.'),
(4, 'Fighting Game', 'A fighting game is a genre of video game that involves combat between two or more characters. Fighting game combat often features mechanics such as blocking, grappling, counter-attacking, and chaining attacks together into \"combos\".'),
(5, 'Stealth', 'A stealth game is a type of video game in which the player primarily uses stealth to avoid or overcome opponents. Games in the genre typically allow the player to remain undetected by hiding, sneaking, or using disguises.'),
(6, 'Sport', 'Sports games involve physical and tactical challenges, and test the player\'s precision and accuracy. Most sports games attempt to model the athletic characteristics required by that sport, including speed, strength, acceleration, accuracy, and so on.'),
(7, 'Battle Royale', 'A battle royale game is an online multiplayer video game genre that blends last-man-standing gameplay with the survival, exploration and scavenging elements of a survival game.'),
(8, 'Survival', 'Survival games are a subgenre of video games which are usually set in hostile, intense, open-world environments. Players generally start with minimal equipment and are required to survive as long as possible by crafting tools, weapons, shelters, and collecting resources.');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `g_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `g_id`, `u_id`, `comment`, `date_time`) VALUES
(1, 38, 1, 'Mortal Kombat X is probably the best fighting game ever', '2023-12-20 15:25:53'),
(2, 38, 1, 'or maybe the second best idk', '2023-12-23 14:35:22'),
(5, 26, 1, 'GOAT of gaming 🐐!!!!', '2023-12-24 14:21:42'),
(10, 38, 1, 'test', '2023-12-24 16:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `developer`
--

CREATE TABLE `developer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `developer`
--

INSERT INTO `developer` (`id`, `name`, `description`) VALUES
(1, 'Ubisoft', 'Ubisoft Entertainment SA is a French video game publisher headquartered in Saint-Mandé with development studios across the world. Its video game franchises include Assassin\'s Creed, Far Cry, For Honor, Just Dance, Prince of Persia, Rabbids, Rayman, Tom Clancy\'s, and Watch Dogs.'),
(2, 'Rockstar Games', 'Rockstar Games, Inc. is an American video game publisher based in New York City. The company was established in December 1998 as a subsidiary of Take-Two Interactive, using the assets Take-Two had previously acquired from BMG Interactive.'),
(3, 'NetherRealm Studios', 'NetherRealm Studios is an American video game developer based in Chicago and owned by Warner Bros. Games. Led by video game industry veteran and Mortal Kombat co-creator Ed Boon, the studio is in charge of developing the Mortal Kombat and Injustice series of fighting games.'),
(4, 'Electronic Arts', 'Electronic Arts Inc. is an American video game company headquartered in Redwood City, California. Founded in May 1982 by Apple employee Trip Hawkins, the company was a pioneer of the early home computer game industry and promoted the designers and programmers responsible for its games as \"software artists\"'),
(5, 'IO Interactive', 'IO Interactive A/S is a Danish video game developer based in Copenhagen, best known for creating and developing the Hitman and Kane and Lynch franchises. IO Interactive\'s most recent game is Hitman 3, which was released in January 2021.'),
(6, 'Epic Games', 'Epic Games is an American video game and software company that creates games and offers its game engine technology to other developers.'),
(7, 'Mojang Studios', 'Mojang Studios is a Swedish video game developer based in Stockholm. The studio is best known for developing the sandbox and survival game Minecraft, the best-selling video game of all time.'),
(8, 'Valve', 'Valve is the main developer and publisher of the single-player Half-Life and Portal games and the multiplayer games Counter-Strike, Team Fortress 2, Dota 2, Day of Defeat, and Artifact. Valve also published the multiplayer game Left 4 Dead and developed and published Left 4 Dead 2.'),
(9, 'Activision', 'Activision is a leading worldwide developer, publisher, and distributor of interactive entertainment for various gaming consoles, handheld platforms, and PC, including blockbuster franchises like Call of Duty®, Crash®, and SpyroTM.');

-- --------------------------------------------------------

--
-- Table structure for table `dislike_comment`
--

CREATE TABLE `dislike_comment` (
  `id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dislike_comment`
--

INSERT INTO `dislike_comment` (`id`, `c_id`, `u_id`) VALUES
(33, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(500) NOT NULL,
  `trailer` mediumtext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(6,2) NOT NULL,
  `category` int(11) NOT NULL,
  `developer` int(11) NOT NULL,
  `views` int(11) DEFAULT 0,
  `rating` decimal(2,1) DEFAULT 0.0,
  `rate_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`, `image`, `trailer`, `description`, `price`, `category`, `developer`, `views`, `rating`, `rate_count`) VALUES
(26, 'Red Dead Redemption 2', 'RDR2.jpg', 'https://www.youtube.com/embed/gmA6MrX81z4?si=pes3EFzCV0WO9AMZ&amp;controls=0', 'Red Dead Redemption 2 is a Western-themed action-adventure game set\r\n            in an open world environment featuring a fictionalized version of\r\n            the Western, Midwestern, and Southern United States in 1899, during\r\n            the latter half of the Wild West era and the turn of the twentieth\r\n            century. The game is played from a first or third-person\r\n            perspective. It has both single-player and online multiplayer\r\n            components. The game has new features absent from the previous game', 59.99, 1, 2, 8, 0.0, 0),
(28, 'Red Dead Rdemption', 'RDR1.jpeg', 'https://www.youtube.com/embed/-o7rES_3ymA?si=ljn2TFYgLQerw4sZ&amp;controls=0', 'Red Dead Redemption is a Western-themed action-adventure game played\r\n            from a third-person perspective. It is the second game in the Red\r\n            Dead series and is set during the decline of the American frontier\r\n            in the year 1911. The player controls John Marston and completes\r\n            missions—linear scenarios with set objectives—to progress through\r\n            the story; in the game’s epilogue, the player controls John’s son\r\n            Jack', 29.99, 1, 2, 1, 0.0, 0),
(29, 'Grand Theft Auto V', 'GTAV.jpeg', 'https://www.youtube.com/embed/QkkoHAzjnUs?si=0RWgMq-SgVLm3Na0&amp;controls=0', 'When a young street hustler, a retired bank robber and a terrifying psychopath find themselves entangled with some of the most frightening and deranged elements of the criminal underworld, the U.S. government and the entertainment industry, they must pull off a series of dangerous heists to survive in a ruthless city in which they can trust nobody, least of all each other.', 39.99, 1, 2, 1, 0.0, 0),
(31, 'Watch Dogs', 'WD1.webp', 'https://www.youtube.com/embed/DqoQG_XYF-8?si=aMHaaLLVBnAHlgCa&amp;controls=0', 'Watch Dogs is an action-adventure game, played from a third-person view. The player controls hacker Aiden Pearce, who uses his smartphone to control trains and traffic lights, infiltrate security systems, jam cellphones, access pedestrians\' private information, and empty their bank accounts.', 29.99, 1, 1, 0, 0.0, 0),
(32, 'Watch Dogs 2', 'WD2.jpeg', 'https://www.youtube.com/embed/hh9x4NqW0Dw?si=PpUztfdFLDGI8nMh&amp;controls=0', 'The sequel to its 2014 predecessor, Watch Dogs 2 takes place in San Francisco, California. The player takes control of Marcus Holloway, a hacker and a member of the hacktivist group DedSec who aims to take down CTOS 2.0. The game was followed by Watch Dogs: Legion in 2020.', 49.99, 1, 1, 1, 0.0, 0),
(37, 'Fifa 23', 'FIFA23.webp', 'https://www.youtube.com/embed/0tIW1X2dv0c?si=U2mUtutlMFM07T3J&amp;controls=0', 'FIFA 23 features the men\'s World Cup game mode and the women\'s World Cup game mode, replicating the 2022 FIFA World Cup and the 2023 FIFA Women\'s World Cup. The 2022 FIFA World Cup mode was released on 9 November for all platforms except for the Nintendo Switch Legacy Edition.', 69.99, 6, 4, 3, 0.0, 0),
(38, 'Mortal Kombat X', 'MKX.jpeg', 'https://www.youtube.com/embed/jSi2LDkyKmI?si=esO1pY0KcB4wWUdu&amp;controls=0', 'Mortal Kombat X is a fighting game in which two characters fight against each other using a variety of attacks, including special moves, and the series\' trademark gruesome finishing moves, Fatalities. The game allows two players to face each other (either locally or online), or a single player to play against the CPU.', 19.99, 4, 3, 463, 5.0, 1),
(39, 'Grand Theft Auto IV', 'GTAIV.png', 'https://www.youtube.com/embed/M80K51DosFo?si=noUHU76MoHcMHCDz&amp;controls=0', 'Grand Theft Auto IV is an action-adventure game played from a third-person perspective. Players complete missions—linear scenarios with set objectives—to progress through the story. It is possible to have several active missions running at one time, as some require players to wait for further instructions or events.', 19.99, 1, 2, 6, 0.0, 0),
(40, 'Hitman', 'Hitman.jpeg', 'https://www.youtube.com/embed/2DTPhRRKAfE?si=f3rAaa_PbdqCzOL4&amp;controls=0', 'The single-player story follows genetically engineered assassin Agent 47 as he goes on a worldwide adventure and solves a mysterious series of seemingly unconnected assassinations. Hitman features a number of large, open-ended sandboxes that Agent 47 can freely explore.', 19.99, 5, 5, 0, 0.0, 0),
(41, 'Assassin\'s Creed IV: Black Flag', 'ACBF.jpeg', 'https://www.youtube.com/embed/OwVe4ZNeQZk?si=Jb_aOuuyMgwdt7Q8&amp;controls=0', 'Assassin\'s Creed IV: Black Flag is an action-adventure, stealth game set in an open world environment and played from a third-person perspective. The game features three main cities: Havana, Kingston, and Nassau, which reside under Spanish, British, and pirate influence, respectively.', 19.99, 1, 1, 136, 3.5, 2),
(42, 'Assassin\'s Creed Unity', 'ACU.jpeg', 'https://www.youtube.com/embed/xzCEdSKMkdU?si=YfGt-gS4XD6CNTwC&amp;controls=0', 'Assassin\'s Creed® Unity is an action/adventure game set in the city of Paris during one of its darkest hours, the French Revolution. Take ownership of the story by customising Arno\'s equipement to make the experience unique to you, both visually and mechanically.', 29.99, 1, 1, 77, 0.0, 0),
(44, 'Tom Clancy\'s Rainbow Six® Siege', 'R6S.jpeg', 'https://www.youtube.com/embed/KlbLLRdg9u8?si=P-jBBaq2nrB1ckge&amp;controls=0', 'Tom Clancy\'s Rainbow Six® Siege is an elite, realistic, tactical, team-based shooter where superior planning and execution triumph. It features 5v5 attack vs. defense gameplay and intense close-quarters combat in destructible environments.', 19.99, 3, 1, 1, 0.0, 0),
(45, 'Fortnite Battle Royale', 'Fortnite.jpeg', 'https://www.youtube.com/embed/WJW-bzXZM8M?si=ZXC3-YR4FbKfXdIO&amp;controls=0', 'Fortnite is a third-person shooter game where up to 100 players compete to be the last person or team standing. You can compete alone or join a team of up to four. You progress through the game by exploring the island, collecting weapons, building fortifications and engaging in combat with other players.', 0.00, 7, 6, 2, 3.0, 1),
(46, 'Minecraft', 'Minecraft.jpg', 'https://www.youtube.com/embed/MmB9b5njVbA?si=AbW8zKPtFMF5oloZ&amp;controls=0', 'In Minecraft, players explore a blocky, procedurally generated, three-dimensional world with virtually infinite terrain and may discover and extract raw materials, craft tools and items, and build structures, earthworks, and machines.', 29.99, 8, 7, 0, 0.0, 0),
(47, 'Counter Strike: Global Offensive', 'CSGO.jpg', 'https://www.youtube.com/embed/edYCtaNueQY?si=9OMOfrnWY5n3w41a&amp;controls=0', 'Counter-Strike: Global Offensive (CS:GO) is a round-based, 5v5 tactical FPS with an Attackers vs. Defenders setup and no respawns, meaning if a player is eliminated they will not respawn until the next round. The game is available to download from the STEAM Games Client.', 0.00, 3, 8, 2, 0.0, 0),
(48, 'Call of Duty®: Modern Warfare', 'CODMW19.webp', 'https://www.youtube.com/embed/bH1lHCirCGI?si=TRnX6bydCxq7mlCj&amp;controls=0', 'The campaign follows a CIA officer and British SAS forces as they team up with rebels from the fictional Republic of Urzikstan, combating together against Russian Armed Forces who have invaded the country and the Urzik terrorist group Al-Qatala, while searching for a stolen shipment of chlorine gas.', 59.99, 3, 9, 7, 0.0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `like_comment`
--

CREATE TABLE `like_comment` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `like_comment`
--

INSERT INTO `like_comment` (`id`, `u_id`, `c_id`) VALUES
(54, 1, 5),
(108, 1, 10),
(110, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `g_id` int(11) NOT NULL,
  `rating` double NOT NULL,
  `rating_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_of_birth` date NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `date_of_birth`, `fname`, `lname`, `role`) VALUES
(1, 'Soldier', 'omar.eljundi@hotmail.com', 'Soldier2003', '2003-04-02', 'Omar', 'El-Jundi', 1),
(2, 'Al-Safwah', 'abdelrahmadsafwe@gmail.com', 'safwah1234', '2004-02-01', 'Abdelrahman', 'Safweh', 2),
(3, 'Gilbertos', 'gilbert123@hotmail.com', 'gg123321', '2003-10-17', 'Gilbert', 'Sahyoun', 2),
(38, 'test', 'test@test.com', 'test', '0001-01-01', 'test', 'test', 2),
(39, 'test1', 'test1@test.com', 'test', '0001-01-01', 'test', 'test', 2);

-- --------------------------------------------------------

--
-- Table structure for table `userlibrary`
--

CREATE TABLE `userlibrary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `purchase_date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlibrary`
--

INSERT INTO `userlibrary` (`id`, `user_id`, `game_id`, `purchase_date_time`) VALUES
(59, 3, 38, '2023-08-01 08:16:33'),
(60, 3, 44, '2023-08-01 08:16:33'),
(61, 3, 26, '2023-08-01 08:16:33'),
(67, 1, 42, NULL),
(68, 1, 26, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userrole`
--

CREATE TABLE `userrole` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userrole`
--

INSERT INTO `userrole` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Client');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `g_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `u_id`, `g_id`) VALUES
(34, 1, 42);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_user` (`u_id`),
  ADD KEY `cart_game` (`g_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `g_id` (`g_id`,`u_id`);

--
-- Indexes for table `developer`
--
ALTER TABLE `developer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dislike_comment`
--
ALTER TABLE `dislike_comment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `c_id` (`c_id`,`u_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `g_category` (`category`),
  ADD KEY `g_developer` (`developer`);

--
-- Indexes for table `like_comment`
--
ALTER TABLE `like_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `g_id` (`g_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `userlibrary`
--
ALTER TABLE `userlibrary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_id` (`u_id`,`g_id`),
  ADD KEY `wishlist_game` (`g_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `developer`
--
ALTER TABLE `developer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dislike_comment`
--
ALTER TABLE `dislike_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `like_comment`
--
ALTER TABLE `like_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `userlibrary`
--
ALTER TABLE `userlibrary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `userrole`
--
ALTER TABLE `userrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_game` FOREIGN KEY (`g_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `cart_user` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_game` FOREIGN KEY (`g_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `comments_user` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `dislike_comment`
--
ALTER TABLE `dislike_comment`
  ADD CONSTRAINT `dislike_comment_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `dislike_comment_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `Games_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `Games_ibfk_2` FOREIGN KEY (`developer`) REFERENCES `developer` (`id`);

--
-- Constraints for table `like_comment`
--
ALTER TABLE `like_comment`
  ADD CONSTRAINT `fk_comment_id` FOREIGN KEY (`c_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `like_comment_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `like_comment_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`g_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`role`) REFERENCES `userrole` (`id`);

--
-- Constraints for table `userlibrary`
--
ALTER TABLE `userlibrary`
  ADD CONSTRAINT `UserLibrary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `UserLibrary_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_game` FOREIGN KEY (`g_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `wishlist_user` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
