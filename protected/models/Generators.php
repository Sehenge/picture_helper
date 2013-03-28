<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 3/28/13
 * Time: 4:08 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * Class Generators
 */
class Generators
{
    public static function addToFeed($data)
    {
        $line = array($data['upc'],$data['model'],implode('', explode(" ", $data['model'])),$data['colorCode'],
            $data['frame'],$data['lens'],$data['material'],$data['style'],$data['usage'],$data['size'],
            $data['description'],$data['polar'],$data['rx'],$data['gender'],$data['country']);
        /*
        $upc = $data['upc'];
        $model = $data['model'];
        $alterModel = implode('', explode(" ", $model));
        $colorCode = $data['colorCode'];
        $frame = $data['frame'];
        $lens = $data['lens'];
        $material = $data['material'];
        $style = $data['style'];
        $usage = $data['usage'];
        $size = $data['size'];
        $description = $data['description'];
        $polarized = $data['polar'];
        $rxable = $data['rx'];
        $gender = $data['gender'];
        $country = $data['country'];*/

        $tempFile = fopen('temp.csv', 'a');
        fputcsv($tempFile, $line);
        fclose($tempFile);
        return $linecount = count(file('temp.csv'));
        //return 2;
    }

    public static function azGenerator($data)
    {
        $upc = $data['upc'];
        $model = $data['model'];
        $alterModel = implode('', explode(" ", $model));
        $colorCode = $data['colorCode'];
        $frame = $data['frame'];
        $lens = $data['lens'];
        $material = $data['material'];
        $style = $data['style'];
        $usage = $data['usage'];
        $size = $data['size'];
        $description = $data['description'];
        $polarized = $data['polar'];
        $rxable = $data['rx'];
        $gender = $data['gender'];
        $country = $data['country'];

        $head = array('Auction Title','Inventory Number','Quantity Update Type','Quantity','Starting Bid','Reserve','Weight','ISBN','UPC','EAN','ASIN','MPN','Short Description','Description','Manufacturer','Brand','Condition','Warranty','Seller Cost','Product Margin','Buy It Now Price','Retail Price','Second Chance Offer Price','Picture URLs','TaxProductCode','Supplier Code','Supplier PO','Warehouse Location','Received In Inventory','Inventory Subtitle','Relationship Name','Variation Parent SKU','Ad Template Name','Posting Template Name','Schedule Name','eBay Category List','eBay Store Category Name','Labels','DC Code','Do Not Consolidate ','ChannelAdvisor Store Title','ChannelAdvisor Store Description','Store Meta Description','ChannelAdvisor Store Price','ChannelAdvisor Store Category ID','Classification','Attribute1Name','Attribute1Value','Attribute2Name','Attribute2Value','Attribute3Name','Attribute3Value','Attribute4Name','Attribute4Value','Attribute5Name','Attribute5Value','Attribute6Name','Attribute6Value','Attribute7Name','Attribute7Value','Attribute8Name','Attribute8Value','Attribute9Name','Attribute9Value','Attribute10Name','Attribute10Value','Attribute11Name','Attribute11Value','Attribute12Name','Attribute12Value','Attribute13Name','Attribute13Value','Attribute14Name','Attribute14Value','Attribute15Name','Attribute15Value','Attribute16Name','Attribute16Value','Attribute17Name','Attribute17Value','Attribute18Name','Attribute18Value','Harmonized Code','Height','Length','Width','Ship Zone Name','Ship Carrier Code','Ship Class Code','Ship Rate First Item','Ship Handling First Item','Ship Rate Additional Item','Ship Handling Additional Item','(repeat)');
        $content = array('Auction Title','Inventory Number','INSTOCK','Quantity','Starting Bid','','','',$upc,'','','','',$description,'Manufacturer','Brand','NEW','','Seller Cost','','Buy It Now Price','Retail Price','','Picture URLs','','','','','','','','','','','','','','','','','','','','','',$description,$model,'Attribute1Value','COLOR CODE',$colorCode,'COLOR DESCRIPTION','Attribute3Value','SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH','NEED WIDTH','RX_TEMPLE_LENGTH','NEED LENGTH','GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND','NEED BRAND','CONDITION','NEW','','','','','','','','','','','','');
        $fp = fopen('azFeed.csv', 'w');
        fputcsv($fp, $head);
        fclose($fp);
        var_dump($model); die(1);
    }

    public static function ukGenerator()
    {

    }

    public static function fpGenerator()
    {

    }

    public static function stdGenerator()
    {

    }

    public static function checkCount()
    {
        return count(file('temp.csv'));
    }
}