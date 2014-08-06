<?php

$ROOT = "/nfs/raven/u1/r/rymalc/public_html/tm2/";
$HTTP_ROOT = "http://people.oregonstate.edu/~rymalc/tm2/";

require_once $ROOT . "../initialize.php";


$query = <<<_END
INSERT INTO `rymalc-db`.`tm_status`
(
name
)
VALUES
('active'),('cancelled'),('complete')
_END;

query_b($mysql_handle,$query);

?>