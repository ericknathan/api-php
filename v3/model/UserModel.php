<?php

  class UserModel {
    private $_conn;

    public function __construct($conn) {
      $json = file_get_contents('php://input');
      $data = json_decode($json);

      $this->_conn = $conn;
    }

    public function findMany($filter = null) {
      $sql = $filter == null ? "SELECT * FROM tbl_user" : "SELECT * FROM tbl_user WHERE $filter";
      $stm = $this->_conn->prepare($sql);
      $stm->execute();
      return [
        "status" => "success",
        "data" => $stm->fetchAll(PDO::FETCH_ASSOC)
      ];
    }

    public function findOne($id) {
      $sql = "SELECT * FROM tbl_user WHERE id_user = :id";
      $stm = $this->_conn->prepare($sql);
      $stm->bindParam(":id", $id);
      $stm->execute();
      $result = $stm->fetch(PDO::FETCH_ASSOC);
      return $result == false
        ? generateError("User not found")
        : [
          "status" => "success",
          "data" => $result
        ];
    }

    public function create($data) {
      try {
        $sql = "INSERT INTO tbl_user (name, surname, email, phone, photo) VALUES (:name, :surname, :email, :phone, :photo)";

        $extension = pathinfo($data["photo"], PATHINFO_EXTENSION);
        $filename = md5(microtime()) . ".$extension";
        $path = "../uploads/" . $filename;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $path);

        $stm = $this->_conn->prepare($sql);
        $stm->bindParam(":name", $data["name"]);
        $stm->bindParam(":surname", $data["surname"]);
        $stm->bindParam(":email", $data["email"]);
        $stm->bindParam(":phone", $data["phone"]);
        $stm->bindParam(":photo", $filename);
        $stm->execute();
        return [
          "status" => "success",
          "message" => "User created successfully",
          "userId" => $this->_conn->lastInsertId()
        ];
      } catch (PDOException $error) {
        return generateError($error->getMessage());
      }
    }

    public function update($id, $data) {
      try {
        $sql = "SELECT photo FROM tbl_user WHERE id_user = :id";
        $stm = $this->_conn->prepare($sql);
        $stm->bindParam(":id", $id);
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_ASSOC);
        $photo = $result["photo"];
        unlink("../uploads/$photo");
        
        $sql = "UPDATE tbl_user SET name = :name, surname = :surname, email = :email, phone = :phone, photo = :photo WHERE id_user = :id";

        $extension = pathinfo($data["photo"], PATHINFO_EXTENSION);
        $filename = md5(microtime()) . ".$extension";
        $path = "../uploads/" . $filename;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $path);

        $stm = $this->_conn->prepare($sql);
        $stm->bindParam(":id", $id);
        $stm->bindParam(":name", $data["name"]);
        $stm->bindParam(":surname", $data["surname"]);
        $stm->bindParam(":email", $data["email"]);
        $stm->bindParam(":phone", $data["phone"]);
        $stm->bindParam(":photo", $data["photo"]);
        $stm->execute();
        return [
          "status" => "success",
          "message" => "User updated successfully",
          "userId" => $id
        ];
      } catch (PDOException $error) {
        return generateError($error->getMessage());
      }
    }

    public function delete($id) {
      try {
        if(!$id || $id == null) {
          return generateError("User not found");
        }
        
        $sql = "SELECT photo FROM tbl_user WHERE id_user = :id";
        $stm = $this->_conn->prepare($sql);
        $stm->bindParam(":id", $id);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);
        $photo = $result["photo"];
        unlink("../uploads/$photo");

        $sql = "DELETE FROM tbl_user WHERE id_user = :id";
        $stm = $this->_conn->prepare($sql);
        $stm->bindParam(":id", $id);
        $stm->execute();
        return [
          "status" => "success",
          "message" => "User deleted successfully",
          "userId" => $id
        ];
      } catch (PDOException $error) {
        return generateError($error->getMessage());
      }
     

      return $stm->rowCount();
    }
  }

  function generateError($message) {
    return [
      "status" => "error",
      "message" => $message
    ];
  }
?>