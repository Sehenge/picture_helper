<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Feeder';
$this->breadcrumbs=array(
	'Feeder',
);
?>

<div class="count">
    Count of products in feed: <span id="fcount">0</span>
</div>

<form class="feederInput" action="?r=site/getdir" method="post">
    <div class="finput">
        <input type="text" placeholder="UPC" name="upc"/>
        <input type="text" placeholder="MODEL" name="model"/>
        <input type="text" placeholder="BRAND" name="brand"/>
        <input type="text" placeholder="COLOR CODE" name="colorCode"/>
        <div class="fselect">
            <select name="colorCodeS"></select>
        </div>
        <input type="text" placeholder="COLOR" name="color"/>
        <div class="fselect">
            <select name="colorS"></select>
        </div>
        <input type="text" placeholder="FRAME" name="frame"/>
        <input type="text" placeholder="LENS" name="lens"/>
        <input type="text" placeholder="MATERIAL" name="material"/>
        <!--input type="text" placeholder="SHAPE" name="shape"/-->
        <input type="text" placeholder="USAGE" name="usage"/>
        <input type="text" placeholder="SIZE" name="size"/>
        <div class="fselect">
            <select name="sizeS"></select>
        </div>
        <input type="text" placeholder="PRICE" name="price"/>
        <div class="fselect">
            <select name="priceS"></select>
        </div>

        RX <input type="checkbox" name="rx" value="rx">
        POLARIZED <input type="checkbox" name="polar" value="polar">
        <div class="select">
            <select name="gender">
                <option>Male</option>
                <option>Female</option>
                <option>Unisex</option>
            </select>
        </div>
        <div class="select">
            <select name="description">
                <option>Sunglasses</option>
                <option>Eyeglasses</option>
            </select>
        </div>
        <div class="select">
            <select name="style">
                <option>Rectangle</option>
                <option>Aviator</option>
                <option>Round</option>
                <option>Oval</option>
            </select>
        </div>
        <div class="select">
            <select name="country">
                <option>Imported</option>
                <option>Italy</option>
                <option>United Kingdom</option>
                <option>France</option>
                <option>Japan</option>
                <option>Australia</option>
            </select>
        </div>
</div>
    <div class="fbuttons">
     <?php
        echo CHtml::ajaxSubmitButton('Add to Feed', CHtml::normalizeUrl(array('site/addtofeed')),
            array(
                'data'=>'js:jQuery(this).parents("form").serialize()',
                'success'=>
                'function(data){
                      helper = new Helper();
                      console.log(data);
                      $("#fcount").text(data);
                      //helper.PrintImages(data);
                      //$("#preloader").hide();
                      return false;
                 }'
            ),
            array(
                'class'=>'ajaxSubmit',
                'name'=>'addtofeed'
            ));
        echo CHtml::ajaxSubmitButton('Generate AZ Feed', CHtml::normalizeUrl(array('site/azgen')),
            array(
                'data'=>'js:jQuery(this).parents("form").serialize()',
                'success'=>
                'function(data){
                      helper = new Helper();
                      console.log(data);
                      //helper.PrintImages(data);
                      //$("#preloader").hide();
                      return false;
                 }'
            ),
            array(
                'class'=>'ajaxSubmit',
                'name'=>'azGenBtn'
            ));
        echo CHtml::ajaxSubmitButton('Generate UK Feed', CHtml::normalizeUrl(array('site/ukgen')),
        array(
            'data'=>'js:jQuery(this).parents("form").serialize()',
            'success'=>
            'function(data){
                  helper = new Helper();
                  //helper.PrintImages(data);
                  //$("#preloader").hide();
                  return false;
             }'
        ),
        array(
            'class'=>'ajaxSubmit',
            'name'=>'ukGenBtn'
        ));

        echo CHtml::ajaxSubmitButton('Generate FP Feed', CHtml::normalizeUrl(array('site/fpgen')),
            array(
                'data'=>'js:jQuery(this).parents("form").serialize()',
                'success'=>
                'function(data){
                      helper = new Helper();
                      console.log(data);
                      return false;
                 }'
            ),
            array(
                'class'=>'ajaxSubmit',
                'name'=>'fpGenBtn'
            ));

        echo CHtml::ajaxSubmitButton('Generate Ebay Feed', CHtml::normalizeUrl(array('site/ebaygen')),
            array(
                'data'=>'js:jQuery(this).parents("form").serialize()',
                'success'=>
                'function(data){
                      helper = new Helper();
                      //helper.PrintImages(data);
                      //$("#preloader").hide();
                      return false;
                 }'
            ),
            array(
                'class'=>'ajaxSubmit',
                'name'=>'fpGenBtn'
            ));
        echo CHtml::ajaxSubmitButton('Generate Std Feed', CHtml::normalizeUrl(array('site/stdgen')),
            array(
                'data'=>'js:jQuery(this).parents("form").serialize()',
                'success'=>
                'function(data){
                      helper = new Helper();
                      //helper.PrintImages(data);
                      //$("#preloader").hide();
                      return false;
                 }'
            ),
            array(
                'class'=>'ajaxSubmit',
                'name'=>'stdGenBtn'
            ));

        echo CHtml::ajaxSubmitButton('Clear Feed', CHtml::normalizeUrl(array('site/clearfeed')),
            array(
                'data'=>'js:jQuery(this).parents("form").serialize()',
                'success'=>
                'function(data){
                      helper = new Helper();
                      console.log(data);
                      $("#fcount").text(data);
                      //helper.PrintImages(data);
                      //$("#preloader").hide();
                      return false;
                 }'
            ),
            array(
                'class'=>'ajaxSubmit',
                'name'=>'clearfeed'
            ));
        ?>
    </div>
</form>