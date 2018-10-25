# Sharepay-api
Share Pay application APIs

This repository contains APIs for an application SharePay.

SharePay is an application to split the bills among friends.

APIs are created in core PHP (No Language Libraries used).

### Security 
Not Storing any user data in raw format

Created custom crypto provider class to encerypt data and also using AES256 encryption for encrypting some data.

## The stack & building from source 
APIs are built upon PHP 7.1

IIS Server

Library - <a href="https://github.com/niravmadariya/sharepay-api/blob/master/php/db_pdo.inc">db_pdo.inc</a> from <a href="https://github.com/niravmadariya/phplib/tree/master/inc/db_pdo.inc">db_pdo.inc</a> for database transactions (with custom updates) 

## Building the Project

### 1. changes in php/local.inc - add your database connection parameter
```
var $Host     = "";
var $Database = "";
var $User     = "";
var $Password = "";
var $charset  = "utf8";


// Replace your own AES 256 Encryption key
$_CONFIG["aes_enc_key"] = "Your AES 256 Key";

// Replace your own AES 256 Encryption key (used by client app to encrypt data, differs from above key)
$_CONFIG["aes_enc_client_key"]="Your Client AES 256 Encrytion key";

// Replace with your own salt to encrypt data 
$_CONFIG["crypto_provider_salt"] = "Your Encryption Salt";

```

### 2. changes in Database - import users.sql

#### For now this project only runs on IIS (soon there will be update with apache configurations)
#### Also, for now there is only login API available, soon there will be an update for other APIs.

#### Show some :heart: and star the repo to support the project
[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?v=102)](https://opensource.org/licenses/Apache-2.0)
[![License](https://img.shields.io/badge/license-Apache%202.0-blue.svg)](https://github.com/niravmadariya/sharepay-api/blob/master/LICENSE)

## License

```
Copyright 2018 Nirav Madariya

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

```
