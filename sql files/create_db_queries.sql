-- create User table
CREATE TABLE `users` (
    `UserID` INT NOT NULL AUTO_INCREMENT,
    `Email` VARCHAR(100) NULL,
    `Password` VARCHAR(45) NULL,
    `FirstName` VARCHAR(45) NULL,
    `LastName` VARCHAR(45) NULL,
    `MiddleInitial` VARCHAR(45) NULL,
    PRIMARY KEY (`UserID`)
);

-- create Applicant table
CREATE TABLE `applicants` (
    `ApplicantID` INT NOT NULL AUTO_INCREMENT,
    `UserID` INT NOT NULL,
    `Address` VARCHAR(100) DEFAULT NULL,
    `Phone` VARCHAR(45) DEFAULT NULL,
    `DOB` DATE DEFAULT NULL,
    PRIMARY KEY (`ApplicantID`),
    KEY `applicant_UserID_idx` (`UserID`),
    CONSTRAINT `UserID` FOREIGN KEY (`UserID`)
        REFERENCES `users` (`UserID`)
);

-- create Manager table
CREATE TABLE `managers` (
    `ManagerID` INT(10) UNSIGNED ZEROFILL NOT NULL,
    `UserID` INT DEFAULT NULL,
    PRIMARY KEY (`ManagerID`),
    KEY `UserID_idx` (`UserID`),
    CONSTRAINT `manager_UserID` FOREIGN KEY (`UserID`)
        REFERENCES `users` (`UserID`)
        ON DELETE CASCADE ON UPDATE CASCADE
);

 # create Admin table
 CREATE TABLE `admins` (
  `AdminID` INT NOT NULL AUTO_INCREMENT,
  `UserID` INT NULL,
  PRIMARY KEY (`AdminID`),
  INDEX `admin_UserID_idx` (`UserID` ASC),
  CONSTRAINT `admin_UserID`
    FOREIGN KEY (`UserID`)
    REFERENCES `users` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE TABLE `animals` (
    `AnimalID` INT NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(45) NULL,
    `Breed` VARCHAR(45) NULL,
    `Species` VARCHAR(45) NULL,
    `Height` DECIMAL NULL,
    `Weight` DECIMAL NULL,
    `DOB` DATE NULL,
    `Arrival_Date` DATE NULL,
    `Color` VARCHAR(45) NULL,
    `Available` VARCHAR(45) NULL,
    PRIMARY KEY (`AnimalID`)
);
  
  # create Application table
  CREATE TABLE `applications` (
  `ApplicationID` INT NOT NULL AUTO_INCREMENT,
  `ApplicantID` INT NULL,
  `AnimalID` INT NULL,
  `HomeType` VARCHAR(45) NULL,
  `Employed` VARCHAR(45) NULL,
  `LandlordApproval` VARCHAR(45) NULL,
  `Date` DATE NULL,
  `Status` VARCHAR(45) NULL,
  PRIMARY KEY (`ApplicationID`),
  INDEX `application_ApplicantID_idx` (`ApplicantID` ASC),
  INDEX `animal_AnimalID_idx` (`AnimalID` ASC),
  CONSTRAINT `application_ApplicantID`
    FOREIGN KEY (`ApplicantID`)
    REFERENCES `applicants` (`ApplicantID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `animal_AnimalID`
    FOREIGN KEY (`AnimalID`)
    REFERENCES `animals` (`AnimalID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    
# create AdopterTable
CREATE TABLE `adopters` (
  `AdopterID` INT NOT NULL AUTO_INCREMENT,
  `ApplicantID` INT NULL,
  PRIMARY KEY (`AdopterID`),
  INDEX `adopter_ApplicantID_idx` (`ApplicantID` ASC),
  CONSTRAINT `adopter_ApplicantID`
    FOREIGN KEY (`ApplicantID`)
    REFERENCES `applicants` (`ApplicantID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

