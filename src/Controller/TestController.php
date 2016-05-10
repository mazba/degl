<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class TestController extends AppController
{
    public function index()
    {
        $json = [['name'=>'AAA',
            'age'=>55],
            ['name'=>'BBB',
                'age'=>555]];
        echo '<pre>';
        $json = json_encode($json);

        $array = json_decode($json,true);
        $simple_string = '';
        foreach($array as $value) {
            if(count($value) > 1) {
                $tmp = implode(",", $value);
            }
            $simple_string .=  $tmp.",";
        }
        $simple_string = substr($simple_string,0,strlen($simple_string)-1);
        echo $simple_string;
        echo '</pre>';
        die;
die;
    }

    public function subfuc()
    {
        $array = array(array("blue", "red", "green"), array("one", "three", "twenty"));
            $str = "";
            foreach($array as $value) {
                if(count($value) > 1) {
                    $tmp = implode("~", $value);
                }
                $str .=  $tmp."&";
            }
            $str = substr($str,0,strlen($str)-1);
            echo $str;
        die;



    }
}
