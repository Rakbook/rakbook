<?php

require_once('dbutils.php');

easyQuery('DELETE FROM authtokens WHERE expires<NOW()');

echo 'Cleanup complete';
?>