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
