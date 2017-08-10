<?php
use Cake\Routing\Router;
if(!empty($file)){ ?>
<div class="row panel panel-default">
    <?php
    $path = pathinfo($file['document']);
    if ($path['extension'] == 'jpg' || $path['extension'] == 'png' || $path['extension'] == 'JPG' || $path['extension'] == 'PNG') {
        ?>
        <div>
            <a data-lightbox="dak_file_image"
               href="<?php echo Router::url('/', true) . 'img/' . $file['document']; ?>">
                <img width="700" height="600" class="dak_file_image" style="display: block; margin: 0 auto"
                     src="<?php echo Router::url('/', true) . 'img/' . $file['document']; ?>">
            </a>
        </div>
    <?php }
    else if($path['extension'] == 'pdf'){
        ?>
        <div style="text-align: center; color: #000; font-size: 22px "  >
            <a href="<?php echo Router::url('/', true) . 'img/' . $file['document']; ?>" target="_blank">Click here to see</a>
        </div>
    <?php } } ?>
    <?php if(empty($file)): ?>
    <div class="row panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Sorry! Document has not been found!
            </h3>
        </div>
        <?php endif; ?>
        <script>
            $('.dak_file_image').on('mouseenter', function () {
                $(this).trigger('click');
            });
        </script>