<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\MenuItemModel;
use App\Models\OrderItemModel;
use App\Models\MenuCategoryModel;
use App\Models\UserModel;
use App\Models\OrderModel;
use CodeIgniter\Controller;

class BusinessownerController extends BaseController
{
    protected $menuModel;
    protected $session;

    public function __construct()
    {
        $this->menuItemModel = new MenuItemModel();
        $this->session = \Config\Services::session();
        
    }

    /**
     * Retrieves menu items for the current business owner.
     */

    public function getMenuItem(){
        // Retrieve menu items based on the current business owner's ID
        $menuItems = $this->menuItemModel->where('businessowner_id', $this->session->get('businessowner_id'))->findAll();

        return $menuItems;

    }
    
    /**
     * Manages menu items with pagination.
     */
    public function menuManagement()

    {   // Retrieve menu items with pagination
        $menuItems = $this->getMenuItem();
        $totalItems = count($menuItems);
        $itemsPerPage = 10;
        $totalPages = ceil($totalItems / $itemsPerPage);
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;
    
        // Slice menu items based on pagination parameters
        $menuItems = array_slice($menuItems, $offset, $itemsPerPage);
    
        $data = [
            'menuItems' => $menuItems,
            'totalItems' => $totalItems,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ];
    
        return view('businessowner/menu_management', $data);
    }

    /**
     * Searches for menu items based on a search query.
     */
    public function search()
    {
        $menuItemModel = new MenuItemModel();

        // Retrieve search query from POST request
        $search = $this->request->getPost('search');
  
        if (!empty($search)) {

            $conditions = [];
            $searchableFields = ['name', 'description'];

            
            foreach ($menuItemModel->allowedFields as $field) {
            // Construct where clause for search query
                $conditions[] = "$field LIKE '%$search%'";
            }
            
            $whereClause = implode(' OR ', $conditions);

            $whereClause .= " AND businessowner_id = " . $this->session->get('businessowner_id');
            
            // Retrieve menu items based on search query
            $menuItems = $menuItemModel->where($whereClause)->orderBy('name', 'ASC')->findAll();

        
        } else {
            // Retrieve all menu items in alphabetical order
            $menuItems = $menuItemModel->where('businessowner_id', $this->session->get('businessowner_id'))
            ->orderBy('name', 'ASC')
            ->findAll();
        }
        
        $data['menuItems'] = $menuItems;

       
        return view('businessowner/menu_management', $data);
    }

