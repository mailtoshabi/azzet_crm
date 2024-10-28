<?php

namespace App\Http\Utilities;

use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Utility{

    //Constants

    const SUPER_ADMIN_ID = 1;
    const ROLE_ADMIN = 1;

    const FROM_MAIL = 'shabeer@gmail.com';

    const COUNTRY_CODE = '+91';
    const COUNTRY = 'IN';
    const CURRENCY_DISPLAY = 'INR';
    const CURRENCY_WORD_DISPLAY = 'Rupees';
    const STATE_ID_KERALA = 12;

    const PAGINATE_COUNT = 15;

    const PAYMENT_ONLINE = 1;
    const PAYMENT_COD = 2;

    const ITEM_ACTIVE = 1;
    const ITEM_INACTIVE = 0;

    const STATUS_NEW = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_PRODUCTION = 2;
    const STATUS_OUT = 3;
    const STATUS_DELIVERED = 4;
    const STATUS_CLOSED = 5;
    const STATUS_ONHOLD = 6;
    const STATUS_CANCELLED = 7;

    public static function otp()
    {
        $otp = md5( rand(0,1000) );
        /*$otp = rand(100000, 999999);*/
        return $otp;
    }

    protected  static $saleStatus = [
        self::STATUS_NEW => ['name'=>'New', 'date_field'=>'created_at'],
        self::STATUS_CONFIRMED => ['name'=>'confirmed', 'date_field'=>'date_confirmed'],
        self::STATUS_PRODUCTION => ['name'=>'On Production', 'date_field'=>'date_production'],
        self::STATUS_OUT => ['name'=>'Out for Delivery', 'date_field'=>'date_out_delivery'],
        self::STATUS_DELIVERED => ['name'=>'Delivered', 'date_field'=>'date_delivered'],
        self::STATUS_CLOSED => ['name'=>'Closed', 'date_field'=>'date_closed'],
        self::STATUS_ONHOLD => ['name'=>'On Hold', 'date_field'=>'date_onhold'],
        self::STATUS_CANCELLED => ['name'=>'Cancelled', 'date_field'=>'date_cancelled'],
    ];
    public static function saleStatus()
    {
        return static::$saleStatus;
    }

    // public static function settings($term) {
    //     $value = Settings::where('term', $term)->value('value');
    //     return $value;
    // }

    public static function addUnderScore($data)
    {
        return empty($data) ? '' : $data . '_';
    }

    public static function cleanString($string) {
        $string = str_replace(' ','_', $string); // Replaces all spaces with underscore.
        $string = str_replace('-_','_', $string);
        $string = str_replace('_-','_', $string);
        $string = str_replace('-','_', $string);
        $string = str_replace('--','_', $string);
        $string = str_replace('__','_', $string);

        $string = preg_replace('/[^A-Za-z.0-9\-_]/', '', $string); // Removes special chars.

        return Str::limit($string, $limit = 25, $end = '...');
    }

    public static function currencyToWords(float $number)
    {
        $no = floor($number);
        $decimal = round($number - ($no), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise_pre = !empty($Rupees) ? ' and ' : '';
        $paise = ($decimal) ? $paise_pre . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' paise ' : '';
        $rupees_word = !empty($paise)?'':self::CURRENCY_WORD_DISPLAY;
        return ($Rupees ? $Rupees : '') . $paise . $rupees_word . ' only' ;
    }

    public static function formatPrice($val,$r=2)
    {
        $n = $val;
        $sign = ($n < 0) ? '-' : '';
        $i = number_format(abs($n),$r);
        return  $sign.$i;
    }

    // public static function stockInBranch($branch,$product)
    // {
    //     $branch_product = DB::table('branch_product')->where(['branch_id'=>$branch, 'product_id'=>$product])->first();
    //     return $branch_product->stock;
    // }

    public static function numToWords($number)
    {
        $words = array(
            '0' => 'Zero', '1' => 'One', '2' => 'Two',
            '3' => 'Three', '4' => 'Four', '5' => 'Five',
            '6' => 'Six', '7' => 'Seven', '8' => 'Eight',
            '9' => 'Nine', '10' => 'Ten', '11' => 'Eleven',
            '12' => 'Twelve', '13' => 'Thirteen', '14' => 'Fourteen',
            '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty',
            '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty', '60' => 'Sixty',
            '70' => 'Seventy', '80' => 'Eighty', '90' => 'Ninety'
        );

        if ($number <= 20) {
            return $words[$number];
        }
        elseif ($number < 100) {
            return $words[10 * floor($number / 10)]
                . ($number % 10 > 0 ? ' ' . $words[$number % 10] : '');
        }
        else {
            $output = '';
            if ($number >= 1000000000) {
                $output .= static::numToWords(floor($number / 1000000000))
                    . ' Billion ';
                $number %= 1000000000;
            }
            if ($number >= 1000000) {
                $output .= static::numToWords(floor($number / 1000000))
                    . ' Million ';
                $number %= 1000000;
            }
            if ($number >= 1000) {
                $output .= static::numToWords(floor($number / 1000))
                    . ' Thousand ';
                $number %= 1000;
            }
            if ($number >= 100) {
                $output .= static::numToWords(floor($number / 100))
                    . ' Hundred ';
                $number %= 100;
            }
            if ($number > 0) {
                $output .= ($number <= 20) ? $words[$number] :
                $words[10 * floor($number / 10)] . ' '
                    . ($number % 10 > 0 ? $words[$number % 10] : '');
            }
            return trim($output);
        }
    }
}
