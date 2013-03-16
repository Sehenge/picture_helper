<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

    <form class="input" action="?r=site/getdir" method="post">
        <input type="text" placeholder="ASIN" name="asin"/>
        <?php
        echo CHtml::ajaxSubmitButton('Submit', CHtml::normalizeUrl(array('site/getdir')),
            array(
                'data'=>'js:jQuery(this).parents("form").serialize()+"&isAjaxRequest=1"',
                'success'=>
                'function(data){
                      $("#searchResult").html(data);
                      return false;
                 }'

            ),
            array(
                'id'=>'ajaxSubmit',
                'name'=>'ajaxSubmit'
            ));
        ?>
    </form>

<div class="output">
    <textarea readonly id="searchResult"></textarea>
</div>