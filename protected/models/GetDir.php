<?php

/**
 * Class GetDir
 */
class GetDir
{

    private static $_exception;

    private static $_brands;

    /**
     * @param $asin
     *
     * @return array All possible paths to images
     */
    public static function parseImages($asin)
	{
        $output = array();
        $asin = explode('_', $asin);
        $brand = self::getPath($asin[0]);
        $string = file_get_contents('http://affordableluxurygroup.com/Pictures/' . $brand);
        $doc = new DOMDocument();
        $doc->strictErrorChecking = FALSE;
        $doc->loadHTML($string);
        $xml = simplexml_import_dom($doc);
        $result = $xml->xpath("//a[contains(.,'jpg')]");

        foreach ($result as $element) {
            $separated = explode('_', $element);
            if((isset($separated[1])) && (($asin[1] == $separated[1]) || ($asin[1] == $separated[0]))) {
                if ((isset($separated[2])) && (($asin[2] == $separated[2]) || ($asin[2] == $separated[1]))) {
                    $output[] = 'http://affordableluxurygroup.com/Pictures/' . $brand . '/' . implode('_', $separated) . ", \n";
                }
            }
        }

        return $output;
	}

    /**
     * @param $asin
     *
     * @return array All possible cases
     */
    public static function parseCases($asin)
    {
        $output = array();
        $asin = explode('_', $asin);
        $brand = self::getPath($asin[0]);
        $string = file_get_contents('http://affordableluxurygroup.com/Pictures/CASES/');
        $doc = new DOMDocument();
        $doc->strictErrorChecking = FALSE;
        $doc->loadHTML($string);
        $xml = simplexml_import_dom($doc);
        $result = $xml->xpath("//a[contains(@href,'jpg')]/@href");
        foreach ($result as $element) {
            if (strpos(strtoupper($element), $brand) !== false) {
                $output[] = 'http://affordableluxurygroup.com/Pictures/CASES/' . $element . ", \n";
            }
        }

        return $output;
    }

    /**
     * @param $mcode
     *
     * @return string Path to manufacturer folder on server
     */
    public static function getPath($mcode) {
        switch ($mcode) {
            case 'AN': return 'ARNETTE';
            case 'CZ': return 'CAZAL';
            case 'BA': return 'BALENCIAGA';
            case 'BE': return 'BURBERRY';
            case 'BV': return 'BVLGARI';
            case 'CA': return 'CHRISTIAN_AUDIGIER';
            case 'RC': return 'ROBERTO CAVALLI';
            case 'CN': return 'CHANEL';
            case 'CH': return 'CHROME_HEARTS';
            case 'CL': return 'CHLOE';
            case 'DD':
            case 'DG': return 'DG';
            case 'CD': return 'CHRISTIAN_DIOR';
            case 'EH': return 'ED_HARDY';
            case 'EP': return 'EMILIO_PUCCI';
            case 'FE': return 'FERRAGAMO';
            case 'FS': return 'FENDI';
            case 'GA': return 'GIORGIO_ARMANI';
            case 'GG': return 'GUCCI';
            case 'JC': return 'JIMMY_CHOO';
            case 'JU': return 'JUICY_COUTURE';
            case 'MB': return 'MONT_BLANC';
            case 'MJ':
            case 'MM': return 'MARC_JACOBS';
            case 'MK':
            case 'MMK': return 'MICHAEL_KORS';
            case 'MO': return 'MOSCHINO';
            case 'OK': return 'OAKLEY';
            case 'OP': return 'OLIVER_PEOPLES';
            case 'PR':
            case 'SPR':
            case 'PS':
            case 'SPS':
            case 'VPS':
            case 'VPR': return 'PRADA';
            case 'CO': return 'COACH';
            case 'RB': return 'RAY_BAN';
            case 'TC': return 'TIFFANY';
            case 'TF': return 'TOM_FORD';
            case 'TH': return 'TAG_HEUER';
            case 'VA': return 'VALENTINO';
            case 'VE': return 'VERSACE';
            case 'VO': return 'VOGUE';
            case 'YS': return 'YSL';
            case 'DQ': return 'DSQUARED';
            case 'LV': return 'LANVIN';
            case 'PO': return 'PERSOL';
            case 'PU': return 'PUMA';
            case 'TR': return 'TRUE_RELIGION';
            case 'TO': return 'TODS';
            case 'JS': return 'JUST_CAVALLI';
            case 'CR': return 'CARRERA';
            case 'TB': return 'TORY_BURCH';
            case 'AX':
            case 'EA': return 'ARMANI';
            case 'DF': return 'DIANE_VON_FURSTENBERG';
            case 'A': return 'ADIDAS';
            case 'NK': return 'NIKE';
            case 'AF': return 'AFFLICTION';
            case 'BM': return 'BLUMARINE';
            case 'HR': return 'CHRISTIAN_ROTH';
            case 'NA': return 'NAUTICA';
            case 'RE': return 'REVO';
            case 'AN': return 'ARNETTE';
            case 'LA': return 'LACOSTE';
            case 'JG': return 'JOHN_GALLIANO';
            case 'MA': return 'MARCHON';
            case 'WX': return 'WILEY_X';
            case 'CK': return 'CALVIN_KLEIN';
            case 'SK': return 'SWAROVSKI';
            case 'BB': return 'BEBE';
            case 'PD': return 'PORSCHE_DESIGN';
            case 'SP': return 'SPY';
            case 'VZ': return 'VON_ZIPPER';
            case 'NW': return 'NINE_WEST';
            case 'CV': return 'CAVIAR';
            case 'VW': return 'VERA_WANG';
            case 'KS': return 'KATE_SPADE';
            case 'FR': return 'FRED_LUNETTES';
            case 'CS': return 'COSTA_DEL_MAR';
            case 'AW': return 'ANDY_WOLF';
            case 'DL': return 'DIESEL';
            case 'SR': return 'SONIA_RYKIEL';
            case 'MY': return 'MYKITA';
            case 'RL': return 'RALPH_LAUREN';
            case 'AL':
            case 'MBM':
            case 'SBM': return 'ALAIN_MIKLI';
            case 'PG': return 'PENGUIN';
            case 'DY': return 'DKNY';
            case 'SCH':
            case 'VCH': return 'CHOPARD';
            default: return 'Manufacturer code was not found';
        }
    }

    /**
     * @return array
     */
    public static function getAllBrands() {
        self::$_brands = array('ARNETTE', 'BALENCIAGA', 'BURBERRY', 'BVLGARI', 'CHRISTIAN AUDIGIER', 'ROBERTO CAVALLI',
                                 'CHANEL', 'CHROME HEARTS', 'CHLOE', 'CAZAL', 'D&G', 'DOLCE&GABBANA');
        return self::$_brands;
    }

    /**
     * @param $situation
     *
     * @return string
     */
    public static function printException($situation) {
        switch ($situation) {
            case 'cases not found':
            case 'images not found': self::$_exception = "We are apologise, but no one image were found! You can:\n".
            "1. Check your input information and try again\n".
            "2. Try to find images manually\n".
            "3. If image exists but program cann't find it - Please contact support!\n";
        }
        return self::$_exception;
    }
}