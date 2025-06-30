# FotoSelect Backend
FotoSelect is an application designed for photographers who want to share photo albums with their clients in an organized and secure way. This repository contains the **backend API**, built with **pure PHP**, responsible for managing users, JWT-based authentication, galleries, images, access permissions, subscription plans, and credit transactions.

The backend follows the **MVP** and **DDD** architecture, with clean and modular code to facilitate maintenance, scalability, and seamless integration with the frontend developed in Next.js.

## Main Features
- User registration and login (JWT)
- Creation and management of photo galleries
- Upload, listing, and deletion of images
- Access control (photographers, clients, and administrators)
- Credit system for photo selection and purchases `to do`
- Subscription plan management `to do`


# How to Run
1. Clone the Repository:
   ```bash
   git clone https://github.com/RodriguesEmerson/fotoselect
   ```
2. Enable friendly URLs in Apache settings:
   - In the `httpd.conf` file, enable:
     ```
     LoadModule rewrite_module modules/mod_rewrite.so
     ```
   - Still in `httpd.conf`, change:
     ```
     <Directory '${SRVROOT}/htdocs'>
         AllowOverride None
     </Directory>
     ```
     to
     ```
     <Directory '${SRVROOT}/htdocs'>
         AllowOverride All
     </Directory>
     ```
3. In the `backend` folder, run the command below in the terminal to install the dependencies:
   ```bash
   composer update
   ```
6. Start the Apache server and MySQL in XAMPP.
7. Test the API (tip: use Insomnia or Postman).
