<?php
    require_once "config.php";

    $id = $_GET['id'];
    $sql = "DELETE FROM lernende WHERE id_Lernende = $id";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (mysqli_connect_error()) {
            die('Connection timeout(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
            $conn->close();
        } else {
            $conn->query($sql);
            $conn->close();
            header("Location: index.php");
        }
    }
?>