<?php
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Scheme Details'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Scheme Detail') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Scheme Details'), ['action' => 'index']) ?> </li>
    </ul>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-stack"></i><?= __('Scheme Details') ?></h6>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label><?= __('Scheme English Name') ?></label>
                    <input value="<?= h($scheme->name_en) ?>" class="form-control" type="text" disabled>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?= __('Scheme Bangla Name') ?></label>
                    <input value="<?= h($scheme->name_bn) ?>" class="form-control" type="text" disabled>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?= __('Scheme Code') ?></label>
                    <input value="<?= h($scheme->scheme_code) ?>" class="form-control" type="text" disabled>

                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label><?= __('Project') ?></label>
                    <input value="<?= $scheme->has('project') ?  $scheme->project->name_en : '' ?>" class="form-control" type="text" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?= __('District') ?></label>
                    <input value="<?= $scheme->has('district') ?  $scheme->district->name_en : '' ?>" class="form-control" type="text" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?= __('Financial Year Estimate') ?></label>
                    <input value="<?= $scheme->has('financial_year_estimate') ?h($scheme->financial_year_estimate->name) : '' ?>" class="form-control" type="text" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?= __('Upazila') ?></label>
                    <input value="<?= $scheme->has('upazila') ?h($scheme->upazila->name_en):'' ?>" class="form-control" type="text" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label><?= __('Municipality') ?></label>
                    <input value="<?= $scheme->has('municipality')?h($scheme->municipality->name_en):'' ?>" class="form-control" type="text" disabled>
                </div>
            </div>

        </div>
