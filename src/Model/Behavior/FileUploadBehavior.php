<?php
/**
 * Created by PhpStorm.
 * User: shaiful
 * Date: 5/31/15
 * Time: 4:45 PM
 */
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Event\Event;
use Cake\ORM\Entity;

class FileUploadBehavior extends Behavior
{
    protected $_defaultConfig = [
        'upload_path'=>'',
        'field'=>'',
        'types'=>'jpg|png|jpeg',
        'required'=>false
    ];
    public function upload_file(Entity $entity)
    {
        $base_upload_path=WWW_ROOT.'img';
        $config = $this->config();
        $result=array();
        if((isset($_FILES[$config['field']]))&&($_FILES[$config['field']]['error']==0))
        {
            $tmp_name = $_FILES[$config['field']]["tmp_name"];

            $name = time().'_'.str_replace(' ','_',$_FILES[$config['field']]['name']);
            if($config['upload_path'])
            {
                $name=$config['upload_path'].'/'.$name;
            }
            if(move_uploaded_file($tmp_name, $base_upload_path.'/'.$name))
            {
                $result['status']=true;
                $result['info']['file_path']=$name;
                return $result;
            }
            else
            {
                $result['status']=false;
                $result['message']='Failed to upload';
                return $result;
            }
        }
        else
        {
            if($config['required'])
            {
                $result['status']=false;
                $result['message']='File reuqired';
                return $result;
            }
            else
            {
                $result['status']=true;
                return $result;
            }
        }

    }

    public function beforeSave(Event $event, Entity $entity)
    {

        $config = $this->config();
        $upload=$this->upload_file($entity);
        if($upload['status']===false)
        {
            $event->stopPropagation();
            return;
        }
        else
        {
            if(isset($upload['info']['file_path']))
            {
                $entity[$config['field']]=$upload['info']['file_path'];
            }
            else
            {
                $entity->dirty($config['field'],false);
            }

        }
    }
}