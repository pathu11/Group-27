<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require APPROOT . '\vendor\autoload.php';
class Customer extends Controller {
    private $customerModel;
    private $deliveryModel;
    private $publisherModel;
    private $ordersModel;
    private $userModel;
    private $adminModel;
    private $chatModel;
  
    private $db;
    public function __construct(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
        $this->customerModel=$this->model('Customers');
        $this->deliveryModel=$this->model('Deliver');
        $this->userModel=$this->model('User');
        $this->ordersModel=$this->model('Orders');
        $this->publisherModel=$this->model('Publishers')  ;
        $this->adminModel=$this->model('Admins')  ;
        $this->chatModel=$this->model('Chat')  ;
        $this->db = new Database();
    }
   
    
    public function comment() {
        if (!isLoggedIn()) {
            redirect('landing/login');
        }

        $user_id = $_SESSION['user_id'];
        $customerDetails = $this->customerModel->findCustomerById($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => $customerDetails[0]->name,
                'comment' => trim($_POST['comment']),
                'parentComment' => trim($_POST['parentComment']),
                'comment_err' => '',
            ];

            if (empty($data['comment'])) {
                $data['comment_err'] = 'Please enter a comment';
            }

            if (empty($data['comment_err'])) {
                if ($this->customerModel->addComment($data)) {
                    flash('Successfully Added');
                    redirect('customer/comment');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('customer/comment', $data);
            }
        } else {
            $data = [
                'comment' => '',
                'parentComment' => '',
                'comment_err' => '',
            ];

            $this->view('customer/comment', $data);
        }
    }

    public function getComments() {
        header('Content-Type: application/json');
        $comments = $this->customerModel->getComments();
        echo json_encode($comments);
    }

