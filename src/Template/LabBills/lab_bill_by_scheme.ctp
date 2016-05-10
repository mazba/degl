<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Lab Bill By Scheme') ?></li>
    </ul>
</div>
<?php
if($LabLetterRegisters)
{
?>
    <div class="row panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">
                <i  class="icon-paragraph-right2"></i><?= __('Lab Bill by Scheme') ?>
                <small><?= $LabLetterRegisters{0}->scheme->name_en ?> </small>
            </h6>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><?= __('Letter Subject') ?></th>
                <th><?= __('Received From') ?></th>
                <th><?= __('Lab Test Short Name') ?></th>
                <th><?= __('Number of Test') ?></th>
                <th><?= __('Rate') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            foreach($LabLetterRegisters as $LabLetterRegister)
            {
                ?>
                <tr style="background: #ececec">
                    <td><?= $LabLetterRegister['subject'] ?></td>
                    <td><?= $LabLetterRegister['received_from'] ?></td>
                    <td colspan="5"></td>
                </tr>
                <?php
                foreach($LabLetterRegister['lab_actual_tests'] as $lab_tests)
                {
                    $total+= $lab_tests['rate'];
                    ?>
                    <tr>
                        <td colspan="2"></td>
                        <td><?= $lab_tests['lab_test_short_name'] ?></td>
                        <td><?= $lab_tests['number_of_test'] ?></td>
                        <td><?= $lab_tests['rate'] ?></td>

                    </tr>
                    <?php
                }
            }
            ?>
            <tr><td colspan="4" class="text-danger"><?= __('Total') ?></td><td><?php echo $total ?></td></tr>
            </tbody>


        </table>
    </div>

    <?php
}
else
{
    ?>
    <h1 style="text-align: center; color: red"> <?php echo __('No Data Found') ?></h1>
    <?php
}
?>


<script type="text/javascript">
    $(document).ready(function () {

    });
</script>
