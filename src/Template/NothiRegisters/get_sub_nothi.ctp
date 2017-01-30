<?php

if (!empty($nothiRegisters)) {
    echo $this->Form->input('parent_id', ['label' => '', 'class' => 'form-control nothi_register_id', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]);
}