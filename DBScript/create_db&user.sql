

CREATE DATABASE IF NOT EXISTS 
	`single30_egg_db` 
DEFAULT CHARACTER SET 
	utf8 
COLLATE 
	utf8_general_ci;


GRANT ALL PRIVILEGES ON
	single30_egg_db.*
TO
	'single30_eggapp'@'localhost'
IDENTIFIED BY
	'BaoChangJi';
	
