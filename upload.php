<?php
include('session.php'); 

if ($login_level == 1) {
    $user_type  = "student";
} elseif ($login_level == 2) {
    $user_type  = "teacher";
} elseif ($login_level == 3) {
    $user_type  = "admin";
}

// Check if user_type is set, if not, terminate with an error message
if (!isset($user_type)) {
    die("User type not set.");
}

// Fetch user data
$result = mysqli_query($con, "SELECT * FROM `user_".$user_type."_detail` WHERE ".$user_type."_userID = $login_id");

// Check if data is fetched successfully
if (!$result) {
    die("Error fetching data: " . mysqli_error($con));
}

// Fetch the data
$data = mysqli_fetch_array($result);

// Check if data is fetched successfully
if (!$data) {
    die("No data found for the user.");
}

// Fetch image and user ID
$data_img = isset($data[$user_type.'_img']) ? $data[$user_type.'_img'] : '';
$data_id = isset($data[$user_type.'_userID']) ? $data[$user_type.'_userID'] : '';

// Debugging: Print fetched data
echo "<pre>";
print_r($data);
echo "</pre>";

if (isset($_POST['submit'])) {
    // Check file format
    if (!in_array($imageFileType, array("jpg", "png", "jpeg", "gif"))) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.location='profile.php';</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.'); window.location='profile.php';</script>";
    } else {
        if ($data_img == 'temp.gif') {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $imgName = $_FILES["fileToUpload"]["name"];
                $query = "UPDATE `user_".$user_type."_detail` SET `".$user_type."_img` = '$imgName' WHERE `".$user_type."_userID` =".$data_id." ";
                mysqli_query($con,$query);
                echo "<script>alert('Successfully Update'); window.location='profile.php';</script>";
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.'); window.location='profile.php';</script>";
            }
        } else {
            unlink('assets/img/profile_img/'.$data_img);
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $imgName = $_FILES["fileToUpload"]["name"];
                $query = "UPDATE `user_".$user_type."_detail` SET `".$user_type."_img` = '$imgName' WHERE `".$user_type."_userID` =".$data_id." ";
                mysqli_query($con,$query);
                echo "<script>alert('Successfully Update'); window.location='profile.php';</script>";
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.'); window.location='profile.php';</script>";
            }
        }
    }
}

?>