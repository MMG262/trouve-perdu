<?php
session_start();
require_once __DIR__ . '/../includes/auth.php';

require_login();

session_destroy();
header('Location: login.php');
exit;
