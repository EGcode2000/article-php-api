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
  
  // article category query
  $result = $category->read();
  
  // Get row count
  $num = $result->rowCount();
  
  // Check if any posts
  if($num > 0) {
    // Category array
    $categories_arr = array();
    // $categories_arr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $category_item = array(
        'id' => $id,
        'name' => $name,
        'url_path' => $url_path,
        'created_at' => $created_at
      );
  
      // Push to "data"
      array_push($categories_arr, $category_item);
      // array_push($categories_arr['data'], $category_item);
    }
  
    // Turn to JSON & output
    echo json_encode($categories_arr);
  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }