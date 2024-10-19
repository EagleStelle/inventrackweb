<?php

session_start();
session_destroy();

header("Location: /inventrackweb/login.html");
exit;

?>