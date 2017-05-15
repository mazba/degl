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

}
