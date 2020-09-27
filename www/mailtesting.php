<?php

require_once('mailmanagement.php');

$inbox = getInbox();

$emails=imap_sort($inbox, SORTDATE, 1);

$m=new Mail($inbox, $emails[1]);

print_r($m);

?>