<?php
// Error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$F2UF = "tebOCBsYaEC\$F2UF"; // Define $F2UF with the correct password here
// Get the environment variables
$server = "mibodywebapp-server.mysql.database.azure.com";
$username = "zrpvczwzph";
$password = $F2UF; // Use $F2UF here
$database = "mibodywebapp-database";

// Initialize the MySQL connection
$con = mysqli_init();

// Connect to the MySQL database
if (!$con) {
    die("mysqli_init failed");
}

if (!mysqli_real_connect($con, $server, $username, $password, $database, 3306)) {
    die("Connect Error (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
}

echo "Connected successfully";
?>

<!DOCTYPE html>
<html lang="de">
<title>MiBody</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Styles/css.css">
<link rel="stylesheet" href="Styles/fonts.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>

<div style="position:absolute; height: 100%" id="aux"></div>
<!-- Auhentication -->
<div id="authenticationPanel" class="modal" style="display: <?php if (isset($user_data)) echo "none";
else echo "block" ?>">
    <div class="modal-content animate-top card-4">
        <div id="logIn" style="display: block">
            <header class="container white center padding-32">
                <h2 class="wide"><i class="fa fa-sign-in margin-right"></i>Einloggen</h2>
            </header>
            <div class="container">
                <form method="post">
                    <p><label><i class="fa fa-envelope"></i> Email:</label></p>
                    <input class="input border" type="email" name="logInEmail" placeholder="Email eingeben" required>
                    <p><label><i class="fa fa-key"></i> Passwort:</label></p>
                    <input class="input border" type="password" name="logInPassword" placeholder="******" required>
                    <input class="button block teal padding-16 section right" type="submit" value="Einloggen"
                           onclick="<?php if (isset($_POST['logInEmail']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                               $email = $_POST['logInEmail'];
                               $password = $_POST['logInPassword'];
                               $query = "select * from users where email = '$email' limit 1";
                               $result = mysqli_query($con, $query);
                               if ($result && mysqli_num_rows($result) > 0) {
                                   $user_data = mysqli_fetch_assoc($result);
                                   if ($user_data['password'] === $password) {
                                       $_SESSION['user_id'] = $user_data['user_id'];
                                       header("Location: index.php");
                                       die;
                                   } else {
                                       echo "alert('Wrong password!')";
                                   }
                               }
                           } ?>">
                    <p class="right">Haben Sie kein Konto? <a style="cursor: pointer" class="text-blue"
                                                              onclick="document.getElementById('signUp').style.display='block'; document.getElementById('logIn').style.display='none'">Registrieren</a>
                    </p><br><br>
                </form>
            </div>
        </div>
        <div id="signUp" style="display: none">
            <header class="container white center padding-32">
                <h2 class="wide"><i class="fa fa-sign-in margin-right"></i>Registrieren</h2>
            </header>
            <div class="container">
                <form method="post">
                    <p><label><i class="fa fa-user"></i> Name:</label></p>
                    <input class="input border" type="text" name="signUpName" placeholder="Name eingeben" required>
                    <p><label><i class="fa fa-envelope"></i> Email:</label></p>
                    <input class="input border" type="email" name="signUpEmail" placeholder="Email eingeben" required>
                    <p><label><i class="fa fa-key"></i> Passwort:</label></p>
                    <input class="input border" type="password" name="signUpPassword" placeholder="******" required>
                    <input class="button block teal padding-16 section right" value="Einloggen" type="submit"
                           onclick="<?php if (isset($_POST['signUpEmail']) && isset($_POST['signUpName']) && isset($_POST['signUpPassword'])) {
                               $email = $_POST['signUpEmail'];
                               $user_name = $_POST['signUpName'];
                               $password = $_POST['signUpPassword'];
                               $user_id = random_num(20);
                               $query = "insert into users (user_id,username,password,email) values ('$user_id','$user_name','$password','$email')";
                               mysqli_query($con, $query);
                               echo "document.getElementById('signUp').style.display='none'; document.getElementById('logIn').style.display='block'";
                           } ?>">
                    <p class="right">Haben Sie ein Konto? <a style="cursor: pointer" class="text-blue"
                                                             onclick="document.getElementById('signUp').style.display='none'; document.getElementById('logIn').style.display='block'">Einloggen</a>
                    </p><br><br>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Navbar -->
