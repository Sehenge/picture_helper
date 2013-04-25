<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Feeder';
$this->breadcrumbs=array(
	'Feeder',
);
?>

<div class="count">
    Count of products in temporary feed: <span id="fcount">0</span>
</div>
<table class="files">
    <tr><td>Temp:</td><td><a href="https://www.union-progress.com/feedhelper/picture_helper/temp.csv">Download</a></td></tr>
    <tr><td>Amazon:</td><td><a href="https://www.union-progress.com/feedhelper/picture_helper/azFeed.csv">Download</a></td></tr>
    <tr><td>Amazon UK:</td><td><a href="https://www.union-progress.com/feedhelper/picture_helper/ukFeed.csv">Download</a></td></tr>
    <tr><td>Sears:</td><td><a href="https://www.union-progress.com/feedhelper/picture_helper/fpFeed.csv">Download</a></td></tr>
    <tr><td>Ebay:</td><td><a href="https://www.union-progress.com/feedhelper/picture_helper/ebayFeed.csv">Download</a></td></tr>
    <tr><td>Ewc:</td><td><a href="https://www.union-progress.com/feedhelper/picture_helper/regFeed.csv">Download</a></td></tr>
</table>

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
        <input type="text" placeholder="FRAME COLOR" name="frame"/>
        <input type="text" placeholder="LENS COLOR" name="lens"/>
        <!--input type="text" placeholder="MATERIAL" name="material"/-->
        <div class="select">
            <select name="material">
                <option>Metal</option>
                <option>Plastic</option>
                <option>Composite</option>
            </select>
        </div>
        <!--input type="text" placeholder="SHAPE" name="shape"/-->
        <!--input type="text" placeholder="USAGE" name="usage"/-->
        <div class="select">
            <select name="usage">
                <option>Fashion</option>
                <option>Sports</option>
                <option>Watersports</option>
                <option>Snowsports</option>
                <option>Golf</option>
            </select>
        </div>
        <input type="text" placeholder="SIZE" name="size"/>
        <div class="fselect">
            <select name="sizeS"></select>
        </div>
        <input type="text" placeholder="STARTING BID" name="startingBid"/>
        <input type="text" placeholder="SELLER COST" name="sellerCost"/>
        <div class="fselect">
            <select name="sellerCostS"></select>
        </div>
        <input type="text" placeholder="RETAIL PRICE" name="retail"/>
        <input type="text" placeholder="QUANTITY" name="quantity"/>


        RX <input type="checkbox" name="rx" value="rx">
        POLARIZED <input type="checkbox" name="polar" value="polar">
        <div class="select">
            <select name="gender">
                <option>Men</option>
                <option>Women</option>
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
                <option>Butterfly</option>
                <option>Cat-eye</option>
                <option>Goggle</option>
                <option>Rimless</option>
                <option>Semi-Rimless</option>
                <option>Shield</option>
                <option>Oversized</option>
                <option>Square</option>
                <option>Sport</option>
                <option>Wayfarer</option>
                <option>Wrap</option>
                <option>Heart</option>
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
        <!--input class="customSubmit" name="searchShdx" type="button" value="Search Shadesexpo" id="searchShdx" /-->
        <input class="customSubmit" name="addToFeed" type="button" value="Add to feed" id="addToFeed" />
        <input class="customSubmit" name="azGenBtn" type="button" value="Generate AZ Feed" id="azGenBtn" />
        <input class="customSubmit" name="ukGenBtn" type="button" value="Generate UK Feed" id="ukGenBtn" />
        <input class="customSubmit" name="fpGenBtn" type="button" value="Generate FP Feed" id="fpGenBtn" />
        <input class="customSubmit" name="ebayGenBtn" type="button" value="Generate Ebay Feed" id="ebayGenBtn" />
        <input class="customSubmit" name="regGenBtn" type="button" value="Generate EWC Feed" id="regGenBtn" />
        <input class="customSubmit" name="clearfeed" type="button" value="Clear Feed" id="clearfeed" />
    </div>
    <div id="fifth_img"></div>

    <div class="output" style="position: relative; top: -324px; left: -23px;">
        <textarea id="searchResult" name="pictures"></textarea>
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