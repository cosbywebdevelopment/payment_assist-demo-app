# laravel-demo-app
A demonstration Laravel application with full Payment Assist integration

## Installation
1.Install Composer using detailed installation instructions [here](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
```
$ wget https://getcomposer.org/composer.phar
$ chmod +x composer.phar
$ mv composer.phar /usr/local/bin/composer
```
2.Install Node.js using detailed installation instructions [here](https://nodejs.org/en/download/package-manager/)
```
$ yum install npm
```
3.Clone repository
```
$ git clone https://github.com/paymentassist/laravel-demo-app.git
```
4.Change into the working directory
````
$ cd laravel-demo-app
````
5.Copy .env.example to .env and modify according to your environment
````
$ cp .env.example .env
````
6.An application key can be generated with the command
````
$ php artisan key:generate
````
7.Execute following commands to install other dependencies
````
$ npm install
$ npm run dev
````
8.Run these commands to create the tables within the defined database and populate seed data
````
$ php artisan migrate --seed
````
<p>User: admin@admin.com</p>
<p>Password: password</p>
<p></p>
9.Add your Payment Assist API credentials to the .env file

<p>PA_API_KEY=</p>
<p>PA_SECRET=</p>



