# Oak Bank

## Description:
This web application enables users to manage multiple bank accounts in different currencies, perform money transfers between accounts and between users, and receive payments. A unique feature is the use of code cards for secure transfers, requiring a code for each transaction. It also features a cryptocurrency exchange platform with real-time pricing information and the ability to buy and sell various digital currencies in multiple fiat currencies.

## Features:
* Multiple bank accounts in various currencies.
* Money transfers between accounts.
* Money transfers between users.
* Code generation for money transfers.
* Currency exchange.
* Receive payments.
* Buy and sell cryptocurrencies.
* Transaction history.

## Prerequisites:
<ol>
<li>PHP 8.0</li>
<li>MySQL 8.0.31</li>
<li>Node.js 14.17.6</li>
<li>Composer</li>
</ol>

## Instructions to run the website:
<ol>
<li>Clone the repository:<br><code>git clone https://github.com/renars-ozols/oak-bank.git</code></li><br>
<li>Install dependencies:<br><code>composer install</code><br><code>npm install</code></li><br>
<li>Register at https://coinmarketcap.com/api/ and get your API key. </li><br>
<li>Rename <code>.env.example</code> to <code>.env</code>.</li><br>
<li>Enter your API key and database settings in the <code>.env</code> file.</li><br>
<li>In your terminal run these commands: <br><code>php artisan key:generate</code> to set Laravel application key.
<br><code>php artisan migrate</code> to create database tables.
<br><code>npm run dev</code> to compile the frontend assets.
<br><code>php artisan serve</code> to run the server.
</li><br>
</ol>

### Homepage
<img width="1343" alt="screenshot" src="https://user-images.githubusercontent.com/43919610/216307488-ebd95db4-9ba3-412e-a2d4-7350582f1644.png">

### Register and Login page
![register_login](https://user-images.githubusercontent.com/43919610/216307811-072eb1a9-7511-4c19-9a04-90ddb837913d.gif)

### Accounts, money transfer, transaction filtering
![account](https://user-images.githubusercontent.com/43919610/216307975-e9dfa96c-a7b3-478e-85a1-ea3f83876c60.gif)

### Crypto, buying and selling, transaction filtering
![crypto](https://user-images.githubusercontent.com/43919610/216308136-d1b32468-eb87-4d9a-9b8c-16765bbc0f95.gif)
