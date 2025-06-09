# FotoSelect Backend



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
