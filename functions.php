<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$databaseURL = "https://mibody-86533-default-rtdb.europe-west1.firebasedatabase.app/";
include("firebaseRDB.php");

function login($db, $email, $password) {
    print("Login");
        try {
            // Retrieve user data from Firebase
            $user_data = $db->retrieve("user");
            $user_data = json_decode($user_data, true);

                $result = $db->retrieve("user");
                $result = json_decode($result, 1);

                foreach ($result as $user) {
                    if ($user['email'] == $email && $user['password'] == $password) {
                        $_SESSION['user_id'] = $user['user_id'];
                        header("Location: index.php");
                    die;
                    }
                }
                echo "alert('Wrong email or password!')";
        } catch (Exception $e) {
            // Print error message
            echo "Error: " . $e->getMessage();
            return null;
        }

}

function signup($db, $id, $username, $email, $password) {
    print("Signup");

        try {
            // Insert data into 'user' node
            $insert = $db->insert("user", [
                "user_id" => $id,
                "userName" => $username,
                "userEmail" => $email,
                "userPassword" => $password
             ]);
             if (!$insert) {
                 throw new Exception("Failed to insert data into Firebase Database");
             }
        } catch (Exception $e) {
            // Print error message
            echo "Error: " . $e->getMessage();
            return null;
        }

}

function check_login($db) {
    print("Check login");
    if (isset($_SESSION['user_id'])) {
        print_r($_SESSION['user_id']);
        $id = $_SESSION['user_id'];

        try {
            // Retrieve user data from Firebase
            $user_data = $db->retrieve("user");
            $user_data = json_decode($user_data, true);

            // Check if user data is found
            if ($user_data) {
                return $user_data;
            } else {
                return null; // No user data found
            }
        } catch (Exception $e) {
            // Print error message
            echo "Error: " . $e->getMessage();
            return null;
        }
    } else {   
        print("No login");
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
