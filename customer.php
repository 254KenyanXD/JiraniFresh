<?php
session_start();
if ($_SESSION['user']['role'] !== 'customer') die("Unauthorized");
echo "<h2>Customer Dashboard</h2>";
echo "<p>View your orders and update address</p>";