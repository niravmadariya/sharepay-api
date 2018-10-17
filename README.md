# Sharepay-api
Share Pay application APIs

This repository contains APIs for an application SharePay.

SharePay is an application to split the bills among friends.

APIs are created in core PHP (No Language Libraries used).

## The stack & building from source 
APIs are built upon PHP 7.1

IIS Server

Library - db_pdo.inc for database transactions 

## Building the Project

1. changes in php/local.inc - add your database connection parameter
```
var $Host     = "";
var $Database = "";
var $User     = "";
var $Password = "";
var $charset  = "utf8";
```

2. changes in lob/Crypto_provider.inc - add your own salt
```
$salt = "YourSalt";
```

3. changes in api/login.php - add your own AES-256 encryption key for encryption
```
$aes = new AES($data[0]["password"],"YourKey",256);
```

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
