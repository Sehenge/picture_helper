<?php

/**
 * Class GetDir
 */
class GetDir
{

    private static $_exception;

    private static $_brands;

    /**
     * @param $sku
     *
     * @return array All possible paths to images
     */
    public static function parseImages($sku, $sh)
	{
        $output = array(); $paths = array();
        $pattern = "/(AZ)?([A-Z]+)([^A-Z0-9])([A-Z0-9]+)([^A-Z0-9])([A-Z0-9]+)/";
        preg_match($pattern, $sku, $matches);
        if (substr($matches[4], -2) == 'LS') {
            $submodel = substr($matches[4], 0, -2);
        } else if (substr($matches[4], -1) == 'S') {
            $submodel = substr($matches[4], 0, -1);
        }
        //$sku = explode(' ', $sku); $sku = explode('-', implode("-", $sku));

        //$sku[0] = preg_replace("/(AZ)?/", "", $sku[0]);
        if (is_array(self::getPath($matches[2]))) {
            $brands = self::getPath($matches[2]);
        } else {
            $brands[] = self::getPath($matches[2]);
        }
        foreach ($brands as $brand) {
            $lc_brand = ucfirst(strtolower($brand));
            if ($sh == 'aff') {
                $paths[] = 'http://affordableluxurygroup.com/Large_Pictures/' . $brand;
                $paths[] = 'http://affordableluxurygroup.com/Pictures/' . $brand;
                $paths[] = 'http://affordableluxurygroup.com/Large_Pictures/' . $lc_brand;
                $paths[] = 'http://affordableluxurygroup.com/Pictures/' . $lc_brand;
            } else {
                $paths[] = 'http://shadesexpo.net/Ebay/Glasses_Large/' . $brand;
                $paths[] = 'http://shadesexpo.net/Ebay/Glasses/' . $brand;
                $paths[] = 'http://shadesexpo.net/Ebay/Glasses_Large/' . $lc_brand;
                $paths[] = 'http://shadesexpo.net/Ebay/Glasses/' . $lc_brand;
            }

            foreach ($paths as $path) {
                if ($string = @file_get_contents($path)) {
                    $doc = new DOMDocument();
                    $doc->strictErrorChecking = FALSE;
                    $doc->loadHTML($string);
                    $xml = simplexml_import_dom($doc);
                    $result = $xml->xpath("//a[contains(.,'jpg') or contains(.,'JPG')]");
                    if (isset($result)) {
                        if ($output) {
                            break;
                        }
                        foreach ($result as $element) {
                            $separated = explode('_', $element);
                            if((isset($separated[1]) && $matches[4] == $separated[1])
                                || ($matches[4] == $separated[0])
                                || ((isset($submodel) && $submodel == $separated[0]))
                                || ((isset($submodel) && isset($separated[1]) && $submodel == $separated[1]))) {
                                if ((isset($separated[2]) && ($matches[6] == $separated[2]) || ($matches[6] == $separated[1]))) {
                                    $output[] = $path . '/' . implode('_', $separated) . ",";
                                }
                            }
                        }
                    }
                }
            }
        }

        return $output;
	}

    /**
     * @param $sku
     *
     * @return array All possible cases
     */
    public static function parseCases($sku, $sh)
    {
        $output = array(); $paths = array();
        //$sku = explode(' ', $sku);
        //$sku[0] = preg_replace("/(AZ)?/", "", $sku[0]);

        $pattern = "/(AZ)?([A-Z]+)([^A-Z0-9])([A-Z0-9]+)([^A-Z0-9])([A-Z0-9]+)/";
        preg_match($pattern, $sku, $matches);

        if (is_array(self::getPath($matches[2]))) {
            $brands = self::getPath($matches[2]);
        } else {
            $brands[] = self::getPath($matches[2]);
        }


        foreach ($brands as $brand) {
            if ($sh == 'aff') {
                $paths[] = 'http://affordableluxurygroup.com/Large_Pictures/Cases/';
                $paths[] = 'http://affordableluxurygroup.com/Pictures/CASES/';
            } else {
                $paths[] = 'http://shadesexpo.net/Ebay/Glasses_Large/Cases/';
                $paths[] = 'http://shadesexpo.net/Ebay/Glasses/Cases/';
            }

            foreach ($paths as $path) {
                if($string = @file_get_contents($path)){ 
                    $doc = new DOMDocument();
                    $doc->strictErrorChecking = FALSE;
                    $doc->loadHTML($string);
                    $xml = simplexml_import_dom($doc);
                    $result = $xml->xpath("//a[contains(@href,'jpg') or contains(@href,'JPG')]/@href");
                    if (isset($result)) {
                        foreach ($result as $element) {
                            if (strpos(strtoupper($element), $brand) !== false) {
                                $output[] = $path . $element . ",";
                            }
                        }
                    }
                }
            }
        }

        return $output;
    }

