<?php
session_start();
session_unset();
session_destroy();

header("Location: espace_membre.php");
exit();
?>