    /**
     * Generates AI description for a menu item.
     */
    public function generateAIDescription($id)
    {
        // Retrieve menu item by ID
        $menuModel = new \App\Models\MenuItemModel();
        $menuItem = $menuModel->find($id);
    
        if (!$menuItem) {
            echo "Menu item not found\n";
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Menu Item Not Found');
        }
        // Construct prompt for AI description generation
        $prompt = "Please generate a description for the following menu item: '{$menuItem['name']}'. Provide a brief description of the item.";

        // Set up HTTP client
        $client = new \GuzzleHttp\Client(); 
    
        // Retrieve API key and other parameters
        $apiKey = getenv('CLAUDE_API_KEY');
        $anthropicVersion = '2023-06-01';
        $model = 'claude-3-haiku-20240307';
        $maxTokens = 1024;
        $messages = [
            ['role' => 'user', 'content' => $prompt]
        ];
    
        try {
            // Send request to AI model
            $response = $client->post('https://api.anthropic.com/v1/messages', [
                'headers' => [
                    'x-api-key' => $apiKey,
                    'anthropic-version' => $anthropicVersion,
                    'content-type' => 'application/json'
                ],
                'json' => [
                    'model' => $model,
                    'max_tokens' => $maxTokens,
                    'messages' => $messages
                ]
            ]);
            // Process response
            $responseBody = $response->getBody();
            $responseData = json_decode($responseBody, true);
            $returned_suggestions = $responseData["content"][0]["text"];
            
            // Update menu item with AI description
            $aiDescription = json_encode($returned_suggestions);
            $menuItem['ai_description'] = $aiDescription;

            $menuModel->update($id, $menuItem);
            
            // Retrieve updated menu item
            $menuItem = $menuModel->find($id);
            
            $isBestSeller = $menuItem['is_best_seller'] != 0 ? 'Yes' : 'No';
            
            // Return view with updated menu item
            return view('businessowner/edit_item', [
                'menuItem' => $menuItem,
                'isBestSeller' => $isBestSeller,
                'returned_suggestions' => $menuItem['ai_description']
            ]);
            
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
              
            } else {
                
            }
        }
    }
    
    

    /**
     * Displays the form to add or edit a menu item.
     */
    public function addedit($id = null)
    {
        $data['menuItem'] = ($id === null) ? null : $this->menuModel->find($id);
        return view('businessowner/add_item', $data);
    }
    
    /**
     * Handles the submission of a new menu item.
     */
    public function additem_submit()
    {
        $businessOwnerId = session()->get('businessowner_id');
      
        $menuItemModel = new MenuItemModel();
        // Retrieve form data
        $dishName = $this->request->getPost('dishName');
        $price = $this->request->getPost('price');
        $description = $this->request->getPost('description');
        $category = $this->request->getPost('category');
        $bestseller = $this->request->getPost('bestseller') ? 1 : 0;
        $image = $this->request->getFile('image');
        $request = $this->request->getFile('image');
       
        // Handle image upload
        if ($image->isValid() && !$image->hasMoved()) {
            $extension = $image->getClientExtension();
            $newName = $dishName . '.' . $extension;
            $image->move(WRITEPATH . 'uploads', $newName);
        }
    
        // Validate price
        if (!is_numeric($price) || !preg_match("/^\d+(\.\d{1,2})?$/", $price)) {
            session()->setFlashdata('error', 'Price must be a number with exactly two decimal points (e.g., 00.00)');
            return redirect()->to(base_url('menu_management/add_item'));

        }
           
        // Prepare data for insertion
        $data = [
            'name' => $dishName,
            'price' => $price,
            'description' => $description,
            'Category_ID' => $category,
            'is_best_seller' => $bestseller,
            'businessowner_id' => $businessOwnerId,
            'img' => $newName ?? null 
        ];
        // Insert data into database
        $menuItemModel->insert($data);
        $id = $menuItemModel->insertID();
    
        $menuItem = $menuItemModel->find($id);
    
        $isBestSeller = $menuItem['is_best_seller'] != 0 ? 'Yes' : 'No';
    
        session()->setFlashdata('success', 'Menu item added successfully.');
    
        return view ('businessowner/add_item', $menuItem);
    }
    
    /**
     * Manages menu categories.
     */
    public function categoryManagement()
    {
        // Retrieve categories for the current business owner
        $menuCategoryModel = new MenuCategoryModel();
        $categories = $menuCategoryModel->where('businessowner_id', $this->session->get('businessowner_id'))->findAll();

        $data['categories'] = $categories;
      
        return view('businessowner/category_management', $data);
       
    }

    /**
     * Adds a new category.
     */
    public function addCategory()
    {   
    $categoryModel = new MenuCategoryModel();
    $categoryName = $this->request->getPost('categoryName');
    $businessowner_id = $this->session->get('businessowner_id');
    
    // Validate category name
    if (!$categoryName) {
        session()->setFlashdata('error', 'Category name cannot be empty');
        return redirect()->to(base_url('menu_management/category_management'));
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $categoryName)) {
        session()->setFlashdata('error', 'Category name can only contain charaters.');
        return redirect()->to(base_url('menu_management/category_management'));
    }

    // Insert new category into the database
    $categoryModel->insert(['name' => $categoryName, 'businessowner_id' => $businessowner_id]);

    session()->setFlashdata('success', 'Category added successfully');

    $menuCategoryModel = new MenuCategoryModel();
    $categories = $menuCategoryModel->where('businessowner_id', $businessowner_id)->findAll();

    $data['categories'] = $categories;

    return view('businessowner/category_management', $data);


}
    
    /**
     * Deletes a category.
     */
    public function deleteCategory($categoryId)
    {
        $categoryModel = new MenuCategoryModel();
        $categoryModel->delete($categoryId);
    
        return redirect()->to(base_url('menu_management/category_management'))->with('success', 'Category deleted successfully');
    }
    

    /**
     * Displays details of a specific menu item.
     */
    public function viewItem($id)
{
    $menuModel = new MenuItemModel(); 

    // Retrieve details of the specified menu item
    $menuItem = $menuModel->find($id);

    // Determine if the item is a best seller
    $isBestSeller = $menuItem['is_best_seller'] != 0 ? 'Yes' : 'No';

    return view('businessowner/view_item', ['menuItem' => $menuItem, 'isBestSeller' => $isBestSeller]);
}


    /**
     * Edit details of a specific menu item.
     */
    public function editItem($id)
    {
        $menuModel = new MenuItemModel(); 

        $menuItem = $menuModel->find($id);
        
        $data = [
            'menuItem' => $menuItem,
            'itemid' => $id 
        ];


            return view('businessowner/edit_item', $data);
        
    }
    /**
     *  Updates a menu item.
     */
    public function updateItem($id)
    {
    $menuModel = new MenuItemModel();

    // Prepare updated data from form inputs
    $updatedData = [
        'name' => $this->request->getPost('dishName'), 
        'price' => $this->request->getPost('price'),
        'description' => $this->request->getPost('description'),
        'Category_ID' => $this->request->getPost('category'), 
        'is_best_seller' => $this->request->getPost('bestseller') ? 1 : 0 
    ];
    // Update the menu item in the database
    $menuModel->update($id, $updatedData);
    session()->setFlashdata('success', 'Menu item updated successfully');


    return redirect()->to(base_url("menu_management/edit_item/$id"));
}

    /**
     * Deletes a menu item.
     */
    public function deleteItem($id) 
    {
        $menuModel = new MenuItemModel(); 

        // Find the menu item to be deleted
        $menuItem = $menuModel->find($id);
        if (!$menuItem) {
            return redirect()->to('menu_management')->with('error', 'Menu item with ID: {$id}  not found.');
        }
        // Delete the menu item from the database
        $menuModel->delete($id);

        return redirect()->to('menu_management')->with('success', 'Menu item deleted successfully.');
            
    }
    

    /**
     * Displays the total order number.
     */
    public function orderManagement()
    {
        $orderModel = new OrderModel();
        $id = $this->session->get('businessowner_id');
        $orderItemModel = new OrderItemModel();
        // Count total orders and today's orders
        $totalOrderCount = $orderModel->where('businessowner_id', $id)->countAllResults();
       

        $todaysOrderCount = $orderModel->where('businessowner_id', $id)
                                       ->where('DATE(timestamp)', date('Y-m-d'))
                                       ->countAllResults();
    
        $data = [
            'todaysOrderCount' => $todaysOrderCount,
            'totalOrderCount' => $totalOrderCount,
            'orderModel' => $orderModel
        ];

     

    
        return view('businessowner/order_management', $data);
    }

    /**
     * Displays the pending orders.
     */
    public function pendingOrder()    
   {   

    $orderModel = new OrderModel();
    $orderItemModel = new OrderItemModel();
    $id = $this->session->get('businessowner_id');

    $pendingOrders = $orderModel->where('businessowner_id', $id)
                                ->where('status', 'Pending')
                                ->findAll();

    $orders = [];
    // Process pending orders
    foreach ($pendingOrders as $order) {
        if (is_array($order)) {
            $order = (object) $order;
        }
        // Find order items for each pending order
        $orderItems = $orderItemModel->where('id', $order->id)->findAll();
        // Construct order data
        $orderData = [
            'tableNumber' => $order->table_number,
            'orderNumber' => $order->id,
            'numberOfPeople' => $order->number_of_dining,
            'orderItems' => $orderItems,
        ];
    
        $orders[] = $orderData;
    }
    
    $data = [
        'orders' => $orders,
    ];
    
    return view('businessowner/current_order', $data);
}
    /**
     * Displays the past orders.
     */
    public function pastOrder()
{
    $orderModel = new OrderModel();
    $orderItemModel = new OrderItemModel();
    $id = $this->session->get('businessowner_id');

    // Retrieve past orders for the current business owner
    $completOrders = $orderModel->getPastOrders($id);

    $orders = [];

    foreach ($completOrders as $order) {
        if (is_array($order)) {
            $order = (object) $order;
        }
        // Find order items for each past order
        $orderItems = $orderItemModel->where('id', $order->id)->findAll();

        $orderData = [
            'tableNumber' => $order->table_number,
            'orderNumber' => $order->id,
            'numberOfPeople' => $order->number_of_dining,
            'orderItems' => $orderItems,
        ];

        $orders[] = $orderData;
    }

    $data = [
        'orders' => $orders,
    ];

    return view('businessowner/past_order', $data);
}



    /**
     * Displays the past orders.
     */
    public function qrGenerator()
    {
        $data['businessowner_id'] = session()->get('businessowner_id');
        return view('businessowner/qrcode', $data);
    
    }


    /**
     * Displays the signup page.
     */
    public function signUp()
    {

        return view('businessowner/signup');
    }

    /**
     * Handles the new businessowner register form.
     */
    public function register()

    {

        $userModel = new UserModel();
        $username_input = $this->request->getPost('username');
        $password_input = $this->request->getPost('password');
        $usertype_input = 'business_owner'; 
        $business_name_input = $this->request->getPost('businessname');
        $business_type_input = $this->request->getPost('businesstype');
        $business_address_input = $this->request->getPost('address');
        $total_tables_input = $this->request->getPost('totaltables');
        $email_input = $this->request->getPost('email');

        $errors = [];
        // Validation rules for form fields
        // Check if fields are empty, meet specific criteria, etc.

        // Check username
        if (empty($username_input)) {
            $errors['username'] = "Username cannot be empty";
        } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $username_input)) {
            $errors['username'] = "Username can only contain letters and numbers";
        }
        // Check password
        $length = strlen($password_input);  
        if (empty($password_input)) {
            $errors['password'] = "Password is required";
        } elseif ($length < 6) {
            $errors['password'] = "Password must be at least 6 characters";
        } elseif (!preg_match("/[a-zA-Z]/", $password_input) || !preg_match("/[0-9]/", $password_input)) {
            $errors['password'] = "Password must contain at least one letter and one number";
        }
        // Check business name
        if (empty($business_name_input)) {
            $errors['business_name'] = "Business name is required";
        }
        // Check business address
        if (empty($business_address_input)) {
            $errors['business_address'] = "Business address is required";
        } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $business_address_input)) {
            $errors['business_address'] = "Business address can only contain letters and spaces";
        }
        // Check total tables
        if (!is_numeric($total_tables_input)) {
            $errors['total_tables'] = "Total tables must be a number";
        }
        // Check email
        if (empty($email_input)) {
            $errors['email'] = "Email is required";
        } elseif (!filter_var($email_input, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }

        $this->session->setFlashdata('errors', $errors);
        // If no errors, register the user
        if (empty($errors)) {
        
            $hashedPassword = password_hash($password_input, PASSWORD_DEFAULT);
            $userData = [
                'username' => $username_input,
                'password_hashed' => $hashedPassword,
                'usertype' => $usertype_input,
                'business_name' => $business_name_input,
                'business_type' => $business_type_input,
                'business_address' => $business_address_input,
                'total_tables' => $total_tables_input,
                'email' => $email_input
            ];
            
            $userModel->insert($userData);
            
            $this->session->setFlashdata('message', [
                'username' => $username_input,
                'success' => 'Registration successful!'
            ]);
            
            return redirect()->to('signup');

        } else {
            //If there are errors, return to sign-up page with error messages
            return view('businessowner/signup', ['errors' => $errors]);
        }
    }

    /**
     * Displays the login page.
     */    
        public function login(){
            $uri = service('uri');
            $tableNumber = $uri->getSegment(1);
            $businessOwnerId = $uri->getSegment(2);
            $userType = ($tableNumber !== null && $businessOwnerId !== null) ? 'customer' : 'business_owner';
            $data['userType'] = $userType;    
            $data['tableNumber'] = $tableNumber;
            $data['businessOwnerId'] = $businessOwnerId; 
            return view('businessowner/businessowner_login', $data);
        }


    /**
     * Handles the businessowner login.
     */    
    public function loginAuth()
    {
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');
    $userModel = new UserModel();
    $user = $userModel->where('username', $username)->first();

    if ($user && password_verify($password, $user['password_hashed'])) {
        // Check if the user is an admin
        if ($user['usertype'] === 'admin') {
            session()->set([
                'isLoggedIn' => true,
                'userId' => $user['id'],
                'username' => $username,
                'usertype' => 'admin',
                'isAdmin' => true 
            ]);

            return redirect()->to('/admin');
        }

        // proceed to check the user type
        if ($user['usertype'] === 'business_owner') {
            $businessOwnerId = $user['id'];
            session()->set([
                'isLoggedIn' => true,
                'userId' => $user['id'],
                'username' => $username,
                'usertype' => 'business_owner',
                'businessowner_id' => $businessOwnerId,
                'isAdmin' => false 
            ]);

            return redirect()->to('menu_management');
        }

        $uri = service('uri');
        $tableNumber = $uri->getSegment(1);
        $businessOwnerId = $uri->getSegment(2);

        if ($user['usertype'] === 'customer' && $tableNumber !== null && $businessOwnerId !== null) {
            session()->set([
                'isLoggedIn' => true,
                'userId' => $user['id'],
                'username' => $username,
                'usertype' => 'customer',
                'isAdmin' => false 
            ]);
            return redirect()->to("{$tableNumber}/{$businessOwnerId}/login");
        }
    }
    return redirect()->to('login');
}


public function landing(){

    $username = session()->get('username');

    return view('businessowner/landing', ['username' => $username]);
}

public function logout()
{
    session()->destroy(); 
    return redirect()->to('login'); 
}
  
}