<div class="top">
    <div class=" black card">
        <a class="bar-item button padding-large hide-medium hide-large right" href="javascript:void(0)"
           onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
        <a href="#" class="bar-item button padding-large">MiBODY</a>
        <a href="#anatomy" class="bar-item button padding-large hide-small">ANATOMIE</a>
        <a href="#aboutUs" class="bar-item button padding-large hide-small">ÜBER UNS</a>
        <a href="#contact" class="bar-item button padding-large hide-small">CONTACT</a>
        <a href="logout.php" style="text-decoration: none"
           class="padding-large hover-red hide-small right"><?php if (isset($user_data)) echo $user_data['username'] ?>
            <i class="fa fa-sign-out"></i></a>
    </div>
</div>

<!-- Navbar on small screens (remove the onclick attribute if you want the navbar to always show on top of the content when clicking on the links) -->
<div id="navDemo" class="bar-block black hide hide-large hide-medium top" style="margin-top:46px">
    <a href="#aboutUs" class="bar-item button padding-large" onclick="myFunction()">ÜBER UNS</a>
    <a href="#contact" class="bar-item button padding-large" onclick="myFunction()">CONTACT</a>
    <a href="#anatomy" class="bar-item button padding-large" onclick="myFunction()">ANATOMIE</a>
    <a href="logout.php" class="bar-item button padding-large"
       onclick="myFunction()"><?php if (isset($user_data)) echo $user_data['username'] ?><br>LOG OUT</a>
</div>

