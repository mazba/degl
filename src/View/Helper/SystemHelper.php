<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * System helper
 */
class SystemHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public function display_date($date)
    {
        if(strlen($date)<1)
        {
            return '';
        }
        $display_string=date('d-M-Y',$date);
        if($display_string===false)
        {
            return '';
        }
        else
        {
            return $display_string;
        }
    }
    public function display_date_time($date)
    {
        if(strlen($date)<1)
        {
            return '';
        }
        $display_string=date('d-M-Y H:m:s',$date);
        if($display_string===false)
        {
            return '';
        }
        else
        {
            return $display_string;
        }
    }

}
