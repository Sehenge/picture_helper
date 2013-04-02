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
        foreach ($data as $key => $value) {
            $data[$key] = strtoupper($value);
        }
        isset($data['rx']) ? $data['rx'] = 'YES' : $data['rx'] = 'NO';
        isset($data['polar']) ? $data['polar'] = 'POLARIZED' : $data['polar'] = '';
        $size_arr = explode('/', $data['size']);
        $width = $size_arr[0];
        $length = $size_arr[2];


        $line = array($data['upc'],$data['model'],implode('', explode(" ", $data['model'])),$data['colorCode'],
            $data['frame'],$data['lens'],$data['material'],$data['style'],$data['usage'],$data['size'],
            $data['description'],$data['polar'],$data['rx'],$data['gender'],$data['country'],$width,$length);
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

    public static function azGenerator()
    {
        $head = array('Auction Title','Inventory Number','Quantity Update Type','Quantity','Starting Bid','Reserve','Weight','ISBN','UPC','EAN','ASIN','MPN','Short Description','Description','Manufacturer','Brand','Condition','Warranty','Seller Cost','Product Margin','Buy It Now Price','Retail Price','Second Chance Offer Price','Picture URLs','TaxProductCode','Supplier Code','Supplier PO','Warehouse Location','Received In Inventory','Inventory Subtitle','Relationship Name','Variation Parent SKU','Ad Template Name','Posting Template Name','Schedule Name','eBay Category List','eBay Store Category Name','Labels','DC Code','Do Not Consolidate ','ChannelAdvisor Store Title','ChannelAdvisor Store Description','Store Meta Description','ChannelAdvisor Store Price','ChannelAdvisor Store Category ID','Classification','Attribute1Name','Attribute1Value','Attribute2Name','Attribute2Value','Attribute3Name','Attribute3Value','Attribute4Name','Attribute4Value','Attribute5Name','Attribute5Value','Attribute6Name','Attribute6Value','Attribute7Name','Attribute7Value','Attribute8Name','Attribute8Value','Attribute9Name','Attribute9Value','Attribute10Name','Attribute10Value','Attribute11Name','Attribute11Value','Attribute12Name','Attribute12Value','Attribute13Name','Attribute13Value','Attribute14Name','Attribute14Value','Attribute15Name','Attribute15Value','Attribute16Name','Attribute16Value','Attribute17Name','Attribute17Value','Attribute18Name','Attribute18Value','Harmonized Code','Height','Length','Width','Ship Zone Name','Ship Carrier Code','Ship Class Code','Ship Rate First Item','Ship Handling First Item','Ship Rate Additional Item','Ship Handling Additional Item','(repeat)');
        $fp = fopen('azFeed.csv', 'w');
        fputcsv($fp, $head);
        if (($handle = fopen("temp.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $upc = $data[0];
                $model = $data[1];
                $manufacturer = explode(" ", $data[1]);
                $manufacturer = $manufacturer[0];
                $alterModel = $data[2];
                $colorCode = $data[3];
                $frame = $data[4];
                $lens = $data[5];
                $material = $data[6];
                $style = $data[7];
                $usage = $data[8];
                $size = $data[9];
                $description = $data[10];
                $polarized = $data[11];
                $rxable = $data[12];
                $gender = $data[13];
                $country = $data[14];
                $width = $data[15];
                $length = $data[16];
                $invNumber = 'AZ' . $model . '-' . $colorCode . '-' . $width;

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
                $country = $data['country'];
                */


                $content = array('Auction Title',$invNumber,'INSTOCK','Quantity','Starting Bid','','','',$upc,'','','','',$description,$manufacturer,'Brand','NEW','','Seller Cost','','Buy It Now Price','Retail Price','','Picture URLs','','','','','','','','','','','','','','','','','','','','','',$description,'MODEL',$model,'COLOR CODE',$colorCode,'COLOR DESCRIPTION','Attribute3Value','SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH',$width,'RX_TEMPLE_LENGTH',$length,'GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND','NEED BRAND','CONDITION','NEW','','','','','','','','','','','','');
                fputcsv($fp, $content);
            }
        }
        fclose($fp);
        fclose($handle);
        //self::clearFeed();
    }

    public static function ukGenerator()
    {
        $head = array('Auction Title','Inventory Number','Quantity Update Type','Quantity','Starting Bid','Reserve','Weight','ISBN','UPC','EAN','ASIN','MPN','Short Description','Description','Manufacturer','Brand','Condition','Warranty','Seller Cost','Product Margin','Buy It Now Price','Retail Price','Second Chance Offer Price','Picture URLs','TaxProductCode','Supplier Code','Supplier PO','Warehouse Location','Received In Inventory','Inventory Subtitle','Relationship Name','Variation Parent SKU','Ad Template Name','Posting Template Name','Schedule Name','eBay Category List','eBay Store Category Name','Labels','DC Code','Do Not Consolidate ','ChannelAdvisor Store Title','ChannelAdvisor Store Description','Store Meta Description','ChannelAdvisor Store Price','ChannelAdvisor Store Category ID','Classification','Attribute1Name','Attribute1Value','Attribute2Name','Attribute2Value','Attribute3Name','Attribute3Value','Attribute4Name','Attribute4Value','Attribute5Name','Attribute5Value','Attribute6Name','Attribute6Value','Attribute7Name','Attribute7Value','Attribute8Name','Attribute8Value','Attribute9Name','Attribute9Value','Attribute10Name','Attribute10Value','Attribute11Name','Attribute11Value','Attribute12Name','Attribute12Value','Attribute13Name','Attribute13Value','Attribute14Name','Attribute14Value','Attribute15Name','Attribute15Value','Attribute16Name','Attribute16Value','Attribute17Name','Attribute17Value','Attribute18Name','Attribute18Value','Harmonized Code','Height','Length','Width','Ship Zone Name','Ship Carrier Code','Ship Class Code','Ship Rate First Item','Ship Handling First Item','Ship Rate Additional Item','Ship Handling Additional Item','(repeat)');
        $fp = fopen('ukFeed.csv', 'w');
        fputcsv($fp, $head);
        if (($handle = fopen("temp.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $upc = $data[0];
                $model = $data[1];
                $manufacturer = explode(" ", $data[1]);
                $manufacturer = $manufacturer[0];
                $alterModel = $data[2];
                $colorCode = $data[3];
                $frame = $data[4];
                $lens = $data[5];
                $material = $data[6];
                $style = $data[7];
                $usage = $data[8];
                $size = $data[9];
                $description = $data[10];
                $polarized = $data[11];
                $rxable = $data[12];
                $gender = $data[13];
                $country = $data[14];
                $width = $data[15];
                $length = $data[16];
                $invNumber = 'UK' . $model . '-' . $colorCode . '-' . $width;

                $content = array('Auction Title',$invNumber,'INSTOCK','Quantity','Starting Bid','','','',$upc,'','','','',$description,$manufacturer,'Brand','NEW','','Seller Cost','','Buy It Now Price','Retail Price','','Picture URLs','','','','','','','','','','','','','','','','','','','','','',$description,'MODEL',$model,'COLOR CODE',$colorCode,'COLOR DESCRIPTION','Attribute3Value','SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH',$width,'RX_TEMPLE_LENGTH',$length,'GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND','NEED BRAND','CONDITION','NEW','','','','','','','','','','','','');
                fputcsv($fp, $content);
            }
        }
        fclose($fp);
        fclose($handle);
        //self::clearFeed();
    }

    public static function fpGenerator()
    {
        $head = array('Auction Title','Inventory Number','Quantity Update Type','Quantity','Starting Bid','Reserve','Weight','ISBN','UPC','EAN','ASIN','MPN','Short Description','Description','Manufacturer','Brand','Condition','Warranty','Seller Cost','Product Margin','Buy It Now Price','Retail Price','Second Chance Offer Price','Picture URLs','TaxProductCode','Supplier Code','Supplier PO','Warehouse Location','Received In Inventory','Inventory Subtitle','Relationship Name','Variation Parent SKU','Ad Template Name','Posting Template Name','Schedule Name','eBay Category List','eBay Store Category Name','Labels','DC Code','Do Not Consolidate ','ChannelAdvisor Store Title','ChannelAdvisor Store Description','Store Meta Description','ChannelAdvisor Store Price','ChannelAdvisor Store Category ID','Classification','Attribute1Name','Attribute1Value','Attribute2Name','Attribute2Value','Attribute3Name','Attribute3Value','Attribute4Name','Attribute4Value','Attribute5Name','Attribute5Value','Attribute6Name','Attribute6Value','Attribute7Name','Attribute7Value','Attribute8Name','Attribute8Value','Attribute9Name','Attribute9Value','Attribute10Name','Attribute10Value','Attribute11Name','Attribute11Value','Attribute12Name','Attribute12Value','Attribute13Name','Attribute13Value','Attribute14Name','Attribute14Value','Attribute15Name','Attribute15Value','Attribute16Name','Attribute16Value','Attribute17Name','Attribute17Value','Attribute18Name','Attribute18Value','Harmonized Code','Height','Length','Width','Ship Zone Name','Ship Carrier Code','Ship Class Code','Ship Rate First Item','Ship Handling First Item','Ship Rate Additional Item','Ship Handling Additional Item','(repeat)');
        $fp = fopen('fpFeed.csv', 'w');
        fputcsv($fp, $head);
        if (($handle = fopen("temp.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $upc = $data[0];
                $manufacturer = explode(" ", $data[1]);
                $manufacturer = $manufacturer[0];
                $model = preg_replace("/ /", "_", $data[1]);
                $alterModel = $data[2];
                $colorCode = $data[3];
                $frame = $data[4];
                $lens = $data[5];
                $material = $data[6];
                $style = $data[7];
                $usage = $data[8];
                $size = $data[9];
                $description = $data[10];
                $polarized = $data[11];
                $rxable = $data[12];
                $gender = $data[13];
                $country = $data[14];
                $width = $data[15];
                $length = $data[16];
                $invNumber = 'FP' . $model . '-' . $colorCode . '-' . $width;

                $content = array('Auction Title',$invNumber,'INSTOCK','Quantity','Starting Bid','','','',$upc,'','','','',$description,$manufacturer,'Brand','NEW','','Seller Cost','','Buy It Now Price','Retail Price','','Picture URLs','','','','','','','','','','','','','','Sears','','','','','','','',$description,'MODEL',$model,'COLOR CODE',$colorCode,'COLOR DESCRIPTION','Attribute3Value','SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH',$width,'RX_TEMPLE_LENGTH',$length,'GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND','NEED BRAND','CONDITION','NEW','','','','','','','','','','','','');
                fputcsv($fp, $content);
            }
        }
        fclose($fp);
        fclose($handle);
    }

    public static function ebayGenerator()
    {
        $head = array('Auction Title','Inventory Number','Quantity Update Type','Quantity','Starting Bid','Reserve','Weight','ISBN','UPC','EAN','ASIN','MPN','Short Description','Description','Manufacturer','Brand','Condition','Warranty','Seller Cost','Product Margin','Buy It Now Price','Retail Price','Second Chance Offer Price','Picture URLs','TaxProductCode','Supplier Code','Supplier PO','Warehouse Location','Received In Inventory','Inventory Subtitle','Relationship Name','Variation Parent SKU','Ad Template Name','Posting Template Name','Schedule Name','eBay Category List','eBay Store Category Name','Labels','DC Code','Do Not Consolidate ','ChannelAdvisor Store Title','ChannelAdvisor Store Description','Store Meta Description','ChannelAdvisor Store Price','ChannelAdvisor Store Category ID','Classification','Attribute1Name','Attribute1Value','Attribute2Name','Attribute2Value','Attribute3Name','Attribute3Value','Attribute4Name','Attribute4Value','Attribute5Name','Attribute5Value','Attribute6Name','Attribute6Value','Attribute7Name','Attribute7Value','Attribute8Name','Attribute8Value','Attribute9Name','Attribute9Value','Attribute10Name','Attribute10Value','Attribute11Name','Attribute11Value','Attribute12Name','Attribute12Value','Attribute13Name','Attribute13Value','Attribute14Name','Attribute14Value','Attribute15Name','Attribute15Value','Attribute16Name','Attribute16Value','Attribute17Name','Attribute17Value','Attribute18Name','Attribute18Value','Harmonized Code','Height','Length','Width','Ship Zone Name','Ship Carrier Code','Ship Class Code','Ship Rate First Item','Ship Handling First Item','Ship Rate Additional Item','Ship Handling Additional Item','(repeat)');
        $fp = fopen('ebayFeed.csv', 'w');
        fputcsv($fp, $head);
        if (($handle = fopen("temp.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $upc = $data[0];
                $manufacturer = explode(" ", $data[1]);
                $manufacturer = $manufacturer[0];
                $model = $data[1];
                $alterModel = $data[2];
                $colorCode = $data[3];
                $frame = $data[4];
                $lens = $data[5];
                $material = $data[6];
                $style = $data[7];
                $usage = $data[8];
                $size = $data[9];
                $description = $data[10];
                $polarized = $data[11];
                $rxable = $data[12];
                $gender = $data[13];
                $country = $data[14];
                $width = $data[15];
                $length = $data[16];
                $invNumber = $model . '-' . $colorCode . '-' . $width;
                $description == 'SUNGLASSES' // todo: need to check gender? (MENS)
                    ? $templateName = 'FP /FREE SHIP/***SUN***MENS/no upc'
                    : $templateName = 'FP /FREE SHIP/***RX/no upc';

                $content = array('Auction Title',$invNumber,'INSTOCK','Quantity','Starting Bid','','','',$upc,'','','','',$description,$manufacturer,'Brand','NEW','','Seller Cost','','Buy It Now Price','Retail Price','','Picture URLs','','','','','','','','','SHADESEXPO EBAY NEW DESIGN','','','','','Sears','','','','','','','',$description,'MODEL',$model,'COLOR CODE',$colorCode,'COLOR DESCRIPTION','Attribute3Value','SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH',$width,'RX_TEMPLE_LENGTH',$length,'GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND','NEED BRAND','CONDITION','NEW','','','','','','','','','','','','');
                fputcsv($fp, $content);
            }
        }
        fclose($fp);
        fclose($handle);
    }

    public static function stdGenerator()
    {

    }

    public static function checkCount()
    {
        if (file_exists('temp.csv')) {
            return count(file('temp.csv'));
        } else {
            return 0;
        }
    }

    public static function clearFeed()
    {
        if ($fp = fopen('temp.csv', 'w')) {
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }
}