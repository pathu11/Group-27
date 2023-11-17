<?php
 class Admin extends Controller{
  private $adminModel;
  
  private $userModel;

  private $db;
  public function __construct(){
      $this->adminModel=$this->model('Admins');
      $this->userModel=$this->model('User');
     
     
      $this->db = new Database();

  }
  public function index(){
      if (!isLoggedIn()) {
          redirect('landing/login');
      } else {
          $user_id = $_SESSION['user_id'];
         
          $adminDetails = $this->adminModel->findAdminById($user_id);  
          $data = [
              'adminDetails' => $adminDetails,
              'adminName'=>$adminDetails[0]->name
          ];
          $this->view('admin/index', $data);
      }
  }

  public function categories(){
    $user_id = $_SESSION['user_id'];
         
    $adminDetails = $this->adminModel->findAdminById($user_id);
    $bookCategoryDetails = $this->adminModel->getBookCategories();
    $eventCategoryDetails = $this->adminModel->getEventCategories();  
    $data = [
        'adminDetails' => $adminDetails,
        'adminName'=>$adminDetails[0]->name,
        'bookCategoryDetails'=>$bookCategoryDetails,
        'eventCategoryDetails'=>$eventCategoryDetails,
    ];
    $this->view('admin/categories',$data);
  }
 }