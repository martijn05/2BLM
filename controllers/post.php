<?php
  session_start();
  include_once("../includes/Database.php");

  // text
  $text = $_POST["textPost"];
  // image
  $directory = "../images/posts/";
  $imageID = hash("sha256", "postfoto_".(count(glob($directory . "*")) + 1));

  $target_dir = "../images/posts/";
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

  // Check if file already exists
  if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
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
      $userID = $_SESSION['user_id'];

      date_default_timezone_set('UTC');
      $date = date("Y-m-d H:i:s");

      insertQuery("INSERT INTO posts VALUES (null, '$text','$imageUrl','$date','$userID');");

      echo "<script>window.location.href = '../?post=success';</script>";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
  
  echo "<br><a href='../'>Ga terug naar het overzicht</a>";