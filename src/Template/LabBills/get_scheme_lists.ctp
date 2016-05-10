<?php
if (isset($labLetterRegisters)) {
    echo $this->Form->input('letter_id', ['options' => $labLetterRegisters, 'empty' => __('Select'), 'id' => 'scheme-id']);
} elseif (isset($schemes)) {
    echo $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => __('Select')]);
}
?>

<script>
    $(document).ready(function () {
        $('#scheme-id').chosen();
    });
</script>
