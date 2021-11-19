<?php

  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Content-Type: application/json');

  include('./database/connection.php');
  include('./crud.php');

  $action = $_REQUEST['action'];

  switch ($action) {
    case 'READ':
      echo read($conn);
      break;
    case 'GET':
      $id = $_REQUEST['id'];
      echo readID($id, $conn);
      break;
    case 'CREATE':
      $name = $_REQUEST['name'];
      $surname = $_REQUEST['surname'];
      $email = $_REQUEST['email'];
      $phone = $_REQUEST['phone'];
      $photo = $_REQUEST['photo'];

      echo create($name, $surname, $email, $phone, $photo, $conn);
      break;
    case 'UPDATE':
      $id = $_REQUEST['id'];
      $name = $_REQUEST['name'];
      $surname = $_REQUEST['surname'];
      $email = $_REQUEST['email'];
      $phone = $_REQUEST['phone'];
      $photo = $_REQUEST['photo'];

      echo update($id, $name, $surname, $email, $phone, $photo, $conn);
      break;
    case 'DELETE':
      $id = $_REQUEST['id'];

      echo delete($conn, $id);
      break;
    default:
      echo json_encode([
        "status"=>"error",
        "message"=>"Ação inexistente!"
      ]);
      break;
  }

?>