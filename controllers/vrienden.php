<?php
  $UiD = $_SESSION['user_id'];

  if (isset($_GET["accept"])) {
      $id = $_GET["accept"];
      insertQuery("UPDATE vrienden SET status = 'a' WHERE (id_1 = '$id') and (id_2 = '$UiD');");
      insertQuery("INSERT INTO vrienden VALUES ('$UiD', '$id', 'a');");
      header('Location: ./');
  }
  if (isset($_GET["ignore"])) {
      $id = $_GET["ignore"];
      insertQuery("DELETE FROM vrienden WHERE (id_1 = '$id') and (id_2 = '$UiD');");
      header('Location: ./');
  }
  if (isset($_GET["delete"])) {
      $id = $_GET["delete"];
      insertQuery("DELETE FROM vrienden WHERE (id_1 = '$id') and (id_2 = '$UiD');");
      insertQuery("DELETE FROM vrienden WHERE (id_1 = '$UiD') and (id_2 = '$id');");
      header('Location: ./');
  }
  if (isset($_GET["chat"])) {
      $id = $_GET["chat"];
      $already = getQuery("SELECT * FROM chats WHERE (user_verz_id = '$UiD' AND user_ont_id = '$id') OR (user_verz_id = '$id' AND user_ont_id = '$UiD');");
      if ($already == []) insertQuery("INSERT INTO chats VALUES (NULL,'$UiD','$id','Hallo, ik wil graag chatten met jou!',current_timestamp());");
      $_SESSION['chatReceId'] = $id;
      header('Location: ../chat/');
  }