<!-- Page content -->
<div class="content" style="max-width:2000px;margin-top:46px;">

    <!-- Automatic Slideshow Images -->
    <div class="mySlides display-container center">
        <img src="Assets/Images/images_jpg/slide_1.jpg" class="slide" alt="KopfUndHalsModel">
        <div class="display-bottommiddle container text-white padding-32 hide-small">
            <h3>Kopf- und Halsmodell</h3>
            <p><b>KONSEQUENTE MODELLAKTUALISIERUNGEN HALTEN UNS KOPF UND SCHULTERN ÜBER DEM REST, UND DIES IST KEINE
                    AUSNAHME</b></p>
        </div>
    </div>
    <div class="mySlides display-container center">
        <img src="Assets/Images/images_jpg/slide_2.jpg" class="slide" alt="NetzHautSchichten">
        <div class="display-bottommiddle container text-white padding-32 hide-small">
            <h3>Netzhautschichten</h3>
            <p><b>MACHEN SIE SICH EIN BILD VON UNSEREM RETINAL LAYERS-MODELL</b></p>
        </div>
    </div>
    <div class="mySlides display-container center">
        <img src="Assets/Images/images_jpg/slide_3.jpg" class="slide" alt="Meningen">
        <div class="display-bottommiddle container text-white padding-32 hide-small">
            <h3>Kopfhaut & Meningen</h3>
            <p><b>ZIEHEN SIE DIE FÜNF SCHICHTEN DER KOPFHAUT VIRTUELL AB, BEVOR SIE ZU DEN SCHICHTEN DER DURA MATER
                    ÜBERGEHEN.</b></p>
        </div>
    </div>

    <!-- The Learn Section -->
    <div class="black" id="anatomy">
        <div class="container content padding-64" style="max-width:800px">
            <h2 class="wide center">ANATOMIE</h2>
            <p class="opacity center"><i>Etwas, das jeder hat, das aber bei Mädchen besser aussieht.</i></p><br>

            <div class="row-padding padding-32" style="margin:0 -16px">
                <a href="Pages/Category_1.html" target="discoverBody">
                    <div class="third margin-bottom white"
                         onclick="showLearnFrames()">
                        <center><img src="Assets/Images/images_png/category-1/category-1.png" alt="Skeleton"
                                     style="height:400px; margin-top: 10%;" class="hover-opacity"></center>
                        <div class="container white" style="text-align: center;">
                            <p><b>Skelett</b></p>
                            <p class="opacity">Skeleton</p>
                            <p>Als Skelett bezeichnet man die Gesamtheit der Knochen eines Organismus und damit das zum
                                Aufbau des Körpers benötigte Stützgerüst.</p><br>
                            <button class="button black margin-bottom"
                                    onclick="document.getElementById('discoverMode').style.display='block'">Entdecken
                            </button>
                        </div>
                    </div>
                </a>
                <a href="Pages/Category_2.html" target="discoverBody">
                    <div class="third margin-bottom"
                         onclick="showLearnFrames()">
                        <center><img src="Assets/Images/images_png/category-2/category-2.png" alt="Muscles"
                                     style="height:400px; margin-top: 10%;" class="hover-opacity"></center>
                        <div class="container white" style="text-align: center;">
                            <p><b>Muskeln</b></p>
                            <p class="opacity">Muscles</p>
                            <p>Als Muskeln bezeichnet man die kontraktilen Organe des menschlichen Körpers, deren
                                Aufgabe darin besteht, Teile des Körpers aktiv zu bewegen.</p>
                            <button class="button black margin-bottom"
                                    onclick="document.getElementById('discoverMode').style.display='block'">Entdecken
                            </button>
                        </div>
                    </div>
                </a>
                <a href="Pages/Category_3.html" target="discoverBody">
                    <div class="third margin-bottom"
                         onclick="showLearnFrames()">
                        <center><img src="Assets/Images/images_png/category-3/category-3.png" alt="Organs"
                                     style="height:400px; margin-top: 10%;" class="hover-opacity"></center>
                        <div class="container white" style="text-align: center;">
                            <p><b>Organe</b></p>
                            <p class="opacity">Organs</p>
                            <p>Ein Organ ist ein spezialisierter Teil des Körpers, der sich aus unterschiedlichen Zellen
                                und Geweben zusammensetzt.</p><br>
                            <button class="button black margin-bottom"
                                    onclick="document.getElementById('discoverMode').style.display='block'">Entdecken
                            </button>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Learn Frames -->
    <div id="discoverMode" class="modal">
        <div id="discoverContent" class="modal-content animate-top card-4">
            <header class="container white center padding-32">
                <span onclick="document.getElementById('discoverMode').style.display='none'"
                      class="button white xlarge display-topright">✖</span>
                <span onclick="toggleFullScreen()"
                      class="button white xlarge" style="position: absolute; top: 0; right: 40px">▣</span>
                <h3 class="wide"><i class="fa fa-compass margin-right"></i>Entdecken sie der Korper</h3>
            </header>
            <iframe id="discoverFrame" name="discoverBody" class="display-container center"
                    style="width: 100%; border: 0"></iframe>
        </div>
    </div>
</div>


<!-- About Us Section -->
<div class="container content center padding-64" style="max-width:800px" id="aboutUs">
    <h2 class="wide">Über Uns</h2>
    <p class="opacity"><i>„Wissenschaftler sollten niemals behaupten, dass etwas absolut wahr ist. Du solltest niemals
            Perfektion oder 100 Prozent beanspruchen, weil du nie dorthin gelangst.”<span style="font-size: x-small;"> - Jocelyn Bell Burnell</span></i>
    </p>
    <p class="center">Die Website wurde 2022 eingerichtet, um insbesondere Schülern zu helfen, die Funktionsweise des
        menschlichen Körpers zu verstehen. Es enthält detaillierte Informationen über Blutgefäße, Organe und das Skelett
        des menschlichen Körpers. In Zukunft möchten wir diese Seite weiterentwickeln, um eine interaktivere
        Schnittstelle zu haben und den Fortschritt des Benutzers beim Erlernen des menschlichen Körpers zu
        speichern.</p>
    <center>
        <div class="profile">
            <p>Miriam Pleșa</p>
        </div>
    </center>
