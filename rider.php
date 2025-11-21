<?php
session_start();
if ($_SESSION['user']['role'] !== 'rider') die("Unauthorized");
echo "<h2>Rider Dashboard</h2>";
echo "<p>Request delivery assignments</p>";