<?php

namespace App\Http\Utilities;

use App\Models\Settings;
use Illuminate\Support\Facades\DB;

class Utility{

    //Constants

    const ADMIN_ID = 1;
    const PRODUCT_TYPE_RENT = 1;
    const PRODUCT_TYPE_NORMAL = 0;

    const LENDER_TYPE_CUSTOMER = 1;
    const LENDER_TYPE_BRANCH = 0;

    const FROM_MAIL = 'shabeer@gmail.com';

    const COUNTRY_CODE = '+91';
    const COUNTRY = 'KSA';
    const CURRENCY_DISPLAY = 'SAR';
    const CURRENCY_WORD_DISPLAY = 'Riyal';

    const DEFAULT_PRICE = 'products.price_month';
    const DEFAULT_LOCATION_RADIUS = 10;
    const OTP_MESSAGE = ' is your Boxat OTP and is valid for 10 minutes. Do not share it with anyone.';

    const PAGINATE_COUNT = 15;

    const PAYMENT_ONLINE = 1;
    const PAYMENT_COD = 2;

    const ITEM_ACTIVE = 1;
    const ITEM_INACTIVE = 0;

    const ITEM_VERIFIED = 1;
    const ITEM_UNVERIFIED = 0;

    const TICKET_CUSTOMER_POSTED = 1;
    const TICKET_ADMIN_REPLIED = 2;

    const STATUS_NEW = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECT = 2;
    const STATUS_READY = 3;
    const STATUS_DISPATCHED = 4;
    const STATUS_OUT = 5;
    const STATUS_OUT_PICKUP = 6;
    const STATUS_DELIVERED = 7;
    const STATUS_PICKED = 8;
    const STATUS_CLOSED = 9;
    const STATUS_ONHOLD = 10;
    const STATUS_CANCELLED = 11;
    const STATUS_RETURN_WAREHOUSE = 11;

    const STATUS_PARTIALLY = 2;

    const STATUS_SUBMITTED = 0;
    const STATUS_REVIEWAL = 1;
    const STATUS_MODIFY = 2;
    const STATUS_APPROVE = 3;

    const MESSAGE_TYPE_ALL = 0;
    const MESSAGE_TYPE_BRANCH = 1;
    const MESSAGE_TYPE_CUSTOMER = 2;
    const MESSAGE_TYPE_DRIVER = 3;

    const NOTIFICATION_TYPE_ALL = 0;
    const NOTIFICATION_TYPE_BRANCH = 1;
    const NOTIFICATION_TYPE_CUSTOMER = 2;
    const NOTIFICATION_TYPE_DRIVER = 3;

    const TICKET_TYPE_TECHNICAL = 1;
    const TICKET_TYPE_SALES = 2;
    const TICKET_TYPE_COMPLAINTS = 3;

    const TICKET_ESC_AGENT = 1;
    const TICKET_ESC_MANAGEMENT = 2;
    const TICKET_ESC_EXECUTIVE = 3;

    const SELLER_TYPE_CUSTOMER = 'Customer';
    const SELLER_TYPE_WAREHOUSE = 'Warehouse';

    const MAX_REVIEW_LIMIT = 5;

    public static function otp()
    {
        $otp = md5( rand(0,1000) );
        /*$otp = rand(100000, 999999);*/
        return $otp;
    }

    protected  static $status = [
        self::TICKET_CUSTOMER_POSTED => 'Active',
        self::ITEM_INACTIVE => 'Inactive',
    ];
    public static function status()
    {
        return static::$status;
    }

