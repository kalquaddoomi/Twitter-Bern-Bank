<?php
    session_start();
    if(!isset($_SESSION['access_token'])) {

    }
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="../css/master.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="../js/us-map-1.0.1/raphael.js"></script>
    <script src="../js/us-map-1.0.1/jquery.usmap.js"></script>
    <script src="../js/onready.js"></script>
</head>
<body>

<div class="tbb-nav-control">
    <ul>
        <li id="tbb-view-pm">View Primaries and Caucuses Schedule</li>
        <li id="tbb-view-ff">View my Friends and Followers</li>
        <li id="tbb-manage-ff">Manage Friend and Followers</li>
        <li id="tbb-organize-ff"></li>
    </ul>
</div>

<div class="tbb-page" id="get-started">
</div>

<div class="tbb-page" id="friends-followers-table">
    <ul>

    </ul>
</div>
<div class="tbb-page" id="state-map-view">
    <div id="clicked-state"></div>
    <div id="map" style="width: 300px; height:300px;"></div>
</div>
</body>
</html>

