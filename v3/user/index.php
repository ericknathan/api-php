<?php

  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
  header('Content-Type: application/json');

  include('../database/Connection.php');
  include('../model/UserModel.php');
  include('../controller/UserController.php');

  $conn = new Connection();
  $model = new UserModel($conn->getConnection());
  $controller = new UserController($model);

  $data = $controller->router();
  echo json_encode($data);

  ?>
