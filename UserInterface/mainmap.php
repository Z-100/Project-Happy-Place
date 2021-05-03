<?php
require_once("../Database/marker.class.php");
require_once("../Database/database.class.php");

$conn = new Database("localhost", "root", "", "projecthappyplace");


$newMarker = new Marker(9, 46);
//$newMarker->saveInDB($newMarker($conn));

$markers = Marker::getMarker($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Needed html stuff-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>World Map</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="icon" type="image/png" href="img/img.gif">

        <!--Icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <!--Everything needed for the map-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" type="text/css">
        <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
            <style>
            .map {
                height: 400px;
                width: 100%;
            }
            </style>
    </head>

    <body>
        <nav>
        <div id="topNav">
            <h3 id="crntpage">Current page: login</h3>
                <a href="index.php"><button type="submit" class="button">Back to index!</button></a>
                <a href="login.php"><button type="submit" class="button">Register!</button></a>
                <a href="impressum.php"><button type="submit" class="button">Impressum!</button></a>
                <a href="../CRUD/index.php"><button type="submit" class="button">Login</button></a>

            </div>
        </nav>

        <div id="startDiv">
            <h1 class="center">Below this text should be a worldmap</h1>
            <h3 class="">How to navigate through the world:</h3>
            <p class="">
            The navigation with a touchscreen<br>
            Use one finger to just look through the map and two to zoom in on a specific locationon.
            <br><br>
            The navigation with a mouse and a keyboard<br>
            Hold left mousebutton to look around. CTRL + Scrolling zooms in and out of the map
            </p>

            <!--World Map div + JS-->
            <div id="map" class="map">
                <script type="text/javascript">
                        const markerPoints = [<?php
                                                foreach ($markers as $marker) {
                                                    print $marker->toJson();
                                                    print ',';
                                                }
                                            ?>];
                        const features = [];
                        for (let marker of markerPoints) {
                        features.push(new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.fromLonLat([marker.lng, marker.lat]))
                        }));
                        }
                        var markers = new ol.layer.Vector({
                        source: new ol.source.Vector({
                            features: features
                        }),
                        style: new ol.style.Style({
                            image: new ol.style.Icon({
                            anchor: [0.5, 46],
                            anchorXUnits: 'fraction',
                            anchorYUnits: 'pixels',
                            scale: 0.1,
                            src: '../img/marker.png'
                            })
                        })
                        })
                        var map = new ol.Map({
                        target: 'map',
                        layers: [
                            new ol.layer.Tile({
                            source: new ol.source.OSM()
                            }),
                            markers
                        ],
                        view: new ol.View({
                            center: ol.proj.fromLonLat([8.2275, 46.8182]),
                            zoom: 7.5
                        })
                    });
                </script>  
            </div>
        </div>

        <div id="license">
            <p id="license"></i><a href="https://www.github.com/z-100" target="_blank"><i class="fa fa-github" style="font-size:24px"></i> GitHub</a></p>
            <p id="license"><a href="mailto:marvin131t@gmail.com" target="_blank"><i class="fa fa-envelope" style="font-size:24px"></i> Contact the Dev!</a></p>
            <p id="license"></i><a href="https://twitter.com/Marvin_Gacamole" target="_blank"><i class="fa fa-twitter" style="font-size:24px"></i> Twitter</a></p>
        </div>
    </body>
</html>