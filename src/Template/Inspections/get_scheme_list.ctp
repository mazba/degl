<?php

if(!empty($schemes)){
    echo $this->Form->input('scheme_id[]',['label'=>__('Scheme'),'options'=>$schemes,'empty'=>__('Select')]);
    echo $this->Form->input('status1[]',['label'=>__('Status'),'options'=>[1=>'Ok',0=>'Not Ok']]);
}

