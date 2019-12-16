<?php 
  class Category {

    // DB stuff
    private $conn;
    private $table = 'categories';
    
    // Category Properties
    public $id;
    public $name;
    public $url_path;
    public $created_at;
    
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }
    
    // Get Categories
    
    public function read() {
    
      // Create query

      $query = 'SELECT  
                    c.id, 
                    c.name, 
                    c.url_path, 
                    c.created_at
                FROM ' . $this->table . ' c
                ORDER BY
                    c.created_at DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Execute query
      $stmt->execute();
      return $stmt;
    }

    // Get Single Category
    public function read_single() {
          // Create query
          $query = 'SELECT 
                    c.id, 
                    c.name, 
                    c.url_path, 
                    c.created_at
                    FROM ' . $this->table . ' c
                    WHERE
                        c.id = :id
                    LIMIT 0,1';
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          // Bind ID
          $stmt->bindParam(":id", $this->id);
          // Execute query
          $stmt->execute();
          //$row = $stmt->fetch(PDO::FETCH_ASSOC);
          return $stmt;
    }
    // Create Category
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' 
                    SET name = :name, 
                    url_path = :url_path';

          // Prepare statement
          $stmt = $this->conn->prepare($query);
          
          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->url_path = htmlspecialchars(strip_tags($this->url_path));
          
          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':url_path', $this->url_path);

          // Execute query
          if($stmt->execute()) {
            return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;
    }
    // Update Category
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET name = :name, 
                                url_path = :url_path
                                WHERE id = :id';
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->url_path = htmlspecialchars(strip_tags($this->url_path));
          $this->id = htmlspecialchars(strip_tags($this->id));
          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':url_path', $this->url_path);
          $stmt->bindParam(':id', $this->id);
          // Execute query
          if($stmt->execute()) {
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
    }
    // Delete Category
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));
          // Bind data
          $stmt->bindParam(':id', $this->id);
          // Execute query
          if($stmt->execute()) {
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
    }
    
  }