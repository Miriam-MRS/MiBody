<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$databaseURL = "https://mibody-86533-default-rtdb.europe-west1.firebasedatabase.app/";

// Include Firebase RDB library
include("firebaseRDB.php");

try {
    // Initialize Firebase RDB instance
    $db = new firebaseRDB($databaseURL);

    // Insert data into 'user' node
    $insert = $db->insert("user", [
        "userName" => "Miriam",
        "userEmail" => "plesamiriam@yahoo.com",
        "userPassword" => "1234567"
    ]);

    if (!$insert) {
        throw new Exception("Failed to insert data into Firebase Database");
    }

    // Retrieve data from 'user' node
    $data = $db->retrieve("user");

    if (!$data) {
        throw new Exception("Failed to retrieve data from Firebase Database");
    }

    // Decode retrieved data
    $data = json_decode($data, true);

    // Print retrieved data
    print_r($data);

} catch (Exception $e) {
    // Print error message
    echo "Error: " . $e->getMessage();
}
?>
