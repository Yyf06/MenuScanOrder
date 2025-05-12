<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MenuItemModel;
use App\Models\TempDataModel;
use App\Models\UserModel;
use App\Models\OrderModel;

class CustomerController extends BaseController

{
    private $menuItemModel;

    public function __construct()
    {
        helper(['url', 'session']); 
        $this->menuItemModel = new MenuItemModel();
    }

    /**
     * Prepares common view data used by multiple methods.
     */
    private function ViewData($tableNumber, $businessOwnerId, $restaurantName) {
        // Retrieve session data
        $isLoggedIn = session()->get('isLoggedIn');
        $userId = session()->get('userId');
        $username = session()->get('name');
        
        // Get menu items for the business owner
        $menuItems = $this->menuItemModel->getMenuItems($businessOwnerId);
        
        // Filter bestsellers from menu items
        $bestSellers = array_filter($menuItems, function ($menuItem) {
            return $menuItem['is_best_seller'] == 1;
        });
        // Pagination setup
        $totalItems = count($menuItems);
        $itemsPerPage = 10;
        $totalPages = ceil($totalItems / $itemsPerPage);
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;
        $menuItems = array_slice($menuItems, $offset, $itemsPerPage);
    
        return [

            'restaurantName' => $restaurantName, 
            'businessOwnerId' => $businessOwnerId,
            'tableNumber' => $tableNumber,
            'menuItems' => $menuItems,
            'bestSellers' => $bestSellers,
            'isLoggedIn' => $isLoggedIn ,
            'userId' => $userId,
            'username'=> $username,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
    
        ];
    }
    
    public function index()
    {   
        // Retrieve session data
        $tableNumber = session()->get('tableNumber');
        $businessOwnerId = session()->get('businessOwnerId');
        $isLoggedIn = session()->get('isLoggedIn');
        $userId = session('user_id');
        $userModel = new UserModel();
        $restaurantName = $userModel->where('id', $businessOwnerId)->get()->getRow('business_name');
       
     
        // Prepare view data
        $data = $this->ViewData($tableNumber, $businessOwnerId, $restaurantName);
        $data['user_id'] = $userId;
    
        return view('customer_landingpage', $data);

    }

     /**
     * Displays the customer landing page for logged-in users.
     */

    public function loggedinLanding(){
        // Get table number and business owner ID from URI
        $tableNumber = $this->request->uri->getSegment(1);
        $businessOwnerId = $this->request->uri->getSegment(2);
        $userId = session('userId');
    
        $userModel = new UserModel();
        // Get restaurant name based on business owner ID
        $restaurantName = $userModel->where('id', $businessOwnerId)->get()->getRow('business_name');
        
        $data = [
            'tableNumber' => $tableNumber,
            'businessOwnerId' => $businessOwnerId,
            'restaurantName' => $restaurantName,
            'userId' => $userId,
        ];
    
        
        return view('customer_landingpage', $data);
    }
    
     /**
     * Displays the customer landing page with QR code.
     */
    public function QR_index($tableNumber, $businessOwnerId) {
        // Get restaurant name based on business owner ID
        $userModel = new UserModel();
        
        $restaurantName = $userModel->where('id', $businessOwnerId)->get()->getRow('business_name');

        if (!$restaurantName) {
            $restaurantName = 'Unknown';
        }
        // Set session data for restaurant name, table number, and business owner ID
        session()->set('restaurantName', $restaurantName);
        session()->set('tableNumber', $tableNumber);
        session()->set('businessOwnerId', $businessOwnerId);

        // Insert temporary data
        $tempDataModel = new TempDataModel();
        $tempDataModel->insert([
            'tableNumber' => $tableNumber,
            'businessOwnerId' => $businessOwnerId
        ]);
        // Get user session data
        $userId = session()->get('userId');
        $username = session()->get('username');
        $isLoggedIn = session()->get('isLoggedIn');

        // Get URI segments
        $uri = service('uri');
        $tableNumber = $uri->getSegment(1);
        $businessOwnerId = $uri->getSegment(2);
    
        
        // Prepare view data using ViewData method
        $data = $this->ViewData($tableNumber, $businessOwnerId, $restaurantName);
        
        $data['username'] = $username; 
        $data['userId'] = $userId; 
        $data['isLoggedIn'] = $isLoggedIn; 
        return view('customer_landingpage', $data);
    }

    /**
     * Displays the signup page.
     */
    public function signUp() {
        $tableNumber = session()->get('tableNumber');
        $businessOwnerId = session()->get('businessOwnerId');
        $data['tableNumber'] = $tableNumber;
        $data['businessOwnerId'] = $businessOwnerId; 

        return view('customer_signup', $data);
    }


