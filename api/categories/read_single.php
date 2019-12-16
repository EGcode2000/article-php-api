<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  include_once '../../config/Database.php';
  include_once '../../models/Category.php';
  
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  
  // Instantiate article category object
  $category = new Category($db);
  
  // Get ID
  $category->id = isset($_GET['id']) ? $_GET['id'] : die();
  

  // article category query
  $result = $category->read_single();

  // Get row count
  $num = $result->rowCount();

  if($num == 1) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $category_item = array(
      'id' => $id,
      'name' => $name,
      'url_path' => $url_path,
      'created_at' => $created_at
    );
      // Make JSON
      print_r(json_encode($category_item));
    }else{
        // No Posts
        echo json_encode(
            array('message' => 'No Category Found')
        );
    }

