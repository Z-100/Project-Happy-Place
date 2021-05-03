<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log in</title>
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
                <h1 class="center">Add a user</h1>
            <br>
            <br>
            <br>
            <div id="submitDiv">
                <form action="" method="POST">
                    <label for="PSC">Enter the ZIP Code: </label>
                    <input id="PSC" type="text" name="PSC" minlength="4" maxlength="8">
                    <label for="fname">Enter the first name: </label>
                    <input id="fname" type="text" name="fname" maxlength="16">
                    <label for="surname">Enter the last name: </label>
                    <input id="surname" type="text" name="surname" maxlength="16">

                    <input type="submit" id="submit" value="Submit">
                </form> 
                <?php
                    if ( ! isset( $_SESSION['isLogged'] ) or "1" != $_SESSION['isLogged'] )
                    header('Location: ' . '../1/index.php');
                    
                    require_once "config.php";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        $postal = $_POST['PSC'];
                        $fname = $_POST['fname'];
                        $surname = $_POST['surname'];
                        
                        $nameRegex = "/\w/";
                        $pscRegex = '/[0-9]{4}/';

                        if (preg_match($nameRegex, $fname) == 0 || preg_match($nameRegex, $surname) == 0 || preg_match($pscRegex, $postal) == 0) {
                            echo "<p>Please enter the information needed</p>";
                        } elseif (empty($postal) || empty($fname) || empty($surname)) {
                            echo "<p>Please enter the information needed</p>";
                        } else {
                            echo "<p>Information submitted</p>";
                            echo "<p>Take a look at the <i><a href=mainmap.php>World Map</a></i>!</p>";
                            
                                if (mysqli_connect_error()) {
                                    die('Connection timeout(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
                                } else {

                                    $resultZIP = mysqli_query($conn, "SELECT id_Ortschaften FROM ortschaften WHERE PLZ=$postal");
                                    $newID = mysqli_fetch_array($resultZIP)[0];

                                    $INSERT = "INSERT INTO `lernende` (`Vorname`, `Nachname`, `Ortschaften_id_Ortschaften`) VALUES (\"$fname\",\"$surname\",\"$newID\")";
                                    $conn->query($INSERT);

                                    $resultCoor = mysqli_query($conn, "SELECT Name FROM ortschaften WHERE id_Ortschaften=$newID");   
                                    $newCoor = mysqli_fetch_array($resultCoor)[0];
                                    

                                }
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