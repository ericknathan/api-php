<?php

  include('./database/Connection.php');
  include('./model/UserModel.php');
  include('./controller/UserController.php');

  $conn = new Connection();
  
  $user = new UserModel($conn->getConnection());
?>