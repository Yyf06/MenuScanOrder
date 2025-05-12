<?php namespace App\Controllers;

use Google\Client as GoogleClient;
use App\Models\MenuItemModel;
use App\Models\TempDataModel;
use Exception;

class Auth extends BaseController
{
    protected $user;
    protected $base_url;

    public function __construct()
    {
    
        $this->base_url = getenv('app.baseURL');
        $this->user = new GoogleClient();
        $this->user->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $this->user->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $this->user->setRedirectUri($this->base_url . 'googlelogin/callback');
        $this->user->addScope("email");
        $this->user->addScope("profile");
    }


    public function google_login()
    {
       
        $authUrl = $this->user->createAuthUrl();
    
        return redirect()->to($authUrl);
    }

    public function google_callback()
    {  
        $tempDataModel = new TempDataModel();
        $tempData = $tempDataModel->orderBy('id', 'DESC')->first(); 
        $tableNumber = $tempData['tableNumber'];
        $businessOwnerId = $tempData['businessOwnerId'];
        try {
            $token = $this->user->fetchAccessTokenWithAuthCode($this->request->getGet('code'));
            
            if (isset($token['error'])) {
                throw new Exception('Error retrieving access token: ' . $token['error']);
            }
            
            $this->user->setAccessToken($token);
    
            $google_oauth = new \Google\Service\Oauth2($this->user);
            $google_account_info = $google_oauth->userinfo->get();
    
            $userModel = new \App\Models\UserModel();
            $user = $userModel->where('email', $google_account_info->email)->first();
    
            if (!$user) {
                $newData = [
                    'email' => $google_account_info->email,
                    'username' => $google_account_info->name,
                    'isadmin' => false,  
                ];
                $userModel->insert($newData);
                $user = $userModel->where('email', $google_account_info->email)->first();
           } else {
                $isAdmin = $user['isadmin'];
                $usertype = $user['usertype'];
            }
            
         
            session()->set([
                'isLoggedIn' => true,
                'userId' => $user['id'], 
                'email' => $user['email'],
                'name' => $user['username'],
                'isAdmin' => $user['isadmin'],
                'usertype' => $user['usertype']
            ]);
    
            if ($user['isadmin']) {
                return redirect()->to('/admin');
            } elseif ($user['usertype'] == 'business_owner') {
                $businessOwnerId = $user['id']; 
                session()->set('businessowner_id', $businessOwnerId);
    
                $menuItemModel = new MenuItemModel();
                
                $menuItems = $menuItemModel->getMenuItems($businessOwnerId);
                $data['menuItems'] = $menuItems;
                
                return view('businessowner/menu_management', $data);
        
            } elseif ($user['usertype'] == 'customer') {
                session()->setFlashdata('tempData', $tempData);
                session()->setFlashdata('tableNumber', $tableNumber);
                session()->setFlashdata('businessOwnerId', $businessOwnerId);
                
                $tempDataModel->delete($tempData['id']);
                
                return redirect()->to("{$tableNumber}/{$businessOwnerId}");
               
}

              
           

        } catch (Exception $e) {
            log_message('error', 'Google callback error: ' . $e->getMessage());
    
            echo 'Error: ' . $e->getMessage();
        }
    }
    

    public function logout()
    {
       
        session()->remove(['isLoggedIn', 'userId', 'email', 'name', 'isAdmin', 'usertype', 'businessowner_id']);

        if (isset($_COOKIE['g_state'])) {
            unset($_COOKIE['g_state']);
            setcookie('g_state', '', time() - 3600, '/'); 
        }

        $googleLogoutUrl = 'https://accounts.google.com/Logout?continue=https://appengine.google.com/_ah/logout?continue=' . base_url('login');
        return redirect()->to($googleLogoutUrl);
    }

}
