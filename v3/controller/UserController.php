<?php

  class UserController {
    private $_method;
    private $_userModel;

    private $_user = [];

    public function __construct($model) {
      $this->_userModel = $model;
      $this->_method = $_SERVER['REQUEST_METHOD'];

      $json = file_get_contents('php://input');
      $data = json_decode($json);
      
      $this->_user['id'] = $_GET['id'] ?? $data->id ?? null;
      $this->_user['name'] = $_POST['name'] ?? $data->name ?? null;
      $this->_user['surname'] = $_POST['surname'] ?? $data->surname ?? null;
      $this->_user['email'] = $_POST['email'] ?? $data->email ?? null;
      $this->_user['phone'] = $_POST['phone'] ?? $data->phone ?? null;
      $this->_user['photo'] = $_POST['photo'] ?? $data->photo ?? null;
    }

    public function router() {
      switch ($this->_method) {
        case 'GET':
          if($this->_user['id'] !== null) {
            return $this->_userModel->findOne($this->_user['id']);
          }

          $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
          return $this->_userModel->findMany($filter);
          break;
        case 'POST':
          return $this->_userModel->create($this->_user);
          break;
        case 'PUT':
          return $this->_userModel->update($this->_user['id'], $this->_user);
          break;
        case 'DELETE':
          $userId = $this->_user['id'];
          return $this->_userModel->delete($userId);
          break;
        default:
          return ['error'=>'Method not allowed'];
          break;
      }
    }
  }

?>