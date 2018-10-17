<?php

$_CONFIG["PHP,SERVERBASE"] = dirname(dirname(__FILE__));

$_CONFIG["domainNM"] = $_SERVER["HTTP_HOST"];

$_CONFIG["PHP,PATH"] = $_CONFIG["PHP,SERVERBASE"]."\\php\\";

$_CONFIG["PHP,LIB"] = $_CONFIG["PHP,SERVERBASE"]."\\lib\\";

?>