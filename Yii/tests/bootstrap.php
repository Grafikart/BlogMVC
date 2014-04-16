<?php
require_once('../vendor/yiisoft/yii/framework/yiit.php');
$config = include('../config/test.php');
Yii::createWebApplication($config);