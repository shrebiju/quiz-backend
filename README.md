# My Quiz App
This is the backend API for the Quiz App built in Laravel.



1. as first do git clone https://github.com/shrebiju/quiz-backend.git
2. composer install 
3. create .env file 
4. php artisan migrate 
5. php artisan serve
 it will run on http://127.0.0.1:8000 

6. php artisan migrate --seed it will generate necessary data with admin and user
if you also want to use in easy way you can seed the data to automatically generaate data question and everything

and for admin and user in database seed i have made 
    
    <!-- for Admin
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'), 
            'role' => 'admin', --> -->
    <!-- for User

            'name' => 'Regular User',
            'email' => 'user01@example.com',
            'password' => bcrypt('password'),
            'role' => 'user', -->
   