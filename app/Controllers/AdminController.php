<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\UserSubscriptionModel;


class AdminController extends BaseController
{
    /**
     * Display the admin dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        // Check if user is logged in and is an admin
        if (session()->get('isLoggedIn') && session()->get('isAdmin')) {
            // If yes, display the user data
            return $this->displayUser();

        } else {
            // If not, redirect to login page
          
            return redirect()->to(base_url('login'));
            
        }
    
    }

     /**
     * Add a new user.
     *
     * @return mixed
     */
    public function addUser()
    {   
        // Retrieve username and password from the POST request
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create a new instance of UserModel
        $userModel = new UserModel();

        // Define user data
        $userData = [
            'username' => $username,
            'password' => $hashedPassword
        ];

        // Insert user data into the database
        $userModel->insert($userData);

        return redirect()->back()->with('success', 'User created successfully');
    }

    /**
     * Display user data with pagination and subscriptions.
     *
     * @return mixed
     */

    public function displayUser() {
        // Create an instance of UserModel
        $userModel = new UserModel();
        $userData = $userModel->findAll();
        // Calculate total number of items
        $totalItems = count($userData);
        $itemsPerPage = 10;
        $totalPages = ceil($totalItems / $itemsPerPage);
        // Get current page number from the query string or default to 1
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        // Calculate offset for pagination
        $offset = ($currentPage - 1) * $itemsPerPage;
        // Slice user data to display items for the current page
        $userData = array_slice($userData, $offset, $itemsPerPage);
    
        $data = [
            'userData' => $userData,
            'totalItems' => $totalItems,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ];
    
    
        $subscriptionModel = new UserSubscriptionModel();
        $subscriptions = $subscriptionModel->findAll();
    
        return view('admin', [
            'userData' => $userData,
            'subscriptions' => $subscriptions,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage 
        ]);
    }
    /**
     * Delete a user by ID.
     *
     * @param int $id The ID of the user to be deleted.
     * @return mixed
     */
    public function deleteUser($id) {

        $userModel = new UserModel();

        
        $userItem = $userModel->find($id);
        // If user not found, redirect with error message
        if (!$userItem) {
            return redirect()->to('admin')->with('error', 'User with ID: {$id}  not found.');
        }
        // Delete the user
        $userModel->delete($id);
        // Redirect to admin page with success message
        return redirect()->to('admin')->with('success', 'User deleted successfully.');
    }

    /**
     * Alter the password of a user.
     *
     * @return mixed
     */
    public function alterPassword(){
        // Retrieve username and password from POST request
        $username = $this->request->getPost('username_c');
        $password = $this->request->getPost('password_c');
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $userModel = new UserModel();
    
        $userData = $userModel->where('username', $username)->first();
        
        // If user exists, update password and redirect with success message; otherwise, redirect with error message
        if ($userData) {
            $userData['password_hashed'] = $hashedPassword;
    
            $userModel->save($userData);
    
            return redirect()->back()->with('success', 'Password updated successfully');
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
    }
    /**
     * Display the edit user form.
     *
     * @param int $id The ID of the user to edit.
     * @return mixed
     */
    public function editUser($id)
    {
        $userModel = new UserModel();
        $subscriptions = new UserSubscriptionModel();

        $userData = $userModel->find($id);
        $subscription = $subscriptions->find($id);
   
        return view('edit_user', ['userData' => $userData, 'subscriptions' => $subscription]);        
    }

    /**
     * Update user data and subscription.
     *
     * @param int $id The ID of the user to update.
     * @return mixed
     */
    public function updateUser($id)
    {
        $userModel = new UserModel();
        $subscriptionModel = new UserSubscriptionModel();


        $userData = [
            'username' => $this->request->getPost('username'), 
            'password' => $this->request->getPost('password'),
            'business_name' => $this->request->getPost('businessname')
        ];

        if (!empty($password)) {
           
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $userData['password_hashed'] = $hashedPassword;}
   
         // Retrieve subscription data from POST request
        $subscriptionData = [
            'subscription_plan' => $this->request->getPost('subscription-plan'), 
            'start_date' => $this->request->getPost('start-date'), 
            'end_date' => $this->request->getPost('end-date'),
            'status' => $this->request->getPost('status') 
        ];
        // Validate start date and end date
        if (strtotime($subscriptionData['start_date']) >= strtotime($subscriptionData['end_date'])) {
            session()->setFlashdata('error', 'Start date must be before end date');
            return redirect()->to(base_url("admin/edit_user/$id"));
        }
        // Update user data
        if ($userData){
            $userModel->update($id, $userData);
        }
          // Find and update subscription data
            $subscription = $subscriptionModel->where('user_id', $id)->first();
            if ($subscription) {
                $subscriptionModel->update($subscription['id'], $subscriptionData);
            }

        session()->setFlashdata('success', 'User data updated successfully');

        return redirect()->to(base_url("admin/edit_user/$id"));
}

/**
 * Log out the user.
 */

public function logout()
{
    session()->destroy(); 
    
    
    return redirect()->to(base_url('login'));
}


}
