<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require APPROOT . '\vendor\autoload.php';
class Delivery extends Controller{
    private $deliveryModel;
    private $adminModel;
    private $userModel;
    private $orderModel;
    private $publisherModel;
    private $db;
    public function __construct(){
        $this->deliveryModel=$this->model('deliver');
        $this->userModel=$this->model('User');
        $this->orderModel=$this->model('Orders');
        $this->publisherModel=$this->model('Publishers'); 
        $this->adminModel=$this->model('Admins'); 
        $this->db = new Database();
    }
    public function index(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
            $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
            if ($deliveryDetails !== null) {
                $deliveryName = $deliveryDetails[0]->name;
                // Rest of your code...
            }
            
            $data = [
                'deliveryDetails' => $deliveryDetails,
                'deliveryName'=>$deliveryName
            ];
            $this->view('delivery/index', $data);
        }
       
       
    }
    public function updatePricePerOne($delivery_id){
        if(!isLoggedIn()){
            redirect('landing/login');
        }
    
        $user_id = $_SESSION['user_id'];
        $deliveryDetails=$this->deliveryModel->findDeliveryById($user_id);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Form submitted, process the data
    
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'deliveryDetails'=>$deliveryDetails,
                'deliveryName'=>$deliveryDetails[0]->name,
             
                'delivery_id' => $delivery_id,
                'priceperkilo' => trim($_POST['priceperkilo']),
                
                'priceperkilo_err' => '',
            ];
               
                   
                
                if(empty($data['priceperkilo'])){
                    $data['priceperkilo_err']='Please enter the charge for per additional kilo gram';      
                }else if($data['priceperkilo']<0 ){
                    $data['priceperkilo_err']='Please enter a valid price'; 
                }
               
    
                //make sure errors are empty
                if( empty($data['priceperkilo_err'])   ){   
                    if($this->deliveryModel->updatePricePerOne($data)){
                        flash('update_success','You are added the book  successfully');
                        redirect('delivery/index');
                    }else{
                        die('Something went wrong');
                    }
                }else{
                        $this->view('delivery/updatePricePerOne',$data);
                    }
                   
            }else{
                     
                $delivers = $this->deliveryModel->finddeliveryByDelId($delivery_id);
                
                
                $data = [
                    
                    'delivery_id' => $delivery_id,
                    'priceperkilo' => $delivers->priceperkilo,
                    
                    'priceperkilo_err'=>'',
                    'deliveryName'=>$delivers->name
                   
                ];
                $this->view('delivery/updatePricePerOne',$data);
    
            }  
        
    }
    public function updatepriceAdditional($delivery_id){
        if(!isLoggedIn()){
            redirect('landing/login');
        }
    
        $user_id = $_SESSION['user_id'];
        $deliveryDetails=$this->deliveryModel->findDeliveryById($user_id);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Form submitted, process the data
    
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'deliveryDetails'=>$deliveryDetails,
                'delivery_id' => $delivery_id,
                'priceperadditional' => trim($_POST['priceperadditional']),
                
                'priceperadditional_err' => '',
            ];
               
                   
                
                if(empty($data['priceperadditional'])){
                    $data['priceperadditional_err']='Please enter the charge for per additional kilo gram';      
                }else if($data['priceperadditional']<0 ){
                    $data['priceperadditional_err']='Please enter a valid price'; 
                }
               
    
                //make sure errors are empty
                if( empty($data['priceperadditional_err'])   ){   
                    if($this->deliveryModel->updatepriceAdditional($data)){
                        flash('update_success','You are added the book  successfully');
                        redirect('delivery/index');
                    }else{
                        die('Something went wrong');
                    }
                }else{
                        $this->view('delivery/updatepriceAdditional',$data);
                    }
                   
            }else{
                     
                $delivers = $this->deliveryModel->finddeliveryByDelId($delivery_id);
                
                
                $data = [
                    
                    'delivery_id' => $delivery_id,
                    'priceperadditional' => $delivers->priceperadditional,
                    
                    'priceperadditional_err'=>'',
                   
                ];


                $this->view('delivery/updatepriceAdditional',$data);
    
            }  
        
    }
    
    public function shippingorders(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
    
        $deliveryid = null;
    
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
    
            $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
            $orderDetails = $this->orderModel->findBookShippingOrders();
    
            $senderName = $receiverName = $senderStreet = $senderTown = $senderDistrict = $senderPostalCode = $receiverStreet = $receiverTown = $receiverDistrict = $receiverPostalCode = '';
    
            
        } else {
            echo "Not logged in as a publisher";
        }
        $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
        $data = [
            'orderDetails'=>$orderDetails,
            'deliveryName'=>$deliveryDetails[0]->name
        ];
       
        $this->view('delivery/shippingorders',$data);
    }
    public function notification(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            
            $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
           
            if ($deliveryDetails) {
               
                $deliveryid = $deliveryDetails[0]->delivery_id;
              
                $messageDetails = $this->deliveryModel->findMessageByUserId($user_id);
                $unreadCount = $this->publisherModel->getUnreadMessagesCount($user_id);
                // $messageDetails2 = $this->deliveryModel->getMessageById($message_id);
                // if($messageDetails){
                //     if($this->publisherModel->changeStatus($message_id)){
                //         flash('post_message', 'change status');
                //     }else {
                //         echo "Not found";
                //     }
                // }
            } else {
                echo "Not found";
            }
        } else {
            echo "Not a publisher";
        }
    
        $data = [
            'unreadCount'=>$unreadCount,
            'deliveryid' => $deliveryid,
            'deliveryDetails' => $deliveryDetails,
            'messageDetails' => $messageDetails,
           
            'deliveryName'  =>$deliveryDetails[0] ->name
        ];
    

        $this->view('delivery/notification',$data);
    }
    
    public function deliveredorders(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
    
        $deliveryid = null;
    
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
    
            $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
            $orderDetails = $this->orderModel->findBookDeliveredOrders();
    
            $senderName = $receiverName = $senderStreet = $senderTown = $senderDistrict = $senderPostalCode = $receiverStreet = $receiverTown = $receiverDistrict = $receiverPostalCode = '';
    
            
        } else {
            echo "Not logged in as a publisher";
        }
        $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
        $data = [
            'orderDetails'=>$orderDetails,
            'deliveryName'=>$deliveryDetails[0]->name
           
        ];
       
        $this->view('delivery/deliveredorders',$data);
    }
    public function returnedorders(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
    
        $deliveryid = null;
    
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
    
            $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
            $orderDetails = $this->orderModel->findBookReturnedOrders();
    
            $senderName = $receiverName = $senderStreet = $senderTown = $senderDistrict = $senderPostalCode = $receiverStreet = $receiverTown = $receiverDistrict = $receiverPostalCode = '';
    
            
        } else {
            echo "Not logged in as a publisher";
        }
        $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
        $data = [
            'orderDetails'=>$orderDetails,
            'deliveryName'=>$deliveryDetails[0]->name
           
        ];
        $this->view('delivery/returnedorders',$data);
    }
    public function processedorders() {
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
    
        $deliveryid = null;
    
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
    
            $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
            $orderDetails = $this->orderModel->findBookProOrders();
    
            $sender_id = $senderName = $receiverName = $senderStreet = $senderTown = $senderDistrict = $senderPostalCode = $receiverStreet = $receiverTown = $receiverDistrict = $receiverPostalCode = '';
    
            
        } else {
            echo "Not logged in as a publisher";
        }
        $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
        $data = [
            'orderDetails'=>$orderDetails,
            'deliveryName'=>$deliveryDetails[0]->name
           
        ];
    
        $this->view('delivery/processedorders', $data);
    }
    public function pickedUp($order_id){
        if (!isLoggedIn()) {
            redirect('landing/login');

        }
        $user_id = $_SESSION['user_id'];
    
        $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
        $orderDetails=$this->deliveryModel->findOrderById($order_id);
        $customer_id=$orderDetails[0]->customer_id;
        $customerDetails=$this->deliveryModel->findCustomerById($customer_id);
        $book_id = $orderDetails[0]->book_id;
        $bookDetails = $this->adminModel->getBookDetailsById($book_id);

        if ($bookDetails[0]->type == 'new') {
            $user_idPub = $bookDetails[0]->publisher_id;
            $ownerDetails = $this->adminModel->getPublisherDetailsById($user_idPub);
            $ownerEmail = $ownerDetails[0]->email;
        } else if ($bookDetails[0]->type == 'used' || $bookDetails[0]->type == 'exchanged') {
            $user_idPub = $bookDetails[0]->customer_id;
            $ownerDetails = $this->adminModel->getPublisherDetailsById($user_idPub);
            $ownerEmail = $ownerDetails[0]->email;
        }

        $data=[
           

            'sender_name'=>$deliveryDetails[0]->name,
            'messageToPublisher' => "Picked up   your order from  your location  successfully",
            'user_idPub' => $ownerDetails[0]->user_id,
            'sender_id'=>$user_id,
            'topic'=>"Delivery Status",
            'message'=>"picked up  your order from the pick up location  successfully",
            'user_id'=>$customerDetails[0]->user_id,
            'reciever_email'=>$customerDetails[0]->email,
            
           
        ];
        if($this->deliveryModel->pickedUp($order_id) && $this->deliveryModel->addMessage($data) && $this->adminModel->addMessageToPublisher($data)){
           $this->sendEmails( $ownerEmail, $data);
           redirect('delivery/shippingorders');
            
        }
        else{
            die('Something went wrong');
        }
    }
    public function delivered($order_id){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
        $user_id = $_SESSION['user_id'];
    
        $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
        $orderDetails=$this->deliveryModel->findOrderById($order_id);
        $customer_id=$orderDetails[0]->customer_id;
        $customerDetails=$this->deliveryModel->findCustomerById($customer_id);
        $book_id = $orderDetails[0]->book_id;
        $bookDetails = $this->adminModel->getBookDetailsById($book_id);

        if ($bookDetails[0]->type == 'new') {
            $user_idPub = $bookDetails[0]->publisher_id;
            $ownerDetails = $this->adminModel->getPublisherDetailsById($user_idPub);
            $ownerEmail = $ownerDetails[0]->email;
        } else if ($bookDetails[0]->type == 'used' || $bookDetails[0]->type == 'exchanged') {
            $user_idPub = $bookDetails[0]->customer_id;
            $ownerDetails = $this->adminModel->getPublisherDetailsById($user_idPub);
            $ownerEmail = $ownerDetails[0]->email;
        }

        $data=[
           

            'sender_name'=>$deliveryDetails[0]->name,
            'messageToPublisher' => "Delivered  your order from the your location to your customer's  location successfully",
            'user_idPub' => $ownerDetails[0]->user_id,
            'sender_id'=>$user_id,
            'topic'=>"Delivery Status",
            'message'=>"Delivered  your order from the pick up location to your location successfully",
            'user_id'=>$customerDetails[0]->user_id,
            'reciever_email'=>$customerDetails[0]->email,
            
           
        ];
        if($this->deliveryModel->delivered($order_id) && $this->deliveryModel->addMessage($data) && $this->adminModel->addMessageToPublisher($data)){
           $this->sendEmails( $ownerEmail, $data);
           redirect('delivery/shippingorders');
            
        }
        else{
            die('Something went wrong');
        }
    }
    
    public function returned($order_id){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
        $user_id = $_SESSION['user_id'];
    
        $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
        $orderDetails=$this->deliveryModel->findOrderById($order_id);
        $customer_id=$orderDetails[0]->customer_id;
        $customerDetails=$this->deliveryModel->findCustomerById($customer_id);
        $book_id = $orderDetails[0]->book_id;
        $bookDetails = $this->adminModel->getBookDetailsById($book_id);

        if ($bookDetails[0]->type == 'new') {
            $user_idPub = $bookDetails[0]->publisher_id;
            $ownerDetails = $this->adminModel->getPublisherDetailsById($user_idPub);
            $ownerEmail = $ownerDetails[0]->email;
        } else if ($bookDetails[0]->type == 'used' || $bookDetails[0]->type == 'exchanged') {
            $user_idPub = $bookDetails[0]->customer_id;
            $ownerDetails = $this->adminModel->getPublisherDetailsById($user_idPub);
            $ownerEmail = $ownerDetails[0]->email;
        }

        $data=[
           

            'sender_name'=>$deliveryDetails[0]->name,
            'messageToPublisher' => "Sorry to inform that your order was returned to your picked up location again",
            'user_idPub' => $ownerDetails[0]->user_id,
            'sender_id'=>$user_id,
            'topic'=>"Delivery Status",
            'message'=>"Returned  your order to the  pick up location ",
            'user_id'=>$customerDetails[0]->user_id,
            'reciever_email'=>$customerDetails[0]->email,
            
           
        ];
        if($this->deliveryModel->returned($order_id) && $this->deliveryModel->addMessage($data) && $this->adminModel->addMessageToPublisher($data)){
           $this->sendEmails( $ownerEmail, $data);
           redirect('delivery/shippingorders');
            
        }
        else{
            die('Something went wrong');
        }
    }
    private function sendEmails($ownerEmail, $data) {
        $this->sendEmail($data['reciever_email'], $data['topic'], $data['message']);
        $this->sendEmail($ownerEmail, $data['topic'], $data['messageToPublisher']);
    }
    
    private function sendEmail($recipientEmail, $subject, $body) {
        $mail = new PHPMailer(true);
    
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;  // Specify your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USER; // SMTP username
            $mail->Password = MAIL_PASS; // SMTP password
            $mail->SMTPSecure = MAIL_SECURITY;
            $mail->Port = MAIL_PORT;
    
            // Recipients
            $mail->setFrom('readspot27@gmail.com', 'READSPOT');
            $mail->addAddress($recipientEmail);  // Add a recipient
    
            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
    
            $mail->send();
        } catch (Exception $e) {
            die('Something went wrong: ' . $mail->ErrorInfo);
        }
    }
    
   
    
    public function message(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
        $user_id = $_SESSION['user_id'];
        $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'sender_name'=>$deliveryDetails[0]->name,
                'sender_id' =>$user_id,
                'topic'=> trim($_POST['topic']),
                'message' => trim($_POST['message']),
                'user_id' => trim($_POST['receiver_id']),
                'message_err' => '',
                'topic_err' => '',
            ];

            if (empty($data['message'])) {
                $data['message_err'] = 'Please enter a message';
            }
            if (empty($data['topic'])) {
                $data['topic_err'] = 'Please enter a topic';
            }

            if (empty($data['message_err']) && empty($data['topic_err'])) {
                if ($this->deliveryModel->addMessage($data)) {
                    flash('Successfully Added');
                    redirect('delivery/processedorders');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('delivery/message', $data);
            }
        } else {
            $data = [

                'sender_id'=>'',
                'topic'=>'',
                'message' => '',
                'user_id' => '',
                'message_err' => '',
                'topic_err'=>''
            ];

            $this->view('delivery/message', $data);
        }
       
    }

    public function viewMessage($message_id){
        if (!isLoggedIn()) {
            redirect('landing/login');
        }
        $deliveryid = null;
    
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            
            $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
           
            if ($deliveryDetails) {
               
                $deliveryid = $deliveryDetails[0]->delivery_id;
              
                $messageDetails = $this->deliveryModel->findMessageByUserId($user_id);
                $messageDetails2 = $this->deliveryModel->getMessageById($message_id);

                if($messageDetails && $messageDetails2 ){
                    if($this->publisherModel->changeStatus($message_id)){
                        flash('post_message', 'change status');
                    }else {
                        echo "Not found";
                    }
                }
                
            } else {
                echo "Not found";
            }
        } else {
            echo "Not a publisher";
        }
    
        $data = [
            'deliveryid' => $deliveryid,
            'deliveryDetails' => $deliveryDetails,
            'messageDetails' => $messageDetails,
            'messageDetails2' => $messageDetails2,
            'deliveryName'  =>$deliveryDetails[0] ->name
        ];
    

        $this->view('delivery/viewMessage',$data);
    }
    
    

}