<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
> To Run the PART B NXM ASSESSMENT, switch to `part-b` branch: <code>git switch part-b</code> 
## Installation
> Deploy NXM ASSESSMENT in a Web Server (Ubuntu)
1. Install Apache Web Server
    -   <code>sudo apt install apache2 -y</code>
    -   Start Apache2 service: <code>sudo service apache2 start</code>
2. Install PHP and Dependencies
    -   <code>sudo apt install php libapache2-mod-php php-mbstring php-xmlrpc php-soap php-gd php-xml php-cli php-zip php-bcmath php-tokenizer php-json php-pear php-curl php-mysql</code>
    -   Enable MySQL PDO PHP Extention by uncommenting: <code>extension=pdo_mysql</code> in <i>/etc/apache2/7.4/apache2/php.ini</i> by removing <b>;</b>
3. Install MySQL Database Server
    -   <code>sudo apt install mysql-server -y</code>
    -   Start MySQL service: <code>sudo service mysql start</code>
    -   Run: <code>mysql_secure_connection</code>
        -   Remove anonymous users? [Y/n] y
        -   Disallow root login remotely? [Y/n] n
        -   Remove test database and access to it? [Y/n] y
        -   Reload privilege tables now? [Y/n] y
    -   Login to MySQL using root: <code>sudo mysql -u root</code>
    -   Create an <b>admin</b> user to localhost/127.0.0.1 database together with the password: <code>ALTER USER 'admin'@'localhost' IDENTIFIED BY 'Admin_2k21'</code>
    -   Grant ALL permission to <b>admin</b> user: <code>GRANT ALL ON *.* TO 'admin'@'localhost';</code>
    -   Save changes to database without reloading or restart mysql service: <code>FLUSH PRIVILEGES;</code>
    -   Login to MySQL using the user `admin`: <code>sudo mysql -u admin -p</code> then enter the password: `Admin_2k21`
    -   Create a database: <code>CREATE DATABASE nxm_assessment;</code>
    -   Import the dumped MySQL file `nxm_assessment.sql`: <code>SOURCE ./nxm_assessment.sql;</code> 
4. Install Composer for Laravels' PHP Dependency Manager 
    -   <code>curl -sS https://getcomposer.org/installer | php</code>
    -   <code>sudo mv composer.phar /usr/local/bin/composer</code>
    -   <code>sudo chmod +x /usr/local/bin/composer</code>
5. Install NodeJS & NPM for Laravels' NODE Package Manger
    -   <code>sudo apt install npm -y</code>
    -   Update NPM: <code>sudo npm install -g npm</code>
    -   Install NodeJS-LTS:
        -   <code>sudo npm install -g n</code>
        -   <code>sudo n lts</code>
        -   Run <code>sudo npm install</code> command on root directory of nxm_assessment to install npm dependencies
6. Clone NXM ASSESSMENT Repository and Install PHP and NPM dependencies then move to Apache web root
    -   Open terminal and type: <code>git clone https://github.com/mboy1011/nxm_assessment</code>
    -   Install PHP Dependencies using Composer:
        -   <code>composer update</code>
    -   Install NPM Dependencies using `npm` command:
        -   <code>npm install</code>
    -   Move the `nxm_assessment` directory:<code>sudo mv nxm_assessment /var/www/html/</code>
    -   Change the permission to apache's web server user 
        -   <code>sudo chgrp -R www-data /var/www/html/nxm_assessment/</code>
        -   <code>sudo chmod -R 775 /var/www/html/nxm_assessment/storage</code>
7. Create a new Virtual Host for nxm_assessment:
    -   Go to <b>site-available</b> directory: <code>cd /etc/apache2/sites-available</code>
    -   Create a <b><i>nxm_assessment.conf</i></b>: <code>sudo vim nxm_assessment.conf</code>
    -   Add the following code to `nxm_assessment.conf`:
    ```apache
        <VirtualHost *:80>
            ServerName 172.29.165.208
            ServerAdmin webmaster@172.29.165.208
            DocumentRoot /var/www/html/nxm_assessment/public
            <Directory /var/www/html/nxm_assessment>
                AllowOverride All
            </Directory>
            ErrorLog ${APACHE_LOG_DIR}/error.log
            CustomLog ${APACHE_LOG_DIR}/access.log combined
        </VirtualHost>
    ```
    -   Disable default config file for virtual host: <code>sudo a2dissite 000-default.conf</code>
    -   Enable our newly created virtual host: <code>sudo a2ensite nxm.conf</code>
    -   Enable Apache's <b>rewrite</b> module: <code>sudo a2enmod rewrite</code>
    -   Restart Apache Service: <code>sudo service apache2 restart</code>
8. Create DotEnv for Laravel by copying `.env.example` to nxm_assessment root directory: <code>cp .env.example ./.env</code>
    ```.env
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=nxm_assessment
    DB_USERNAME=admin
    DB_PASSWORD=Admin_2k21
    ```
9. Execute the following commands:
    -   <code>php artisan migrate</code> to migrate all database migrations.
    -   <code>php artisan key:generate</code> to generate an APP_KEY to `.env`
> To Run the NXM ASSESSMENT Locally for development: <code>php artisan serve</code>