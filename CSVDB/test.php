<?php

require_once("CSVDB.php");

$db = new CSVDB("xser");
$db->exec("create database xser");
$db->exec("create table post (id,title,content,time)");
$db->exec("insert into post values(1,\"a\",\"b\",\"c\")");