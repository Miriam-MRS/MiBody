<?php
$databaseURL = "https://mibody-86533-default-rtdb.europe-west1.firebasedatabase.app/";
include("firebaseRDB.php");
$db = new firebaseRDB($databaseURL);
$insert = $db->insert("user", [
                      "userName": "Miriam",
                      "userEmail": "plesamiriam@yahoo.com",
                      "userPassword": "1234567"
                      ]);
$data = $db->retrieve("user");
$data = json_decode($data, 1);
print_r($data);

