<?php
    $errors = [];
    if(!isset($_SESSION['username'])) {
        if(isset($_POST['submitted'])) {
            $pword;
            $pword2;
            if (!isset($_POST["uname"]) || empty($_POST["uname"])) {
                $errors[] = "no uname";
            }
            if (!isset($_POST["email"]) || empty($_POST["email"])) {
                $errors[] = "no email";
            }
            if (!isset($_POST["pword"]) || empty($_POST["pword"])) {
                $errors[] = "no password";
            } else {
                $pword = $_POST["pword"];
            }
            if (!isset($_POST["pword2"]) || empty($_POST["pword2"])) {
                    $errors[] = "no password2";
            } else {
                $pword2 = $_POST["pword2"];
            }
            if(!empty($pword)&&!empty($pword2)&& $pword!=$pword2) {
                $errors[] = "passwords not equal";
            }
            if (!isset($_POST["vname"]) || empty($_POST["vname"])) {
                $errors[] = "no vname";
            }
            if (!isset($_POST["nname"]) || empty($_POST["nname"])) {
                $errors[] = "no nname";
            }
            if (!isset($_POST["agb"]) || empty($_POST["agb"])) {
                $errors[] = "no agb";
            }
            if(empty($errors)){
                $hashvalue = password_hash($_POST['pword'], PASSWORD_DEFAULT);
                require_once ('dbaccess.php'); //to retrieve connection details
                $db_obj = new mysqli($host, $user, $password, $database); //Datenbankverbindung aufbauen
                $sql = "INSERT INTO `guests` (`username`, `password`, `e-mail`, `vorname`, `nachname`)VALUES (?, ?, ?, ?, ?)"; //SQL-Statement erstellen
                $stmt = $db_obj->prepare($sql); //SQL-Statement „vorbereiten”
                $stmt-> bind_param("sssss", $uname, $pass, $mail, $vname, $nname); //Parameter binden
                $uname = $_POST['uname'];$pass = $hashvalue;$mail = $_POST['email'];$vname = $_POST['vname'];$nname = $_POST['nname'];//Variablen mit Werte versehen
               $stmt->execute(); //Statement ausführen
               $stmt->close();
               $db_obj->close();
                echo 'Erfolgreich angemeldet!<a href="?site=login">Hier einloggen!</a>';
            }
        }
    ?>
    <div  style="text-align:center">
        <h2 >REGISTRIERUNG</h2>
        <div >
        <form id="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?site=register" method="post">
            <div class="row">
                <div class="col-sm-6">
                    <fieldset>
                        <legend><strong>Benutzer Daten:</strong></legend>
                        <label for="uname">*Username:</label>
                        <input type="text" id="uname" placeholder="Username" name="uname"><br>
                        <?php 
                            if(in_array("no uname", $errors))
                                echo '<p class="text-danger">*Kein Benutzername</p>';
                        ?>
                        <label for="pword">*Password:</label>
                        <input type="password" id="pword" placeholder="Password" name="pword"><br>
                        <?php 
                            if(in_array("no password", $errors))
                                echo '<p class="text-danger">*Kein Kennwort</p>';
                        ?>

                        <label for="pword2">*Password-Wiederholung:</label>
                        <input type="password" id="pword2" placeholder="Password" name="pword2"><br>
                        <?php 
                            if(in_array("no password2", $errors))
                                echo '<p class="text-danger">*Keine Kennwortwiederholung</p>';
                            if(in_array("passwords not equal", $errors))
                                echo '<p class="text-danger">*Kennwörter nicht gleich!</p>';
                        ?>

                        <label for="email">*Enter your email:</label>
                        <input type="email" id="email" name="email">
                        <?php 
                            if(in_array("no email", $errors))
                                echo '<p class="text-danger">*Keine E-mailadresse</p>';
                        ?>
                    </fieldset>
                </div>
                <div class="col-sm-6">
                    <fieldset>
                        <legend><strong>Persönliche Daten:</strong></legend>
                        <label for="anrede">Anrede:</label>
                        <select id="anrede" form="register" name="anrede">
                            <option>bitte wählen</option>
                            <option value="frau" >Frau</option>
                            <option value="herr" name="anrede">Herr</option>
                        </select><br><br>
                        <label for="vorname">*Vorname:</label>
                        <input type="text" id="vorname" name="vname" placeholder="Vorname"><br>
                        <?php 
                            if(in_array("no vname", $errors))
                                echo '<p class="text-danger">*Kein Vorname</p>';
                        ?>
                        <label for="nachname">*Nachname:</label>
                        <input type="text" id="nachname" name="nname" placeholder="Nachname"><br>
                        <?php 
                            if(in_array("no nname", $errors))
                                echo '<p class="text-danger">*Kein Nachname</p>';
                        ?>
                    </fieldset>
                </div>
                <div class="col-12">
                    <input type="checkbox" id="agb" name="agb" value="agb">
                    <label id="agb" for="agb"> Ich bin damit einverstanden, dass diese Daten zur Anmeldung benutzt werden.</label><br>
                    <?php 
                            if(in_array("no agb", $errors))
                                echo '<p class="text-danger">*AGB muss akzeptiert werden!</p>';
                        ?>
                    <input type="submit" name="submitted" value="Anmelden"><br><br><br>
                </div>
            </div>
        </form>
    </div>
    </div>
<?php
} else if ($_SESSION["username"] == 'gast') {
    if (isset($_POST['submitted'])) {
        $pword;
        $pword2;
        if (!isset($_POST["uname"])) {
            $errors[] = "no uname";
        }
        if (!isset($_POST["email"])) {
            $errors[] = "no email";
        }
        if (!isset($_POST["pword"]) || $_POST["pword"] != "gast") {
            $errors[] = "old password";
        } else {
            $pword = $_POST["pword"];
        }
        if (!isset($_POST["pword2"])) {
            $errors[] = "no password2";
        } else {
            $pword2 = $_POST["pword2"];
        }
        if (!isset($_POST["vname"])) {
            $errors[] = "no vname";
        }
        if (!isset($_POST["nname"])) {
            $errors[] = "no nname";
        }
        if (!isset($_POST["agb"]) || empty($_POST["agb"])) {
            $errors[] = "no agb";
        }
    }
    ?>
    <div  style="text-align:center">
        <h2 >Daten bearbeiten</h2>
        <div >
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?site=register" method="post">
            <div class="row">
                <div class="col-sm-6">
                    <fieldset>
                        <legend><strong>Benutzer Daten:</strong></legend>
                        <label for="uname">*Username:</label>
                        <input type="text" id="uname" placeholder="Gast" name="uname"><br>
                        <?php
                        if (in_array("no uname", $errors))
                            echo '<p class="text-danger">*Kein Benutzername</p>';
                        ?>
                        <label for="pword">*Altes Password:</label>
                        <input type="password" id="pword" placeholder="Password" name="pword"><br>
                        <?php
                        if (in_array("old password", $errors))
                            echo '<p class="text-danger">*Altes Kennwort eingeben</p>';
                        ?>

                        <label for="pword2">*Neues Password:</label>
                        <input type="password" id="pword2" placeholder="Password" name="pword2"><br>
                        <?php
                        if (in_array("no password2", $errors))
                            echo '<p class="text-danger">*Kein neues Kennwort</p>';
                        ?>

                        <label for="email">*Enter your email:</label>
                        <input type="email" id="email" name="email" placeholder="gast@gmail.com">
                        <?php
                        if (in_array("no email", $errors))
                            echo '<p class="text-danger">*Keine E-mailadresse</p>';
                        ?>
                    </fieldset>
                </div>
                <div class="col-sm-6">
                    <fieldset>
                        <legend><strong>Persönliche Daten:</strong></legend>
                        <label for="anrede">Anrede:</label>
                        <select id="anrede">
                            <option value="waehlen">bitte wählen</option>
                            <option value="frau" name="anrede">Frau</option>
                            <option value="herr" name="anrede">Herr</option>
                        </select><br><br>
                        <label for="vorname">*Vorname:</label>
                        <input type="text" id="vorname" name="vname" placeholder="Max"><br>
                        <?php
                        if (in_array("no vname", $errors))
                            echo '<p class="text-danger">*Kein Vorname</p>';
                        ?>
                        <label for="nachname">*Nachname:</label>
                        <input type="text" id="nachname" name="nname" placeholder="Mustermann"><br>
                        <?php
                        if (in_array("no nname", $errors))
                            echo '<p class="text-danger">*Kein Nachname</p>';
                        ?>
                    </fieldset>
                </div>
                <div class="col-12">
                    <input type="checkbox" id="agb" name="agb" value="agb">
                    <label id="agb" for="agb">Änderung bestätigen</label><br>
                    <?php
                    if (in_array("no agb", $errors))
                        echo '<p class="text-danger">*Änderung muss bestätigt werden!</p>';
                    ?>
                    <input type="submit" name="submitted" value="Absenden"><br><br><br>
                </div>
            </div>
        </form>
    </div>
    </div>
<?php
    }else if($_SESSION['username']=='admin') {
        echo '<h2>USER</h2>';
        require_once ('dbaccess.php'); //to retrieve connection details
        $conn = new mysqli($host, $user, $password, $database); //Datenbankverbindung aufbauen
        $sql = "SELECT * FROM guests";
        $result = $conn->query($sql);
        echo "<table border='1'>";
        echo "<tr><th>UserID</th><th>Name</th><th>Password</th><th>e-mail</th><th>Anrede</th><th>Vorname</th><th>Nachname</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['UserID'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "<td>" . $row['e-mail'] . "</td>";
            echo "<td>" . $row['Anrede'] . "</td>";
            echo "<td>" . $row['vorname'] . "</td>";
            echo "<td>" . $row['nachname'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $conn->close();
    }else{
        ?>
                    <div style="text-align:center">
                        <p>Du bist nicht als User eingeloggt</p>
                        <a href="?site=login">Hier einloggen!</a>
                    </div>
<?php
    }
?>