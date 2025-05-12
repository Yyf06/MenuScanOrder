<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuscannerDataSeeder extends Seeder
{
    public function run()
    {
        $menuCategories = [
            ['name' => 'Cold Dish'],
            ['name' => 'Main Courses'],
            ['name' => 'Desserts'],
            ['name' => 'Drinks']
        ];

        $this->db->table('Menu_Categories')->insertBatch($menuCategories);

      
        $menuItems = [
            
            [
                'name' => 'Caesar Salad',
                'img' => 'Caesar_Salad.jpg',
                'price' => 9.99,
                'is_best_seller' => 0,
                'description' => 'The dressing is made with garlic, Parmesan, anchovies, lemon juice, and olive oil, creating a rich and indulgent flavor profile. This popular salad is a refreshing and satisfying choice, perfect as a starter or a light main course',
                'Category_ID' => 1,
                'businessowner_id' => 7,
                'ai_description' => "Here is a brief description for the menu item 'Caesar Salad':\n\nCaesar Salad is a classic salad made with crisp romaine lettuce, tossed in a tangy and creamy Caesar dressing. It is typically topped with croutons, freshly grated Parmesan cheese, and sometimes grilled or roasted chicken for added protein. The dressing is made with garlic, Parmesan, anchovies, lemon juice, and olive oil, creating a rich and indulgent flavor profile. This popular salad is a refreshing and satisfying choice, perfect as a starter or a light main course."
            ],
            [
                'name' => 'Margherita Pizza',
                'img' => 'margherita_pizza.jpg',
                'price' => 12.99,
                'Category_ID' => 2, 
                'description' => 'Classic pizza topped with tomato sauce, fresh mozzarella, basil leaves, and a drizzle of olive oil',
                'is_best_seller' => '1',
                'businessowner_id' => '7',
                'ai_description' => 'Margherita Pizza is a classic Italian pizza topped with tomato sauce, fresh mozzarella cheese, and fresh basil leaves. It is named after Queen Margherita of Italy and is known for its simple yet delicious flavor. The pizza dough is typically thin and crispy, providing the perfect base for the flavorful toppings. A drizzle of olive oil adds richness and enhances the overall taste of this beloved dish.'
            ],
            [
                'name' => 'Tasty Donuts',
                'img' => 'Tasty Donuts.jpg',
                'price' => 6.99,
                'Category_ID' => 3,
                'description' => 'Decadent donuts served warm with vanilla ice cream',
                'is_best_seller' => '0',
                'businessowner_id' => '7',
                'ai_description' => ''
            ],
            [
                'name' => 'Mojito',
                'img' => 'mojito.jpg',
                'price' => 8.99,
                'Category_ID' => 4, 
                'description' => 'Classic cocktail made with rum, mint, lime, sugar, and soda water',
                'is_best_seller' => '0',
                'businessowner_id' => '7',
                'ai_description' => ''
            ],
            [
                'name' => 'Latte',
                'img' => 'latte.jpg',
                'price' => 5.00,
                'is_best_seller' => 0,
                'description' => 'ewcf',
                'Category_ID' => 3, 
                'businessowner_id' => 7,
                'ai_description' => "Here is a brief description for the menu item 'Latte':\n\nLatte: A classic espresso-based coffee drink, the latte is made by combining a shot of rich, bold espresso with steamed, frothy milk. The result is a creamy, well-balanced beverage with a smooth, velvety texture and a delicate layer of foam on top. Perfect for coffee lovers looking for a comforting, flavorful pick-me-up any time of day."

            ]
        ];

        $this->db->table('Menu_Item')->insertBatch($menuItems);
    
        $orderData = [
            [
                'customer_id' => 1,
                'table_number' => 5,
                'timestamp' => date('Y-m-d H:i:s'),
                'status' => 'Pending',
                'number_of_dining' => 2,
                'businessowner_id' => 7,
            ],
            [
                'customer_id' => 2,
                'table_number' => 8,
                'timestamp' => date('Y-m-d H:i:s'),
                'status' => 'Completed',
                'number_of_dining' => 4,
                'businessowner_id' => 7,
            ],
            [
                'customer_id' => 1,
                'table_number' => 4,
                'timestamp' => '2024-04-28 00:00:00',
                'status' => 'Pending',
                'number_of_dining' => 2,
                'businessowner_id' => 7,
            ],
            [
                'customer_id' => 4,
                'table_number' => 8,
                'timestamp' => '2024-04-24 12:46:32',
                'status' => 'Completed',
                'number_of_dining' => 4,
                'businessowner_id' => 1,
            ],
            [
                'customer_id' => 1,
                'table_number' => 5,
                'timestamp' => '2024-05-01 00:00:00',
                'status' => 'Completed',
                'number_of_dining' => 2,
                'businessowner_id' => 7,
            ],
           
        ];

        $this->db->table('Order')->insertBatch($orderData);

        $orderItems = [
            [
                'order_id' => 1,
                'name' => 'Caesar Salad',
                'quantity' => 2,
                'amount' => 19.98,
            ],
            [
                'order_id' => 1,
                'name' => 'Margherita Pizza',
                'quantity' => 1,
                'amount' => 12.99,
            ],
            [
                'order_id' => 3,
                'name' => 'Burger',
                'quantity' => 2,
                'amount' => 12.99,
            ],
            [
                'order_id' => 4,
                'name' => 'Pizza',
                'quantity' => 1,
                'amount' => 14.99,
            ],
            [
                'order_id' => 8,
                'name' => 'Salad',
                'quantity' => 3,
                'amount' => 14.99,
            ],
            

        ];

       
        foreach ($orderItems as $orderItem) {
            $this->db->table('Order_Item')->insert($orderItem);
        }
    
    
        $file = fopen('menuscanner/app/Database/Seeds/users.csv', 'r');

        
        if ($file !== FALSE) {
            while (($data = fgetcsv($file)) !== FALSE) {
                $userData = [
                    'username' => $data[1], 
                    'password_hashed' => $data[2], 
                    'usertype' => $data[3], 
                    'email' => $data[4],
                    'isadmin' => $data[5], 
                    'business_name' => $data[6], 
                    'business_type' => $data[7], 
                    'business_address' => $data[8], 
                    'total_tables' => $data[9], 
                ];
    
                // Insert the user data into the database
                $this->db->table('users')->insert($userData);
            }

            fclose($file);
        } else {
     
            echo "Error: Unable to open file containing user data.";
        }
    }
}
    
   

