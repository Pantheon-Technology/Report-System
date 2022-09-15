DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS techs;

CREATE TABLE IF NOT EXISTS `admins`(
`username` CHAR(7) NOT NULL,
`password` VARCHAR(20) NOT NULL,
PRIMARY KEY (username)
);

CREATE TABLE IF NOT EXISTS `techs`(
`username` CHAR(7) NOT NULL,
`password` VARCHAR(20) NOT NULL,
PRIMARY KEY (`username`)
);

INSERT INTO `admins` (`username`, `password`) VALUES (`apple`, `orange`)


INSERT INTO `techs` (`username`, `password`) VALUES (`orange`, `apple`)