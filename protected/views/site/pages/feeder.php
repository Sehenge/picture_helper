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

<form class="feederInput" method="post">
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
        <input type="text" placeholder="STARTING BID" name="startingBid"/>
        <input type="text" placeholder="SELLER COST" name="sellerCost"/>
        <div class="fselect">
            <select name="sellerCostS"></select>
        </div>
        <input type="text" placeholder="BUY IT NOW" name="buyItNow"/>
        <input type="text" placeholder="RETAIL PRICE" name="retail"/>
        <input type="text" placeholder="QUANTITY" name="quantity"/>


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
        <input class="customSubmit" name="searchAff" type="button" value="Search Affordable" id="searchAff" />
        <input class="customSubmit" name="addToFeed" type="button" value="Add to feed" id="addToFeed" />
        <input class="customSubmit" name="azGenBtn" type="button" value="Generate AZ Feed" id="azGenBtn" />
        <input class="customSubmit" name="ukGenBtn" type="button" value="Generate UK Feed" id="ukGenBtn" />
        <input class="customSubmit" name="fpGenBtn" type="button" value="Generate FP Feed" id="fpGenBtn" />
        <input class="customSubmit" name="ebayGenBtn" type="button" value="Generate Ebay Feed" id="ebayGenBtn" />
        <input class="customSubmit" name="regGenBtn" type="button" value="Generate Regular Feed" id="regGenBtn" />
        <input class="customSubmit" name="clearfeed" type="button" value="Clear Feed" id="clearfeed" />
    </div>
    <div id="fifth_img"></div>

    <div class="output" style="position: relative; top: -378px; left: -23px;">
        <textarea readonly id="searchResult" name="pictures"></textarea>
    </div>
</form>


<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<div class="img_container" style="top: -320px;">
    <div class="eyewear"></div>
    <div class="cases">
        <form>

        </form>
    </div>
</div>

<div id='bpop'><span>Test message</span></div>

<div class="tmpCont" style="display: none;"></div>