    /**
     * Confirm order page for logged-in users
     */
    public function confirmOrder($userId)
    //logged in users
    {
        $isLoggedIn =session()->get('isLoggedIn');

        $userId = session()->get('userId');
        $email = session()->get('email');
        $username = session()->get('username');
        $isAdmin = session()->get('isAdmin');
        
        $orderModel = new OrderModel();
        $orders = $orderModel->where('customer_id', $userId)->findAll();

        $tableNumber = session()->get('tableNumber');

        $restaurantName = session()->get('restaurantName');
    
    
        
       $data = [
        'userId' => $userId,
        'email' => $email,
        'username' => $username,
        'isAdmin' => $isAdmin,
        'orders' => $orders,
        'restaurantName' => $restaurantName,
        'tableNumber' => $tableNumber,
        'isLoggedIn' => $isLoggedIn
    ];
    
        
        
       return view('order_confirm', $data);
    }

    /**
     * Place order page for guests
     */
    public function placeOrder($tableNumber, $businessOwnerId)
    //place orders without logging in
    {
        $isLoggedIn =session()->get('isLoggedIn');
    
        $userModel = new UserModel();
        // Get restaurant name based on business owner ID
        $restaurantName = $userModel->where('id', $businessOwnerId)->get()->getRow('business_name');
        
       $data = [
        'restaurantName' => $restaurantName,
        'businessOwnerId' => $businessOwnerId,
        'tableNumber' => $tableNumber,
        'isLoggedIn' => $isLoggedIn
    ];
    
        
        
       return view('order_confirm', $data);
    }

    /**
     *  Customer sign-up process
     */
    public function customer_signUp()
    {
        
        helper(['form']);
        $userModel = new UserModel();
    
        // Retrieve user input
        $username_input = $this->request->getPost('username');
        $password_input = $this->request->getPost('password');
        $email_input = $this->request->getPost('email');
        
        $tableNumber = session()->get('tableNumber');
        $businessOwnerId = session()->get('businessOwnerId');
        
        // Hash the password
        $hashedPassword = password_hash($password_input, PASSWORD_DEFAULT);
    
        $data = [
            'username' => $username_input,
            'password_hashed' => $hashedPassword,
            'usertype' => 'customer',
            'email' => $email_input,
            'businessOwnerId' => $businessOwnerId,
            'tableNumber' => $tableNumber
        ];
    
        // Insert user data into the database
        $userModel->insert($data);
    
        // Set flash message
        session()->setFlashdata('message', [
            'success' => 'Registration successful!'
        ]);
    
    
        $data['tableNumber'] = $tableNumber;
    
        return view('customer_signup', $data);
    }
     /**
     *  Customer login page
     */
    public function login() {
        $uri = service('uri');
        $tableNumber = $uri->getSegment(1);
        $businessOwnerId = $uri->getSegment(2);
        $data['tableNumber'] = $tableNumber;
        $data['businessOwnerId'] = $businessOwnerId; 
        return view('login', $data);
    }    
    
    /**
     *  Customer login authentication
     */
    public function loginAuth()
    {
        // Retrieve user input
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $userType = 'customer';
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();
        // Validate user credentials
        if ($user && password_verify($password, $user['password_hashed'])) {
            if ($user['usertype'] === 'customer') {
                
                $uri = service('uri');
                $tableNumber = $uri->getSegment(1);
                $businessOwnerId = $uri->getSegment(2);
                $username = $user['username'];
                $userId = $user['id']; 
                // Set session data
                session()->set('id', $userId); 
                session()->set('tableNumber', $tableNumber);
                session()->set('businessOwnerId', $businessOwnerId);
                session()->set('username', $username);
                session()->set('email', $user['email']);
                
                
                
                $isLoggedIn = true;
                session()->set('isLoggedIn', $isLoggedIn);
                $userModel = new UserModel();
        
                $restaurantName = $userModel->where('id', $businessOwnerId)->get()->getRow('business_name');

                $data = $this->ViewData($tableNumber, $businessOwnerId, $restaurantName);
                $data['isLoggedIn'] = $isLoggedIn;
                $data['username'] = $username; 
                $data['userId'] = $userId; 
           
             return view('customer_landingpage', $data);
            } else {
             
                return view('login');
            }
            return view('login');
        }
    }

    public function logout()
{
 
    session()->remove('id');
    $uri = service('uri');
        $tableNumber = $uri->getSegment(1);
        $businessOwnerId = $uri->getSegment(2);
 
    session()->remove('username');
    session()->remove('email');
    $data['tableNumber'] = $tableNumber;
    $data['businessOwnerId'] = $businessOwnerId; 
    return view('login', $data);
    

}
}
