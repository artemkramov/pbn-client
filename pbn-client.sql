-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2018 at 10:47 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pbn-client`
--

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `local` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `isDefault` tinyint(1) NOT NULL DEFAULT '0',
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `url`, `local`, `name`, `isDefault`, `isDeleted`) VALUES
(1, 'en', 'en_EN', 'English', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sort` int(11) NOT NULL DEFAULT '0',
  `parentID` int(11) DEFAULT NULL,
  `pageID` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `menuTypeID` int(11) NOT NULL,
  `isEnabled` tinyint(1) NOT NULL DEFAULT '1',
  `isDirect` tinyint(1) NOT NULL DEFAULT '0',
  `isNewTab` tinyint(1) NOT NULL DEFAULT '0',
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `dateCreated`, `dateModified`, `sort`, `parentID`, `pageID`, `image`, `url`, `menuTypeID`, `isEnabled`, `isDirect`, `isNewTab`, `isDeleted`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, NULL, 1, NULL, NULL, 1, 1, 0, 0, 0),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, 2, NULL, NULL, 1, 1, 0, 0, 0),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, NULL, 3, NULL, NULL, 1, 1, 0, 0, 0),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 2, 4, NULL, NULL, 1, 1, 0, 0, 0),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 4, 5, NULL, NULL, 1, 1, 0, 0, 0),
(6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, NULL, 2, NULL, NULL, 2, 1, 0, 0, 0),
(7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, NULL, NULL, '/user', 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu-language`
--

CREATE TABLE `menu-language` (
  `id` int(11) NOT NULL,
  `menuID` int(11) NOT NULL,
  `language` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu-language`
--

INSERT INTO `menu-language` (`id`, `menuID`, `language`, `title`) VALUES
(1, 1, 'en', 'Main page'),
(2, 2, 'en', 'Follow us'),
(3, 3, 'en', 'Contact us'),
(4, 4, 'en', 'Submenu'),
(5, 6, 'en', 'Follow us'),
(6, 5, 'en', 'Subsubmenu'),
(7, 7, 'en', 'Login/Register');

-- --------------------------------------------------------

--
-- Table structure for table `menu-type`
--

CREATE TABLE `menu-type` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu-type`
--

INSERT INTO `menu-type` (`id`, `alias`, `name`, `isDeleted`) VALUES
(1, 'header', 'Header menu', 0),
(2, 'footer', 'Footer menu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `datePublished` date DEFAULT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sort` int(11) NOT NULL,
  `pageTypeID` int(11) DEFAULT NULL,
  `isPaginationOn` tinyint(1) NOT NULL DEFAULT '0',
  `paginationID` int(11) DEFAULT NULL,
  `paginationPerPage` smallint(6) DEFAULT NULL,
  `templateCarcassID` int(11) NOT NULL,
  `templateInnerID` int(11) NOT NULL,
  `isMainPage` tinyint(1) NOT NULL DEFAULT '0',
  `isEnabled` tinyint(1) NOT NULL DEFAULT '1',
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `image1`, `image2`, `image3`, `datePublished`, `dateCreated`, `dateModified`, `sort`, `pageTypeID`, `isPaginationOn`, `paginationID`, `paginationPerPage`, `templateCarcassID`, `templateInnerID`, `isMainPage`, `isEnabled`, `isDeleted`) VALUES
(1, NULL, NULL, NULL, '2018-03-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, NULL, 1, 1, 1, 1, 2, 1, 1, 0),
(2, NULL, NULL, NULL, '2018-03-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 2, 0, 1, 1, 1, 3, 0, 1, 0),
(3, NULL, NULL, NULL, '2018-03-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2, 0, NULL, NULL, 1, 3, 0, 1, 0),
(4, NULL, NULL, NULL, '2018-03-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 2, 0, NULL, NULL, 1, 3, 0, 1, 0),
(5, NULL, NULL, NULL, '2018-03-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 2, 0, NULL, NULL, 1, 3, 0, 1, 0),
(6, NULL, NULL, NULL, '2018-03-14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 2, 0, NULL, NULL, 1, 3, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `page-extra`
--

CREATE TABLE `page-extra` (
  `id` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `fieldName` varchar(255) NOT NULL,
  `fieldValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page-extra`
--

INSERT INTO `page-extra` (`id`, `pageID`, `fieldName`, `fieldValue`) VALUES
(1, 2, 'type', 'post');

-- --------------------------------------------------------

--
-- Table structure for table `page-language`
--

CREATE TABLE `page-language` (
  `id` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `language` varchar(3) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext,
  `descriptionShort` text,
  `seoTitle` text,
  `seoDescription` text,
  `seoKeywords` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page-language`
--

INSERT INTO `page-language` (`id`, `pageID`, `language`, `title`, `description`, `descriptionShort`, `seoTitle`, `seoDescription`, `seoKeywords`) VALUES
(1, 1, 'en', 'Main page', NULL, NULL, 'Main page', 'Main page', 'Main page'),
(2, 2, 'en', 'Family Banking Tips', '<p>Banking is all about education. This is why people who have banking advice need to really do their research. A family can get the best possible banking advice if they talk to financial organs, go online, and read the newspaper. Personal finance is about understanding what a family has and what a family wants to do with its money. Everyone from adults to university students can save and make money if they are smart. The following are some key pieces of <a href="http://www.pennywatchers.net/">banking advice</a> for families.</p>\n<p><strong>Shop Around for the Best Rates<br></strong>Before investing in any one group, it is wise to do some homework. Different banks and organs have different policies and deals for families looking for savings, chequing, and investment options. There are price comparison websites online that allow families to investigate different loan options and interest rates. Knowledge is power when it comes to a family’s money and interests.</p>\n<p><strong>Investigate a Bank’s Resources<br></strong>It is important to always know what a financial group offers individuals and families. For example, a student loan could come with lower interest rates if the individual’s family has an account with the organ. Additionally, it is wise to see what investment and savings options are offered by a financial group. Some people may get lower rates or fees if they sign up with their family versus independently.</p>\n<p>Banks want business. This is why investing in a group as a family is a smart decision: it can mean lower rates on many different types of services and accounts. It is important that a family is clear about its needs: whether the focus is applying for a vehicle loan or looking for the best savings and investment options. With some research, a family can find a bank that services all of its needs.</p>', '<p>Banking is all about education. This is why people who have banking advice need to really do their research. A family can get the best possible banking advice if they talk to financial organs, go online, and read the newspaper. Personal finance is about understanding what a family has and what a family wants to do with its money. Everyone from adults to university students can save and make money if they are smart. The following are some key pieces of <a href="http://www.pennywatchers.net/">banking advice</a> for families.</p>', 'Family Banking Tips', NULL, NULL),
(3, 3, 'en', 'Providing More Services for my Clients', '<p>Over my last fifteen years as an accountant, I have had the opportunity to interact with many different businesses.&nbsp; Each one of them has presented challenges to me and I have enjoyed the opportunity to work with so many business owners.&nbsp; But due to the economic climate that we are now in, I see that in a couple of years a number of my clients will be gone and I may not be able to maintain the lifestyle that I love.&nbsp; So, I have decided that it is time to provide more services to my clients.</p>\r\n<p>Over my last fifteen years as an accountant, I have had the opportunity to interact with many different businesses.&nbsp; Each one of them has presented challenges to me and I have enjoyed the opportunity to work with so many business owners.&nbsp; But due to the economic climate that we are now in, I see that in a couple of years a number of my clients will be gone and I may not be able to maintain the lifestyle that I love.&nbsp; So, I have decided that it is time to provide more services to my clients.</p>\r\n<p>Over my last fifteen years as an accountant, I have had the opportunity to interact with many different businesses.&nbsp; Each one of them has presented challenges to me and I have enjoyed the opportunity to work with so many business owners.&nbsp; But due to the economic climate that we are now in, I see that in a couple of years a number of my clients will be gone and I may not be able to maintain the lifestyle that I love.&nbsp; So, I have decided that it is time to provide more services to my clients.</p>', NULL, 'Providing More Services for my Clients', NULL, NULL),
(4, 4, 'en', 'Forex Education: Top 5 Currency Trading Essentials that can help you to improve your Trading', 'If you are struggling to earn consistent profit in forex exchange market then try these simple but important currency trading essentials because they are definitely going to get you substantial profit in forex currency trading market:\r\n\r\nUse Longer Time Frames – Part time forex traders generally think that they don’t need to select longer time frames for trade. In order to establish good forex trading strategy, you need to trade with longer time frames. Longer trading time frames means that you have to study forex trading charts for the longer duration of time like for 2 or for 4 hours daily.\r\nGive some time to your Trades to Work – This option can only be used by those traders who have effectively sized their trading positions. In currency trading market, prices of the currencies can fluctuate dramatically. While trading currencies in the market, traders need to be sure that they will get reasonable profit at the end of their trade. For instance, if you are trading in a market with 30pips stop loss then there are more chances for you to kick out of the currency trading market.\r\nDo not depend so much on Technical Indicators – Rather than depending so much on technical trading indicators, you need to follow major trends with the help of hop board and simple moving average. All successful forex traders does not completely rely on technical forex trading indicators because these indicators can not accurately predict the future currency trading market as they are based on past events.\r\nStart Trading with Two Major Forex Currency Pairs – Beginner traders should always start with one or two major forex currency pairs. In order to get maximum profit by trading a forex currency pair in the market, you need to gather some basic data of the specific forex currency pair. Never trade with three or more currency pairs in the market because it will almost impossible for you to get necessary knowledge about each forex currency pair.\r\nStop listening to the Trading Giants – The forex currency trading world is full of forex trading gurus and trading giants. You can find these gurus and trading giants giving their free suggestions to immature traders on every forex trading forum. While, these trading gurus might seem to be quiet knowledge but you should never trust on them. A good trader should always believe in his forex trading education. A quality forex education will not only guide you about your forex trading goals but it can also be your best companion.', NULL, 'Forex Education: Top 5 Currency Trading Essentials...', NULL, NULL),
(5, 5, 'en', 'John Thomas Financial – NY’s Brokerage and Financial Company', 'John Thomas Financial is a company that works on the principles of excellence in service, dedication to client success and full integrity. Basically, this means that the company provides every customer with special, customized solutions meant to meet financial goals. It means being able to bring forth immense expertise, research and overall experience with the intention of providing clients with totally sound investment decisions. It works on delivering excellent client service with total drive, energy, and integrity. Suffice it to say that John Thomas Financial intends to help clients achieve general success, since this also means the success of the company. Indeed, every client, whether it is personal or corporate, brings a set of finance investment goals and objectives to John Thomas Financial Company. For the company to meet distinct demands, its investment professionals work to utilize their experience, expertise, and knowledge on financial investment. The company works with clients who are clear about their expectations. It then works out a strategy meant to achieving such goals. John Thomas Financial works with customers going through life changes in the public policy and economic markets. It also works utilizing the goals of the company in the recreation of finance relationships based on client service excellence.\r\n\r\nJohn Thomas Financial provides comprehensive financial services meant to meet an array of investment goals. Such goals include short-term financial trading, portfolio management, market hedging strategies, liquid and income generation. The independent research and analysis of John Thomas Financial when it comes to the capital markets is meant to provide assistance to clients; helping them become fully armed with the appropriate knowledge and help them to be sufficiently-informed when it comes to investment decisions. In having a good view of the big economic environment together with existing market trends and analyses, John Thomas offers actionable views and insights that support financial investment objectives of its clients. The seasoned analysts of the company track down world markets when it comes to real time. The company offers investment experts and professionals with real time analysis of issuing and investment tools, as well as market movements.\r\n\r\nJohn Thomas Financial has Mike Norman as one of its leaders. It is the chief economist of the company. It does calculations on John Thomas Financial with the day-to-day Fiscal Liquidity Index using data on deposits and withdrawals coming from Treasury Statements. The company’s Liquidity Index is available to all clients, traders, advisors and investors on Bloomberg Professional via Bloomberg Terminal. Mike Norman works on doing reports on Economic Outlook. Most experts consider this to be an essential report on consumer sentiment, market outlook and credit cycles. Needless to say, Mike Norman of John Thomas Financial is one of the most trusted experts in financial matters.', NULL, 'John Thomas Financial – NY’s Brokerage and Financial Company', NULL, NULL),
(6, 6, 'en', 'Privacy', 'fsdf sdfsdfsdgfdg ', NULL, 'Privacy', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page-page`
--

CREATE TABLE `page-page` (
  `id` int(11) NOT NULL,
  `pageParentID` int(11) NOT NULL,
  `pageChildID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page-page`
--

INSERT INTO `page-page` (`id`, `pageParentID`, `pageChildID`) VALUES
(1, 1, 2),
(2, 2, 3),
(3, 1, 4),
(4, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `page-route`
--

CREATE TABLE `page-route` (
  `id` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `routeID` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page-route`
--

INSERT INTO `page-route` (`id`, `pageID`, `routeID`, `alias`) VALUES
(1, 2, 1, 'family-banking-tips'),
(2, 3, 4, 'providing-more-services-for-my-clients'),
(3, 4, 1, 'forex-education-top-5-currency-trading-essentials-that-can-help-you-to-improve-your-trading'),
(4, 5, 1, 'john-thomas-financial-nys-brokerage-and-financial-company'),
(5, 6, 3, 'privacy');

-- --------------------------------------------------------

--
-- Table structure for table `page-type`
--

CREATE TABLE `page-type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page-type`
--

INSERT INTO `page-type` (`id`, `name`, `alias`) VALUES
(1, 'Page', 'page'),
(2, 'Post', 'post');

-- --------------------------------------------------------

--
-- Table structure for table `pagination`
--

CREATE TABLE `pagination` (
  `id` int(11) NOT NULL,
  `template` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pagination`
--

INSERT INTO `pagination` (`id`, `template`, `isDeleted`) VALUES
(1, '/page/<:page>', 0),
(2, 'p=<:page>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`id`, `name`, `link`, `priority`, `isDeleted`) VALUES
(1, 'Content', 'content/<:alias>', 1, 0),
(3, 'Common', '<:all>', 3, 0),
(4, 'Subpage', '<:alias>/<:alias>', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `name`, `alias`, `type`, `isDeleted`) VALUES
(1, 'General', 'general-carcass', 'carcass', 0),
(2, 'Main page', 'main-page', 'inner', 0),
(3, 'Post', 'post', 'inner', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parentID` (`parentID`),
  ADD KEY `pageID` (`pageID`),
  ADD KEY `menuTypeID` (`menuTypeID`);

--
-- Indexes for table `menu-language`
--
ALTER TABLE `menu-language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menuID` (`menuID`);

--
-- Indexes for table `menu-type`
--
ALTER TABLE `menu-type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paginationID` (`paginationID`),
  ADD KEY `templateCarcassID` (`templateCarcassID`),
  ADD KEY `templateInnerID` (`templateInnerID`),
  ADD KEY `pageTypeID` (`pageTypeID`);

--
-- Indexes for table `page-extra`
--
ALTER TABLE `page-extra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pageID` (`pageID`);

--
-- Indexes for table `page-language`
--
ALTER TABLE `page-language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pageID` (`pageID`);

--
-- Indexes for table `page-page`
--
ALTER TABLE `page-page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pageParentID` (`pageParentID`),
  ADD KEY `pageChildID` (`pageChildID`);

--
-- Indexes for table `page-route`
--
ALTER TABLE `page-route`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pageID` (`pageID`),
  ADD KEY `routeID` (`routeID`);

--
-- Indexes for table `page-type`
--
ALTER TABLE `page-type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagination`
--
ALTER TABLE `pagination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `menu-language`
--
ALTER TABLE `menu-language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `menu-type`
--
ALTER TABLE `menu-type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `page-extra`
--
ALTER TABLE `page-extra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `page-language`
--
ALTER TABLE `page-language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `page-page`
--
ALTER TABLE `page-page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `page-route`
--
ALTER TABLE `page-route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `page-type`
--
ALTER TABLE `page-type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pagination`
--
ALTER TABLE `pagination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parentID`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `menu_ibfk_2` FOREIGN KEY (`pageID`) REFERENCES `page` (`id`),
  ADD CONSTRAINT `menu_ibfk_3` FOREIGN KEY (`menuTypeID`) REFERENCES `menu-type` (`id`);

--
-- Constraints for table `menu-language`
--
ALTER TABLE `menu-language`
  ADD CONSTRAINT `menu-language_ibfk_1` FOREIGN KEY (`menuID`) REFERENCES `menu` (`id`);

--
-- Constraints for table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`paginationID`) REFERENCES `pagination` (`id`),
  ADD CONSTRAINT `page_ibfk_2` FOREIGN KEY (`templateCarcassID`) REFERENCES `template` (`id`),
  ADD CONSTRAINT `page_ibfk_3` FOREIGN KEY (`templateInnerID`) REFERENCES `template` (`id`),
  ADD CONSTRAINT `page_ibfk_4` FOREIGN KEY (`pageTypeID`) REFERENCES `page-type` (`id`);

--
-- Constraints for table `page-extra`
--
ALTER TABLE `page-extra`
  ADD CONSTRAINT `page-extra_ibfk_1` FOREIGN KEY (`pageID`) REFERENCES `page` (`id`);

--
-- Constraints for table `page-language`
--
ALTER TABLE `page-language`
  ADD CONSTRAINT `page-language_ibfk_1` FOREIGN KEY (`pageID`) REFERENCES `page` (`id`);

--
-- Constraints for table `page-page`
--
ALTER TABLE `page-page`
  ADD CONSTRAINT `page-page_ibfk_1` FOREIGN KEY (`pageParentID`) REFERENCES `page` (`id`),
  ADD CONSTRAINT `page-page_ibfk_2` FOREIGN KEY (`pageChildID`) REFERENCES `page` (`id`);

--
-- Constraints for table `page-route`
--
ALTER TABLE `page-route`
  ADD CONSTRAINT `page-route_ibfk_1` FOREIGN KEY (`pageID`) REFERENCES `page` (`id`),
  ADD CONSTRAINT `page-route_ibfk_2` FOREIGN KEY (`routeID`) REFERENCES `route` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
