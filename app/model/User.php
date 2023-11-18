<?php
class User{
   private $db;

    public function __construct(){
        $this->db=new Database;
    }

    public function getUsers(){
        $this->db->query('SELECT * FROM users');
        $results=$this->db->resultSet();

        return $results;
    }

    public function signupCustomer($data) {
        try {
            $this->db->beginTransaction(); // Begin the transaction

            // Insert data into the 'users' table
            $this->db->query('INSERT INTO users (email, pass, user_role) VALUES (:email, :pass, :user_role)');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':pass', $data['pass']);
            $this->db->bind(':user_role', 'customer');

            if ($this->db->execute()) {
                $user_id = $this->db->lastInsertId();

                // Insert data into the 'customers' table using the obtained user ID as the foreign key
                $this->db->query('INSERT INTO customers (user_id, name, email, pass) VALUES (:user_id, :name, :email, :pass)');
                $this->db->bind(':user_id', $user_id);
                $this->db->bind(':name', $data['name']);
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':pass', $data['pass']);

                if ($this->db->execute()) {
                    $this->db->commit(); // Commit the transaction
                    return true;
                } else {
                    $this->db->rollBack(); // Roll back the transaction if 'customers' insert fails
                }
            } else {
                $this->db->rollBack(); // Roll back the transaction if 'users' insert fails
            }
        } catch (PDOException $e) {
            echo "Transaction failed: " . $e->getMessage();
            $this->db->rollBack(); // Roll back the transaction on exception
        }

        return false;
    }
    public function signupPub($data){
        try {
            $this->db->beginTransaction(); // Begin the transaction

            // Insert data into the 'users' table
            $this->db->query('INSERT INTO users (email, pass, user_role) VALUES (:email, :pass, :user_role)');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':pass', $data['pass']);
            $this->db->bind(':user_role', 'publisher');

            if ($this->db->execute()) {
                $user_id = $this->db->lastInsertId();

                // Insert data into the 'customers' table using the obtained user ID as the foreign key
                $this->db->query('INSERT INTO publishers (user_id, name,company_name,reg_no, email,contact_no, pass) VALUES (:user_id, :name,:company_name,:reg_no, :email,:contact_no , :pass)');

                $this->db->bind(':user_id', $user_id);
                $this->db->bind(':name', $data['name']);
                $this->db->bind(':company_name', $data['company_name']);
                $this->db->bind(':reg_no', $data['reg_no']);
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':contact_no', $data['contact_no']);
                $this->db->bind(':pass', $data['pass']);

                if ($this->db->execute()) {
                    $this->db->commit(); // Commit the transaction
                    return true;
                } else {
                    $this->db->rollBack(); // Roll back the transaction if 'customers' insert fails
                }
            } else {
                $this->db->rollBack(); // Roll back the transaction if 'users' insert fails
            }
        } catch (PDOException $e) {
            echo "Transaction failed: " . $e->getMessage();
            $this->db->rollBack(); // Roll back the transaction on exception
        }

        return false;
    }

    public function signupCharity($data){
        try {
            $this->db->beginTransaction(); // Begin the transaction

            // Insert data into the 'users' table
            $this->db->query('INSERT INTO users (email, pass, user_role) VALUES (:email, :pass, :user_role)');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':pass', $data['pass']);
            $this->db->bind(':user_role', 'charity');

            if ($this->db->execute()) {
                $user_id = $this->db->lastInsertId();

                // Insert data into the 'customers' table using the obtained user ID as the foreign key
                $this->db->query('INSERT INTO charity (user_id, name,org_name,reg_no, email,contact_no, pass) VALUES (:user_id, :name,:org_name,:reg_no, :email,:contact_no , :pass)');

                $this->db->bind(':user_id', $user_id);
                $this->db->bind(':name', $data['name']);
                $this->db->bind(':org_name', $data['org_name']);
                $this->db->bind(':reg_no', $data['reg_no']);
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':contact_no', $data['contact_no']);
                $this->db->bind(':pass', $data['pass']);

                if ($this->db->execute()) {
                    $this->db->commit(); // Commit the transaction
                    return true;
                } else {
                    $this->db->rollBack(); // Roll back the transaction if 'customers' insert fails
                }
            } else {
                $this->db->rollBack(); // Roll back the transaction if 'users' insert fails
            }
        } catch (PDOException $e) {
            echo "Transaction failed: " . $e->getMessage();
            $this->db->rollBack(); // Roll back the transaction on exception
        }

        return false;
    }
    

    


    public function login($email, $pass)
{
    $this->db->query('SELECT * FROM users WHERE email=:email');
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    if (!$row) {
        // User not found
        return false;
    }

    $storedPassword = $row->pass;

    // Check if the stored password is hashed
    $isPasswordHashed = password_verify($pass, $storedPassword);

    if ($isPasswordHashed) {
        // Password is hashed
        return $row;
    } else {
        // Check if the password matches without hashing
        if ($pass === $storedPassword) {
            return $row;
        } else {
            // Passwords do not match
            return false;
        }
    }
}   
    //find by user email
    public function findUserByEmail($email){
        $this->db->query('SELECT * from users WHERE email=:email');
        $this->db->bind(':email',$email);

        $row=$this->db->single();

        //check row
        if($this->db->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function findUserByPubId($user_id){
        $this->db->query('SELECT * from publishers WHERE user_id=:user_id');
        $this->db->bind(':user_id',$user_id);
       

        return $this->db->resultSet();
    }

   

    

}
