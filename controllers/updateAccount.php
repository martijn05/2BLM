<?php
  session_start();
  include_once("../includes/Database.php");

  // update
  $naam = $_POST["name"];
  $email = $_POST["mail"];
  $tel = $_POST["tel"];

  $userID = $_SESSION['user_id'];
  $user = getQuery("SELECT * FROM users WHERE id = '$userID';")[0];
  $oldmail = $user["email"];
  $oldtel = $user["telefoon"];

  if (isset($_FILES["imagePost"])) {
    // image
    $directory = "../images/profiel/";
    $imageID = hash("sha256", "profielfoto_".(count(glob($directory . "*")) + 1));

    $target_dir = "../images/profiel/";
    $target_file = $target_dir . basename($_FILES["imagePost"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["imagePost"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    }

    // Check file size
    if ($_FILES["imagePost"]["size"] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["imagePost"]["tmp_name"], $target_dir.$imageID.".".$imageFileType)) {
        $imageUrl = $target_dir.$imageID.".".$imageFileType;

        date_default_timezone_set('UTC');
        $date = date("Y-m-d H:i:s");

        if ($oldmail != $email && $oldtel != $oldtel) {
          //send mail
          //send sms
          insertQuery("UPDATE users SET naam = '$naam', email = '$email', telefoon = '$tel', profiel_img_url = '$imageUrl', tel_verif = '0', mail_verif = '0' WHERE (id = '$userID');");
        }
        elseif ($oldmail != $email) {
          //send mail
          insertQuery("UPDATE users SET naam = '$naam', email = '$email', profiel_img_url = '$imageUrl', mail_verif = '0' WHERE (id = '$userID');");
        }
        elseif ($oldtel != $tel) {
          //send sms
          insertQuery("UPDATE users SET naam = '$naam', telefoon = '$tel', profiel_img_url = '$imageUrl', tel_verif = '0' WHERE (id = '$userID');");
        }
        else {
          insertQuery("UPDATE users SET naam = '$naam', profiel_img_url = '$imageUrl' WHERE (id = '$userID');");
        }

      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  } else {
    if ($oldmail != $email && $oldtel != $oldtel) {
      //send mail
      //send sms
      insertQuery("UPDATE users SET naam = '$naam', email = '$email', telefoon = '$tel', tel_verif = '0', mail_verif = '0' WHERE (id = '$userID');");
    }
    elseif ($oldmail != $email) {
      //send mail
      insertQuery("UPDATE users SET naam = '$naam', email = '$email', mail_verif = '0' WHERE (id = '$userID');");
    }
    elseif ($oldtel != $tel) {
      //send sms
      insertQuery("UPDATE users SET naam = '$naam', telefoon = '$tel', tel_verif = '0' WHERE (id = '$userID');");
    }
    else {
      insertQuery("UPDATE users SET naam = '$naam' WHERE (id = '$userID');");
    }
  }
  
  header("Location: ../profiel/");