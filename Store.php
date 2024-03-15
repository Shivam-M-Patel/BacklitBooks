<!DOCTYPE html>
<?php
session_start();
$searchbar = true;


// Page is set to Store (store.php) by default, so when the user visits that will be the page they see.
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'Storefront';
// Include and show the requested page
include $page . '.php';
?>
