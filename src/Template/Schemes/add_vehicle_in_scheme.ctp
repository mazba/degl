<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<style>
    /*.modal {*/
        /*position: absolute;*/
        /*top: 100px;*/
        /*bottom: 0;*/
        /*left: 0;*/
        /*z-index: 10040;*/
        /*overflow: auto;*/
        /*overflow-y: auto;*/
    /*}*/
</style>
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Letter Details  </h6>


                </div>
                <div class="panel-body">

                    <table class="table table-bordered">
                        <tr>
                            <td>পেরক</td>
                            <td><?= __('Subject') ?></td>
                            <td><?= __('Attachment') ?></td>
                        </tr>
                        <tr>
                            <td><?= $vehicle_hire_letter['receive_from'] ?></td>
                            <td><?= $vehicle_hire_letter['subject'] ?></td>
                            <td>


                                <?php

                                if (1) {

                                    ?>
                                    <a data-lightbox="dak_file_image"
                                       href="<?php echo Router::url('/', true) . 'files/receive_files/' . $attachment['files']['file_path']; ?>">
                                        <img width="100" height="80" class="dak_file_image"
                                             src="<?php echo Router::url('/', true) . 'files/receive_files/' . $attachment['files']['file_path']; ?>">
                                    </a>
                                    <?php
                                } else { ?>
                                    <a target="_blank"
                                       href="<?php echo Router::url('/', true) . 'files/receive_files/' . $attachment['files']['file_path']; ?>">
                                        <?php echo $attachment['files']['file_path']; ?>
                                    </a><br>
                                <?php } ?>


                            </td>
                        </tr>

                    </table>

                </div>

            </div>



<?php if($hired_vehicles){?>

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Hired vehicle list </h6>


                </div>
                <div class="panel-body">

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td><?= __('Vehilce Title') ?></td>
                            <td><?= __('Vehicle Location') ?></td>
                            <td><?= __('Action') ?></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($hired_vehicles as $row)
                        {

                            ?>
                            <tr>
                                <td><?=$row['title']?></td>
                                <td><?=$row['location']?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#<?=$row['vehicle_id']?>">
                                       Return
                                    </button>
                                    <div style="margin-top: 15%;" class="modal fade myModal1"  id="<?=$row['vehicle_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Update vehicle location</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <form method="post" class="form-horizontal vehicle-location-form" id="<?=$row['id']?>">
                                                        <input type="hidden" class="vehicle_id" value="<?=$row['vehicle_id']?>" name="vehicle_id">
                                                        <input type="hidden"  class="vehicle_hire_id" value="<?=$row['id']?>" name="vehicle_hire_id">
                                                        <div class="">
                                                            <label for="recipient-name" class="control-label">Location:</label>
                                                            <input type="text" class="form-control location" id='' name="location">
                                                        </div> <br/>
                                                        <div class="form-actions text-right">
                                                            <button type="button" class="btn btn-primary vehicle-location-submit">Save changes</button> <br/>
                                                        </div>

                                                    </form>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="child" class="btn btn-default child" data-dismiss="" data-target="#">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>




                            <?php
                        }
                        ?>
                        </tbody>

                    </table>


                </div>

            </div>

<?php } ?>

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Add new vehicle </h6>


                </div>
                <div class="panel-body">

                    <?= $this->Form->create(null, ['controller' => '', 'action' => '', 'class' => 'form-horizontal','id'=>'add_vehicle_in_scheme', 'role' => 'form']); ?>
                    <div class="form-actions text-right">
                        <input type="button" value="<?= __('Save') ?>" class="btn btn-primary add_new_vehicle">
                        <?=$id?>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <td><?= __('Vehilce Title') ?></td>
                            <td><?= __('Select') ?></td>
                            <td><?= __('Location') ?></td>

                        </tr>
                        <?php
                        $i = 0;
                        foreach ($vehicles as $vehicle) {
                            ?>
                            <tr>
                                <td><?= $vehicle['title'] ?></td>
                                <td><input type="checkbox" value="<?= $vehicle['id'] ?>"
                                           name="selected_vehicles[]" <?php if (in_array($vehicle['id'], $hired_vehicles)) {
                                        echo 'checked';
                                    } ?>></td>
                                <td><input <?php if (!in_array($vehicle['id'], $hired_vehicles)) {
                                        echo "disabled";
                                    } ?>
                                        class="form-control location<?= $vehicle['id'] ?> <?php if (in_array($vehicle['id'], $hired_vehicles)) {
                                            echo "change" . $hired_vehicles[$i];
                                        } ?>" type="text" value="<?php if (in_array($vehicle['id'], $hired_vehicles)) {
                                        echo $location[$i++];
                                    } ?>" name="location[<?= $vehicle['id'] ?>]"></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <div class="form-actions text-right">
                        <input type="button" id="add_new_vehicle" value="<?= __('Save') ?>" class="btn btn-primary add_new_vehicle">
                    </div>
                    <?= $this->Form->end() ?>



                </div>

            </div>

<script>
    $(document).ready(function () {
        $("input[type=checkbox]").on('click', function () {
            if ($(this).is(':checked')) {
                var location = "location" + $(this).val();
                $('.' + location).removeAttrs('disabled')
            } else {
                var location = "location" + $(this).val();
                var change = "change" + $(this).val();
                if ($('.' + location).hasClass(change)) {
                    $('.' + location).removeAttrs('disabled')
                } else {
                    $('.' + location).attr('disabled', true)
                }


            }
        });


        $(document).on('click','.add_new_vehicle',function(){
            $.ajax({
            type: "POST",
            url: '<?= $this->Url->build("/Schemes/add_vehicle_in_scheme/$id")?>',
            data: $(this).closest('form').serialize(),
            timeout: 3000,
            success: function (data, status) {
                $('#scheme_progress_wrp').html('<div class="alert alert-success" role="alert">' + data + '</div>');
                $('#scheme_vehicles').trigger('click');
            }
        });
 });

        $(document).on('click','.vehicle-location-submit',function(event){
           event.preventDefault();
          // console.log(event);
            var vehicle_id=$(this).closest('form').find('.vehicle_id').val();
            var vehicle_hire_id=$(this).closest('form').find('.vehicle_hire_id').val();
            var location= $(this).closest('form').find('.location').val();
         //   console.log(vehicle_id);
            $.ajax({
                type: "POST",
                url: '<?= $this->Url->build("/Schemes/update_vehicle_location")?>',
                data:{id: vehicle_id,vehicle_hire_id:vehicle_hire_id,location:location},
                timeout: 3000,
                success: function (data, status) {
                    $('#scheme_progress_wrp').html('<div class="alert alert-success" role="alert">' + data + '</div>');
                    $('#scheme_vehicles').trigger('click');
                }
            });
        });

        $('.child').click(function(){
            $('.myModal1').modal('hide');
        });
    })
</script>
