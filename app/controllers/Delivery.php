<?php
class Delivery extends Controller{
    private $deliveryModel;
    
    private $userModel;
    private $orderModel;
    private $db;
    public function __construct(){
        $this->deliveryModel=$this->model('deliver');
        $this->userModel=$this->model('User');
        $this->orderModel=$this->model('Orders');
       
       
        $this->db = new Database();
    }
    public function index(){
        if (!isLoggedIn()) {
            redirect('landing/login');
        } else {
            $user_id = $_SESSION['user_id'];
           
            $deliveryDetails = $this->deliveryModel->findDeliveryById($user_id);
            $deliveryName=$deliveryDetails[0]->name;
             
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
       
        $this->view('delivery/notification');
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
    
            $senderName = $receiverName = $senderStreet = $senderTown = $senderDistrict = $senderPostalCode = $receiverStreet = $receiverTown = $receiverDistrict = $receiverPostalCode = '';
    
            
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
    
    

}