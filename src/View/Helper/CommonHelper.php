<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * System helper
 */
class CommonHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];


//  eng to bangla
    function EngToBanglaNum($input) {
        $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
        return str_replace(range(0, 9), $bn_digits, $input);
    }
//    eng to bangla month
    public function eng_to_bn_month($str){
        $eng_month = array('Jan','Feb','Mar','Apr','May','Jun', 'Jul', 'Aug','Sep','Oct','Nov','Dec');
        $bng_month = array('জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন', 'জুলাই', 'অগাস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর');
        return str_replace($eng_month, $bng_month, $str);
    }
    public function eng_to_bn_month_full($str){
        $eng_month = array('January','February','March','April','May','June', 'July', 'August','September','October','November','December');
        $bng_month = array('জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন', 'জুলাই', 'অগাস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর');
        return str_replace($eng_month, $bng_month, $str);
    }

    public function eng_to_bn($str){
        $eng_number = array(1,2,3,4,5,6,7,8,9,0,'');
        $ban_number = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','');
        return str_replace($eng_number,$ban_number,$str);
    }

}
