<?php

$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`tm_status` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` VARCHAR(512) NOT NULL
)
ENGINE = InnoDB;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`tm_task` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`short_desc` VARCHAR(256) NOT NULL,
`long_desc` VARCHAR(2048) NOT NULL,
`timestamp_created` TIMESTAMP,
`timestamp_start` TIMESTAMP,
`timestamp_end` TIMESTAMP,
`status_id` INT NOT NULL,
`priority` INT NOT NULL,
FOREIGN KEY (`status_id`) REFERENCES `tm_status` (id)
)
ENGINE = InnoDB;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`tm_tag` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` VARCHAR(512) NOT NULL
)
ENGINE = InnoDB;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`tm_task_tag`
(
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`task_id` INT NOT NULL,
`tag_id` INT NOT NULL,
FOREIGN KEY (`task_id`) REFERENCES `tm_task` (id),
FOREIGN KEY (`tag_id`) REFERENCES `tm_tag` (id)
)
ENGINE = InnoDB;
_END;

query_b($mysql_handle,$query);

?>