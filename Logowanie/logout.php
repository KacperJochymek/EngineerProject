<?php
session_start();
require 'config.php';
$_SESSION = [];
session_unset();
session_destroy();
header("Location: /index.php");
