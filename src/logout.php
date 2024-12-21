<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: /~S5146769/');
