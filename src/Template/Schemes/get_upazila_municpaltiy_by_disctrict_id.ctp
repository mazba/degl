<?php
$data['upazilas']=$this->Form->input('upazila_id', ['options' => $upazilas, 'empty' => 'select a upazila']);
$data['municipalities']=$this->Form->input('municipality_id', ['options' => $municipalities, 'empty' => 'NONE']);
echo json_encode($data);