    /**
     * @param $mcode
     *
     * @return array|string
     */
    public static function getPath($mcode)
    {
        switch ($mcode) {
            case 'AN': return 'ARNETTE';
            case 'CZ': return 'CAZAL';
            case 'BAL': return 'BALENCIAGA';
            case 'BE': return 'BURBERRY';
            case 'BVL': return 'BVLGARI';
            case 'ChAdv': return 'CHRISTIAN_AUDIGIER'; // todo: wtf2?
            case 'RC': return 'CAVALLI';
            case 'CN': return 'CHANEL';
            case 'CHROME HEARTS': return 'CHROME_HEARTS';
            case 'CE':
            case 'CL': return 'CHLOE';
            case 'DD':
            case 'DG': return array('DG', 'DOLCE&GABANA', 'DOLCE');
            case 'CD': return 'CHRISTIAN_DIOR';
            case 'CHRISTIAN DIOR': return 'CHRISTIAN_DIOR';
            case 'EHO':
            case 'EHR':
            case 'EHL':
            case 'EHS': return 'EDHARDY';
            case 'EP': return 'EMILIO_PUCCI';
            case 'SF':
            case 'FE': return 'FERRAGAMO';
            case 'FS': return 'FENDI';
            case 'F': return 'FENDI';
            case 'GG': return 'GUCCI';
            case 'JC':
            case 'JIMMY CHOO': return 'JIMMY_CHOO';
            case 'JU':
            case 'JUICY': return 'JUICY_COUTURE';
            case 'MB': return 'MONT_BLANC';
            case 'MJ':
            case 'MM': return array('MARC_JACOBS', 'MarcJacobs');
            case 'MKS':
            case 'MK':
            case 'MMK': return 'MICHAEL_KORS';
            case 'MO': return 'MOSCHINO';
            case 'OX':
            case 'OK': return 'OAKLEY';
            case 'OP': return 'OLIVER_PEOPLE';
            case 'PR':
            case 'SPR':
            case 'PS':
            case 'SPS':
            case 'VPS':
            case 'VPR': return 'PRADA';
            case 'CC':
            case 'HC':
            case 'COACH': return 'COACH';
            case 'RX':
            case 'RB': return 'RayBan';
            case 'TIF': return array('TIFFANY', 'TIFFANY_CO');
            case 'TF': return 'TOM_FORD';
            case 'TH': return array('TAG_HEUER','TAGHEUER');
            case 'VAL': return 'VALENTINO';
            case 'VE': return 'VERSACE';
            case 'VO': return 'VOGUE';
            case 'YSL': return 'YSL';
            case 'DQ': return array('D SQUARED','Dsquared2');
            case 'LV': return 'LANVIN';
            case 'PO': return 'PERSOL';
            case 'PU': return 'PUMA';
            case 'TR': return 'TRUE_RELIGION';
            case 'TO': return 'TODS';
            case 'JS': return 'JUST_CAVALLI';
            case 'CARRERA': return 'CARRERA';
            case 'CAR': return 'CARRERA';
            case 'TY': return 'TORY_BURCH';
            case 'AX':
            case 'EA':
            case 'AR':
            case 'GA': return 'ARMANI';
            case 'DF': return 'DVF';
            case 'AA': return 'ADIDAS';
            case 'NK': return 'NIKE';
            case 'AFFLICTION': return 'AFFLICTION';
            case 'BM': return 'BLUMARINE';
            case 'HR': return 'CHRISTIAN_ROTH';
            case 'NA': return 'NAUTICA';
            case 'RE': return 'REVO';
            case 'LA': return 'LACOSTE';
            case 'JG': return 'JOHN_GALLIANO';
            case 'MA': return 'MARCHON';
            case 'WX': return 'WILEY_X';
            case 'CK': return array('CK', 'CALVIN_KLEIN');
            case 'SK': return 'SWAROVSKI';
            case 'BB': return 'BEBE';
            case 'P': return 'PORSCHE_DESIGN';
            case 'SP': return 'SPY';
            case 'VZ': return 'VON_ZIPPER';
            case 'NW': return 'NINE_WEST';
            case 'CV': return 'CAVIAR';
            case 'VW':
            case 'VERA WANG': return 'VERA_WANG';
            case 'KS': return 'KATE_SPADE';
            case 'FR': return 'FRED_LUNETTES'; // todo: wtf?
            case 'CS': return 'COSTA_DEL_MAR';
            case 'AW': return 'ANDYWOLF';
            case 'DS':
            case 'DL': return 'DIESEL';
            case 'SR': return 'SONIA_RYKIEL';
            case 'MYKITA': return 'MYKITA';
            case 'RL': return 'RALPH_LAUREN';
            case 'AL':
            case 'ML':
            case 'MBM':
            case 'SBM': return 'ALAN_MIKLI';
            case 'PG': return 'PENGUIN';
            case 'DY': return 'DKNY';
            case 'CH':
            case 'SCH':
            case 'VCH': return 'CHOPARD';
            case 'AMQ': return 'MCQUEEN';
            case 'BV': return 'BOTTEGA_VENETA';
            case 'POL': return 'POLICE';
            case 'BL': return 'BALMAIN';
            case 'NR': return 'NINARICCI';
            case 'SMU':
            case 'VMU': return 'MIUMIU';
            default: return 'Manufacturer code was not found';
        }
    }

