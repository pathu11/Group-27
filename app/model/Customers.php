<?php 
  class Customers{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }


    public function findCustomerById($user_id){
        $this->db->query('SELECT * from customers WHERE user_id=:user_id');
        $this->db->bind(':user_id',$user_id);
       

        return $this->db->resultSet();
    }

  
    public function findUsedBookByCusId($customer_id){
      $this->db->query('SELECT * from books WHERE customer_id=:customer_id AND type="used" AND status="approval"');
      $this->db->bind(':customer_id',$customer_id);
     

      return $this->db->resultSet();
    }

    public function findExchangedBookByCusId($customer_id){
      $this->db->query('SELECT * from books WHERE customer_id=:customer_id AND type="exchanged" AND status="approval"');
      $this->db->bind(':customer_id',$customer_id);
     

      return $this->db->resultSet();
    }

    // public function getUsedBookById($book_id){
    //   $this->db->query('SELECT * from books WHERE book_id=:book_id ');
    //   $this->db->bind(':book_id',$book_id);
    //   return $this->db->resultSet();
    //   // $row = $this->db->single();
    //   // return $row;
    // }

    public function findUsedBookById($book_id) {
      $this->db->query('SELECT * from books WHERE book_id=:book_id');
      $this->db->bind(':book_id',$book_id);
      $row = $this->db->single();
      return $row;
    }




  public function addComment($data) {
    // Assuming $this->db is an instance of your database class
    $this->db->query('INSERT INTO comments (name, comment, parent_comment) VALUES (:name, :comment, :parent_comment)');
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':comment', $data['comment']);
    $this->db->bind(':parent_comment', $data['parentComment']);
    return $this->db->execute();
}

  public function getComments() {
    $this->db->query('SELECT * FROM comments ORDER BY timestamp DESC');
    return $this->db->resultSet();
  }






  public function AddUsedBook($data){
    $this->db->query('INSERT INTO books (book_name, ISBN_no, author, price, category, weight, descript, img1, img2, img3, `condition`, published_year, price_type, type, account_name, account_no, bank_name, branch_name, town, district, postal_code, customer_id, status) 
                                VALUES(:book_name, :ISBN_no, :author, :price, :category, :weight, :descript, :img1, :img2, :img3, :condition, :published_year, :price_type, :type, :account_name, :account_no, :bank_name, :branch_name, :town, :district, :postal_code, :customer_id, :status)');
    
    $this->db->bind(':book_name',$data['book_name']);
    $this->db->bind(':ISBN_no',$data['ISBN_no']);
    // $this->db->bind(':ISSN_no',$data['ISSN_no']);
    // $this->db->bind(':ISMN_no',$data['ISMN_no']);
    $this->db->bind(':author',$data['author']);
    $this->db->bind(':price',$data['price']);
    $this->db->bind(':category',$data['category']);
    $this->db->bind(':weight',$data['weight']);
    $this->db->bind(':descript',$data['descript']);
    $this->db->bind(':img1',$data['img1']);
    $this->db->bind(':img2',$data['img2']);
    $this->db->bind(':img3',$data['img3']);
    $this->db->bind(':condition',$data['condition']);
    $this->db->bind(':published_year',$data['published_year']);
    $this->db->bind(':price_type',$data['price_type']);
    $this->db->bind(':type',$data['type']);
    $this->db->bind(':account_name',$data['account_name']);
    $this->db->bind(':account_no',$data['account_no']);
    $this->db->bind(':bank_name',$data['bank_name']);
    $this->db->bind(':branch_name',$data['branch_name']);
    $this->db->bind(':town',$data['town']);
    $this->db->bind(':district',$data['district']);
    $this->db->bind(':postal_code',$data['postal_code']);
    $this->db->bind(':customer_id', $data['customer_id']);
    $this->db->bind(':status', $data['status']);
    // execute
    if($this->db->execute()){
        return true;
    }else{
        return false;
    }        
  }

  public function updateusedbook($data) {
    $this->db->query('UPDATE books 
              SET book_name = :book_name, 
              ISBN_no = :ISBN_no, 
              author = :author,  
              price = :price, 
              category = :category,
              weight = :weight,
              descript = :descript,
              img1 = :img1,
              img2 = :img2,
              img3 = :img3,
              `condition` = :condition, 
              published_year = :published_year,  
              price_type = :price_type, 
              type = :type,
              account_name = :account_name,
              account_no = :account_no,
              bank_name = :bank_name,
              branch_name = :branch_name,
              town = :town, 
              district = :district,  
              postal_code = :postal_code, 
              customer_id = :customer_id,
              status = :status
              WHERE book_id = :book_id');

    // Bind values
    $this->db->bind(':book_id',$data['book_id']);
    $this->db->bind(':book_name',$data['book_name']);
    $this->db->bind(':ISBN_no',$data['ISBN_no']);
    // $this->db->bind(':ISSN_no',$data['ISSN_no']);
    // $this->db->bind(':ISMN_no',$data['ISMN_no']);
    $this->db->bind(':author',$data['author']);
    $this->db->bind(':price',$data['price']);
    $this->db->bind(':category',$data['category']);
    $this->db->bind(':weight',$data['weight']);
    $this->db->bind(':descript',$data['descript']);
    $this->db->bind(':img1',$data['img1']);
    $this->db->bind(':img2',$data['img2']);
    $this->db->bind(':img3',$data['img3']);
    $this->db->bind(':condition',$data['condition']);
    $this->db->bind(':published_year',$data['published_year']);
    $this->db->bind(':price_type',$data['price_type']);
    $this->db->bind(':type',$data['type']);
    $this->db->bind(':account_name',$data['account_name']);
    $this->db->bind(':account_no',$data['account_no']);
    $this->db->bind(':bank_name',$data['bank_name']);
    $this->db->bind(':branch_name',$data['branch_name']);
    $this->db->bind(':town',$data['town']);
    $this->db->bind(':district',$data['district']);
    $this->db->bind(':postal_code',$data['postal_code']);
    $this->db->bind(':customer_id', $data['customer_id']);
    $this->db->bind(':status', $data['status']);

    // Execute
    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
  }

  public function deleteusedbook($book_id) {
    $this->db->query('DELETE FROM books WHERE book_id = :book_id');
    // Bind values
    $this->db->bind(':book_id', $book_id);

    // Execute after binding
    $this->db->execute();

    // Check for row count affected
    if ($this->db->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
  }

  }