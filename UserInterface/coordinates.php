<?php
/**
 * Strassenkoordinaten über Nominatim API abfragen.
 * Vorlage für Lernende
 */
require_once("../Database/database.class.php");
$dblink = new Database('localhost', 'root', '', 'projecthappyplace');

// CHANGES MADE BELOW THIS LINE ARE AT OWN RISK //

// Query to fetch randomly one place without coordinates
$places = "SELECT * FROM ortschaften ". 
          "WHERE ( latitude is NULL OR latitude='') " .
          "AND ( longitude is NULL OR longitude='') " .
          "ORDER BY RAND() LIMIT 1;";

if (mysqli_connect_error()) {
    die('Connect Error (' . $dblink->connect_errno . ') ' . $dblink->connect_error);
}

if ($result = $dblink->query($places)) {
  while($row = $result->fetch_object()) {
    $id_ortschaften = $row->Name;
    $coord = nominatimCoordinates($row->Name . ",Schweiz"); // Restrict to switzerland
  }
} else {
  $dblink->close();
  die('Query Error (' . $dblink->errno . ') ' . $dblink->error);
}

if ($id_ortschaften > 0) {
  $update = sprintf("UPDATE places SET %s WHERE id=%d", $coord, $it_ortschaften);
  if(!$dblink->query($update)) {
    echo ('Query Error (' . $dblink->errno . ') ' . $dblink->error);
  }
}

$dblink->close();


function nominatimCoordinates($search) {
  $sql = "";
  // &osm_type=way => Only fetch roads
  $base = "https://nominatim.openstreetmap.org/search?q=%s&osm_type=way&format=json";
  $useragent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
  $referer   = "https://www.zli.ch";

  $url = sprintf($base, $search);

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_USERAGENT, $useragent);
  curl_setopt($curl, CURLOPT_REFERER, $referer);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $response = curl_exec($curl);
  $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  curl_close($curl);

  if ($httpcode == 200) {
      $response = json_decode($response, true);
      // Build SQL UPDATE query;
      $sql = "latitude='".$response[0]['lat']."', longitude='".$response[0]['lon']."'";
  } else {
      echo 'ERROR: ' . $httpcode;
  }
  return $sql;
}


?>