    public static function getBrand($mcode)
    {
        switch ($mcode) {
            case 'AN': return 'ARNETTE';
            case 'CZ': return 'CAZAL';
            case 'BAL': return 'BALENCIAGA';
            case 'BE': return 'BURBERRY';
            case 'BVL': return 'BVLGARI';
            case 'CA': return 'CHRISTIAN AUDIGIER'; // todo: wtf2?
            case 'RC': return 'CAVALLI';
            case 'CN': return 'CHANEL';
            case 'CHROME HEARTS': return 'CHROME_HEARTS';
            case 'CE':
            case 'CL': return 'CHLOE';
            case 'DD':
            case 'DG': return 'DOLCE&GABANA';
            case 'CD': return 'CHRISTIAN DIOR';
            case 'EHO':
            case 'EHR':
            case 'EHL':
            case 'EHS': return 'ED HARDY';
            case 'EP': return 'EMILIO PUCCI';
            case 'SF':
            case 'FE': return 'FERRAGAMO';
            case 'FS': return 'FENDI';
            case 'F': return 'FENDI';
            case 'GG': return 'GUCCI';
            case 'JC': return 'JIMMY CHOO';
            case 'JU': return 'JUICY COUTURE';
            case 'MB': return 'MONT BLANC';
            case 'MJ':
            case 'MM': return 'MARC JACOBS';
            case 'MKS':
            case 'MK':
            case 'MMK': return 'MICHAEL KORS';
            case 'MO': return 'MOSCHINO';
            case 'OX':
            case 'OK': return 'OAKLEY';
            case 'OP': return 'OLIVER PEOPLE';
            case 'PR':
            case 'SPR':
            case 'PS':
            case 'SPS':
            case 'VPS':
            case 'VPR': return 'PRADA';
            case 'CC':
            case 'HC':
            case 'COACH': return 'COACH';
            case 'RX':
            case 'RB': return 'RAY-BAN';
            case 'TIF': return 'TIFFANY';
            case 'TF': return 'TOM FORD';
            case 'THE': return 'TAG HEUER'; // todo: ????s
            case 'VAL': return 'VALENTINO';
            case 'VE': return 'VERSACE';
            case 'VO': return 'VOGUE';
            case 'YSL': return 'YSL';
            case 'DQ': return 'D SQUARED';
            case 'LV': return 'LANVIN';
            case 'PO': return 'PERSOL';
            case 'PU': return 'PUMA';
            case 'TR': return 'TRUE RELIGION';
            case 'TO': return 'TODS';
            case 'JS': return 'JUST CAVALLI';
            case 'CARRERA': return 'CARRERA';
            case 'CAR': return 'CARRERA';
            case 'TY': return 'TORY BURCH';
            case 'AX':
            case 'EA':
            case 'AR':
            case 'GA': return 'ARMANI';
            case 'DF': return 'DVF';
            case 'AA': return 'ADIDAS';
            case 'NK': return 'NIKE';
            case 'AFFLICTION': return 'AFFLICTION';
            case 'BM': return 'BLUMARINE';
            case 'HR': return 'CHRISTIAN ROTH';
            case 'NA': return 'NAUTICA';
            case 'RE': return 'REVO';
            case 'LA': return 'LACOSTE';
            case 'JG': return 'JOHN GALLIANO';
            case 'MA': return 'MARCHON';
            case 'WX': return 'WILEY X';
            case 'CK': return 'CALVIN KLEIN';
            case 'SK': return 'SWAROVSKI';
            case 'BB': return 'BEBE';
            case 'P': return 'PORSCHE DESIGN';
            case 'SP': return 'SPY';
            case 'VZ': return 'VON ZIPPER';
            case 'NW': return 'NINE WEST';
            case 'CV': return 'CAVIAR';
            case 'VW': return 'VERA WANG';
            case 'KS': return 'KATE SPADE';
            case 'FR': return 'FRED LUNETTES';
            case 'CS': return 'COSTA DEL MAR';
            case 'AW': return 'ANDY WOLF';
            case 'DS':
            case 'DL': return 'DIESEL';
            case 'SR': return 'SONIA RYKIEL';
            case 'MYKITA': return 'MYKITA';
            case 'RL': return 'RALPH LAUREN';
            case 'AL':
            case 'ML':
            case 'MBM':
            case 'SBM': return 'ALAN MIKLI';
            case 'PG': return 'PENGUIN';
            case 'DY': return 'DKNY';
            case 'CH':
            case 'SCH':
            case 'VCH': return 'CHOPARD';
            case 'AMQ': return 'MCQUEEN';
            case 'BV': return 'BOTTEGA VENETA';
            case 'POL': return 'POLICE';
            case 'BL': return 'BALMAIN';
            case 'NR': return 'NINA RICCI';
            case 'SMU':
            case 'VMU': return 'MIU MIU';
            default: return 'Manufacturer code was not found';
        }
    }

