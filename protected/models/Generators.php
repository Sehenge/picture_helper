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
            if ($key != 'pictures') {
                $data[$key] = strtoupper($value);
            }
        }
        isset($data['rx']) ? $data['rx'] = 'YES' : $data['rx'] = 'NO';
        isset($data['pictures']) ? $pictures = $data['pictures'] : $pictures = '';
        if (strpos($pictures, 'no one image were found!') !== false) {
            $pictures = '';
        }
        isset($data['polar']) ? $data['polar'] = 'POLARIZED' : $data['polar'] = '';

        $size_arr = explode('/', $data['size']);
        $width = $size_arr[0];
        if (isset($size_arr[2])) {
            $length = $size_arr[2];
        } else if (isset($size_arr[1])) {
            $length = $size_arr[1];
        } else {
            $length = ''; // todo: what to do????
        }
        if (substr($pictures,-1,1) == ',') {
            $pictures = substr($pictures,0,-1);
        }

        $line = array($data['upc'],$data['model'],implode('', explode(" ", $data['model'])),$data['colorCode'],
            $data['frame'],$data['lens'],$data['material'],$data['style'],$data['usage'],$data['size'],
            $data['description'],$data['polar'],$data['rx'],$data['gender'],$data['country'],$width,$length,
            $data['brand'], $data['color'], $data['quantity'], $data['sellerCost'], $data['startingBid'],
            $data['buyItNow'], $data['retail'], $pictures);
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
                $brand = $data[17];
                $color = $data[18];
                $quantity = $data[19];
                $sellerCost = $data[20];
                $startingBid = $data[21];
                $retail = $data[22];
                $buyitnow = $data[23];
                $pictures = $data[24];
                $invNumber = 'AZ' . $model . '-' . $colorCode . '-' . $width;
                $aucTitle = $brand . ' ' . $description . ' ' . $model . ' ' . $color . ' ' . $colorCode . ' ' . $alterModel;

                $content = array($aucTitle,$invNumber,'INSTOCK',$quantity,$startingBid,'','','',$upc,'','','','',$description,$manufacturer,$brand,'NEW','',$sellerCost,'',$buyitnow,$retail,'',$pictures,'','','','','','','','','','','','','','','','','','','','','',$description,'MODEL',$model,'COLOR CODE',$colorCode,'COLOR DESCRIPTION',$color,'SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH',$width,'RX_TEMPLE_LENGTH',$length,'GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND',$brand,'CONDITION','NEW','','','','','','','','','','','','');
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
                $brand = $data[17];
                $color = $data[18];
                $quantity = $data[19];
                $sellerCost = $data[20];
                $startingBid = $data[21];
                $retail = $data[22];
                $buyitnow = $data[23];
                $pictures = $data[24];
                $invNumber = 'UK' . $model . '-' . $colorCode . '-' . $width;
                $aucTitle = $brand . ' ' . $description . ' ' . $model . ' ' . $color . ' ' . $colorCode . ' ' . $alterModel;

                $content = array($aucTitle,$invNumber,'INSTOCK',$quantity,$startingBid,'','','',$upc,'','','','',$description,$manufacturer,$brand,'NEW','',$sellerCost,'',$buyitnow,$retail,'',$pictures,'','','','','','','','','','','','','','','','','','','','','',$description,'MODEL',$model,'COLOR CODE',$colorCode,'COLOR DESCRIPTION',$color,'SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH',$width,'RX_TEMPLE_LENGTH',$length,'GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND',$brand,'CONDITION','NEW','','','','','','','','','','','','');
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
                $brand = $data[17];
                $color = $data[18];
                $quantity = $data[19];
                $sellerCost = $data[20];
                $startingBid = $data[21];
                $retail = $data[22];
                $buyitnow = $data[23];
                $pictures = $data[24];
                $invNumber = 'FP' . $model . '-' . $colorCode . '-' . $width;
                $aucTitle = $brand . ' ' . $description . ' ' . $model . ' ' . $color . ' ' . $colorCode . ' ' . $alterModel;

                $content = array($aucTitle,$invNumber,'INSTOCK',$quantity,$startingBid,'','','',$upc,'','','','',$description,$manufacturer,$brand,'NEW','',$sellerCost,'',$buyitnow,$retail,'',$pictures,'','','','','','','','','','','','','','Sears','','','','','','','',$description,'MODEL',$model,'COLOR CODE',$colorCode,'COLOR DESCRIPTION',$color,'SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH',$width,'RX_TEMPLE_LENGTH',$length,'GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND',$brand,'CONDITION','NEW','','','','','','','','','','','','');
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
                $brand = $data[17];
                $color = $data[18];
                $quantity = $data[19];
                $sellerCost = $data[20];
                $startingBid = $data[21];
                $retail = $data[22];
                $buyitnow = $data[23];
                $pictures = $data[24];
                $invNumber = $model . '-' . $colorCode . '-' . $width;
                $aucTitle = $brand . ' ' . $description . ' ' . $model . ' ' . $color . ' ' . $colorCode . ' ' . $alterModel;
                $description == 'SUNGLASSES' // todo: need to check gender? (MENS)
                    ? $templateName = 'FP /FREE SHIP/***SUN***MENS/no upc'
                    : $templateName = 'FP /FREE SHIP/***RX/no upc';

                $content = array($aucTitle,$invNumber,'INSTOCK',$quantity,$startingBid,'','','',$upc,'','','','',$description,$manufacturer,$brand,'NEW','',$sellerCost,'',$buyitnow,$retail,'',$pictures,'','','','','','','','','SHADESEXPO EBAY NEW DESIGN',$templateName,'','',$description.'::'.$brand,'','','','','','','','',$description,'MODEL',$model,'COLOR CODE',$colorCode,'COLOR DESCRIPTION',$color,'SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH',$width,'RX_TEMPLE_LENGTH',$length,'GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND',$brand,'CONDITION','NEW','','','','','','','','','','','','');
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
            return count(file('temp.csv'));
        } else {
            return 'Error';
        }
    }

    /**
     * @param $model
     *
     * @return array
     */
    public static function getInfoByModel($model)
    {
        $result = array();
        $output = array();
        $connection = Yii::app()->db;

        $command = $connection->createCommand("SELECT * FROM quickbooks_products_info WHERE Desc1 LIKE '" . $model . "'");
        $dataReader = $command->query();
        $result = $dataReader->readAll();

        $pattern = "/([A-Z]+)([^A-Z0-9])([A-Z0-9]+)?(([^A-Z0-9])([A-Z0-9]+))?/";
        preg_match($pattern, $model, $matches);

        $brand = strtoupper(GetDir::getPath($matches[1]));
        foreach ($result as $key => $res) {
            $result[$key]['brand'] = $brand;
        }

        return $result;
    }

    /**
     * @param $model
     * @return mixed
     */
    public static function getInfoByUpc($upc)
    {
        $result = array();
        $output = array();
        $connection = Yii::app()->db;

        $command = $connection->createCommand("SELECT * FROM quickbooks_products_info WHERE UPC = '" . $upc . "'");
        $dataReader = $command->query();
        $result = $dataReader->readAll();

        $pattern = "/([A-Z]+)([^A-Z0-9])([A-Z0-9]+)?(([^A-Z0-9])([A-Z0-9]+))?/";
        preg_match($pattern, $result[0]['Desc1'], $matches);

        $brand = strtoupper(GetDir::getPath($matches[1]));
        foreach ($result as $key => $res) {
            $result[$key]['brand'] = $brand;
        }

        return $result;
    }

    public static function updateCont()
    {
        $obj = array();
        $i = 0;
        if (($handle = fopen("temp.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $obj[$i]['upc'] = $data[0];
                $obj[$i]['model'] = $data[1];
                    $manufacturer = explode(" ", $data[1]);
                $obj[$i]['manufacturer'] = $manufacturer[0];
                $obj[$i]['alterModel'] = $data[2];
                $obj[$i]['colorCode'] = $data[3];
                $obj[$i]['frame'] = $data[4];
                $obj[$i]['lens'] = $data[5];
                $obj[$i]['material'] = $data[6];
                $obj[$i]['style'] = $data[7];
                $obj[$i]['usage'] = $data[8];
                $obj[$i]['size'] = $data[9];
                $obj[$i]['description'] = $data[10];
                $obj[$i]['polarized'] = $data[11];
                $obj[$i]['rxable'] = $data[12];
                $obj[$i]['gender'] = $data[13];
                $obj[$i]['country'] = $data[14];
                $obj[$i]['width'] = $data[15];
                $obj[$i]['length'] = $data[16];
                $obj[$i]['brand'] = $data[17];
                $obj[$i]['color'] = $data[18];
                $obj[$i]['quantity'] = $data[19];
                $obj[$i]['sellerCost'] = $data[20];
                $obj[$i]['startingBid'] = $data[21];
                $obj[$i]['retail'] = $data[22];
                $obj[$i]['buyitnow'] = $data[23];
                $obj[$i]['pictures'] = $data[24];
                $i++;
            }
        }
        return $obj;
    }
}