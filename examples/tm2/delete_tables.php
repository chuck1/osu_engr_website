<?php

$query = <<<_END
DROP TABLE IF EXISTS `rymalc-db`.`tm2_task_tag`;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
DROP TABLE IF EXISTS `rymalc-db`.`tm2_task_event`;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
DROP TABLE IF EXISTS `rymalc-db`.`tm2_task`;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
DROP TABLE IF EXISTS `rymalc-db`.`tm2_tag`;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
DROP TABLE IF EXISTS `rymalc-db`.`tm2_event`;
_END;

query_b($mysql_handle,$query);




?>