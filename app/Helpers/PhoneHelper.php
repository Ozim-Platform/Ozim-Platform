<?php


namespace App\Helpers;


class PhoneHelper
{
    public static function clear_format($phone){

        $phone= str_replace('-','',$phone);

        return $phone;

    }

    public static function format_number($phone){

        $phone = str_replace('+','8',$phone);

        $first_octet = substr($phone,0,1);

        $second_octet = substr($phone,1,3);

        $third_symbol = substr($phone,4,3);

        $fourth_symbol = substr($phone,7,2);

        $fifth_symbol = substr($phone,10,2);

//        dd($first_octet,$second_octet,$third_symbol,$fourth_symbol,$fifth_symbol,$phone);

        return $phone;

    }

}