    /**
     * @return array
     */
    public static function getAllBrands()
    {
        self::$_brands = array('ARNETTE', 'BALENCIAGA', 'BURBERRY', 'BVLGARI', 'CHRISTIAN AUDIGIER', 'ROBERTO CAVALLI',
                                'CHANEL', 'CHROME HEARTS', 'CHLOE', 'CAZAL', 'D&G', 'DOLCE&GABBANA', 'CHRISTIAN DIOR',
                                'EMPORIO ARMANI', 'ED HARDY', 'EMILIO PUCCI', 'FERRAGAMO', 'FENDI', 'GIORGIO ARMANI',
                                'GUCCI', 'JIMMY CHOO', 'JUICY COUTURE', 'MONT BLANC', 'MARC JACOBS', 'MICHAEL KORS',
                                'MARC BY MARC JACOBS', 'MOSCHINO', 'OAKLEY', 'OLIVER PEOPLES', 'CYNTHIA ROWLEY',
                                'PRADA', 'PRADA SPORT', 'COACH', 'RAY-BAN', 'TIFFANY', 'TOM FORD', 'TAG HEUER',
                                'VALENTINO', 'VERSACE', 'VOGUE', 'YSL', 'DSQUARED', 'LANVIN', 'PERSOL', 'PUMA',
                                'TRUE RELIGION', 'TODS', 'JUST CAVALLI', 'CARRERA', 'TORY BURCH', 'ARMANI EXCHANGE',
                                'DIANE VON FURSTENBERG', 'COACH', 'MICHAEL KORS', 'MICHAEL MICHAEL KORS', 'ADIDAS',
                                'NIKE', 'AFFLICTION', 'BLUMARINE', 'CHRISTIAN ROTH', 'NAUTICA', 'REVO', 'ARNETTE',
                                'LACOSTE', 'JOHN GALLIANO', 'MARCHON', 'WILEY X', 'CALVIN KLEIN', 'SWAROVSKI',
                                'BEBE', 'PORSCHE DESIGN', 'SPY', 'VON ZIPPER', 'NINE WEST', 'CAVIAR', 'VERA WANG',
                                'KATE SPADE', 'FRED LUNETTES', 'COSTA DEL MAR', 'ANDY WOLF', 'DIESEL', 'SONIA RYKIEL',
                                'MYKITA', 'RALPH LAUREN', 'ALAIN MIKLI', 'MIKLI BY MIKLI', 'SUBCREW BY MIKLI',
                                'PENGUIN', 'DKNY', 'CHOPARD', 'MCQUEEN', 'BOTTEGA VENETA', 'POLICE', 'BALMAIN', 'NINA RICCI',
                                'MIU MIU');
        return self::$_brands;
    }

