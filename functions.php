<?php
$databaseURL = "https://mibody-86533-default-rtdb.europe-west1.firebasedatabase.app/";
include("firebaseRDB.php");

function check_login($db) {
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];

        try {
            // Retrieve user data from Firebase
            $user_data = $db->retrieve("user/$id");
            $user_data = json_decode($user_data, true);

            // Check if user data is found
            if ($user_data) {
                return $user_data;
            } else {
                return null; // No user data found
            }
        } catch (Exception $e) {
            return null;
        }
    } else {
        return null; // No user_id in session
    }
}

function random_num($length) {
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);
    for ($i = 0; i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}

// Example usage
session_start();

?>
