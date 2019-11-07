# Aleksandro užduotis
## 1. Installiation
    composer install
## 2. Copy .ENV.EXAMPLE to .ENV
    php artisan jwt:secret
    
    Fill Database credentials
    _______________________________________
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=

    Fill Smtp server credentials
    _______________________________________        
    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.googlemail.com
    MAIL_PORT=465
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=ssl
    MAIL_FROM_ADDRESS=
    MAIL_FROM_NAME="Your name"

## 3. Database provisioning
    php artisan migrate
    php artisan db:seed
    
## 4. Serve project

    go to project root directory and call
    
     php -S localhost:8000 -t ./public
     
## 5. Provision Postman

    go to postman and import {project-root}/postman_collection.json
    
    file
     
## 6. Requests

    Register user (PUBLIC METHOD)
    http://localhost:8000/api/register
    
    Login user (PUBLIC METHOD)
    (Gotten token use in private methods)
    http://localhost:8000/api/login
    
    GET USER DATA (PRIVATE ADMIN METHOD)
    http://localhost:8000/api/users/1
    
    GET USER LIST (PRIVATE ADMIN METHOD)
    http://localhost:8000/api/users
    
    GET USER DATA (PRIVATE USER|ADMIN METHOD)
    http://localhost:8000/api/profile
    
    REMIND PASSWORD (PUBLIC METHOD)
    (methods sends an restore code to use in restore password method)
    http://localhost:8000/api/remind
    
    RESTORE PASSWORD (PUBLIC METHOD)
    (use hash got from email)
    http://localhost:8000/api/password-reset 
    
    ADD TODO RECORD (PRIVATE USER METHOD)
    http://localhost:8000/api/todo-add
    
    UPDATE TODO RECORD (PRIVATE USER-OWNER METHOD)
    http://localhost:8000/api/todo-update
    
    GET LIST OF ALL USERS TODO (PRIVATE ADMIN METHOD)
    http://localhost:8000/api/todo-list
    
    DELETE TODO RECORD (PRIVATE ADMIN METHOD)
    http://localhost:8000/api/todo-delete
    
    GET ACTIVITY LOG OF ALL SYSTEM (PRIVATE ADMIN METHOD)
    http://localhost:8000/api/activity-log
    
    
    
    