    /**
     * @param $nameu
     * @return string
     */
    public static function getManCode($nameu)
    {
        if( strcmp($nameu, 'ARNETTE') == 0) return 'AN';
        if( strcmp($nameu, 'BALENCIAGA') == 0) return 'BA';
        if( strcmp($nameu, 'BURBERRY') == 0) return 'BE';
        if( strcmp($nameu, 'BVLGARI') == 0) return 'BVL';
        if( strcmp($nameu, 'CHRISTIAN AUDIGIER') == 0) return 'CA';
        if( strcmp($nameu, 'ROBERTO CAVALLI') == 0 ) return 'RC';
        if( strcmp($nameu, 'ROBERTO CAVALLI') == 0 ) return 'RC';
        if( strcmp($nameu, 'CHANEL') == 0 ) return 'CN';
        if( strcmp($nameu, 'CHROME HEARTS') == 0) return 'CH';
        if( strcmp($nameu, 'CHLOE') == 0 ) return 'CL';
        if( strcmp($nameu, 'CAZAL') == 0 ) return 'CZ';
        if( strcmp($nameu, 'D&G') == 0) return 'DD';
        if( strcmp($nameu, 'DOLCE&GABBANA') == 0) return 'DG';
        if( strcmp($nameu, 'CHRISTIAN DIOR') == 0) return 'CD';
        if( strcmp($nameu, 'EMPORIO ARMANI') == 0) return 'EA';
        if( strcmp($nameu, 'ED HARDY') == 0) return 'EH';
        if( strcmp($nameu, 'EMILIO PUCCI') == 0) return 'EP';
        if( strcmp($nameu, 'FERRAGAMO') == 0 ) return 'FE';
        if( strcmp($nameu, 'FENDI') == 0) return 'FS';
        if( strcmp($nameu, 'GIORGIO ARMANI') == 0 ) return 'GA';
        if( strcmp($nameu, 'GUCCI') == 0 ) return 'GG';
        if( strcmp($nameu, 'JIMMY CHOO') == 0 ) return 'JC';
        if( strcmp($nameu, 'JUICY COUTURE') == 0) return 'JU';
        if( strcmp($nameu, 'MONT BLANC') == 0) return 'MB';
        if( strcmp($nameu, 'MARC JACOBS') == 0 ) return 'MJ';
        if( strcmp($nameu, 'MICHAEL KORS') == 0 ) return 'MK';
        if( strcmp($nameu, 'MARC BY MARC JACOBS') == 0 ) return 'MM';
        if( strcmp($nameu, 'MOSCHINO') == 0) return 'MO';
        if( strcmp($nameu, 'OAKLEY') == 0 ) return 'OK';
        if( strcmp($nameu, 'OLIVER PEOPLES') == 0) return 'OP';
        if( strcmp($nameu, 'CYNTHIA ROWLEY') == 0) return 'CY';
        if( strcmp($nameu, 'PRADA') == 0) return  'PR';
        if( strcmp($nameu, 'PRADA SPORT') == 0) return 'PS';
        if( strcmp($nameu, 'COACH') == 0) return 'CO';
        if( strcmp($nameu, 'RAY-BAN') == 0 ) return 'RB';
        if( strcmp($nameu, 'TIFFANY') == 0 ) return 'TIF';
        if( strcmp($nameu, 'TOM FORD') == 0) return 'TF';
        if( strcmp($nameu, 'TAG HEUER') == 0 ) return 'TH';
        if( strcmp($nameu, 'VALENTINO') == 0 ) return 'VA';
        if( strcmp($nameu, 'VERSACE') == 0 ) return 'VE';
        if( strcmp($nameu, 'VOGUE') == 0 ) return 'VO';
        if( strcmp($nameu, 'YSL') == 0) return 'YS';
        if( strcmp($nameu, 'DSQUARED') == 0) return 'DQ';
        if( strcmp($nameu, 'LANVIN') == 0) return 'LV';
        if( strcmp($nameu, 'PERSOL') == 0) return 'PO';
        if( strcmp($nameu, 'PUMA') == 0) return 'PU';
        if( strcmp($nameu, 'TRUE RELIGION') == 0) return 'TR';
        if( strcmp($nameu, 'TODS') == 0) return 'TO';
        if( strcmp($nameu, 'JUST CAVALLI') == 0) return 'JS';
        if( strcmp($nameu, 'CARRERA') == 0) return 'CAR';
        if( strcmp($nameu, 'TORY BURCH') == 0) return 'TB';
        if( strcmp($nameu, 'ARMANI EXCHANGE') == 0) return 'AX';
        if( strcmp($nameu, 'DIANE VON FURSTENBERG') == 0) return 'DF';
        if( strcmp($nameu, 'MICHAEL KORS') == 0) return 'MK';
        if( strcmp($nameu, 'MICHAEL MICHAEL KORS') == 0) return 'MMK';
        if( strcmp($nameu, 'ADIDAS') == 0) return 'A';
        if( strcmp($nameu, 'NIKE') == 0) return 'NK';
        if( strcmp($nameu, 'AFFLICTION') == 0) return 'AF';
        if( strcmp($nameu, 'BLUMARINE') == 0) return 'BM';
        if( strcmp($nameu, 'CHRISTIAN ROTH') == 0) return 'HR';
        if( strcmp($nameu, 'NAUTICA') == 0) return 'NA';
        if( strcmp($nameu, 'REVO') == 0) return 'RE';
        if( strcmp($nameu, 'ARNETTE')== 0) return 'AN';
        if( strcmp($nameu, 'LACOSTE') == 0) return 'LA';
        if( strcmp($nameu, 'JOHN GALLIANO') == 0) return 'JG';
        if( strcmp($nameu, 'MARCHON') == 0) return 'MA';
        if( strcmp($nameu, 'WILEY X') == 0) return 'WX';
        if( strcmp($nameu, 'CALVIN KLEIN') == 0) return 'CK';
        if( strcmp($nameu, 'SWAROVSKI') == 0) return 'SK';
        if( strcmp($nameu, 'BEBE') == 0) return 'BB';
        if( strcmp($nameu, 'PORSCHE DESIGN') == 0) return 'PD';
        if( strcmp($nameu, 'SPY') == 0) return 'SP';
        if( strcmp($nameu, 'VON ZIPPER') == 0) return 'VZ';
        if( strcmp($nameu, 'NINE WEST') == 0) return 'NW';
        if( strcmp($nameu, 'CAVIAR') == 0) return 'CV';
        if( strcmp($nameu, 'VERA WANG') == 0) return 'VW';
        if( strcmp($nameu, 'KATE SPADE') == 0) return 'KS';
        if( strcmp($nameu, 'FRED LUNETTES') == 0) return 'FR';
        if( strcmp($nameu, 'COSTA DEL MAR') == 0) return 'CS';
        if( strcmp($nameu, 'ANDY WOLF') == 0) return 'AW';
        if( strcmp($nameu, 'DIESEL') == 0) return 'DL';
        if( strcmp($nameu, 'SONIA RYKIEL') == 0) return 'SR';
        if( strcmp($nameu, 'MYKITA') == 0) return 'MY';
        if( strcmp($nameu, 'RALPH LAUREN') == 0) return 'RL';
        if( strcmp($nameu, 'ALAIN MIKLI') == 0) return 'AL';
        if( strcmp($nameu, 'MIKLI BY MIKLI') == 0) return 'MBM';
        if( strcmp($nameu, 'SUBCREW BY MIKLI') == 0) return 'SBM';
        if( strcmp($nameu, 'PENGUIN') == 0) return 'PG';
        if( strcmp($nameu, 'DKNY') == 0) return 'DY';
        if( strcmp($nameu, 'CHOPARD') == 0) return  'VCH';
        if( strcmp($nameu, 'MCQUEEN') == 0) return  'AMQ';
        if( strcmp($nameu, 'BOTTEGA VENETA') == 0) return  'BV';
        if( strcmp($nameu, 'POLICE') == 0) return  'POL';
        if( strcmp($nameu, 'BALMAIN') == 0) return  'BL';
        if( strcmp($nameu, 'NINA RICCI') == 0) return  'NR';
        if( strcmp($nameu, 'MIU MIU') == 0) return  'VMU';
    }

