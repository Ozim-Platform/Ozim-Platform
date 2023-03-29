<?php


namespace App\Http\Validators;


use Illuminate\Support\Facades\Validator;

class CustomValidator
{
    static function default(){

        return Validator::make([], [], []);
    }
}