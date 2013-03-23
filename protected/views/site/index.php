<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

    <form class="input" action="?r=site/getdir" method="post">
        <input type="text" placeholder="SKU" name="sku"/>
        <div class="select">
            <select name="brand">
                <?php
                foreach($brands as $brand) {
                    echo '<option>', $brand, '</option>';
                }
                ?>
            </select>
        </div>
        <input type="text" placeholder="Model" name="model"/>
        <input type="text" placeholder="Color Code" name="color_code"/>
        <?php
        echo CHtml::ajaxSubmitButton('Search', CHtml::normalizeUrl(array('site/getdir')),
            array(
                'data'=>'js:jQuery(this).parents("form").serialize()',
                'success'=>
                'function(data){
                      helper = new Helper();
                      helper.PrintImages(data);
                      $("#preloader").hide();
                      return false;
                 }'
            ),
            array(
                'id'=>'ajaxSubmit',
                'name'=>'ajaxSubmit'
            ));
        ?>
        <div id="fifth_img"></div>
        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
    </form>

<div class="output">
    <textarea readonly id="searchResult"></textarea>
</div>

<div class="img_container">
    <div class="eyewear"></div>
    <div class="cases">
        <form>

        </form>
    </div>
</div>