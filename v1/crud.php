<?php

  function create($name, $surname, $email, $phone, $photo, $conn) {
    $sql = "INSERT INTO tbl_user (name, surname, email, phone, photo) VALUES ('$name', '$surname', '$email', '$phone', '$photo')";

    if (mysqli_query($conn, $sql)) {
      return json_encode([
        "status"=>"success",
        "message"=>"Dados inseridos com sucesso!",
        "data"=>[
          "name"=>$name,
          "surname"=>$surname,
          "email"=>$email,
          "phone"=>$phone,
          "photo"=>$photo
        ]
      ]);
    } else {
      return json_encode([
        "status"=>"error",
        "message"=>"Erro ao inserir os dados!",
        "data"=>[]
      ]);
    }
  }

  function read($conn) {
    $sql = "SELECT * FROM tbl_user";

    $result = mysqli_query($conn, $sql)
    or die(mysqli_error($conn));

    if ($result = mysqli_query($conn, $sql)) {
      $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

      return json_encode([
        "status"=>"success",
        "message"=>"Usuários obtidos com sucesso!",
        "data"=>$data
      ]);
    } else {
      return json_encode([
        "status"=>"error",
        "message"=>"Erro ao buscar os dados!"
      ]);
    }
  }

  function readID($id, $conn) {
    $sql = "SELECT * FROM tbl_user WHERE id_user=$id";

    if ($result = mysqli_query($conn, $sql)) {
      $data = mysqli_fetch_assoc($result);

      return json_encode([
        "status"=>"success",
        "message"=>"Usuário obtido com sucesso!",
        "data"=>$data
      ]);
    } else {
      return json_encode([
        "status"=>"error",
        "message"=>"Erro ao buscar o usuário informado!"
      ]);
    }
  }

  function update($id, $name, $surname, $email, $phone, $photo, $conn) {
    $sql = "UPDATE tbl_user SET name='$name', surname='$surname', email='$email', phone='$phone', photo='$photo' WHERE id_user=$id";

    if (mysqli_query($conn, $sql)) {
      return json_encode([
        "status"=>"success",
        "message"=>"Dados atualizados com sucesso!",
        "data"=>[
          "id"=> $id,
          "name"=>$name,
          "surname"=>$surname,
          "email"=>$email,
          "phone"=>$phone,
          "photo"=>$photo
        ]
      ]);
    } else {
      echo "$id, $name, $surname, $email, $phone, $photo";
      return json_encode([
        "status"=>"error",
        "message"=>"Erro ao atualizar os dados!"
      ]);
    }
  }

  function delete($conn, $id) {    
    $sql = "DELETE FROM tbl_user WHERE id_user=$id";

    if (mysqli_query($conn, $sql)) {
      return json_encode([
        "status"=>"success",
        "message"=>"Usuário apagado com sucesso!"
      ]);
    } else {
      return json_encode([
        "status"=>"error",
        "message"=>"Erro ao apagar usuário!"
      ]);
    }
  }

?>