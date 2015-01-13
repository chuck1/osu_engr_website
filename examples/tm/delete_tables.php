<?php

$query = <<<_END
DROP TABLE IF EXISTS `rymalc-db`.`tm_task_tag`;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
DROP TABLE IF EXISTS `rymalc-db`.`tm_task`;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
DROP TABLE IF EXISTS `rymalc-db`.`tm_tag`;
_END;

query_b($mysql_handle,$query);

$query = <<<_END
DROP TABLE IF EXISTS `rymalc-db`.`tm_status`;
_END;

query_b($mysql_handle,$query);




?>