    protected  static $saleStatus = [
        self::STATUS_NEW => ['name'=>'New', 'date_field'=>'created_at'],
        self::STATUS_ACCEPTED => ['name'=>'Accepted', 'date_field'=>'date_accepted'],
        self::STATUS_READY => ['name'=>'Ready to Ship', 'date_field'=>'date_ready'],
        self::STATUS_DISPATCHED => ['name'=>'Despatched', 'date_field'=>'date_dispatched'],
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

    protected  static $returnStatus = [
        self::STATUS_NEW => ['name'=>'New', 'date_field'=>'created_at'],
        self::STATUS_ACCEPTED => ['name'=>'Accepted', 'date_field'=>'date_accepted'],
        // self::STATUS_READY => ['name'=>'out for pick up', 'date_field'=>''],
        self::STATUS_OUT => ['name'=>'Out for Pickup', 'date_field'=>'date_out_pickup'],
        self::STATUS_PICKED => ['name'=>'Picked up', 'date_field'=>'date_picked'],
        self::STATUS_CLOSED => ['name'=>'Return to warehouse', 'date_field'=>'date_closed'],
        self::STATUS_ONHOLD => ['name'=>'On Hold', 'date_field'=>'date_onhold'],
        self::STATUS_CANCELLED => ['name'=>'Cancelled', 'date_field'=>'date_cancelled'],
    ];
    public static function returnStatus()
    {
        return static::$saleStatus;
    }

    protected  static $deliveryStatus = [
        self::STATUS_NEW => ['name'=>'New'],
        self::STATUS_ACCEPTED => ['name'=>'Accepted'],
        self::STATUS_REJECT => ['name'=>'Reject'],
        self::STATUS_PICKED => ['name'=>'Picked'],
        self::STATUS_OUT => ['name'=>'Out for Delivery'],
        self::STATUS_OUT_PICKUP => ['name'=>'Out for Pickup'],
        self::STATUS_PICKED => ['name'=>'Picked up'],
        self::STATUS_DELIVERED => ['name'=>'Delivered'],
        self::STATUS_RETURN_WAREHOUSE => ['name'=>'Return to Warehouse'],
    ];
    public static function deliveryStatus()
    {
        return static::$deliveryStatus;
    }

    protected  static $sellerStatus = [
        self::STATUS_SUBMITTED => ['name'=>'Submitted'],
        self::STATUS_REVIEWAL => ['name'=>'Under Reviewal'],
        self::STATUS_MODIFY => ['name'=>'Request for Modification'],
        self::STATUS_APPROVE => ['name'=>'Approved'],
    ];

    public static function sellerStatus()
    {
        return static::$sellerStatus;
    }

    protected  static $saleBatchStatus = [
        self::STATUS_NEW => ['name'=>'New'],
        self::STATUS_ACCEPTED => ['name'=>'Accepted'],
        self::STATUS_PARTIALLY => ['name'=>'Partially Accepted'],
    ];

    public static function saleBatchStatus()
    {
        return static::$saleBatchStatus;
    }

    protected  static $product_units = [
        '1' => ['en'=>'Nos', 'ar'=>'Nos'],
        '2' => ['en'=>'Packet', 'ar'=>'Packet'],
        '3' => ['en'=>'Box', 'ar'=>'Box'],
        '4' => ['en'=>'Case', 'ar'=>'Case'],
    ];
    public static function product_units()
    {
        return static::$product_units;
    }

    protected  static $rent_term_types = [
        '1' => ['en'=>'Hour', 'ar'=>'Hour'],
        '2' => ['en'=>'Day', 'ar'=>'Day'],
        '3' => ['en'=>'Month', 'ar'=>'Month'],
        '4' => ['en'=>'Year', 'ar'=>'Year'],
    ];
    public static function rent_term_types()
    {
        return static::$rent_term_types;
    }

    protected  static $product_sizes = [
        '1' => ['en'=>'Small', 'ar'=>'Small'],
        '2' => ['en'=>'Medium', 'ar'=>'Medium'],
        '3' => ['en'=>'Large', 'ar'=>'Large'],
        '4' => ['en'=>'XL', 'ar'=>'XL'],
    ];
    public static function product_sizes()
    {
        return static::$product_sizes;
    }

    protected  static $product_colors = [
        '1' => ['en'=>'White', 'ar'=>'White'],
        '2' => ['en'=>'Blue', 'ar'=>'Blue'],
        '3' => ['en'=>'Red', 'ar'=>'Red'],
        '4' => ['en'=>'Black', 'ar'=>'Black'],
    ];
    public static function product_colors()
    {
        return static::$product_colors;
    }

    protected  static $message_recipients = [
        self::MESSAGE_TYPE_ALL => "All",
        self::MESSAGE_TYPE_BRANCH => "Warehouse",
        self::MESSAGE_TYPE_CUSTOMER => "Customer",
        self::MESSAGE_TYPE_DRIVER => "Driver",
    ];
    public static function message_recipients()
    {
        return static::$message_recipients;
    }

    protected  static $notification_recipients = [
        self::NOTIFICATION_TYPE_ALL => "All",
        self::NOTIFICATION_TYPE_BRANCH => "Warehouse",
        self::NOTIFICATION_TYPE_CUSTOMER => "Customer",
        self::NOTIFICATION_TYPE_DRIVER => "Driver",
    ];
    public static function notification_recipients()
    {
        return static::$notification_recipients;
    }

    protected  static $offer_types = [
        '1' => "Percentage",
        '2' => "Amount",
    ];
    public static function offer_types()
    {
        return static::$offer_types;
    }

    protected  static $product_types = [
        '1' => "Single",
        '2' => "Bundle",
    ];
    public static function product_types()
    {
        return static::$product_types;
    }

    protected  static $delivery_types = [
        '1' => "Delivery",
        '2' => "Pick Up",
    ];
    public static function delivery_types()
    {
        return static::$delivery_types;
    }

    protected  static $user_permissions = [
        '1' => "User Managment",
        '2' => "Vendor Managment",
        '3' => "Customer Management",
        '4' => "Shipping Management",
        '5' => "Category Management",
        '6' => "Brand Management",
        '7' => "Product Management",
        '8' => "Branch Management",
        '9' => "Orders Management",
        '10' => "Offer Management",
    ];
    public static function user_permissions()
    {
        return static::$user_permissions;
    }

    protected  static $ticket_types = [
        self::TICKET_TYPE_TECHNICAL => 'Technical',
        self::TICKET_TYPE_SALES => 'Sales',
        self::TICKET_TYPE_COMPLAINTS => 'Complaints',
    ];
    public static function ticket_types()
    {
        return static::$ticket_types;
    }

    protected  static $ticket_escalations = [
        self::TICKET_ESC_AGENT => 'Agent',
        self::TICKET_ESC_MANAGEMENT => 'Management',
        self::TICKET_ESC_EXECUTIVE => 'Executive',
    ];
    public static function ticket_escalations()
    {
        return static::$ticket_escalations;
    }

    public static function settings($term) {
        $value = Settings::where('term', $term)->value('value');
        return $value;
    }

    public static function addUnderScore($data)
    {
        return empty($data) ? '' : $data . '_';
    }

    public static function cleanString($string) {
        $string = str_replace(' ','_', $string); // Replaces all spaces with underscore.

        return preg_replace('/[^A-Za-z.0-9\-]/', '', $string); // Removes special chars.
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
        $paise = ($decimal) ? $paise_pre . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Fils' : '';
        return ($Rupees ? $Rupees : '') . $paise . self::CURRENCY_WORD_DISPLAY . ' only' ;
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

    public static function rentTermNameById($id)
    {
        $data = DB::table('rent_terms')->where(['id'=>$id])->first();
        return $data->name;
    }
}
