-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2020 at 05:49 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pex_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_user_media` (IN `p_user_id` INT(10))  BEGIN

  SELECT M.media_id,
         M.copyright,
         M.apod_date,
         M.explanation,
         M.hdurl,
         M.media_type,
         M.service_version,
         M.title,
         M.url

  FROM user_media M
    INNER JOIN user_media_link L ON M.media_id = L.media_id
    INNER JOIN users U           ON U.user_id  = L.user_id
  WHERE U.user_id = p_user_id 
  ORDER BY M.media_id ; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_save_user_media` (IN `p_user_id` INT(10), IN `p_copyright` VARCHAR(50), IN `p_apod_date` VARCHAR(20), IN `p_explanation` VARCHAR(512), IN `p_hdurl` VARCHAR(128), IN `p_media_type` VARCHAR(10), IN `p_service_version` VARCHAR(10), IN `p_title` VARCHAR(50), IN `p_url` VARCHAR(128))  BEGIN
  DECLARE p_media_id           INT(10) DEFAULT -88;
  DECLARE p_user_media_link_id INT(10) DEFAULT -88;

  START TRANSACTION;

    IF ( NOT EXISTS (SELECT * FROM user_media WHERE url = p_url) ) THEN      
      INSERT INTO user_media (copyright, apod_date, explanation, hdurl, media_type, service_version, title, url)
        VALUES (p_copyright, p_apod_date, p_explanation, p_hdurl, p_media_type, p_service_version, p_title, p_url);
    END IF;

    SET p_media_id = ( SELECT media_id FROM user_media WHERE url = p_url );

    INSERT INTO user_media_link (user_id, media_id)
      VALUES (p_user_id, p_media_id);
    
    -- SET p_user_media_link_id = ( SELECT LAST_INSERT_ID() );

  COMMIT;
  
  -- SET p_result = (p_user_media_link_id != -88);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `reason` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `user_permissions` int(16) NOT NULL DEFAULT 1,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `street` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `profile_done` tinyint(1) DEFAULT 0,
  `country` varchar(50) DEFAULT NULL,
  `post_code` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(50) DEFAULT 'default_profile_image.png',
  `interests` varchar(1024) DEFAULT 'Not Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_permissions`, `firstname`, `lastname`, `email`, `password`, `street`, `city`, `profile_done`, `country`, `post_code`, `phone`, `profile_picture`, `interests`) VALUES
