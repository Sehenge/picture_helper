<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$brand = file_get_contents('http://affordableluxurygroup.com/Pictures/' . strtoupper($_POST['asin']));
echo $brand
?>