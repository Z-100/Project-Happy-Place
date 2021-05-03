<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update user</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="icon" type="image/png" href="img/img.gif">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--Icons-->

        
    </head>
    <body>
        <nav>
            <div id="topNav">
                <a href="index.php"><button type="submit" class="button">Back to overview</button></a>
            </div>
        </nav>
        <div id="startDiv">
                <h1 class="center">
                    <?php 
                        require_once "config.php";
                        $id = $_GET['id'];
                        $sql = "SELECT Vorname, Nachname FROM lernende WHERE id_Lernende=$id";
                        $lol = mysqli_query($conn, $sql);
                        $name = mysqli_fetch_array($lol)[0];
                        echo "Update user: " . $name;
                    ?>
                </h1>
            <br>
            <br>
            <br>
            <div id="submitDiv">
                <form action="" method="POST">
                    <label for="newPSC">Update the ZIP Code: </label>
                    <input id="newPSC" type="text" name="newPSC" minlength="4" maxlength="8">
                    <label for="newFNAME">Update the first name: </label>
                    <input id="newFNAME" type="text" name="newFNAME" maxlength="16">
                    <label for="newSURNAME">Update the last name: </label>
                    <input id="newSURNAME" type="text" name="newSURNAME" maxlength="16">

                    <input type="submit" id="submit" value="Submit">
                </form> 
                <?php
                    error_reporting(E_ERROR | E_PARSE);
                    require_once "config.php";

                    $postal = $_POST['newPSC'];
                    $fname = $_POST['newFNAME'];
                    $surname = $_POST['newSURNAME'];
                
                        $nameRegex = "/\w/";
                        $pscRegex = '/[0-9]{4}/';

                        if (preg_match($nameRegex, $fname) == 0 || preg_match($nameRegex, $surname) == 0 || preg_match($pscRegex, $postal) == 0) {
                            echo "<p>Please enter the information needed</p>";
                        } elseif (empty($postal) || empty($fname) || empty($surname)) {
                            echo "<p>Please enter the information needed</p>";
                        } else {
                            echo "<p>Information updated</p>";
                                if (mysqli_connect_error()) {
                                    die('Connection timeout(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
                                } else {
                                    $resultZIP = mysqli_query($conn, "SELECT id_Ortschaften FROM ortschaften WHERE PLZ=$postal");
                                    $newID = mysqli_fetch_array($resultZIP)[0];
                
                                    $sql = "UPDATE lernende SET Vorname='$fname',Nachname='$surname', Ortschaften_id_Ortschaften='$newID' WHERE id_Lernende=$id";
                                    $lol = mysqli_query($conn, $sql);
                                    $conn->close();
                                }
                            }                    
                ?>
            </div>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>

        <div id="license">
            <p id="license"></i><a href="https://www.github.com/z-100" target="_blank"><i class="fa fa-github" style="font-size:24px"></i> GitHub</a></p>
            <p id="license"><a href="mailto:marvin131t@gmail.com" target="_blank"><i class="fa fa-envelope" style="font-size:24px"></i> Contact the Dev!</a></p>
            <p id="license"></i><a href="https://twitter.com/Marvin_Gacamole" target="_blank"><i class="fa fa-twitter" style="font-size:24px"></i> Twitter</a></p>
        </div>
    </body>
</html>