(1, 9, 'Ramon', 'Ramos', 'ramos@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Oakland', 'Oopsiedaisy', 1, 'jkjljkl', 'rw43', '4543535', 'default_profile_image.png', 'AND AGAIN !!! YET AGAIN !!!\r\nWHAT ?? WHAT !! fjdskfjjfsdl - THIS IS HOW WE DO IT - kfjdslkdsjfksdf\r\nA NANANOW NAOW\r\nfjdskfjjfsdl - THIS IS HOW WE DO IT - kfjdslkdsjfksdf\r\nskdfjsdlkfjsdlfkjsdflksdj'),
(2, 3, 'Loopy', 'Jorge', 'jorge@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, 0, NULL, NULL, NULL, 'default_profile_image.png', 'Not Available');

-- --------------------------------------------------------

--
-- Table structure for table `user_media`
--

CREATE TABLE `user_media` (
  `media_id` int(10) NOT NULL,
  `copyright` varchar(50) DEFAULT NULL,
  `apod_date` varchar(20) DEFAULT NULL,
  `explanation` varchar(512) DEFAULT NULL,
  `hdurl` varchar(128) DEFAULT NULL,
  `media_type` varchar(10) DEFAULT NULL,
  `service_version` varchar(10) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_media`
--

INSERT INTO `user_media` (`media_id`, `copyright`, `apod_date`, `explanation`, `hdurl`, `media_type`, `service_version`, `title`, `url`) VALUES
(1, 'Ignacio Diaz Bobillo', '2020-11-13', 'The Tarantula Nebula, also known as 30 Doradus, is more than a thousand light-years in diameter, a giant star forming region within nearby satellite galaxy the Large Magellanic Cloud. About 180 thousand light-years away, it\'s the largest, most violent star forming region known in the whole Local Group of galaxies. The cosmic arachnid sprawls across the top of this spectacular view, composed with narrowband filter data centered on emission from ionized hydrogen and oxygen atoms. Within the Tarantula (NGC 207', 'https://apod.nasa.gov/apod/image/2011/Tarantula_HOO_final_2_2048.jpg', 'image', 'v1', 'The Tarantula Zone', 'https://apod.nasa.gov/apod/image/2011/Tarantula_HOO_final_2_1024.jpg'),
(2, 'Kevin Sargozza', '2020-11-14', 'Yesterday, early morning risers around planet Earth were treated to a waning Moon low in the east as the sky grew bright before dawn. From the Island of Ortigia, Syracuse, Sicily, Italy this simple snapshot found the slender sunlit crescent just before sunrise. Never wandering far from the Sun in Earth\'s sky, inner planets Venus and Mercury shared the calm seaside view. Also in the frame, right of the line-up of Luna and planets, is bright star Spica, alpha star of the constellation Virgo and one of the 20 ', 'https://apod.nasa.gov/apod/image/2011/lunaortybluenodidasc.jpg', 'image', 'v1', 'Venus, Mercury, and the Waning Moon', 'https://apod.nasa.gov/apod/image/2011/lunaortyblue1200nodidasc.jpg'),
(3, 'Marcella Giulia Pace', '2020-11-11', 'What color is the Moon? It depends on the night.  Outside of the Earth\'s atmosphere, the dark Moon, which shines by reflected sunlight, appears a magnificently brown-tinged gray.  Viewed from inside the Earth\'s atmosphere, though, the moon can appear quite different.  The featured image highlights a collection of apparent colors of the full moon documented by one astrophotographer over 10 years from different locations across Italy. A red or yellow colored moon usually indicates a moon seen near the horizon', 'https://apod.nasa.gov/apod/image/2011/MoonColors_Pace_960.jpg', 'image', 'v1', 'Colors of the Moon', 'https://apod.nasa.gov/apod/image/2011/MoonColors_Pace_960.jpg'),
(4, 'undefined', '2020-11-17', 'What\'s creating these long glowing streaks in the sky? No one is sure.  Known as Strong Thermal Emission Velocity Enhancements (STEVEs), these luminous light-purple sky ribbons may resemble regular auroras, but recent research reveals significant differences. A STEVE\'s great length and unusual colors, when measured precisely, indicate that it may be related to a subauroral ion drift (SAID), a supersonic river of hot atmospheric ions thought previously to be invisible.  Some STEVEs are now also thought to be', 'https://apod.nasa.gov/apod/image/2011/SteveMilkyWay_NasaTrinder_6144.jpg', 'image', 'v1', 'A Glowing STEVE and the Milky Way', 'https://apod.nasa.gov/apod/image/2011/SteveMilkyWay_NasaTrinder_960.jpg'),
(5, 'Tomáš Slovinský', '2020-11-16', 'The month was July, the place was the Greek island of Crete, and the sky was spectacular. Of course there were the usual stars like Polaris, Vega, and Antares -- and that common asterism everyone knows: the Big Dipper. But this sky was just getting started.  The band of the Milky Way Galaxy stunned as it arched across the night like a bridge made of stars and dust but dotted with red nebula like candy. The planets Saturn and Jupiter were so bright you wanted to stop people on the beach and point them out. T', 'https://apod.nasa.gov/apod/image/2011/CreteSky_Slovinsky_3000.jpg', 'image', 'v1', 'Light and Glory over Crete', 'https://apod.nasa.gov/apod/image/2011/CreteSky_Slovinsky_1080.jpg'),
(6, 'Greg Polanski', '2020-11-18', 'Most star clusters are singularly impressive.  Open clusters NGC 869 and NGC 884, however, could be considered doubly impressive.  Also known as \"h and chi Persei\", this unusual double cluster, shown above, is bright enough to be seen from a dark location without even binoculars.  Although their discovery surely predates recorded history, the Greek astronomer Hipparchus notably cataloged the double cluster.  The clusters are over 7,000 light years distant toward the constellation of Perseus, but are separat', 'https://apod.nasa.gov/apod/image/2011/DoubleCluster_Polanski_4560.jpg', 'image', 'v1', 'A Double Star Cluster in Perseus', 'https://apod.nasa.gov/apod/image/2011/DoubleCluster_Polanski_960.jpg'),
(7, 'Jen Scott', '2020-11-19', 'Leaving planet Earth for a moment, a SpaceX Falcon 9 rocket arced into the early evening sky last Sunday at 7:27 pm EST. This 3 minute 20 second exposure traces the launch streak over Kennedy Space Center\'s Launch Complex 39A. The rocket carried four astronauts en route to the International Space Station on the first flight of a NASA-certified commercial human spacecraft system. Dubbed Resilience, the astronauts\' Crew Dragon spacecraft successfully docked with the orbital outpost one day later, on Monday, N', 'https://apod.nasa.gov/apod/image/2011/spacex-crew-1-JenScottPhotography-11.jpg', 'image', 'v1', 'Crew-1 Mission Launch Streak', 'https://apod.nasa.gov/apod/image/2011/spacex-crew-1-JenScottPhotography-11_1050.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_media_link`
--

CREATE TABLE `user_media_link` (
  `link_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `media_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_media_link`
--

INSERT INTO `user_media_link` (`link_id`, `user_id`, `media_id`) VALUES
(5, 1, 1),
(4, 1, 2),
(14, 1, 3),
(1, 2, 1),
(3, 2, 2),
(21, 2, 4),
(22, 2, 5),
(23, 2, 6),
(24, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `perm_id` int(10) NOT NULL,
  `perm_name` varchar(50) NOT NULL,
  `perm_bit_mask` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`perm_id`, `perm_name`, `perm_bit_mask`) VALUES
(1, 'Guest', 1),
(2, 'Member', 2),
(3, 'Blog', 4),
(4, 'Admin', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`,`firstname`,`lastname`);

--
-- Indexes for table `user_media`
--
ALTER TABLE `user_media`
  ADD PRIMARY KEY (`media_id`),
  ADD UNIQUE KEY `idx_url` (`url`),
  ADD KEY `idx_title` (`title`);

--
-- Indexes for table `user_media_link`
--
ALTER TABLE `user_media_link`
  ADD PRIMARY KEY (`link_id`),
  ADD UNIQUE KEY `idx_user_id` (`user_id`,`media_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`perm_id`,`perm_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_media`
--
ALTER TABLE `user_media`
  MODIFY `media_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_media_link`
--
ALTER TABLE `user_media_link`
  MODIFY `link_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `perm_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_media_link`
--
ALTER TABLE `user_media_link`
  ADD CONSTRAINT `user_media_link_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_media_link_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `user_media` (`media_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
