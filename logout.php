<?php
declare(strict_types=1);
session_start();

// 1. Clear the data for the rest of this request.
$_SESSION = [];

// 2. Tell PHP to discard the server-side session.
session_destroy();

header('Location: index.php');
exit;


?>