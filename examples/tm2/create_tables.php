<?php

$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`tm2_event_type` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` VARCHAR(512) NOT NULL UNIQUE
)
ENGINE = InnoDB;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`tm2_task` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`short_desc` VARCHAR(256) NOT NULL,
`long_desc` VARCHAR(2048) NOT NULL,
`start` TIMESTAMP,
`end` TIMESTAMP,
`priority` INT NOT NULL,
`user_id` INT NOT NULL,
FOREIGN KEY (`user_id`) REFERENCES `users` (id)
)
ENGINE = InnoDB;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`tm2_tag` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` VARCHAR(512) NOT NULL
)
ENGINE = InnoDB;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`tm2_task_tag`
(
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`task_id` INT NOT NULL,
`tag_id` INT NOT NULL,
FOREIGN KEY (`task_id`) REFERENCES `tm2_task` (id),
FOREIGN KEY (`tag_id`) REFERENCES `tm2_tag` (id)
)
ENGINE = InnoDB;
_END;

query_b($mysql_handle,$query);




$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`tm2_event`
(
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`task_id` INT NOT NULL,
	`event_type_id` INT NOT NULL,
	`ts` TIMESTAMP,
	`i` INT,
	FOREIGN KEY (`task_id`) REFERENCES `tm2_task` (id),
	FOREIGN KEY (`event_type_id`) REFERENCES `tm2_event_type` (id)
)
ENGINE = InnoDB;
_END;

query_b($mysql_handle,$query);

?>