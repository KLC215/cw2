CREATE TABLE `lang`(
    `code` CHAR(2) PRIMARY KEY NOT NULL,
    `description` TEXT NOT NULL
);
CREATE TABLE `areas_lang`(
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `lang` CHAR(2) NOT NULL,
    `name` VARCHAR(80) NOT NULL,
    FOREIGN KEY(`lang`) REFERENCES `lang`(`code`)
);
CREATE TABLE `districts_lang`(
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `area` INT NOT NULL,
    `lang` CHAR(2) NOT NULL,
    `name` VARCHAR(80) NOT NULL,
    FOREIGN KEY(`area`) REFERENCES `areas_lang`(`id`),
    FOREIGN KEY(`lang`) REFERENCES `lang`(`code`)
);
CREATE TABLE `stations`(
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `no` INT NOT NULL,
    `img` TEXT NOT NULL
);
CREATE TABLE `stations_lang`(
    `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `station` INT NOT NULL,
    `lang` CHAR(2) NOT NULL,
    `district` INT NOT NULL,
    `location` TEXT NOT NULL,
    `latitude` DECIMAL NOT NULL,
    `longitude` DECIMAL NOT NULL,
    `type` VARCHAR(30) NOT NULL,
    `address` TEXT NOT NULL,
    `provider` VARCHAR(30) NOT NULL,
    `parking_no` VARCHAR(30) NOT NULL,
    FOREIGN KEY(`station`) REFERENCES `stations`(`id`),
    FOREIGN KEY(`lang`) REFERENCES `lang`(`code`),
    FOREIGN KEY(`district`) REFERENCES `districts_lang`(`id`)
);
