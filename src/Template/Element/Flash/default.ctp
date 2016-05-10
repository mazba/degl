<?php
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<div class="alert alert-info fade in block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="icon-info"></i><?= $message; ?>
</div>
