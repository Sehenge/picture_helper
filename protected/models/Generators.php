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
            ucwords(strtolower($data['description'])),$data['polar'],$data['rx'],$data['gender'],$data['country'],$width,$length,
            ucwords(strtolower($data['brand'])), $data['color'], $data['quantity'], preg_replace("/\./",",",$data['sellerCost']), $data['startingBid'],
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
                $aucTitle = $brand . ' ' . $description . ' ' . preg_replace("/_/", " ", $model) . ' ' . $color . ' ' . $colorCode . ' ' . $alterModel;

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
                $width = $data[15] . 'MM';
                $length = $data[16] . 'MM';
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

                if ( $description == 'Eyeglasses' ) {
                    $ebaycat = '31415';
                    $templateName = 'FP /FREE SHIP/***RX/no upc';
                } else if ( $description == 'Sunglasses' ) {
                    if ( $gender == 'MEN') {
                        $ebaycat = '79720';
                        $templateName = 'FP /FREE SHIP/***SUN***MENS/no upc';
                    } else if ( $gender == 'WOMEN') {
                        $ebaycat = '45246';
                        $templateName = 'FP /FREE SHIP/***SUN***WMNS/no upc';
                    }
                }

                $content = array($aucTitle,$invNumber,'INSTOCK',$quantity,$startingBid,'','','',$upc,'','','','',$description,$manufacturer,$brand,'NEW','',$sellerCost,'',$buyitnow,$retail,'',$pictures,'','','','','','','','','SHADESEXPO EBAY NEW DESIGN',$templateName,'',$ebaycat,$description.'::'.$brand,'','','','','','','','',$description,'MODEL',$model,'COLOR CODE',$colorCode,'COLOR DESCRIPTION',$color,'SIZE',$size,'STYLE',$style,'USAGE',$usage,'PROTECTION',$polarized,'RXABLE',$rxable,'RX_LENS_WIDTH',$width,'RX_TEMPLE_LENGTH',$length,'GENDER',$gender,'COUNTRY OF ORIGIN',$country,'FRAME MATERIAL',$material,'FRAME COLOR',$frame,'LENS COLOR',$lens,'ALTERNATE MODEl4',$alterModel,'BRAND',$brand,'CONDITION','NEW','','','','','','','','','','','','');
                fputcsv($fp, $content);
            }
        }
        fclose($fp);
        fclose($handle);
    }

    public static function regGenerator()
    {
        $fp = fopen('regFeed.csv', 'w');
        if (($handle = fopen("temp.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $upc = $data[0];
                $model = $data[1];
                $manufacturer = explode(" ", $data[1]);
                $manufacturer = $manufacturer[0];
                $colorCode = $data[3];
                $frame = $data[4];
                $lens = $data[5];
                switch($data[6]) {
                    case 'METAL': $material = 1; break;
                    case 'PLASTIC': $material = 2; break;
                    case 'MIX': $material = 3; break;
                    default: $material = 1;
                }
                switch($data[7]) {
                    case 'AVIATOR': $style = 1; break;
                    case 'BUTTERFLY': $style = 2; break;
                    case 'CAT EYE': $style = 3; break;
                    case 'GOGGLE': $style = 4; break;
                    case 'OVAL': $style = 5; break;
                    case 'RECTANGULAR': $style = 6; break;
                    case 'RIMLESS': $style = 7; break;
                    case 'ROUND': $style = 8; break;
                    case 'SEMI-RIMLESS': $style = 9; break;
                    case 'SHIELD': $style = 10; break;
                    case 'SQUARE': $style = 11; break;
                    case 'WAYFARER': $style = 12; break;
                    case 'WRAP': $style = 13; break;
                    case 'HEART': $style = 14; break;
                    default: $style = 1;
                }
                switch($data[8]) {
                    case 'FASHION': $usage = 1; break;
                    case 'SPORTS': $usage = 2; break;
                    case 'WATERSPORTS': $usage = 3; break;
                    case 'SNOWSPORTS': $usage = 4; break;
                    case 'GOLF': $usage = 5; break;
                    default: $usage = 1;
                }
                $size = $data[9];
                $description = $data[10];
                $polarized = $data[11];
                $polarized == 'POLARIZED' ? $polarized = 1 : $polarized = 0;
                $rxable = $data[12];
                $rxable == 'NO' ? $rxable = 0 : $rxable = 1;
                switch($data[13]) {
                    case 'UNISEX': $gender = 1; break;
                    case 'MEN': $gender = 2; break;
                    case 'WOMEN': $gender = 3; break;
                    default: $gender = 1;
                }
                $country = $data[14];
                $width = $data[15];
                $length = $data[16];
                $brand = $data[17];
                $color = $data[18];
                $sellerCost = $data[20];
                $startingBid = $data[21];
                $retail = $data[22];
                $buyitnow = $data[23];
                $pictures = explode(",", $data[24]);
                $pics = '';
                for ($i = 1; $i < 4; $i++) {
                    $pics .= 'ITEMIMAGEURL' . $i . '=' . $pictures[$i] . ',';
                }
                $content = array(1,'','','','','',1,'','','','','','','','','price',$retail,'',$pics,'','','','','','','','','','','','','','','','','','',$description,'','','','','','','','','','','','','','','','','','','','','','','','','',$brand,$upc,'','','','','','',$colorCode,'',$frame,'','','',$country,'',$color,$gender,'','','',$lens,'',$manufacturer,'',$model,'',$size,'',$style,'',$usage,'',$polarized,'',$rxable,'',$width,'',$length,'','','',$material);
                fputcsv($fp, $content);
            }
        }
        fclose($fp);
        fclose($handle);
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
        $command = $connection->createCommand("SELECT * FROM quickbooks_products_info WHERE UPC LIKE '%" . $upc . "%'");
        $dataReader = $command->query();
        $result = $dataReader->readAll();

        $command = $connection->createCommand("SELECT * FROM quickbooks_products_info WHERE
            Attribute = '" . $result[0]['Attribute'] . "' AND
            Desc1 REGEXP '" . $result[0]['Desc1'] . "' AND
            Size = '" . $result[0]['Size'] . "'");
        $dataReader = $command->query();
        $result = $dataReader->readAll();
        $flag = false;

        foreach ($result as $row) {
            if (!preg_match("/CO$|FBA$|VW$|SPO$/", $row['Desc1'])) {
                $flag = true;
                if ($row['QuantityOnHand'] == 0) {
                    foreach ($result as $rowCo) {
                        if (preg_match("/CO$/", $rowCo['Desc1'])) {
                            if ($rowCo['QuantityOnHand'] != 0) {
                                $quantity = $rowCo['QuantityOnHand'];
                            } else {
                                $quantity = 0;
                                foreach ($result as $rowVw) {
                                    if (preg_match("/VW$|SPO$/", $row['Desc1'])) {
                                        $quantity += $rowVw['QuantityOnHand'];
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $quantity = $row['QuantityOnHand'];
                }
            } else if ($flag == false) {
                foreach ($result as $rowCo) {
                    if (preg_match("/CO$/", $rowCo['Desc1'])) {
                        $quantity = $rowCo['QuantityOnHand'];
                    }
                }
            }
        }

        $pattern = "/([A-Z]+)([^A-Z0-9])([A-Z0-9]+)?(([^A-Z0-9])([A-Z0-9]+))?/";
        preg_match($pattern, $result[0]['Desc1'], $matches);

        $brand = strtoupper(GetDir::getBrand($matches[1]));
        foreach ($result as $key => $res) {
            $result[$key]['brand'] = $brand;
            $result[$key]['QuantityOnHand'] = $quantity;
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

    public static function deleteModel($rel)
    {
        $i = 0;
        $obj = array();
        if (($handle = fopen("temp.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($i != $rel) {
                    $obj[] = $data;
                }
                $i++;
            }
        }

        $fp = fopen('temp.csv', 'w');
        foreach ($obj as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }
}