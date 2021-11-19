<?php

  class User {
    private $conn;

    function __construct($conn) {
      $this->conn = $conn;
    }

    public function create($name, $surname, $email, $phone, $photo) {
      $sql = "INSERT INTO tbl_user (name, surname, email, phone, photo) VALUES ('$name', '$surname', '$email', '$phone', '$photo')";
  
      if (mysqli_query($this->conn, $sql)) {
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

    public function findMany() {
      $sql = "SELECT * FROM tbl_user";

      $result = mysqli_query($this->conn, $sql)
      or die(mysqli_error($this->conn));

      if ($result = mysqli_query($this->conn, $sql)) {
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

    public function findOne($id) {
      $sql = "SELECT * FROM tbl_user WHERE id_user=$id";

      if ($result = mysqli_query($this->conn, $sql)) {
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
      };
    }

    public function update($id, $name, $surname, $email, $phone, $photo) {
      $sql = "UPDATE tbl_user SET name='$name', surname='$surname', email='$email', phone='$phone', photo='$photo' WHERE id_user=$id";
  
      if (mysqli_query($this->conn, $sql)) {
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

    public function delete($id) {    
      $sql = "DELETE FROM tbl_user WHERE id_user=$id";
  
      if (mysqli_query($this->conn, $sql)) {
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
  }

  new User($conn)
?>