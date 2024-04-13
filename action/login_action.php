<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

if (isset($_POST['submit-student'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<script>alert('Student Number or Password is empty !');
                                window.location='index.php';
                            </script>";
        // Change this to bootstrap alert
    } else {
        login();
    }
}

if (isset($_POST['submit-teacher'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<script>alert('Username or Password is empty !');
            window.location='index.php';
        </script>";
        // Change this to bootstrap alert
    } else {
        login();
    }
}

function login() {
    $con = mysqli_connect('localhost', 'root', '', 'tracerdata') or die("ERROR");
    // Define $username and $password
    $username = $_POST['username'];
    $password = $_POST['password'];
    // To protect MySQL injection for Security purpose
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $input = "$password";
    include('md5.php');
    // SQL query to fetch information of registered users and find user match.
    $query = mysqli_query($con, "SELECT * FROM `user_account` WHERE `user_name` = '$username' AND `user_password` = '$encrypted'");

if (is_bool($query)) {
    if (!$query) {
        die(mysqli_error($con)); // or handle the error in some appropriate way
    } else {
        die("Query execution returned a boolean value. This may indicate an error."); // Handle this case appropriately
    }
}

$rows = mysqli_fetch_assoc($query);


$rows = mysqli_fetch_assoc($query);


    if ($rows['user_level'] >= 0 && $rows['user_level'] <= 3) {
        $_SESSION['login_user'] = $username; // Initializing Session
        header("location: dashboard.php"); // Go to dashboard
    } else {
        echo "<script>swal('Good job!', 'You clicked the button!', 'success');
        window.location='index.php';
        </script>";
        // Change this to bootstrap alert
    }

    if ($rows['user_status'] == 'unregister') {
        echo "<script>alert.render('');
        window.location='index.php';
        </script>";
        include('alert/danger.php');
    }

    mysqli_close($con); // Closing Connection
}
?>
