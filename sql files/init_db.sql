-- create Database
DROP SCHEMA IF EXISTS `adoptapaw`;
CREATE DATABASE `adoptapaw`;

-- create User table
CREATE TABLE `adoptapaw`.`users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(45) DEFAULT NULL,
  `MiddleInitial` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
);

-- create Applicants table
CREATE TABLE `adoptapaw`.`applicants` (
  `ApplicantID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Phone` varchar(45) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  PRIMARY KEY (`ApplicantID`),
  KEY `applicant_UserID_idx` (`UserID`),
  CONSTRAINT `UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`)
);

-- create Manager table
CREATE TABLE `adoptapaw`.`managers` (
  `ManagerID` int(10) unsigned NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ManagerID`),
  KEY `UserID_idx` (`UserID`),
  CONSTRAINT `manager_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- create Admin table
CREATE TABLE `adoptapaw`.`admins` (
  `AdminID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`AdminID`,`UserID`),
  KEY `admin_UserID_idx` (`UserID`),
  CONSTRAINT `admin_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- create Animals table
-- images must be in C:\xampp\htdocs\[project folder]\data\images
CREATE TABLE `adoptapaw`.`animals` (
  `AnimalID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Breed` varchar(45) DEFAULT NULL,
  `Species` varchar(45) DEFAULT NULL,
  `Height` decimal(10,0) DEFAULT NULL,
  `Weight` decimal(10,0) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Arrival_Date` date DEFAULT NULL,
  `Color` varchar(45) DEFAULT NULL,
  `Available` varchar(45) DEFAULT NULL,
  `ImagePath` varchar(45) DEFAULT NULL, 
  PRIMARY KEY (`AnimalID`)
);
  
-- create Application table
CREATE TABLE `adoptapaw`.`applications` (
  `ApplicationID` int(11) NOT NULL AUTO_INCREMENT,
  `ApplicantID` int(11) DEFAULT NULL,
  `AnimalID` int(11) DEFAULT NULL,
  `HomeType` varchar(45) DEFAULT NULL,
  `Employed` varchar(45) DEFAULT NULL,
  `LandlordApproval` varchar(45) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ApplicationID`),
  KEY `application_ApplicantID_idx` (`ApplicantID`),
  KEY `animal_AnimalID_idx` (`AnimalID`),
  CONSTRAINT `animal_AnimalID` FOREIGN KEY (`AnimalID`) REFERENCES `animals` (`AnimalID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `application_ApplicantID` FOREIGN KEY (`ApplicantID`) REFERENCES `applicants` (`ApplicantID`) ON DELETE CASCADE ON UPDATE CASCADE
);
    
-- create Adopters table
CREATE TABLE `adoptapaw`.`adopters` (
  `AdopterID` int(11) NOT NULL AUTO_INCREMENT,
  `ApplicantID` int(11) DEFAULT NULL,
  PRIMARY KEY (`AdopterID`),
  UNIQUE KEY `ApplicantID` (`ApplicantID`),
  CONSTRAINT `adopters_ApplicantID` FOREIGN KEY (`ApplicantID`) REFERENCES `applicants` (`ApplicantID`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- load dummy data from CSV files
-- put dummy CSV files from C:\xampp\htdocs\data\adoptapaw\data\csv in C:\xampp\mysql\data\adoptapaw\
LOAD DATA INFILE 'animals.csv' # change to path of animals.csv
INTO TABLE adoptapaw.animals 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'users.csv' # change to path of users.csv
INTO TABLE adoptapaw.users
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'managers.csv' # change to path of managers.csv
INTO TABLE adoptapaw.managers 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'admins.csv' # change to path of admins.csv
INTO TABLE adoptapaw.admins 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'applicants.csv' # change to path of applicants.csv
INTO TABLE adoptapaw.applicants 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'applications.csv' # change to path of applications.csv
INTO TABLE adoptapaw.applications 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;