<?php
if (!class_exists('Yii', false) || Yii::app() === null) {
    $config = include(__DIR__ . '/../../config/test.php');
    Yii::createWebApplication($config);
}