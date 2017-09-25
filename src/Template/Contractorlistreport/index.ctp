<?php
use Cake\Core\Configure;
$contractor_type = Configure::read('contractor_type');
?>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= $this->Html->link(__('Contractor List'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Contractor') ?>
        </h6>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="row">
                <?= $this->Form->create(null, ['id' => 'contractor-list']) ?>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('contractor_type', ['required'=>'required','options' => $contractor_type, 'empty' => __('Select')]) ?>
                </div>
                <!--    end field setup-->
                <div class="col-sm-offset-5 col-sm-3" style="margin-top: 15px">
                    <?= $this->Form->submit(__('Contractor Report'), ['class' => 'btn btn-warning']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="row">
            <?php if(isset($results)): ?>
                <?php if((!empty($results))): ?>

                    <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
                        <button class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
                        <h3 class="text-center"><?= __('LGED Gazipur') ?><br>
                            <?php if($type == 1)
                                echo 'LGED ঠিকাদারের তালিকা';
                            elseif($type == 2)
                                echo 'নতুন ঠিকাদারের তালিকা';
                            else
                                echo 'নবায়নকৃত ঠিকাদারের তালিকা';
                            ?>
                        </h3>
                        <div id="report_table">
                            <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
                                <thead>
                                <tr>
                                    <th><?= __('ক্রম') ?></th>
                                    <th><?= __('প্রতিষ্ঠানের নাম') ?></th>
                                    <th><?= __('নাম') ?></th>
                                    <th><?= __('ঠিকানা') ?></th>
                                    <th><?= __('মোবাইল নং') ?></th>
                                    <th><?= __('জাতীয় পরিচয়পত্র') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($results as $key => $result): ?>
                                    <tr>
                                        <td><?= ++$key?></td>
                                        <td><?= $result['contractor_title']?></td>
                                        <td><?= $result['contact_person_name']?></td>
                                        <td><?= $result['contractor_address']?></td>
                                        <td><?= $result['mobile']?></td>
                                        <td><?= $result['nid']?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php else: ?>
                    <h4 class="text-center text-warning" style="margin-top: 1em"><?= __('No data found') ?></h4>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <style>
        div#s2id_contractor-id {
            width: 452px !important;
        }
        div#select2-drop {
            width: 451px !important;
        }
    </style>

    <script>
        function print_rpt(){
            URL="<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
            day = new Date();
            id = day.getTime();
            eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
        }
    </script>


