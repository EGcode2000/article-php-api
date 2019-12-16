<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  include_once '../../config/Database.php';
  include_once '../../models/Post.php';
  
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  
  // Instantiate article post object
  $post = new Post($db);
  
  // Get ID
  $post->id = isset($_GET['id']) ? $_GET['id'] : die();
  

  // article post query
  $result = $post->read_single();

  // Get row count
  $num = $result->rowCount();

  if($num == 1) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $post_item = array(
      'id' => $id,
      'title' => $title,
      'body' => html_entity_decode($body),
      'author' => $author,
      'category_id' => $category_id,
      'category_name' => $category_name,
      'category_url_path' => $category_url_path
    );
      // Make JSON
      print_r(json_encode($post_item));
    }else{
        // No Posts
        echo json_encode(
            array('message' => 'No Post Found')
        );
    }

