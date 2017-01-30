<button id="print" onclick="window.print();return false;" class="btn btn-warning pull-right" style="margin-right: 10px;"><?= __('Print') ?></button>

<h1 class="text-center" style="padding-top: 20px"><?=  __('Local Government Engineering Department') ?></h1>
<h2 class="text-center"><?=  __('Nothi Registers') ?></h2>
<h3 class="text-center" style=""><?=  $office['name_en'].', '.$office['address'] ?></h3>
<table class="table table-bordered" style="padding: 5px">
    <thead>
        <tr>
            <th><?= __('Nothi no') ?></th>
            <th><?= __('Nothi Date') ?></th>
            <th><?= __('Nothi Label') ?></th>
        </tr>

    </thead>
    <tbody>
       <?php
            foreach($nothiRegisters as $nothiRegister)
            {
                ?>
                <tr>
                    <td><?= $nothiRegister['nothi_no'];  ?></td>
                    <td><?= $this->System->display_date($nothiRegister['nothi_date']);  ?></td>
                    <td><?= $nothiRegister['remarks'];  ?></td>
                </tr>
                <?php
            }
       ?>
    </tbody>
</table>
<style>
    @media print
    {
        #print
        {
            display: none;
        }
    }
</style>
<script>
    $(document).ready(function ()
    {
//        $(document).on("click", "button", function(event)
//        {
//
//            $(document).print();
////            w.close();
//        });
    });
</script>