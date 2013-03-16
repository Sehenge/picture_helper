<?php

class GetDir
{
    public $string;

    public static $xml;

	public static function parse($string, $asin)
	{
        $output = array();
        $doc = new DOMDocument();
        $doc->strictErrorChecking = FALSE;
        $doc->loadHTML($string);
        $xml = simplexml_import_dom($doc);
        $result = $xml->xpath("//a[contains(.,'jpg')]");
        $asin = explode('_', $asin);
        foreach ($result as $element) {
            $separated = explode('_', $element);
            if((isset($separated[1])) && ($asin[1] == $separated[1])) {
                if ((isset($separated[2])) && ($asin[2] == $separated[2])) {
                    $output[] = implode('_', $separated);
                }
            }
        }

        return $output;
        //self::$xml = $result;

        //return self::$xml;
	}

    public static function getPath($mcode) {
        if( strcmp($nameu, 'ARNETTE') == 0) return 'AN';
        if( strcmp($nameu, 'BALENCIAGA') == 0) return 'BA';
        if( strcmp($nameu, 'BURBERRY') == 0) return 'BE';
        if( strcmp($nameu, 'BVLGARI') == 0) return 'BV';
        if( strcmp($nameu, 'CHRISTIAN AUDIGIER') == 0) return 'CA';
        if( strcmp($nameu, 'ROBERTO CAVALLI') == 0 ) return 'RC';
        if( strcmp($nameu, 'ROBERTO CAVALLI') == 0 ) return 'RC';
        if( strcmp($nameu, 'CHANEL') == 0 ) return 'CN';
        if( strcmp($nameu, 'CHROME HEARTS') == 0) return 'CH';
        if( strcmp($nameu, 'CHLOE') == 0 ) return 'CL';
        if( strcmp($nameu, 'CAZAL') == 0 ) return 'CZ';
        if( strcmp($nameu, 'D&G') == 0 && strcmp($code, 'DD') == 0) return 'DD';
        if( strcmp($nameu, 'DOLCE&GABBANA') == 0 && strcmp($code, 'DG') == 0) return 'DG';

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

        if( strcmp($nameu, 'PRADA') == 0 && strcmp($code, 'PR') == 0) return  'PR';
        if( strcmp($nameu, 'PRADA') == 0 && strcmp($code, 'PR') == 0) return  'PR';
        if( strcmp($nameu, 'PRADA') == 0 && strcmp($code, 'SPR') == 0) return 'PR';
        if( strcmp($nameu, 'PRADA') == 0 && strcmp($code, 'VPR') == 0) return 'PR';

        if( strcmp($nameu, 'PRADA SPORT') == 0 && strcmp($code, 'PS') == 0) return 'PS';
        if( strcmp($nameu, 'PRADA SPORT') == 0 && strcmp($code, 'VPS') == 0) return 'PS';
        if( strcmp($nameu, 'PRADA') == 0 && strncmp($model_extra, 'SPS', 3) == 0) return 'PS';
        if( strcmp($nameu, 'PRADA SPORT') == 0 && strcmp($code, 'SPS') == 0) return 'PS';


        if( strcmp($nameu, 'COACH') == 0 && strcmp($code, 'CO') == 0) return 'CO';
        if( strcmp($nameu, 'COACH') == 0 && strcmp($code, 'HC') == 0) return 'CO';

        if( strcmp($nameu, 'RAY-BAN') == 0 ) return 'RB';

        if( strcmp($nameu, 'TIFFANY') == 0 ) return 'TC';
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
        if( strcmp($nameu, 'CARRERA') == 0) return 'CR';
        if( strcmp($nameu, 'TORY BURCH') == 0) return 'TB';
        if( strcmp($nameu, 'ARMANI EXCHANGE') == 0) return 'AX';
        if( strcmp($nameu, 'DIANE VON FURSTENBERG') == 0) return 'DF';
//              if( strcmp($nameu, 'COACH') == 0) return 'CO';
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
        if( strcmp($nameu, 'CHOPARD') == 0 && strcmp($code, 'SCH') == 0) return  'VCH';
        if( strcmp($nameu, 'CHOPARD') == 0 && strcmp($code, 'VCH') == 0) return  'VCH';
    }
}