</div>


<div class="container content padding-64" style="max-width:800px" id="contact">
    <h2 class="wide center">CONTACT</h2>
    <p class="opacity center"><i>Fan? Hinterlasse uns einen Kommentar!</i></p>
    <div class="row padding-32">
        <div class="col m6 large margin-bottom">
            <i class="fa fa-map-marker" style="width:30px"></i> Brașov, România<br>
            <i class="fa fa-phone" style="width:30px"></i> Telefon: +40 756 424 087<br>
            <i class="fa fa-envelope" style="width:30px"> </i> Email: plesamiriam@yahoo.com<br>
        </div>
        <div class="col m6">
            <form action="mailto:plesamiriam@yahoo.com?subject=Kommentar von MiBODY!&body=Sehr Schon"
            " target="_blank">
            <div class="row-padding" style="margin:0 -16px 8px -16px">
                <div class="half">
                    <input class="input border" type="text" readonly placeholder="Name wird im Mail App geschrieben."
                           name="Name">
                </div>
                <div class="half">
                    <input class="input border" type="text" readonly placeholder="Email wird automatisch genommen"
                           name="Email">
                </div>
            </div>
            <input class="input border" type="text" readonly placeholder="Kommentar wird im Mail App geschrieben."
                   name="Message">
            <button class="button black section right" type="submit">Senden</button>
            </form>
        </div>
    </div>
</div>

<!-- Image of location/map -->
<div class="container content" style="max-width:2000px" id="mapImage">
    <img src="Assets/Images/images_png/location.png" style="width: 100%;">
</div>


<!-- End Page Content -->
</div>
<!-- Footer -->
<footer class="container padding-64 center opacity light-grey xlarge">
    <i class="fa fa-facebook-official hover-opacity"></i>
    <i class="fa fa-instagram hover-opacity"></i>
    <i class="fa fa-snapchat hover-opacity"></i>
    <i class="fa fa-pinterest-p hover-opacity"></i>
    <i class="fa fa-twitter hover-opacity"></i>
    <i class="fa fa-linkedin hover-opacity"></i>
    <p class="medium">Website von <a href="#">Miriam Pleșa</a></p>
</footer>

<script>
    let fullScreen = false;

    // Automatic Slideshow - change image every 6 seconds
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        myIndex++;
        if (myIndex > x.length) {
            myIndex = 1
        }
        x[myIndex - 1].style.display = "block";
        setTimeout(carousel, 6000);
    }

    // Used to toggle the menu on small screens when clicking on the menu button
    function myFunction() {
        var x = document.getElementById("navDemo");
        if (x.className.indexOf("show") == -1) {
            x.className += " show";
        } else {
            x.className = x.className.replace(" show", "");
        }
    }

    // When the user clicks anywhere outside of the modal, close it
    var modal = document.getElementById('discoverMode');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function toggleFullScreen() {
        var x = document.getElementById("discoverContent");
        var aux = document.getElementById('aux').clientHeight;
        if (fullScreen === true) {
            x.classList.remove('full-screen');
            x.classList.add('modal-content');
            x.style.height = (aux - 220) + 'px';
            document.getElementById('discoverMode').style.paddingTop = '100px';
            document.getElementById('discoverFrame').style.height = '0px';
            document.getElementById('discoverFrame').style.height = (aux - 320) + 'px'
            fullScreen = false;
        } else {
            x.classList.remove('modal-content');
            x.classList.add('full-screen');
            document.getElementById('discoverMode').style.paddingTop = '0px';
            document.getElementById('discoverFrame').style.minHeight = (aux - 120) + 'px';
            x.style.height = (aux)+ 'px';
            fullScreen = true;
        }
    }

    function showLearnFrames(){
        document.getElementById('discoverMode').style.display='block'
        document.getElementById('discoverContent').style.height = (document.getElementById('aux').clientHeight - 220) + 'px'
        document.getElementById('discoverFrame').style.height = (document.getElementById('aux').clientHeight - 320) + 'px'
    }
</script>

</body>

</html>
