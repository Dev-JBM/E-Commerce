<?php
session_start();

if (isset($_SESSION['username'])) {
    echo htmlspecialchars($_SESSION['username']);
} else {
    echo "Guest";
}
