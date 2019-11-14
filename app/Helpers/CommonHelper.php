<?php
namespace App\Helpers;

class CommonHelper
{
    // format phonenumber
    public static function formatPhonenumber($data){
        $result = $data;
        if(  preg_match( '/^(\d{4})(\d{3})(\d{1,})$/', $data,  $matches ) )
            {
                $result = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3];
                return $result;
            }
        return  $result;
    }

    public static function priceFormat($price)
    {
        return number_format($price,0,".",",");
    }

    public static function replaceParamsInText($text, $data = []) {
        foreach ($data as $key => $value) {
            $text = str_replace('{$' . $key . '}', $value, $text);
        }
        return $text;
    }

    public static function commonCurrency($price)
    {
        return number_format($price,0,".",",") . ' ₫';
    }

    public static function checkPreviousSameCurrentUrl() {
        return strtok(url()->previous(), "?") === strtok(request()->url(), "?");
    }

    public static function getDate($format = 'Y/m/d', $date = null, $offset = '+0 months') {
        if(empty($date)) {
          $date = date('Y-m-d');
        }
        return date($format, strtotime($offset, strtotime($date)));
    }

    public static function keepXLines($str, $num=7) {
        $lines = explode("\n", $str);
        $firsts = array_slice($lines, 0, $num);
        return implode("\n", $firsts);
    }

    public static function numberFormat($number)
    {
        return number_format($number,0,".",",");
    }

    public static function checkGiftCode($order, $orderProuct)
    {
        $checkGiftCode = false;
        if(($order['gift_code'] && $orderProuct['product']['gift_code']) == config('common.new_customer')) {
            $checkGiftCode = true;
        }
        return $checkGiftCode;
    }
}
