-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2019 at 05:13 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdev_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `carddecks`
--

CREATE TABLE `carddecks` (
  `CardDeckID` int(10) UNSIGNED NOT NULL,
  `CardID` int(10) UNSIGNED NOT NULL,
  `DeckID` int(10) UNSIGNED NOT NULL,
  `UserID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cardlevels`
--

CREATE TABLE `cardlevels` (
  `Level` int(10) UNSIGNED NOT NULL,
  `CardID` int(10) UNSIGNED NOT NULL,
  `UserID` int(10) UNSIGNED NOT NULL,
  `HitPoints` int(11) DEFAULT NULL,
  `DamagePerSecond` int(11) DEFAULT NULL,
  `CrownTowerDamage` int(11) DEFAULT NULL,
  `DeathDamage` int(11) DEFAULT NULL,
  `ChargeDamage` int(11) DEFAULT NULL,
  `AreaDamage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cardlevels`
--

INSERT INTO `cardlevels` (`Level`, `CardID`, `UserID`, `HitPoints`, `DamagePerSecond`, `CrownTowerDamage`, `DeathDamage`, `ChargeDamage`, `AreaDamage`) VALUES
(1, 1, 1, 652, 65, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `CardID` int(10) UNSIGNED NOT NULL,
  `UserID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(24) NOT NULL,
  `Rarity` char(9) NOT NULL,
  `Type` varchar(15) NOT NULL,
  `ElixirCost` int(11) NOT NULL,
  `HitSpeed` decimal(2,1) DEFAULT NULL,
  `Speed` char(9) DEFAULT NULL,
  `Targets` varchar(64) DEFAULT NULL,
  `AttackRange` char(5) DEFAULT NULL,
  `Lifetime` int(11) DEFAULT NULL,
  `ArenaLevel` int(11) DEFAULT NULL,
  `SpawnSpeed` decimal(2,1) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Radius` decimal(2,1) DEFAULT NULL,
  `Count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`CardID`, `UserID`, `Name`, `Rarity`, `Type`, `ElixirCost`, `HitSpeed`, `Speed`, `Targets`, `AttackRange`, `Lifetime`, `ArenaLevel`, `SpawnSpeed`, `Description`, `Radius`, `Count`) VALUES
(1, 1, 'Knight', 'Common', 'Troop', 3, '1.2', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'A tough melee fighter. The Barbarian&#039;s handsome, cultured cousin. Rumor has it that he was knighted based on the sheer awesomeness of his mustache alone. ', NULL, NULL),
(2, 1, 'Archers', 'Common', 'Troop', 3, '1.2', 'Medium', 'Ground', '5', NULL, 1, NULL, 'A pair of lightly armored ranged attackers. They\'ll help you take down ground and air units, but you\'re on your own with hair coloring advice. ', NULL, NULL),
(3, 1, 'Goblins', 'Common', 'Troop', 2, '1.1', 'Very Fast', 'Ground', 'Melee', NULL, 1, NULL, 'Three fast, unarmored melee attackers. Small, fast, green and mean! ', NULL, NULL),
(4, 1, 'Minions', 'Common', 'Troop', 3, '1.0', 'Fast', 'Air &amp; Ground', '2', NULL, 1, NULL, 'Three fast, unarmored flying attackers. Roses are red, minions are blue, they can fly, and will crush you!', NULL, NULL),
(5, 1, 'Giant', 'Rare', 'Troop', 5, '1.5', 'Slow', 'Buildings', 'Melee', NULL, 1, NULL, 'Slow but durable, only attacks buildings. A real one-man wrecking crew! ', NULL, NULL),
(6, 1, 'Goblin Barrel', 'Epic', 'Spell', 3, NULL, '', 'Ground', '', NULL, 1, NULL, 'Spawns three Goblins anywhere in the Arena. It\'s going to be a thrilling ride, boys! ', NULL, NULL),
(7, 1, 'Arrows', 'Common', 'Spell', 3, NULL, 'Slow', 'Air & Ground', '', NULL, 1, NULL, 'Arrows pepper a large area, damaging all enemies hit. Reduced damage to Crown Towers. ', NULL, NULL),
(8, 1, 'Skeleton Army', 'Epic', 'Troop', 3, '1.0', 'Fast', 'Ground', 'Melee', NULL, 1, NULL, 'Spawns an army of Skeletons. Meet Larry and his friends Harry, Gerry, Terry, Mary, etc. ', NULL, NULL),
(9, 1, 'Prince', 'Epic', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'Don\'t let the little pony fool you. Once the Prince gets a running start, you WILL be trampled. Deals double damage once he gets charging. ', NULL, NULL),
(10, 1, 'Spear Goblins', 'Common', 'Troop', 2, '1.7', 'Very Fast', 'Air & Ground', '5', NULL, 1, NULL, 'Three unarmored ranged attackers. Who the heck taught these guys to throw spears!? Who thought that was a good idea?! ', NULL, NULL),
(11, 1, 'Fireball', 'Rare', 'Spell', 4, NULL, '', 'Air & Ground', '', NULL, 1, NULL, 'Annnnnd... Fireball. Incinerates a small area, dealing high damage. Reduced damage to Crown Towers. ', NULL, NULL),
(12, 1, 'Goblin Hut', 'Rare', 'Building', 5, '1.7', 'Very Fast', 'Ground', '', NULL, 1, '4.7', 'Building that spawns Spear Goblins. Don\'t look inside... you don\'t want to see how they\'re made.', NULL, NULL),
(13, 1, 'Wall Breakers', 'Epic', 'Troop', 3, '1.2', 'Very Fast', 'Buildings', 'Melee', NULL, 1, NULL, 'A daring duo of dangerous dive bombers. Nothing warms a Wall Breaker\'s cold and undead heart like blowing up buildings.', '1.5', 2),
(14, 1, 'Skeletons', 'Common', 'Troop', 1, '1.0', 'Fast', 'Ground', 'Melee', NULL, 2, NULL, 'Three fast, very weak melee fighters. Surround your enemies with this pile of bones!', NULL, 3),
(15, 1, 'Bomber', 'Common', 'Troop', 3, '1.9', 'Medium', 'Ground', '5', NULL, 2, NULL, 'Small, lightly protected skeleton who throws bombs. Deals area damage that can wipe out a swarm of enemies. ', '1.5', NULL),
(16, 1, 'Valkyrie', 'Rare', 'Troop', 4, '1.5', 'Medium', 'Ground', 'Melee', NULL, 2, NULL, 'Tough melee fighter, deals area damage around her. Swarm or horde, no problem! She can take them all out with a few spins.', '2.0', NULL),
(17, 1, 'Witch', 'Epic', 'Troop', 5, '1.0', 'Medium', 'Air & Ground', '5', NULL, 2, NULL, 'Summons Skeletons, shoots destructo beams, has glowing pink eyes that unfortunately don\'t shoot lasers.', '1.1', NULL),
(18, 1, 'Barbarians', 'Common', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 3, NULL, 'A horde of melee attackers with mean mustaches and even meaner tempers.', NULL, 5),
(19, 1, 'Cannon', 'Common', 'Building', 3, '0.8', '', 'Ground', '5.5', 30, 3, NULL, 'Defensive building. Shoots cannonballs with deadly effect, but cannot target flying troops.', NULL, NULL),
(20, 1, 'Battle Ram', 'Rare', 'Troop', 4, '0.4', 'Medium', 'Buildings', 'Melee', NULL, 3, NULL, 'Two Barbarians holding a big log charge at the nearest building, dealing significant damage if they connect; then they go to town with their swords!', NULL, 2),
(21, 1, 'Barbarian Hut', 'Rare', 'Building', 7, NULL, '', 'Ground', '', 60, 3, '9.9', 'Building that periodically spawns Barbarians to fight the enemy. Time to make the Barbarians! ', NULL, 2),
(22, 1, 'Golem', 'Epic', 'Troop', 8, '2.5', 'Slow', 'Buildings', 'Melee', NULL, 3, NULL, 'Slow but durable, only attacks buildings. When destroyed, explosively splits into two Golemites and deals area damage!', NULL, NULL),
(23, 1, 'Barbarian Barrel', 'Epic', 'Spell', 2, NULL, '', 'Ground', '5', NULL, 3, NULL, 'It rolls over and damages anything in its path, then breaks open and out pops a Barbarian! How did he get inside?!', NULL, NULL),
(24, 1, 'Zap', 'Common', 'Spell', 2, NULL, 'Slow', 'Air & Ground', '', NULL, 4, NULL, 'Zaps enemies, briefly stunning them and dealing damage inside a small radius. Reduced damage to Crown Towers.', NULL, NULL),
(25, 1, 'Mega Minion', 'Rare', 'Troop', 3, '1.6', 'Medium', 'Air & Ground', '2', NULL, 4, NULL, 'Flying, armored and powerful. What could be its weakness?! Cupcakes.', NULL, NULL),
(26, 1, 'Inferno Tower', 'Rare', 'Building', 5, '0.4', '', 'Air & Ground', '6', 40, 4, NULL, 'Defensive building, roasts targets for damage that increases over time. Burns through even the biggest and toughest enemies!', NULL, NULL),
(27, 1, 'P.E.K.K.A', 'Epic', 'Troop', 7, '1.8', 'Slow', 'Ground', 'Melee', NULL, 4, NULL, 'A heavily armored, slow melee fighter. Swings from the hip, but packs a huge punch.', NULL, NULL),
(28, 1, 'Lava Hound', 'Legendary', 'Troop', 7, '1.3', 'Slow', 'Buildings', '2', NULL, 4, NULL, 'The Lava Hound is a majestic flying beast that attacks buildings. The Lava Pups are less majestic angry babies that attack anything.', NULL, NULL),
(29, 1, 'Lightning', 'Epic', 'Spell', 6, NULL, 'Slow', 'Air & Ground', '', NULL, 4, NULL, 'Bolts of lightning damage and stun up to three enemy troops or buildings with the most hitpoints in the target area. Reduced damage to Crown Towers.', '3.5', 3),
(30, 1, 'Fire Spirits', 'Common', 'Troop', 2, '0.3', 'Very Fast', 'Air & Ground', '2', NULL, 5, NULL, 'These three Fire Spirits are on a kamikaze mission to give you a warm hug. It\'d be adorable if they weren\'t on fire.', '1.5', 3),
(31, 1, 'Bats', 'Common', 'Troop', 2, '1.1', 'Very Fast', 'Air & Ground', 'Melee', NULL, 5, NULL, 'Spawns a handful of tiny flying creatures. Think of them as sweet, purple... balls of DESTRUCTION!', NULL, 5),
(32, 1, 'Furnace', 'Rare', 'Building', 4, '0.3', 'Very Fast', 'Ground', '2', 50, 5, '9.9', 'The Furnace spawns two Fire Spirits at a time. It also makes great brick-oven pancakes.', '1.5', 2),
(33, 1, 'Night Witch', 'Legendary', 'Troop', 4, '1.5', 'Medium', 'Ground', '', NULL, 5, '7.0', 'Summons Bats to do her bidding, even after death! If you get too close, she isn\'t afraid of pitching in with her mean-looking battle staff.', NULL, 2),
(34, 1, 'Poison', 'Epic', 'Spell', 4, NULL, '', 'Air & Ground', '', 8, 5, NULL, 'Covers the area in a deadly toxin, damaging enemy troops and buildings over time. Yet somehow leaves the grass green and healthy. Go figure!', '3.5', NULL),
(35, 1, 'Tornado', 'Epic', 'Spell', 3, NULL, '', 'Air & Ground', '', NULL, 5, NULL, 'Drags enemy troops to its center while dealing damage over time, just like a magnet. A big, swirling, Tornado-y magnet. Doesn\'t affect buildings.', '5.5', NULL),
(36, 1, 'Skeleton Barrel', 'Common', 'Troop', 3, NULL, 'Medium', 'Buildings', 'Melee', NULL, 6, NULL, 'It\'s a Skeleton party in the sky, until all the balloons pop... then it\'s a Skeleton party on the ground! ', NULL, 7),
(37, 1, 'Mortar', 'Common', 'Building', 4, '5.0', '', 'Ground', '11.5', 30, 6, NULL, 'Defensive building with a long range. Shoots big boulders that deal area damage, but cannot hit targets that get too close!', '2.0', NULL),
(38, 1, 'Flying Machine', 'Rare', 'Troop', 4, '1.0', 'Fast', 'Air & Ground', '6', NULL, 6, NULL, 'The Master Builder has sent his first contraption to the Arena! It\'s a fast and fun flying machine, but fragile!', NULL, NULL),
(39, 1, 'Rocket', 'Rare', 'Spell', 6, NULL, '', 'Air & Ground', '', NULL, 6, NULL, 'Deals high damage to a small area. Looks really awesome doing it. Reduced damage to Crown Towers.', '2.0', NULL),
(40, 1, 'Balloon', 'Epic', 'Troop', 5, '3.0', 'Medium', 'Buildings', 'Melee', NULL, 6, NULL, 'As pretty as they are, you won\'t want a parade of THESE balloons showing up on the horizon. Drops powerful bombs and when shot down, crashes dealing area damage.', NULL, NULL),
(41, 1, 'X-Bow', 'Epic', 'Building', 6, '0.3', 'Slow', 'Ground', '11.5', 40, 6, NULL, 'Nice tower you got there. Would be a shame if this X-Bow whittled it down from this side of the Arena...', NULL, NULL),
(42, 1, 'Royal Giant', 'Common', 'Troop', 6, '1.7', 'Slow', 'Buildings', '5', NULL, 7, NULL, 'Destroying enemy buildings with his massive cannon is his job; making a raggedy blond beard look good is his passion.', NULL, NULL),
(43, 1, 'Royal Recruits', 'Common', 'Troop', 7, '1.3', 'Medium', 'Ground', 'Melee', NULL, 7, NULL, 'Deploys a line of recruits armed with spears, shields and wooden buckets. They dream of ponies and one day wearing metal buckets.', NULL, 6),
(44, 1, 'Three Musketeers', 'Rare', 'Troop', 10, '1.1', 'Medium', 'Air & Ground', '6', NULL, 7, NULL, 'Trio of powerful, independent markswomen, fighting for justice and honor. Disrespecting them would not be just a mistake, it would be a cardinal sin!', NULL, 3),
(45, 1, 'Heal', 'Rare', 'Spell', 1, NULL, '', 'Air & Ground', '', NULL, 7, NULL, 'Heal your troops to keep them in the fight! Friendly troops are healed over time while in the target area. Doesn\'t affect buildings.', '4.0', NULL),
(46, 1, 'Guards', 'Epic', 'Troop', 3, '1.1', 'Fast', 'Ground', 'Melee', NULL, 7, NULL, 'Three ruthless bone brothers with shields. Knock off their shields and all that\'s left are three ruthless bone brothers.', NULL, 3),
(47, 1, 'Dark Prince', 'Epic', 'Troop', 4, '1.3', 'Medium', 'Ground', 'Melee', NULL, 7, NULL, 'The Dark Prince deals area damage and lets his spiked club do the talking for him - because when he does talk, it sounds like he has a bucket on his head.', NULL, NULL),
(48, 1, 'Mega Knight', 'Legendary', 'Troop', 7, '1.7', 'Medium', 'Ground', 'Melee', NULL, 7, NULL, 'He lands with the force of 1,000 mustaches, then jumps from one foe to the next dealing huge area damage. Stand aside!', '1.3', NULL),
(49, 1, 'Freeze', 'Epic', 'Spell', 4, NULL, '', 'Air & Ground', '', 4, 8, NULL, 'Freezes and damages enemy troops and buildings, making them unable to move or attack. Everybody chill.', '3.0', NULL),
(50, 1, 'Bomb Tower', 'Rare', 'Building', 4, '1.6', '', 'Ground', '6', 35, 10, NULL, 'Defensive building that houses a Bomber. Deals area damage to anything dumb enough to stand near it.', '1.5', NULL),
(51, 1, 'Tesla', 'Common', 'Building', 4, '1.1', '', 'Air & Ground', '5.5', 35, 11, NULL, 'Defensive building. Whenever it\'s not zapping the enemy, the power of Electrickery is best kept grounded.', NULL, NULL),
(52, 1, 'Mirror', 'Epic', 'Spell', 1, NULL, '', 'Ground', '', NULL, 12, NULL, 'Mirrors your last card played for +1 Elixir. Will not appear in your starting cards.', NULL, NULL),
(53, 1, 'Prince', 'Epic', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'Don\'t let the little pony fool you. Once the Prince gets a running start, you WILL be trampled. Deals double damage once he gets charging. ', NULL, NULL),
(54, 1, 'Prince', 'Epic', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'Don\'t let the little pony fool you. Once the Prince gets a running start, you WILL be trampled. Deals double damage once he gets charging. ', NULL, NULL),
(55, 1, 'Prince', 'Epic', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'Don\'t let the little pony fool you. Once the Prince gets a running start, you WILL be trampled. Deals double damage once he gets charging. ', NULL, NULL),
(56, 1, 'Prince', 'Epic', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'Don\'t let the little pony fool you. Once the Prince gets a running start, you WILL be trampled. Deals double damage once he gets charging. ', NULL, NULL),
(57, 1, 'Prince', 'Epic', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'Don\'t let the little pony fool you. Once the Prince gets a running start, you WILL be trampled. Deals double damage once he gets charging. ', NULL, NULL),
(58, 1, 'Prince', 'Epic', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'Don\'t let the little pony fool you. Once the Prince gets a running start, you WILL be trampled. Deals double damage once he gets charging. ', NULL, NULL),
(59, 1, 'Prince', 'Epic', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'Don\'t let the little pony fool you. Once the Prince gets a running start, you WILL be trampled. Deals double damage once he gets charging. ', NULL, NULL),
(60, 1, 'Prince', 'Epic', 'Troop', 5, '1.4', 'Medium', 'Ground', 'Melee', NULL, 1, NULL, 'Don\'t let the little pony fool you. Once the Prince gets a running start, you WILL be trampled. Deals double damage once he gets charging. ', NULL, NULL),
(61, 1, 'Balloon', 'Epic', 'Troop', 5, '3.0', 'Medium', 'Buildings', 'Melee', NULL, 6, NULL, 'As pretty as they are, you won\'t want a parade of THESE balloons showing up on the horizon. Drops powerful bombs and when shot down, crashes dealing area damage.', NULL, NULL),
(62, 1, 'Balloon', 'Epic', 'Troop', 5, '3.0', 'Medium', 'Buildings', 'Melee', NULL, 6, NULL, 'As pretty as they are, you won\'t want a parade of THESE balloons showing up on the horizon. Drops powerful bombs and when shot down, crashes dealing area damage.', NULL, NULL),
(66, 3, 'Logitech MX Master 2S', 'Legendary', 'Spell', 10, NULL, 'Very Fast', 'Air', 'Melee', NULL, 13, NULL, 'The best mouse in the world', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(10) UNSIGNED NOT NULL,
  `UserID` int(10) UNSIGNED NOT NULL,
  `CardID` int(10) UNSIGNED DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Content` varchar(255) NOT NULL,
  `Date_Posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `UserID`, `CardID`, `Rating`, `Content`, `Date_Posted`) VALUES
(10, 2, 66, 4, 'Pretty good looking mouse man!!!', '2019-04-05 20:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `decks`
--

CREATE TABLE `decks` (
  `DeckID` int(10) UNSIGNED NOT NULL,
  `UserID` int(10) UNSIGNED NOT NULL,
  `AverageElixirCost` decimal(4,1) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(10) UNSIGNED NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Password` varchar(44) NOT NULL,
  `Country` varchar(64) DEFAULT NULL,
  `FavouriteCardName` varchar(24) DEFAULT NULL,
  `AccountType` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `Password`, `Country`, `FavouriteCardName`, `AccountType`) VALUES
(1, 'system', 'system@localhost.local', 'wikiroyale123', NULL, NULL, 'A'),
(2, '.:DraGz:.', 'dmartens.martens20@gmail.com', 'Dumdumdum123', NULL, NULL, 'U'),
(3, 'Test', 'testuser@gmail.com', 'Password01', NULL, NULL, 'U'),
(4, 'ClashyBashy', 'clashy@clash.royale', 'ClashyBashy', NULL, NULL, 'U'),
(5, 'Confirmed', 'confirmed@la.da', 'Dumdumdum123', NULL, NULL, 'U'),
(6, 'testa', 'dmartens.martens21@gmail.com', 'asd', NULL, NULL, 'U'),
(7, 'Ceejay', 'cj@cj.cj', 'Password01', NULL, NULL, 'U');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carddecks`
--
ALTER TABLE `carddecks`
  ADD PRIMARY KEY (`CardDeckID`),
  ADD KEY `CardDecks_CardIDFK` (`CardID`),
  ADD KEY `CardDecks_DeckIDFK` (`DeckID`),
  ADD KEY `CardDecks_UserIDFK` (`UserID`);

--
-- Indexes for table `cardlevels`
--
ALTER TABLE `cardlevels`
  ADD PRIMARY KEY (`Level`),
  ADD KEY `CardLevels_CardIDFK` (`CardID`),
  ADD KEY `CardLevels_UserIDFK` (`UserID`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`CardID`),
  ADD KEY `Cards_UserIDFK` (`UserID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `Comments_UserIDFK` (`UserID`),
  ADD KEY `Comments_CardIDFK` (`CardID`);

--
-- Indexes for table `decks`
--
ALTER TABLE `decks`
  ADD PRIMARY KEY (`DeckID`),
  ADD KEY `Decks_UserIDFK` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carddecks`
--
ALTER TABLE `carddecks`
  MODIFY `CardDeckID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `CardID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `decks`
--
ALTER TABLE `decks`
  MODIFY `DeckID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carddecks`
--
ALTER TABLE `carddecks`
  ADD CONSTRAINT `CardDecks_CardIDFK` FOREIGN KEY (`CardID`) REFERENCES `cards` (`CardID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CardDecks_DeckIDFK` FOREIGN KEY (`DeckID`) REFERENCES `decks` (`DeckID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CardDecks_UserIDFK` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cardlevels`
--
ALTER TABLE `cardlevels`
  ADD CONSTRAINT `CardLevels_CardIDFK` FOREIGN KEY (`CardID`) REFERENCES `cards` (`CardID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CardLevels_UserIDFK` FOREIGN KEY (`UserID`) REFERENCES `cards` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `Cards_UserIDFK` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Comments_CardIDFK` FOREIGN KEY (`CardID`) REFERENCES `cards` (`CardID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Comments_UserIDFK` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `decks`
--
ALTER TABLE `decks`
  ADD CONSTRAINT `Decks_UserIDFK` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