<!--   END the Scheme basic data     -->
        <div class="panel panel-default">
            <div class="panel-heading bg-info">
                <h6 class="panel-title text-center"><i class="icon-grid4"></i><?= __('Scheme Items') ?></h6>
            </div>
            <div class="panel-body">
                <div id="container_items_input" style="overflow-x: auto; margin-top: 15px;">
                    <?php
                    if($item_code_wise_scheme_details)
                    {
                        foreach($item_code_wise_scheme_details as $data)
                        {
                            ?>
                            <table class="table table-bordered show-grid">
                                <tr>
                                    <td class="text-center alert alert-success" colspan="12"><?php echo $data['item_code']; ?></td>
                                </tr>
                                <tr>
                                    <td><?= __('Deduction') ?></td>
                                    <td><?= __('Comp Sl') ?></td>
                                    <td><?= __('Location/Component') ?></td>
                                    <?php
                                    if($data['item_unit']=='cum')
                                    {
                                        ?>
                                        <td><?= __('Length') ?></td>
                                        <td><?= __('Width') ?></td>
                                        <td><?= __('Height/Depth') ?></td>
                                        <td><?= __('Volume') ?></td>
                                    <?php
                                    }
                                    elseif($data['item_unit']=='sqm')
                                    {
                                        ?>
                                        <td><?= __('Length') ?></td>
                                        <td><?= __('Width') ?></td>
                                        <td><?= __('Area') ?></td>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <td><?= __('No of items') ?></td>
                                    <?php
                                    }
                                    ?>
                                    <td><?= __('Rate') ?></td>
                                    <td><?= __('Total') ?></td>
                                    <td><?= __('Remarks') ?></td>
                                    <td><?= __('Break up') ?></td>
                                </tr>
                                <?php
                                foreach($data['rows'] as $key=>$item)
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $item['deducation'] ?></td>
                                        <td><?php echo $item['comp_serial_no'] ?></td>
                                        <td><?php echo $item['component_location'] ?></td>
                                        <?php
                                        if($data['item_unit']=='cum')
                                        {
                                            ?>
                                            <td><?php echo $item['cl_length'] ?></td>
                                            <td><?php echo $item['cl_width'] ?></td>
                                            <td><?php echo $item['cl_height_depth'] ?></td>
                                            <td><?php echo $item['cl_area_volume'] ?></td>
                                        <?php
                                        }
                                        elseif($data['item_unit']=='sqm')
                                        {
                                            ?>
                                            <td><?php echo $item['cl_length'] ?></td>
                                            <td><?php echo $item['cl_width'] ?></td>
                                            <td><?php echo $item['cl_area_volume'] ?></td>
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <td><?php echo $item['item_quantity'] ?></td>
                                        <?php
                                        }
                                        ?>
                                        <td><?=$item['rate']?></td>
                                        <td><?php echo $item['total'] ?></td>
                                        <td><?php echo $item['remarks'] ?></td>
                                        <td><?php echo $item['has_breakup'] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
if($item_code_wise_revise_scheme)
{
    ?>
    <div class="panel panel-info">
        <div class="panel-heading bg-info">
            <h6 class="panel-title text-center"><i class="icon-grid4"></i><?= __('Revise History') ?></h6>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php
                        $i=0;
                        foreach($item_code_wise_revise_scheme as $key=>$item_group)
                        {
                            $i++;
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
                                            <i class="icon-transmission"></i> Scheme Revise Items <?php echo $key; ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <?php
                                            foreach($item_group as $time=>$items)
                                            {
                                                ?>
                                                <h6> <i class="icon-stopwatch"></i><?php echo date('d-m-Y',$time); ?> <small> <?php echo date('H:i:s',$time); ?></small></h6>
                                                <hr>
                                                <table class="table table-bordered show-grid">
                                                    <tr>
                                                        <td><?= __('Deduction') ?></td>
                                                        <td><?= __('Comp Sl') ?></td>
                                                        <td><?= __('Location/Component') ?></td>
                                                        <?php
                                                        if($data['item_unit']=='cum')
                                                        {
                                                            ?>
                                                            <td><?= __('Length') ?></td>
                                                            <td><?= __('Width') ?></td>
                                                            <td><?= __('Height/Depth') ?></td>
                                                            <td><?= __('Volume') ?></td>
                                                        <?php
                                                        }
                                                        elseif($data['item_unit']=='sqm')
                                                        {
                                                            ?>
                                                            <td><?= __('Length') ?></td>
                                                            <td><?= __('Width') ?></td>
                                                            <td><?= __('Area') ?></td>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <td>No of items</td>
                                                        <?php
                                                        }
                                                        ?>
                                                        <td><?= __('Rate') ?></td>
                                                        <td><?= __('Total') ?></td>
                                                        <td><?= __('Remarks') ?></td>
                                                        <td><?= __('Break up') ?></td>
                                                    </tr>
                                                    <?php
                                                    foreach($items as $item)
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $item['deducation'] ?></td>
                                                            <td><?php echo $item['comp_serial_no'] ?></td>
                                                            <td><?php echo $item['component_location'] ?></td>
                                                            <?php
                                                            if($data['item_unit']=='cum')
                                                            {
                                                                ?>
                                                                <td><?php echo $item['cl_length'] ?></td>
                                                                <td><?php echo $item['cl_width'] ?></td>
                                                                <td><?php echo $item['cl_height_depth'] ?></td>
                                                                <td><?php echo $item['cl_area_volume'] ?></td>
                                                            <?php
                                                            }
                                                            elseif($data['item_unit']=='sqm')
                                                            {
                                                                ?>
                                                                <td><?php echo $item['cl_length'] ?></td>
                                                                <td><?php echo $item['cl_width'] ?></td>
                                                                <td><?php echo $item['cl_area_volume'] ?></td>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <td><?php echo $item['item_quantity'] ?></td>
                                                            <?php
                                                            }
                                                            ?>
                                                            <td><?=$item['rate']?></td>
                                                            <td><?php echo $item['total'] ?></td>
                                                            <td><?php echo $item['remarks'] ?></td>
                                                            <td><?php echo $item['has_breakup'] ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </table>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<?php
if($scheme_remarks)
{
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-bubble6"></i><?= __('Scheme Remarks') ?></h6>
        </div>
        <div class="panel-body">
            <?php
            foreach($scheme_remarks as $scheme_remarks)
            {
                ?>
                <div class="alert alert-block alert-success" style="margin-bottom: 10px;">
                    <h6><i class="icon-bubble-dots2"></i> <?php echo ($scheme_remarks['remarks_type']=='scheme_approve' ? 'Scheme Approve' : 'Scheme Assign'); ?></h6>
                    <hr>
                    <p><?php echo $scheme_remarks['remarks']; ?></p>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}
?>

<?php
if($scheme_conductors)
{
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-construction"></i><?= __('Scheme Conductors') ?></h6>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        <?= __('Contractor Title') ?>
                    </th>
                    <th>
                        <?= __('Contact Person Name') ?>
                    </th>
                    <th>
                        <?= __('Mobile') ?>
                    </th>
                    <th style="width: 100px;">

                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($scheme_conductors as $scheme_conductor)
                {
                    ?>
                    <tr>
                        <td>
                            <?php echo $scheme_conductor['contractors']['contractor_title']; ?>
                        </td>
                        <td>
                            <?php echo $scheme_conductor['contractors']['contact_person_name']; ?>
                        </td>
                        <td>
                            <?php echo $scheme_conductor['contractors']['mobile']; ?>
                        </td>
                        <td>
                            <?php
                                if($scheme_conductor['is_lead'])
                                {
                                ?>
                                    <span class="label label-success"><?= __('Lead Conductors') ?></span>
                                <?php
                                }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}
?>

<?php
if($dak_files)
{
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-folder-open2"></i><?= __('Scheme Dak Files') ?></h6>
        </div>
        <div class="panel-body">
            <div class="list-group">
                <?php
                foreach($dak_files as $dak_file)
                {
                ?>
                    <div class="alert alert-success fade in block-inner">
                        <strong><?= __('Sender Name:') ?></strong> <?php echo $dak_file['sender_name']; ?>
                        <br>
                        <strong><?= __('Letter No:') ?></strong> <?php echo $dak_file['letter_no']; ?>
                        <br>
                        <?php
                            foreach($dak_file['file_paths'] as $file)
                            {
                                ?>
                                <a class="list-group-item" href="<?php echo Router::url('/',true).'files/receive_files/'.$file; ?>"><?php echo $file; ?></a>
                                <?php
                            }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>