    public function index(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/index', $data);
        }
    }
    public function AboutUs(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/AboutUs', $data);
        }
    } 
    public function AddCont(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/AddCont', $data);
        }
    } 
    
    public function Addevnt(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Addevnt', $data);
        }
    } 

    public function AddExchangeBook(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $customerid = null;
    
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                
                $customerDetails = $this->customerModel->findCustomerById($user_id);
                // $bookCategoryDetails = $this->adminModel->getBookCategories();
                if ($customerDetails) {
                    $customerName = $customerDetails[0]->name;
                    $customerid = $customerDetails[0]->customer_id;                 
                } else {
                    echo "Not found";
                }
            }            
            $data=[
                'book_name' => trim($_POST['bookName']),
                'ISBN_no' => trim($_POST['isbnNumber']),
                'author' => trim($_POST['author']),
                'category' => trim($_POST['category']),
                'weight' => trim($_POST['weights']),
                'descript' => trim($_POST['description1']),
                'booksIWant' => trim($_POST['description2']),
                'img1' => '',
                'img2' => '',
                'img3' => '',
                'condition' => trim($_POST['bookCondition']),
                'published_year' => trim($_POST['publishedYear']),
                'type' => trim('exchanged'),
                'town' => trim($_POST['town']),
                'district' => trim($_POST['district']),
                'postal_code' => trim($_POST['postalCode']),
                'customer_id' => trim($customerid),// Replace this with the actual customer ID
                'status' => trim('pending'),

                'bookName_err' => '',
                'publishedYear_err'=>'',
                'weights_err'=>'',
                'ISBN_err'=>'',
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerName
            ];

            if(empty($data['published_year'])){
                $data['publishedYear_err']='Please enter published year';      
            }
            if(empty($data['weight'])){
                $data['weights_err']='Please enter the weight';      
            }else if($data['weight']<0 ){
                $data['weights_err']='Please enter a valid weight'; 
            }

            if(empty($data['bookName_err']) && empty($data['publishedYear_err']) && empty($data['price_err']) && empty($data['weights_err']) && empty($data['ISBN_err'])){

                //image
                if (isset($_FILES['imgFront']['name']) AND !empty($_FILES['imgFront']['name'])) {
                    $img_name = $_FILES['imgFront']['name'];
                    $tmp_name = $_FILES['imgFront']['tmp_name'];
                    $error = $_FILES['imgFront']['error'];
                    
                    if ($error === 0) {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_to_lc = strtolower($img_ex);
                
                        $allowed_exs = array('jpg', 'jpeg', 'png');
                        if (in_array($img_ex_to_lc, $allowed_exs)) {
                            // Generate a unique identifier (e.g., timestamp)
                            $unique_id = time(); 
                            $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgFront.' . $img_ex_to_lc;
                            $img_upload_path = "../public/assets/images/customer/AddExchangeBook/" . $new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
                
                            $data['img1'] = $new_img_name;
                        }
                    }
                }
                

                if (isset($_FILES['imgBack']['name']) AND !empty($_FILES['imgBack']['name'])) {
                    $img_name = $_FILES['imgBack']['name'];
                    $tmp_name = $_FILES['imgBack']['tmp_name'];
                    $error = $_FILES['imgBack']['error'];
                    
                    if($error === 0){
                       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                       $img_ex_to_lc = strtolower($img_ex);
           
                       $allowed_exs = array('jpg', 'jpeg', 'png');
                       if(in_array($img_ex_to_lc, $allowed_exs)){
                          // Generate a unique identifier (e.g., timestamp)
                          $unique_id = time(); 
                          $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgBack.' . $img_ex_to_lc;
                          $img_upload_path = "../public/assets/images/customer/AddExchangeBook/".$new_img_name;
                          move_uploaded_file($tmp_name, $img_upload_path);

                          $data['img2']=$new_img_name;
                       }
                    }
                }
                if (isset($_FILES['imgInside']['name']) AND !empty($_FILES['imgInside']['name'])) {
                    $img_name = $_FILES['imgInside']['name'];
                    $tmp_name = $_FILES['imgInside']['tmp_name'];
                    $error = $_FILES['imgInside']['error'];
                    
                    if($error === 0){
                       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                       $img_ex_to_lc = strtolower($img_ex);
           
                       $allowed_exs = array('jpg', 'jpeg', 'png');
                       if(in_array($img_ex_to_lc, $allowed_exs)){
                          // Generate a unique identifier (e.g., timestamp)
                          $unique_id = time(); 
                          $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgInside.' . $img_ex_to_lc;
                          $img_upload_path = "../public/assets/images/customer/AddExchangeBook/".$new_img_name;
                          move_uploaded_file($tmp_name, $img_upload_path);

                          $data['img3']=$new_img_name;
                       }
                    }
                }
                
                if($this->customerModel->AddExchangeBook($data)){
                    // flash('add_success','You are added the book  successfully');
                    redirect('customer/ExchangeBooks');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->view('customer/AddExchangeBook',$data);
            }


        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/AddExchangeBook', $data);
        }
    } 
    
    public function AddUsedBook(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // process form
            // sanitize post data
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $customerid = null;
    
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                
                $customerDetails = $this->customerModel->findCustomerById($user_id);
                // $bookCategoryDetails = $this->adminModel->getBookCategories();
                if ($customerDetails) {
                    $customerName = $customerDetails[0]->name;
                    $customerid = $customerDetails[0]->customer_id;                 
                } else {
                    echo "Not found";
                }
            }            
            $data=[
                'book_name' => trim($_POST['bookName']),
                'ISBN_no' => trim($_POST['isbnNumber']),
                // 'ISSN_no' => trim($_POST['issnNumber']),
                // 'ISMN_no' => trim($_POST['issmNumber']),
                'author' => trim($_POST['author']),
                'price' => trim($_POST['price']),
                'category' => trim($_POST['category']),
                'weight' => trim($_POST['weights']),
                'descript' => trim($_POST['descriptions']),
                'img1' => '',
                'img2' => '',
                'img3' => '',
                'condition' => trim($_POST['bookCondition']),
                'published_year' => trim($_POST['publishedYear']),
                'price_type' => trim($_POST['priceType']),
                'type' => trim('used'),
                'account_name' => trim($_POST['accName']),
                'account_no' => trim($_POST['accNumber']),
                'bank_name' => trim($_POST['bankName']),
                'branch_name' => trim($_POST['branchName']),
                'town' => trim($_POST['town']),
                'district' => trim($_POST['district']),
                'postal_code' => trim($_POST['postalCode']),
                'customer_id' => trim($customerid),// Replace this with the actual customer ID
                'status' => trim('pending'),

                'bookName_err' => '',
                'publishedYear_err'=>'',
                'price_err'=>'',
                'weights_err'=>'',
                'ISBN_err'=>'',
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerName
            ];

           
            //validate book name
            // if(empty($data['bookName'])){
            //     $data['bookName_err']='Please enter the Book name';      
            // // }else{
            // //     if($this->publisherModel->findbookByName($data['book_name'])){
            // //         $data['book_name_err']='Book name is already taken'; 
            // //     }
            // }
            
            if(empty($data['published_year'])){
                $data['publishedYear_err']='Please enter published year';      
            }

            if(empty($data['price'])){
                $data['price_err']='Please enter the price';      
            }else if($data['price']<0 ){
                $data['price_err']='Please enter a valid price'; 
            }
            
            if(empty($data['weight'])){
                $data['weights_err']='Please enter the weight';      
            }else if($data['weight']<0 ){
                $data['weights_err']='Please enter a valid weight'; 
            }

            //validate ISBN
            // if(empty($data['ISBN_no']) && empty($data['ISSN_no']) && empty($data['ISMN_no'])){
            //     $data['ISBN_err']='Please enter ISBN _NO or ISSN_NO or ISSM_NO';      
            // }
           
            
            //make sure errors are empty
            if(empty($data['bookName_err']) && empty($data['publishedYear_err']) && empty($data['price_err']) && empty($data['weights_err']) && empty($data['ISBN_err'])){

                //image
                if (isset($_FILES['imgFront']['name']) AND !empty($_FILES['imgFront']['name'])) {
                    $img_name = $_FILES['imgFront']['name'];
                    $tmp_name = $_FILES['imgFront']['tmp_name'];
                    $error = $_FILES['imgFront']['error'];
                    
                    if ($error === 0) {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_to_lc = strtolower($img_ex);
                
                        $allowed_exs = array('jpg', 'jpeg', 'png');
                        if (in_array($img_ex_to_lc, $allowed_exs)) {
                            // Generate a unique identifier (e.g., timestamp)
                            $unique_id = time(); 
                            $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgFront.' . $img_ex_to_lc;
                            $img_upload_path = "../public/assets/images/customer/AddUsedBook/" . $new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
                
                            $data['img1'] = $new_img_name;
                        }
                    }
                }
                

                if (isset($_FILES['imgBack']['name']) AND !empty($_FILES['imgBack']['name'])) {
                    $img_name = $_FILES['imgBack']['name'];
                    $tmp_name = $_FILES['imgBack']['tmp_name'];
                    $error = $_FILES['imgBack']['error'];
                    
                    if($error === 0){
                       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                       $img_ex_to_lc = strtolower($img_ex);
           
                       $allowed_exs = array('jpg', 'jpeg', 'png');
                       if(in_array($img_ex_to_lc, $allowed_exs)){
                          // Generate a unique identifier (e.g., timestamp)
                          $unique_id = time(); 
                          $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgBack.' . $img_ex_to_lc;
                          $img_upload_path = "../public/assets/images/customer/AddUsedBook/".$new_img_name;
                          move_uploaded_file($tmp_name, $img_upload_path);

                          $data['img2']=$new_img_name;
                       }
                    }
                }
                if (isset($_FILES['imgInside']['name']) AND !empty($_FILES['imgInside']['name'])) {
                    $img_name = $_FILES['imgInside']['name'];
                    $tmp_name = $_FILES['imgInside']['tmp_name'];
                    $error = $_FILES['imgInside']['error'];
                    
                    if($error === 0){
                       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                       $img_ex_to_lc = strtolower($img_ex);
           
                       $allowed_exs = array('jpg', 'jpeg', 'png');
                       if(in_array($img_ex_to_lc, $allowed_exs)){
                          // Generate a unique identifier (e.g., timestamp)
                          $unique_id = time(); 
                          $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgInside.' . $img_ex_to_lc;
                          $img_upload_path = "../public/assets/images/customer/AddUsedBook/".$new_img_name;
                          move_uploaded_file($tmp_name, $img_upload_path);

                          $data['img3']=$new_img_name;
                       }
                    }
                }
                
                if($this->customerModel->AddUsedBook($data)){
                    // flash('add_success','You are added the book  successfully');
                    redirect('customer/UsedBooks');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->view('customer/AddUsedBook',$data);
            }


        }else{
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                
                $customerDetails = $this->customerModel->findCustomerById($user_id);
                // $bookCategoryDetails = $this->adminModel->getBookCategories();
                if ($customerDetails) {
                    $accName = $customerDetails[0]->account_name;
                    $accNumber = $customerDetails[0]->account_no; 
                    $bankName = $customerDetails[0]->bank_name; 
                    $branchName = $customerDetails[0]->branch_name;
                    $town = $customerDetails[0]->town; 
                    $district = $customerDetails[0]->district;
                    $postalCode = $customerDetails[0]->postal_code;
                    $customerid = $customerDetails[0]->customer_id;
                    $customerName = $customerDetails[0]->name;

                } else {
                    echo "Not found";
                }
            }     
            $data=[
                'account_name' => trim($accName),
                'account_no' => trim($accNumber),
                'bank_name' => trim($bankName),
                'branch_name' => trim($branchName),
                'town' => trim($town),
                'district' => trim($district),
                'postal_code' => trim($postalCode),
                'customer_id' => trim($customerid),// Replace this with the actual customer ID
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerName
            ];

            $this->view('customer/AddUsedBook',$data);

        }
    } 
    
    public function BookContents(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/BookContents', $data);
        }
    } 
    
    public function BookDetails($book_id){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
            $bookDetails=$this->customerModel->findBookById($book_id);
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerName' => $customerDetails[0]->name,
                'customerImage' => $customerDetails[0]->profile_img,
                'bookDetails'=>$bookDetails
            ];
            $this->view('customer/BookDetails', $data);
        }
    } 
    
    public function BookEvents(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/BookEvents', $data);
        }
    } 
    
    public function Bookshelf(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $customerid = null;
        
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
            
                $customerDetails = $this->customerModel->findCustomerById($user_id);  
                
                if ($customerDetails) {
                    $customerid = $customerDetails[0]->customer_id;
                    $bookDetails1 = $this->customerModel->findUsedBookByCusId($customerid);
                    $bookDetails2 = $this->customerModel->findExchangedBookByCusId($customerid);
                } else {
                    echo "Not found";
                }
            } else {
                echo "Not a customer";
            }

            $data = [
                'customerid' => $customerid,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerDetails' => $customerDetails,
                'bookDetails1' => $bookDetails1,
                'bookDetails2' => $bookDetails2,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Bookshelf', $data);
        }
    } 
    
    public function BuyNewBooks()
{
    if (!isLoggedIn()) {
        redirect('landing/login');
    } else {
        $user_id = $_SESSION['user_id'];
        $customerDetails = $this->customerModel->findCustomerById($user_id); 
        $NewbookDetailsByTime = $this->customerModel->findNewBooksByTime();
        // $recommendedBooks=$this->ordersModel->getUserOrderHistoryWithBooks($customerDetails[0]->customer_id);
        
        // print_r($recommendedBooks) ;
       
        // $recommendedCategories = $this->ordersModel->getRecommendedCategories($customerDetails[0]->customer_id);
        // $recommendedBooks = $this->ordersModel->getRecommendedBooks($recommendedCategories);
        $data = [
            'customerDetails' => $customerDetails,
            'customerImage' => $customerDetails[0]->profile_img,
            'customerName' => $customerDetails[0]->name,
            'bookDetails' => $NewbookDetailsByTime,
            // 'recommendedBooks'=>$recommendedBooks
            // 'bookCategoryDetails' => $bookCategoryDetails
        ];

        $this->view('customer/BuyNewBooks', $data);
    }
}

    
    public function BuyUsedBook(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $customerid = null;

            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
            
                $customerDetails = $this->customerModel->findCustomerById($user_id);
              
                if ($customerDetails) {
                    $customerid = $customerDetails[0]->customer_id;
                    $UsedbookDetailsByTime = $this->customerModel->findUsedBooksByTime($customerid);
                    // $bookDetails = $this->customerModel->findUsedBookByNotCusId($customerid);
                } else {
                    echo "Not found";
                }
            } else {
                echo "Not a customer";
            }
                $data = [
                    'customerid' => $customerid,
                    'customerImage' => $customerDetails[0]->profile_img,
                    'customerDetails' => $customerDetails,
                    'bookDetails' => $UsedbookDetailsByTime,
                    'customerName' => $customerDetails[0]->name
                    
                ];
                $this->view('customer/BuyUsedBook', $data);
        }
    } 
    public function addToCart($bookId) {
        $user_id = $_SESSION['user_id'];
        $customerDetails = $this->customerModel->findCustomerById($user_id);
        $customer_id=$customerDetails[0]->customer_id;
        $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
        
        if ($bookId) {
            if ($this->customerModel->addToCart($bookId, $customer_id, $quantity)) {
                echo json_encode(['status' => 'success']);
                return;
            }
        }
    
        echo json_encode(['status' => 'error', 'message' => 'SQL Error: ' . $e->getMessage()]);

    }
    
    public function Cart(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];

           
            $customerDetails = $this->customerModel->findCustomerById($user_id); 
            $customer_id=$customerDetails[0] ->customer_id;
            $cartDetails=$this->customerModel->findCartById($customer_id);
           
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name,
                'cartDetails'=>$cartDetails,
                
            ];
            
            $this->view('customer/Cart', $data);
        }
    } 
    
    public function ContactUs(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/ContactUs', $data);
        }
    } 
    
    public function Content(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Content', $data);
        }
    } 
    
    public function Dashboard(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Dashboard', $data);
        }
    } 
    
    public function DonateBooks(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/DonateBooks', $data);
        }
    } 

    public function Donatedetails(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Donatedetails', $data);
        }
    } 

    public function Donateform(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Donateform', $data);
        }
    } 

    // public function dropdownmenu(){

    //     $this->view('customer/dropdownmenu');
    // }

    public function Event(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Event', $data);
        }
    } 

    public function ExchangeBook(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        $customerid = null;
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            
            if ($customerDetails) {
                $customerid = $customerDetails[0]->customer_id;
                $bookDetails = $this->customerModel->findExchangedBookByNotCusId($customerid);
            } else {
                echo "Not found";
            }
        } else {
            echo "Not a customer";
        }
        $data = [
            'customerid' => $customerid,
            'customerDetails' => $customerDetails,
            'customerImage' => $customerDetails[0]->profile_img,
            'bookDetails' => $bookDetails,
            'customerName' => $customerDetails[0]->name
        ];
            $this->view('customer/ExchangeBook', $data);
    } 

    public function ExchangeBookDetails($bookId){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        $customerid = null;
        
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            
            if ($customerDetails) {
                
                $customerid = $customerDetails[0]->customer_id;
                
                $bookDetails = $this->customerModel->findExchangedBookByCusId($customerid);
                $ExchangeBookId = $this->customerModel->findUsedBookById($bookId);

            } else {
                echo "Not found";
            }
        } else {
            echo "Not a customer";
        }

        $data = [
            'customerid' => $customerid,
            'customerDetails' => $customerDetails,
            'bookDetails' => $bookDetails,
            'ExchangeBookId' => $ExchangeBookId,
            'customerName' => $customerDetails[0]->name,
            'customerImage' => $customerDetails[0]->profile_img,

            'book_id' => $bookId,
            'book_name' => $ExchangeBookId->book_name,
            'ISBN_no' => $ExchangeBookId->ISBN_no,
            'author' => $ExchangeBookId->author,
            'category' => $ExchangeBookId->category,
            'weight' => $ExchangeBookId->weight,
            'descript' => $ExchangeBookId->descript,
            'booksIWant' => $ExchangeBookId->booksIWant,
            'img1' => $ExchangeBookId->img1,
            'img2' => $ExchangeBookId->img2,
            'img3' => $ExchangeBookId->img3,
            'condition' => $ExchangeBookId->condition,
            'published_year' => $ExchangeBookId->published_year,
            'town' => $ExchangeBookId->town,
            'district' => $ExchangeBookId->district,
            'postal_code' => $ExchangeBookId->postal_code
        ];
        $this->view('customer/ExchangeBookDetails', $data);
    } 

    public function ExchangeBooks(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        $customerid = null;
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            
            if ($customerDetails) {
                $customerid = $customerDetails[0]->customer_id;
                $bookDetails = $this->customerModel->findExchangedBookByCusId($customerid);
            } else {
                echo "Not found";
            }
        } else {
            echo "Not a customer";
        }
        $data = [
            'customerid' => $customerid,
            'customerDetails' => $customerDetails,
            'bookDetails' => $bookDetails,
            'customerImage' => $customerDetails[0]->profile_img,
            'customerName' => $customerDetails[0]->name
        ];
            $this->view('customer/ExchangeBooks', $data);
    } 

    // public function index(){
        
    //     $this->view('customer/index');
    // } 

    public function Notification(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id); 
            $messageDetails = $this->publisherModel->findMessageByUserId($user_id); 
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name,
                'messageDetails'=>$messageDetails
            ];
            $this->view('customer/Notification', $data);
        }
    } 

    public function ChangeProfImage(){
        if (!isLoggedIN()) {
            redirect('landing/login');
        }
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $customerid = null;

            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $customerDetails = $this->customerModel->findCustomerById($user_id);
                // $bookCategoryDetails = $this->adminModel->getBookCategories();
                if ($customerDetails) {
                    $customerName = $customerDetails[0]->name;
                    $customerid = $customerDetails[0]->customer_id;                 
                } else {
                    echo "Not found";
                }
            }
            $data=[
                'customerName' => $customerName,
                'customer_id' => $customerid,
                'profile_img' => '',
            ];

            if (isset($_FILES['newImage']['name']) AND !empty($_FILES['newImage']['name'])) {
                $img_name = $_FILES['newImage']['name'];
                $tmp_name = $_FILES['newImage']['tmp_name'];
                $error = $_FILES['newImage']['error'];
                
                if ($error === 0) {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_to_lc = strtolower($img_ex);
            
                    $allowed_exs = array('jpg', 'jpeg', 'png');
                    if (in_array($img_ex_to_lc, $allowed_exs)) {
                        // Generate a unique identifier (e.g., timestamp)
                        $unique_id = time(); 
                        $new_img_name = $customerName . '-' . $unique_id . '-newImage.' . $img_ex_to_lc;
                        $img_upload_path = "../public/assets/images/customer/ProfileImages/" . $new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);
            
                        $data['profile_img'] = $new_img_name;
                    }
                }
            }

            if($this->customerModel->ChangeProfImage($data)){
                // flash('add_success','You are added the book  successfully');
                redirect('customer/Profile',$data);
            }else{
                die('Something went wrong');
            }
        }
    }

    public function Profile(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $customerid = null;
    
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $customerDetails = $this->customerModel->findCustomerById($user_id);
                // $bookCategoryDetails = $this->adminModel->getBookCategories();
                if ($customerDetails) {
                    $customerName = $customerDetails[0]->name;
                    $customerid = $customerDetails[0]->customer_id;                 
                } else {
                    echo "Not found";
                }
            }            
            $data=[
                'customerName' => $customerName,
                'customer_id' => $customerid,
                'profile_img' => $customerDetails[0]->profile_img,
                'first_name' => trim($_POST['FName']),
                'last_name' => trim($_POST['LName']),
                'email' => trim($_POST['email']),
                'contact_number' => trim($_POST['ContactNo']),
                'postal_name' => trim($_POST['Address']),
                'street_name' => trim($_POST['Province']),
                'town' => trim($_POST['city']),
                'district' => trim($_POST['District']),
                'postal_code' => trim($_POST['PostalCode']),
                'account_name' => trim($_POST['AccName']),
                'account_no' => trim($_POST['AccNo']),
                'bank_name' => trim($_POST['BankName']),
                'branch_name' => trim($_POST['BranchName']),
            ];
            
            if (isset($_FILES['newImage']['name']) AND !empty($_FILES['newImage']['name'])) {
                $img_name = $_FILES['newImage']['name'];
                $tmp_name = $_FILES['newImage']['tmp_name'];
                $error = $_FILES['newImage']['error'];
                
                if ($error === 0) {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_to_lc = strtolower($img_ex);
            
                    $allowed_exs = array('jpg', 'jpeg', 'png');
                    if (in_array($img_ex_to_lc, $allowed_exs)) {
                        // Generate a unique identifier (e.g., timestamp)
                        $unique_id = time(); 
                        $new_img_name = $customerName . '-' . $unique_id . '-newImage.' . $img_ex_to_lc;
                        $img_upload_path = "../public/assets/images/customer/ProfileImages/" . $new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);
            
                        $data['profile_img'] = $new_img_name;
                    }
                }
            }

            if($this->customerModel->Profile($data)){
                // flash('add_success','You are added the book  successfully');
                redirect('customer/Profile');
            }else{
                die('Something went wrong');
            }
        } else {
            $user_id = $_SESSION['user_id'];
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerName' => $customerDetails[0]->name,
                'customerImage' => $customerDetails[0]->profile_img,
                'FName' => $customerDetails[0]->first_name,
                'LName' => $customerDetails[0]->last_name,
                'customerEmail' => $customerDetails[0]->email,
                'ContactNumber' => $customerDetails[0]->contact_number,
                'Address' => $customerDetails[0]->postal_name,
                'Province' => $customerDetails[0]->street_name,
                'District' => $customerDetails[0]->	district,
                'City' => $customerDetails[0]->town,
                'PostalCode' => $customerDetails[0]->postal_code,
                'AccName' => $customerDetails[0]->account_name,
                'AccNumber' => $customerDetails[0]->account_no,
                'BankName' => $customerDetails[0]->bank_name,
                'BranchName' => $customerDetails[0]->branch_name,
            ];
            $this->view('customer/Profile', $data);
        }
    } 

    public function Services(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Services', $data);
        }
    } 

    // public function sidebar(){

    //     $this->view('customer/sidebar');
    // }

    public function updateusedbook($bookId){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        $user_id = $_SESSION['user_id'];
       
        $customerDetails = $this->customerModel->findCustomerById($user_id);
        $customer_id=$customerDetails[0]->customer_id;

        // $data = [
        //     'customerDetails' => $customerDetails,
        //     'customerName' => $customerDetails[0]->name
        // ];
        //     $this->view('customer/updateusedbook', $data);

        if($_SERVER['REQUEST_METHOD']=='POST'){
            // process form
            // sanitize post data
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);


                      
            $data=[
                'book_id'=>$bookId,
                'book_name' => trim($_POST['bookName']),
                'ISBN_no' => trim($_POST['isbnNumber']),
                // 'ISSN_no' => trim($_POST['issnNumber']),
                // 'ISMN_no' => trim($_POST['issmNumber']),
                'author' => trim($_POST['author']),
                'price' => trim($_POST['price']),
                'category' => trim($_POST['category']),
                'weight' => trim($_POST['weights']),
                'descript' => trim($_POST['descriptions']),
                'img1' => '',
                'img2' => '',
                'img3' => '',
                'condition' => trim($_POST['bookCondition']),
                'published_year' => trim($_POST['publishedYear']),
                'price_type' => trim($_POST['priceType']),
                'type' => trim('used'),
                'account_name' => trim($_POST['accName']),
                'account_no' => trim($_POST['accNumber']),
                'bank_name' => trim($_POST['bankName']),
                'branch_name' => trim($_POST['branchName']),
                'town' => trim($_POST['town']),
                'district' => trim($_POST['district']),
                'postal_code' => trim($_POST['postalCode']),
                'customer_id' => trim($customer_id),// Replace this with the actual customer ID
                'status' => trim('pending'),

                'bookName_err' => '',
                'publishedYear_err'=>'',
                'price_err'=>'',
                'weights_err'=>'',
                'ISBN_err'=>'',
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];

           
            //validate book name
            // if(empty($data['bookName'])){
            //     $data['bookName_err']='Please enter the Book name';      
            // // }else{
            // //     if($this->publisherModel->findbookByName($data['book_name'])){
            // //         $data['book_name_err']='Book name is already taken'; 
            // //     }
            // }
            
            if(empty($data['published_year'])){
                $data['publishedYear_err']='Please enter published year';      
            }

            if(empty($data['price'])){
                $data['price_err']='Please enter the price';      
            }else if($data['price']<0 ){
                $data['price_err']='Please enter a valid price'; 
            }
            
            if(empty($data['weight'])){
                $data['weights_err']='Please enter the weight';      
            }else if($data['weight']<0 ){
                $data['weights_err']='Please enter a valid weight'; 
            }

            //validate ISBN
            // if(empty($data['ISBN_no']) && empty($data['ISSN_no']) && empty($data['ISMN_no'])){
            //     $data['ISBN_err']='Please enter ISBN _NO or ISSN_NO or ISSM_NO';      
            // }
           
            
            //make sure errors are empty
            if(empty($data['bookName_err']) && empty($data['publishedYear_err']) && empty($data['price_err']) && empty($data['weights_err']) && empty($data['ISBN_err'])){

                //image
                if (isset($_FILES['imgFront']['name']) AND !empty($_FILES['imgFront']['name'])) {
                    $img_name = $_FILES['imgFront']['name'];
                    $tmp_name = $_FILES['imgFront']['tmp_name'];
                    $error = $_FILES['imgFront']['error'];
                    
                    if ($error === 0) {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_to_lc = strtolower($img_ex);
                
                        $allowed_exs = array('jpg', 'jpeg', 'png');
                        if (in_array($img_ex_to_lc, $allowed_exs)) {
                            // Generate a unique identifier (e.g., timestamp)
                            $unique_id = time(); 
                            $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgFront.' . $img_ex_to_lc;
                            $img_upload_path = "../public/assets/images/customer/AddUsedBook/" . $new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
                
                            $data['img1'] = $new_img_name;
                        }
                    }
                }
                
                

                if (isset($_FILES['imgBack']['name']) AND !empty($_FILES['imgBack']['name'])) {
                    $img_name = $_FILES['imgBack']['name'];
                    $tmp_name = $_FILES['imgBack']['tmp_name'];
                    $error = $_FILES['imgBack']['error'];
                    
                    if($error === 0){
                       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                       $img_ex_to_lc = strtolower($img_ex);
           
                       $allowed_exs = array('jpg', 'jpeg', 'png');
                       if(in_array($img_ex_to_lc, $allowed_exs)){
                          // Generate a unique identifier (e.g., timestamp)
                          $unique_id = time(); 
                          $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgBack.' . $img_ex_to_lc;
                          $img_upload_path = "../public/assets/images/customer/AddUsedBook/".$new_img_name;
                          move_uploaded_file($tmp_name, $img_upload_path);

                          $data['img2']=$new_img_name;
                       }
                    }
                }
                if (isset($_FILES['imgInside']['name']) AND !empty($_FILES['imgInside']['name'])) {
                    $img_name = $_FILES['imgInside']['name'];
                    $tmp_name = $_FILES['imgInside']['tmp_name'];
                    $error = $_FILES['imgInside']['error'];
                    
                    if($error === 0){
                       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                       $img_ex_to_lc = strtolower($img_ex);
           
                       $allowed_exs = array('jpg', 'jpeg', 'png');
                       if(in_array($img_ex_to_lc, $allowed_exs)){
                          // Generate a unique identifier (e.g., timestamp)
                          $unique_id = time(); 
                          $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgInside.' . $img_ex_to_lc;
                          $img_upload_path = "../public/assets/images/customer/AddUsedBook/".$new_img_name;
                          move_uploaded_file($tmp_name, $img_upload_path);

                          $data['img3']=$new_img_name;
                       }
                    }
                }
                
                if($this->customerModel->updateusedbook($data)){
                    // flash('update_success','You are added the book  successfully');
                    redirect('customer/UsedBooks');
                }else{
                    die('Something went wrong');
                }
                }else{
                    $this->view('customer/updateusedbook', $data);
                }


        }else{
            $UsedBookId = $this->customerModel->findUsedBookById($bookId);
            // $books = $this->publisherModel->findBookById($book_id);
            if($UsedBookId->customer_id != $customer_id){
                redirect('customer/UsedBooks');
              }
            $data = [
                // 'customerName'=>$customerName,
                'book_id' => $bookId,
                'book_name' => $UsedBookId->book_name,
                'ISBN_no' => $UsedBookId->ISBN_no,
                'author' => $UsedBookId->author,
                'price' => $UsedBookId->price,
                'category' => $UsedBookId->category,
                'weight' => $UsedBookId->weight,
                'descript' => $UsedBookId->descript,
                'img1' => $UsedBookId->img1,
                'img2' => $UsedBookId->img2,
                'img3' => $UsedBookId->img3,
                'condition' => $UsedBookId->condition,
                'published_year' => $UsedBookId->published_year,
                'price_type' => $UsedBookId->price_type,
                'account_name' => $UsedBookId->account_name,
                'account_no' => $UsedBookId->account_no,
                'bank_name' => $UsedBookId->bank_name,
                'branch_name' => $UsedBookId->branch_name,
                'town' => $UsedBookId->town,
                'district' => $UsedBookId->district,
                'postal_code' => $UsedBookId->postal_code,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];


            $this->view('customer/updateusedbook', $data);

        }
    } 

    public function updateexchangebook($bookId){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        $user_id = $_SESSION['user_id'];
       
        $customerDetails = $this->customerModel->findCustomerById($user_id);
        $customer_id=$customerDetails[0]->customer_id;

        // $data = [
        //     'customerDetails' => $customerDetails,
        //     'customerName' => $customerDetails[0]->name
        // ];
        //     $this->view('customer/updateusedbook', $data);

        if($_SERVER['REQUEST_METHOD']=='POST'){
            // process form
            // sanitize post data
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);


                      
            $data=[
                'book_id'=>$bookId,
                'book_name' => trim($_POST['bookName']),
                'ISBN_no' => trim($_POST['isbnNumber']),
                'author' => trim($_POST['author']),
                'category' => trim($_POST['category']),
                'weight' => trim($_POST['weights']),
                'descript' => trim($_POST['description1']),
                'booksIWant' => trim($_POST['description2']),
                'img1' => '',
                'img2' => '',
                'img3' => '',
                'condition' => trim($_POST['bookCondition']),
                'published_year' => trim($_POST['publishedYear']),
                'type' => trim('exchanged'),
                'town' => trim($_POST['town']),
                'district' => trim($_POST['district']),
                'postal_code' => trim($_POST['postalCode']),
                'customer_id' => trim($customer_id),// Replace this with the actual customer ID
                'status' => trim('pending'),

                'bookName_err' => '',
                'publishedYear_err'=>'',
                'price_err'=>'',
                'weights_err'=>'',
                'ISBN_err'=>'',
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            
            if(empty($data['published_year'])){
                $data['publishedYear_err']='Please enter published year';      
            }
            
            if(empty($data['weight'])){
                $data['weights_err']='Please enter the weight';      
            }else if($data['weight']<0 ){
                $data['weights_err']='Please enter a valid weight'; 
            }

            if(empty($data['bookName_err']) && empty($data['publishedYear_err']) && empty($data['price_err']) && empty($data['weights_err']) && empty($data['ISBN_err'])){

                //image
                if (isset($_FILES['imgFront']['name']) AND !empty($_FILES['imgFront']['name'])) {
                    $img_name = $_FILES['imgFront']['name'];
                    $tmp_name = $_FILES['imgFront']['tmp_name'];
                    $error = $_FILES['imgFront']['error'];
                    
                    if ($error === 0) {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_to_lc = strtolower($img_ex);
                
                        $allowed_exs = array('jpg', 'jpeg', 'png');
                        if (in_array($img_ex_to_lc, $allowed_exs)) {
                            // Generate a unique identifier (e.g., timestamp)
                            $unique_id = time(); 
                            $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgFront.' . $img_ex_to_lc;
                            $img_upload_path = "../public/assets/images/customer/AddExchangeBook/" . $new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
                
                            $data['img1'] = $new_img_name;
                        }
                    }
                }
                
                

                if (isset($_FILES['imgBack']['name']) AND !empty($_FILES['imgBack']['name'])) {
                    $img_name = $_FILES['imgBack']['name'];
                    $tmp_name = $_FILES['imgBack']['tmp_name'];
                    $error = $_FILES['imgBack']['error'];
                    
                    if($error === 0){
                       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                       $img_ex_to_lc = strtolower($img_ex);
           
                       $allowed_exs = array('jpg', 'jpeg', 'png');
                       if(in_array($img_ex_to_lc, $allowed_exs)){
                          // Generate a unique identifier (e.g., timestamp)
                          $unique_id = time(); 
                          $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgBack.' . $img_ex_to_lc;
                          $img_upload_path = "../public/assets/images/customer/AddExchangeBook/".$new_img_name;
                          move_uploaded_file($tmp_name, $img_upload_path);

                          $data['img2']=$new_img_name;
                       }
                    }
                }
                if (isset($_FILES['imgInside']['name']) AND !empty($_FILES['imgInside']['name'])) {
                    $img_name = $_FILES['imgInside']['name'];
                    $tmp_name = $_FILES['imgInside']['tmp_name'];
                    $error = $_FILES['imgInside']['error'];
                    
                    if($error === 0){
                       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                       $img_ex_to_lc = strtolower($img_ex);
           
                       $allowed_exs = array('jpg', 'jpeg', 'png');
                       if(in_array($img_ex_to_lc, $allowed_exs)){
                          // Generate a unique identifier (e.g., timestamp)
                          $unique_id = time(); 
                          $new_img_name = $data['book_name'] . '-' . $unique_id . '-imgInside.' . $img_ex_to_lc;
                          $img_upload_path = "../public/assets/images/customer/AddExchangeBook/".$new_img_name;
                          move_uploaded_file($tmp_name, $img_upload_path);

                          $data['img3']=$new_img_name;
                       }
                    }
                }
                
                if($this->customerModel->updateexchangebook($data)){
                    // flash('update_success','You are added the book  successfully');
                    redirect('customer/ExchangeBooks');
                }else{
                    die('Something went wrong');
                }
                }else{
                    $this->view('customer/updateexchangebook', $data);
                }


        }else{
            $ExchangeBookId = $this->customerModel->findUsedBookById($bookId);
            // $books = $this->publisherModel->findBookById($book_id);
            if($ExchangeBookId->customer_id != $customer_id){
                redirect('customer/ExchangeBooks');
            }
            $data = [
                // 'customerName'=>$customerName,
                'book_id' => $bookId,
                'book_name' => $ExchangeBookId->book_name,
                'ISBN_no' => $ExchangeBookId->ISBN_no,
                'author' => $ExchangeBookId->author,
                'category' => $ExchangeBookId->category,
                'weight' => $ExchangeBookId->weight,
                'descript' => $ExchangeBookId->descript,
                'booksIWant' => $ExchangeBookId->booksIWant,
                'img1' => $ExchangeBookId->img1,
                'img2' => $ExchangeBookId->img2,
                'img3' => $ExchangeBookId->img3,
                'condition' => $ExchangeBookId->condition,
                'published_year' => $ExchangeBookId->published_year,
                'town' => $ExchangeBookId->town,
                'district' => $ExchangeBookId->district,
                'postal_code' => $ExchangeBookId->postal_code,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];


            $this->view('customer/updateexchangebook', $data);

        }
    }

    public function deleteusedbook($bookId)
    {
        if ($this->customerModel->deleteusedbook($bookId)) {   
            // flash('post_message', 'book is Removed');
            redirect('customer/UsedBooks');
            
            
        } else {
            die('Something went wrong');
        }
    }

    public function deleteexchangebook($bookId)
    {
        if ($this->customerModel->deleteusedbook($bookId)) {   
            // flash('post_message', 'book is Removed');
            redirect('customer/ExchangeBooks');
            
            
        } else {
            die('Something went wrong');
        }
    }

    public function UsedBooks(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        $customerid = null;
        
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            
            if ($customerDetails) {
                $customerid = $customerDetails[0]->customer_id;
                $bookDetails = $this->customerModel->findUsedBookByCusId($customerid);
            } else {
                echo "Not found";
            }
        } else {
            echo "Not a customer";
        }

        $data = [
            'customerid' => $customerid,
            'customerDetails' => $customerDetails,
            'bookDetails' => $bookDetails,
            'customerImage' => $customerDetails[0]->profile_img,
            'customerName' => $customerDetails[0]->name
        ];

        $this->view('customer/UsedBooks', $data);
    } 

    public function ViewBook($bookId){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        $customerid = null;
        
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            
            if ($customerDetails) {
                
                $customerid = $customerDetails[0]->customer_id;
                
                $bookDetails = $this->customerModel->findUsedBookByCusId($customerid);
                $UsedBookId = $this->customerModel->findUsedBookById($bookId);
                
                // if($bookDetails && $UsedBookId ){
                //     if($this->customerModel->changeStatus($bookId)){
                //         flash('post_message', 'change status');
                //     }else {
                //         echo "Not found";
                //     }
                // }

            } else {
                echo "Not found";
            }
        } else {
            echo "Not a customer";
        }

        $data = [
            'customerid' => $customerid,
            'customerDetails' => $customerDetails,
            'bookDetails' => $bookDetails,
            'UsedBookId' => $UsedBookId,
            'customerName' => $customerDetails[0]->name,
            'customerImage' => $customerDetails[0]->profile_img,

            'book_id' => $bookId,
            'book_name' => $UsedBookId->book_name,
            'ISBN_no' => $UsedBookId->ISBN_no,
            'author' => $UsedBookId->author,
            'price' => $UsedBookId->price,
            'category' => $UsedBookId->category,
            'weight' => $UsedBookId->weight,
            'descript' => $UsedBookId->descript,
            'img1' => $UsedBookId->img1,
            'img2' => $UsedBookId->img2,
            'img3' => $UsedBookId->img3,
            'condition' => $UsedBookId->condition,
            'published_year' => $UsedBookId->published_year,
            'price_type' => $UsedBookId->price_type,
            'account_name' => $UsedBookId->account_name,
            'account_no' => $UsedBookId->account_no,
            'bank_name' => $UsedBookId->bank_name,
            'branch_name' => $UsedBookId->branch_name,
            'town' => $UsedBookId->town,
            'district' => $UsedBookId->district,
            'postal_code' => $UsedBookId->postal_code
        ];
        $this->view('customer/ViewBook', $data);
    } 

    public function ViewBookExchange($bookId){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        $customerid = null;
        
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            
            if ($customerDetails) {
                
                $customerid = $customerDetails[0]->customer_id;
                
                $bookDetails = $this->customerModel->findExchangedBookByCusId($customerid);
                $ExchangeBookId = $this->customerModel->findUsedBookById($bookId);

            } else {
                echo "Not found";
            }
        } else {
            echo "Not a customer";
        }

        $data = [
            'customerid' => $customerid,
            'customerDetails' => $customerDetails,
            'bookDetails' => $bookDetails,
            'ExchangeBookId' => $ExchangeBookId,
            'customerName' => $customerDetails[0]->name,
            'customerImage' => $customerDetails[0]->profile_img,

            'book_id' => $bookId,
            'book_name' => $ExchangeBookId->book_name,
            'ISBN_no' => $ExchangeBookId->ISBN_no,
            'author' => $ExchangeBookId->author,
            'category' => $ExchangeBookId->category,
            'weight' => $ExchangeBookId->weight,
            'descript' => $ExchangeBookId->descript,
            'booksIWant' => $ExchangeBookId->booksIWant,
            'img1' => $ExchangeBookId->img1,
            'img2' => $ExchangeBookId->img2,
            'img3' => $ExchangeBookId->img3,
            'condition' => $ExchangeBookId->condition,
            'published_year' => $ExchangeBookId->published_year,
            'town' => $ExchangeBookId->town,
            'district' => $ExchangeBookId->district,
            'postal_code' => $ExchangeBookId->postal_code
        ];
        $this->view('customer/ViewBookExchange', $data);
    }

    public function viewcontent(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/viewcontent', $data);
        }
    } 

    public function viewevents(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/viewevents', $data);
        }
    } 

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
       
        unset($_SESSION['user_pass']);
        session_destroy();
        redirect('landing/index');
    }

    public function TopCategory(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/TopCategory', $data);
        }
    }

    public function TopAuthor(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/TopAuthor', $data);
        }
    }

    public function Recommended(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Recommended', $data);
        }
    }

    public function UsedBookDetails($bookId){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } 
        $customerid = null;
        
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            
            if ($customerDetails) {
                
                $customerid = $customerDetails[0]->customer_id;
                
                $bookDetails = $this->customerModel->findUsedBookByCusId($customerid);
                $UsedBookId = $this->customerModel->findUsedBookById($bookId);

                
                // if($bookDetails && $UsedBookId ){
                //     if($this->customerModel->changeStatus($bookId)){
                //         flash('post_message', 'change status');
                //     }else {
                //         echo "Not found";
                //     }
                // }

            } else {
                echo "Not found";
            }
        } else {
            echo "Not a customer";
        }

        $data = [
            'customer_user_id'=>$UsedBookId->customer_user_id,
            'customerid' => $customerid,
            'customerDetails' => $customerDetails,
            'bookDetails' => $bookDetails,
            'UsedBookId' => $UsedBookId,
            'customerName' => $customerDetails[0]->name,
            'customerImage' => $customerDetails[0]->profile_img,

            'book_id' => $bookId,
            'book_name' => $UsedBookId->book_name,
            'ISBN_no' => $UsedBookId->ISBN_no,
            'author' => $UsedBookId->author,
            'price' => $UsedBookId->price,
            'category' => $UsedBookId->category,
            'weight' => $UsedBookId->weight,
            'descript' => $UsedBookId->descript,
            'img1' => $UsedBookId->img1,
            'img2' => $UsedBookId->img2,
            'img3' => $UsedBookId->img3,
            'condition' => $UsedBookId->condition,
            'published_year' => $UsedBookId->published_year,
            'price_type' => $UsedBookId->price_type,
            'account_name' => $UsedBookId->account_name,
            'account_no' => $UsedBookId->account_no,
            'bank_name' => $UsedBookId->bank_name,
            'branch_name' => $UsedBookId->branch_name,
            'town' => $UsedBookId->town,
            'district' => $UsedBookId->district,
            'postal_code' => $UsedBookId->postal_code
        ];
        $this->view('customer/UsedBookDetails', $data);
    }

    public function Favorite(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Favorite', $data);
        }
    }



    public function Calender(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/Calender', $data);
        }
    }

    
    public function BookChallenge(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);  
            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name
            ];
            $this->view('customer/BookChallenge', $data);
        }
    }

    public function Order(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $customerDetails = $this->customerModel->findCustomerById($user_id);
            $orderDetails=$this->ordersModel->findOrdersByCustomerId( $customerDetails[0]->customer_id);

            $data = [
                'customerDetails' => $customerDetails,
                'customerImage' => $customerDetails[0]->profile_img,
                'customerName' => $customerDetails[0]->name,
                'orderDetails'=>$orderDetails
            ];
            $this->view('customer/Order', $data);
        }
    }

    public function filterbook(){
        if(isset($_POST['query']) && isset($_POST['bookType'])){
            $inputText = $_POST['query'];
            $bookType = $_POST['bookType'];
            $searchResults ='';
            
            if($bookType=='N'){
                $searchResults = $this->customerModel->searchNewBooks($inputText);
            }
            else if($bookType=='U'){
                $searchResults = $this->customerModel->searchUsedBooks($inputText);
            }
            
            $data = [
                'searchResults' => $searchResults,
                'inputText' => $inputText,
                'bookType'=>$bookType,
            ];
            $this->view('customer/filterbook', $data);
        }
    }
    


}