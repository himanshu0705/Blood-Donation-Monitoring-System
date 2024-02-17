SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `donors` (
  `id` int(10) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `dob` date NOT NULL,
  `sex` varchar(10) NOT NULL,
  `bloodgroup` varchar(10) NOT NULL,
  `mobile` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `lastdate` timestamp NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE  `registration` (
  `rid` int(10) NOT NULL,
  `username` varchar(20) UNIQUE NOT NULL,
  `password` varchar(40) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE  `location` (
  `loc_id` int(10) NOT NULL,
  `town` varchar(20) DEFAULT NULL,
  `state` varchar(30) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE  `blood` (
  `type` varchar(10) PRIMARY KEY,
  `count` int(10)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `registration`
  ADD PRIMARY KEY (`rid`);

ALTER TABLE `location`
  ADD PRIMARY KEY (`loc_id`);

ALTER TABLE `donors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1;
COMMIT;

ALTER TABLE `registration`
  MODIFY `rid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1;
COMMIT;

ALTER TABLE `location`
  MODIFY `loc_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1;
COMMIT;