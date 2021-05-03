<?php
    require_once("../CRUD/config.php");
    require_once("../Database/marker.class.php");

    if (isset($_REQUEST['lat]']) && isset($_REQUEST['lng'])) {
        $newMarker = new Marker($_REQUEST['lat'], $_REQUEST['lng']);
        $newMarker->saveInDB($conn);
    }
?>