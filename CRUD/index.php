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
                <a href="create.php"><button type="submit" class="button">Add user</button></a>
                <a href="../UserInterface/login.php"><button type="submit" class="button">Log Out</button></a>
            </div>
        </nav>
        <?php
        require_once("../Database/database.class.php");
        $conn = new Database("localhost", "root", "", "projecthappyplace");

        echo "<div id=startDiv>";
        echo "<h1 class=center>Project Happy Place: CRUD</h1>";
        echo "<h3 class=center>
                Create or delete users from your Database, 
                update their information or just view their profiles
                </h3>";
        echo "<div id=submitDiv>";
        echo            "<form method=POST>";
        echo            "<label for=username>Enter username: </label>";
        echo            "<input id=username type=text name=username minlength=4 maxlength=8>";
        echo            "<label for=password>Enter password: </label>";
        echo            "<input id=password type=password name=password maxlength=16>";

        echo            "<input type=submit id=submit value=Submit>";
        echo            "</form>";
        echo "</div>";
            
                $adminName = "admin";
                $adminKey = "goodpassword";
                $username = $_POST['username'];
                $password = $_POST['password'];

                $username = $conn->escape($username);
                $password = $conn->escape($password);
                
                    if ($username == $adminName && $password == $adminKey) {
                                
                        session_start();
                        // Storing session data
                        $_SESSION["isLogged"] = "1";
                        

                        require_once("../Database/database.class.php");
                        $conn = new Database("localhost", "root", "", "projecthappyplace");
                        
                        $sql = "SELECT * FROM lernende t1 INNER JOIN ortschaften t2 WHERE Ortschaften_id_Ortschaften=id_Ortschaften";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                                echo "<div id=tableDiv>";
                                    echo "<table class=styled-table>";
                                        echo "<thead>";
                                            echo "<tr>";
                                                echo "<th>ID</th>";
                                                echo "<th>First name</th>";
                                                echo "<th>Last name</th>";
                                                echo "<th>ZIP Code</th>";
                                                echo "<th>City";
                                                echo "<th colspan=2>Actions</th>";
                                            echo "</tr>";
                                        echo "</thead>";
                                        
                                        echo "<tbody>";
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                    echo "<td>" . $row['id_Lernende'] . "</td>";
                                                    echo "<td>" . $row['Vorname'] . "</td>";
                                                    echo "<td>" . $row['Nachname'] . "</td>";
                                                    echo "<td>" . $row['PLZ'] . "</td>";
                                                    echo "<td>" . $row['Name'] . "</td>";
                                                    echo "<td><a href=update.php?id=" . $row['id_Lernende'] . "><button class=updateBTN>Update</button></a></td>";
                                                    echo "<td><a href=delete.php?id=" . $row['id_Lernende'] . "><button class=deleteBTN>Delete</button></a></td>";
                                                    echo "</td>";
                                                echo "</tr>";
                                            }
                                        echo "</tbody>";
                                    echo "</table>";
                                echo "</div>";
                                $result->free();
                            } else {
                                echo "<p class='lead'><em>List empty</em></p>";
                            }
                        $conn->close();
                    } else {
                        exit();
                    }
            ?>
        </div>
        <div id="startDiv">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>Table design by Fabian Dennler</p>
        </div>

        <div id="license">
            <p id="license"></i><a href="https://www.github.com/z-100" target="_blank"><i class="fa fa-github" style="font-size:24px"></i> GitHub</a></p>
            <p id="license"><a href="mailto:marvin131t@gmail.com" target="_blank"><i class="fa fa-envelope" style="font-size:24px"></i> Contact the Dev!</a></p>
            <p id="license"></i><a href="https://twitter.com/Marvin_Gacamole" target="_blank"><i class="fa fa-twitter" style="font-size:24px"></i> Twitter</a></p>
        </div>
    </body>
</html>