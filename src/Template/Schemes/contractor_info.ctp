<div id="">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#contractor_list" aria-controls="work_schedule" role="tab"
                                                  data-toggle="tab"><?=__('Contractor List')?></a></li>

        <li role="presentation" class=""><a href="#contractor_letter" aria-controls="" role="tab"
                                            data-toggle="tab"><?=__('Contractor Letters')?></a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane  active" id="contractor_list">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-table2"></i>Contractor List</h6>
                </div>
                <div class="panel-body">
                    <table class="table  table-bordered">
                        <tr>
                            <td>Contractor Title</td>
                            <td>Contact Person Name</td>
                            <td>Contractor Phone</td>
                            <td>Mobile</td>
                            <td>Is Lead?</td>
                        </tr>
                        <?php foreach($assigned_contractors  as $row):?>
                            <tr>
                                <td><?= $row['contractor']['contractor_title']?></td>
                                <td><?= $row['contractor']['contact_person_name']?></td>
                                <td><?= $row['contractor']['contractor_phone']?></td>
                                <td><?= $row['contractor']['mobile']?></td>
                                <td><?= $row['is_lead']?'Yes':''?></td>
                            </tr>
                        <?php endforeach?>
                    </table>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="contractor_letter">
            <div class="col-md-12 text-right" style="margin-bottom: 1em">
                <a class="btn btn-success modal-contractor"  onclick="return confirm('আপনি কি এই কন্ট্রাকটর এর জন্য কোনো পত্রজারী করতে চান?');"  data-toggle="modal" data-target="#NewLetter"><?= __('Letter Issues') ?></a>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title"><i class="icon-table2"></i><?=__('Letters')?></h6>
                    </div>
                    <div class="panel-body">
                        <table class="table  table-bordered">
                            <tr>
                                <td><?= __('স্মারক নম্বর') ?></td>
                                <td><?= __('বিষয়') ?> </td>
                                <td><?= __('বর্ণনা') ?></td>
                                <td><?= __('অ্যাকশন ') ?></td>
                            </tr>
                            <?php foreach($assign_letters  as $row):?>
                                <tr>
                                    <td><?= $row['sarok_no']?></td>
                                    <td><?= $row['subject']?></td>
                                    <td><?= $row['description']?></td>
                                    <td>
                                        <?php
                                        echo $this->Html->link(__('View'), ['action' => 'contractorLetter', $row['id']],['class'=>'btn btn-sm btn-info', 'target' => '_blank']);
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for contractor -->
<div id="NewLetter" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-new">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row panel panel-default">
                    <div class="panel-body col-sm-12">
                        <div class="form-group input">
                            <label class="col-sm-1 control-label text-right" style="width: 12.333%;"><?= __('Reminder Number') ?></label>
                            <div class="col-sm-11 container_description" style="width: 87.667%;">
                                <input type="text" name="sarok_no" class="reminder form-control" required="required"/>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body col-sm-12">
                        <div class="form-group input">
                            <label class="col-sm-1 control-label text-right" style="width: 12.333%;"><?= __('Subject') ?></label>
                            <div class="col-sm-11 container_description" style="width: 87.667%;">
                                <input type="hidden" name="scheme_id" class="letter_issue_scheme_id" value="<?= $id? $id:'' ?>">
                                <input type="text"  name="subject" class="subject form-control" required="required"/>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body col-sm-12">
                        <div class="form-group input">
                            <label class="col-sm-1 control-label text-right" style="width: 12.333%;"><?= __('Description') ?></label>
                            <div class="col-sm-11 container_description" style="width: 87.667%;">
                                <textarea name="description" class="form-control description" rows="10" required="required"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center"  id="response-text-wrp">
                        <h2 style="padding: 6px"></h2>
                    </div>
                    <div class="col-sm-12 form-actions text-center">
                        <button type="button" class="btn btn-primary btn-block submit-letter"><?= __('Save') ?></button>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12 text-center">
                            <button type="button" style="margin-bottom: 1em" class="modal-close btn btn-sm btn-warning modal-newsletter"><?= __('বন্ধ করুন ') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // modal data save
    $(document).on('click', ".submit-letter", function(){
        var sarok_no = $('.reminder').val();
        var scheme_id = $('.letter_issue_scheme_id').val();
        var subject = $('.subject').val();
        var description = $('.description').val();
        $.ajax({
            type: 'POST',
            url :"<?= $this->Url->build(['controller' => 'Schemes', 'action' => 'newLetterAssign']) ?>",
            data: {scheme_id: scheme_id, subject: subject, description: description, sarok_no: sarok_no},
            success: function(response){
                var response = JSON.parse(response);
                $('.submit-letter').remove();
                $responseWrp = $('#response-text-wrp');
                $responseWrp.find('h2').html(response.msg);
                $responseWrp.find('h2').addClass('btn-success');
                $('.submit-letter').off('click')
            }
        });
    });
</script>