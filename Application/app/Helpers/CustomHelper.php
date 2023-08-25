<?php 

namespace App\Helpers;

use App\Models\User;
use Session;
use DB;

class CustomHelper
{
    public static function marinaName($ids)
    {
        $marina_name = '';
        if(!empty($ids)) {
            $marinaIds = explode(',',$ids);
            $marinaList = User::select('firstname')->whereIn('id', $marinaIds)->get();
            $nameArr = [];
            if (!empty($marinaList)) {
                foreach($marinaList as $rrr){
                    array_push($nameArr, $rrr->firstname);
                }
                if(!empty($nameArr)){
                    $marina_name = implode(', ', $nameArr);
                }
            }
        }
        return $marina_name;
    }

}