    /********************************************************************************
    Функция img_resize(): генерация thumbnails
    Параметры:
    $src             - имя исходного файла
    $dest            - имя генерируемого файла
    $width, $height  - ширина и высота генерируемого изображения, в пикселях
    Необязательные параметры:
    $rgb             - цвет фона, по умолчанию - белый
    $quality         - качество генерируемого JPEG, по умолчанию - максимальное (100)
    ********************************************************************************/
    function resizeImage($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=100)
    {
        $size = getimagesize($src);

        if ($size === false) return false;

        $x_ratio = $width / $size[0];
        $y_ratio = $height / $size[1];

        $ratio       = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);

        $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
        $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
        $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

        $isrc = imagecreatefromjpeg($src);

        $idest = imagecreatetruecolor($width, $height);


        imagefill($idest, 0, 0, $rgb);
        imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0,
            $new_width, $new_height, $size[0], $size[1]);


        $dest_dir = preg_split("/\//", $dest);

        if (!is_dir('/home/union-progress.com/public_html/feedhelper/picture_helper/temp/' . $dest_dir[7] . '/' . $dest_dir[8])) {
            if (!is_dir('/home/union-progress.com/public_html/feedhelper/picture_helper/temp/' . $dest_dir[7])) {
                mkdir('/home/union-progress.com/public_html/feedhelper/picture_helper/temp/' . $dest_dir[7], 0777);
            }
            mkdir('/home/union-progress.com/public_html/feedhelper/picture_helper/temp/' . $dest_dir[7] . '/' . $dest_dir[8], 0777);
        }
        imagejpeg($idest, $dest, $quality);

        imagedestroy($isrc);
        imagedestroy($idest);

        return $dest . ",\n";
    }

    /**
     * @param $situation
     *
     * @return string
     */
    public static function printException($situation)
    {
        switch ($situation) {
            case 'cases not found':
            case 'images not found': self::$_exception = "<exception>We are apologise, but no one image were found! You can:\n".
            "1. Check your input information and try again\n".
            "2. Try to find images manually\n".
            "3. If image exists but program can't find it - Please contact support!\n</exception>";
        }
        return self::$_exception;
    }
}