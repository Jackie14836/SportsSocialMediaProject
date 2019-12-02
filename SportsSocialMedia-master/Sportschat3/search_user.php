<?php
session_start();
include 'connection.php';
if(isset($_SESSION['username'])) {
    $user =  $_SESSION['username'];
    ?>

    <!doctype html>
    <html>
    <head>
        <title>Profile</title>
    </head>
    <style>
        <?php require_once("profile_style.php");?>
        #search{
            margin:20px;
        }
        button{
            font:  bold 16px/1 sans-serif;
            border-radius: 10px;
            padding: 10px 12px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
        }
        input[type=text] {
            font:  18px/1 sans-serif;
            padding:5px 5px;
            border-radius: 10px;
        }
    </style>
    <body>
    <div class="topbar">
        <img src="images/navbar.jpg">
    </div>
    <div class="topnav">
        <a href="home.php">Home</a>
        <div class="topnav-center">
            <?php
            echo '<a class ="chat" href="php-chat/index.php">Join Sports Chat Now</a>';
            ?>
        </div>
        <div class="topnav-right">
            <?php
            echo '<a href="profile.php">Profile</a>';
            ?>
            <?php
            echo '<a href="logout.php">Log out</a>';
            ?>
        </div>
    </div>
    <div id = "search">
        <h1>Search User</h1>
        <form method="POST" action="display_profile.php">
            <input type="text" class="form-control" name="user" placeholder="Search" required="required"/>
            <button class="btn btn-success" name="search">Search</button>
        </form>
    </div>
    </body>
    </html>

    <?php

}else{
    header("location:login.php");
}

?>