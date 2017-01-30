<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('File Tracker') ?></li>

    </ul>
</div>

<div class="wrap">
    <div class="panel panel-success " style="margin-top: 25px">
        <div class="panel-heading">
            <h6 class="panel-title"><?= $my_file['subject'] ?></h6>
        </div>
        <div class="panel-body">
            <p><strong><?= __('Message: ') ?></strong> <?= $my_file['message_text'] ?></p>

            <p><strong><?= __('From: ') ?></strong> <?php echo $my_file['sender_name']; if($my_file['sender_designation']){ ?>
                    (<?= $my_file['sender_designation'] ?>) <?php } ?>
            </p>

            <p><strong><?= __('To: ') ?></strong> <?= $my_file['recipient_name'] ?>
                (<?= $my_file['recipient_designation'] ?>)</p>

            <p><strong><?= __('Date: ') ?></strong> <?= date('d-m-Y', $my_file['created_date']) ?></p>
        <span data-user="<?= $my_file['recipient_id'] ?>" data-id="<?= $my_file['id'] ?>" id=""
              class="btn btn-primary up"> <i
                class="icon-arrow-up11"></i>Track up </span>
        <span data-margin-left="0" data-user="<?= $my_file['recipient_id'] ?>" data-id="<?= $my_file['id'] ?>" id=""
              class="btn btn-primary down"> <i class="icon-arrow-down11"></i>Track down </span>
        </div>
    </div>

    <div class="dddddd">

    </div>


</div>


<script>
    $(document).ready(function () {
        $(document).on('click', '.down', function () {
            var user = $(this).attr('data-user');
            var id = $(this).attr('data-id');
            var margin_left = $(this).attr('data-margin-left');
            margin_left = parseInt(margin_left) + 30;
            var obj= $(this);
            $.ajax({
                url: '<?=$this->Url->build(('/Tracks/getDownMessage'), true)?>',
                type: 'POST',
                data: {user: user, id: id},
                success: function (data) {
                    data = JSON.parse(data)

                    var html = '';
                    $.each(data.history, function (key, value) {
                        var recipient = value.recipient_name + " (" +value.recipient_designation + ")";
                        html = html + '<div class="wrap" >'
                            + '<div class="panel panel-primary" style="margin-left:' + margin_left + 'px">'
                            + '<div class="panel-heading">'
                            + '<h6 class="panel-title panel-trigger">'
                            + '<a class="collapsed" href="#question' + key + value.id + '" data-toggle="collapse">' + value.subject + '</a>'
                            + '</h6>'
                            + '</div>'
                            + '<div id="question' + key + value.id + '" class="panel-collapse collapse" style="height: 0px;">'
                            + '<div  class="panel-body">'
                            + '<p><strong><?= __("Message: ") ?></strong> ' + value.message_text + '</p>'
                            + '<p><strong><?= __("From: ") ?></strong>' + value.sender_name + '</p>'
                            + '<p><strong><?= __("To: ") ?></strong>' + recipient + '</p>'
                            + '<p><strong><?= __('Date: ') ?></strong>' + value.created_date + ' </p>'
                            + '<span data-user="' + value.recipients['user_id'] + '" data-margin-left="' + margin_left + '" data-tag="msg-up" data-id="' + value.id + '" id="" class="btn btn-primary up"> <i class="icon-arrow-up11"></i>Track up </span>&nbsp;'
                            + '<span data-user="' + value.recipients['user_id'] + '" data-margin-left="' + margin_left + '" data-tag="msg-down" data-id="' + value.id + '" id="" class="btn btn-primary down"> <i class="icon-arrow-down11"></i>Track down </span>'
                            + '</div>'
                            + '</div>'
                            + '</div>'
                            +  '<div class="dddddd">'
                            + '</div>'
                            + '</div>';
                    })




                    // var html2 = '';
                    $.each(data.tasks, function (key, value) {

                        html = html + '<div class="wrap" >'
                            + '<div class="panel panel-info" style="margin-left:' + margin_left + 'px">'
                            + '<div class="panel-heading">'
                            + '<h6 class="panel-title panel-trigger"><a class="collapsed" href="#task' + value.id + '" data-toggle="collapse">' + value.display_text + '</a></h6>'
                            + '</div>'
                            + '<div id="task' + value.id + '" class="panel-collapse collapse" style="height: 0px;">'
                            + '<div  class="panel-body">'
                            + '<span  data-margin-left="' + margin_left + '" data-id="' + value.table_row_id + '" id="" class="btn btn-primary task-up"> <i class="icon-arrow-up11"></i>Track up </span>&nbsp;'
                            + '<span data-margin-left="' + margin_left + '" data-id="' + value.table_row_id + '" id="" class="btn btn-primary task-down"> <i class="icon-arrow-down11"></i>Track down </span>'
                            + '</div>'
                            + '</div>'
                            + '</div>'
                            +  '<div class="ffffff">'
                            + '</div>'
                            + '</div>';
                    })

                    obj.closest('.wrap').find('.dddddd').html(html)
                    //obj.closest('.wrap').find('.ffffff').append(html2)

                }

            });

        });

        $(document).on('click', '.task-down', function () {
            var id = $(this).attr('data-id');
            var margin_left = $(this).attr('data-margin-left');
            margin_left = parseInt(margin_left) + 30;
            var obj= $(this);
            $.ajax({
                type: 'POST',
                url: '<?=$this->Url->build(('/Tracks/getDownTask'), true)?>',
                data: {id: id},
                success: function (data) {
                    data = JSON.parse(data);
                    var html2 = '';
                    $.each(data, function (key, value) {

                        html2 = html2
                            + '<div class="wrap" >'
                            + '<div class="panel panel-info" style="margin-left:' + margin_left + 'px">'
                            + '<div class="panel-heading">'
                            + '<h6 class="panel-title panel-trigger"><a class="collapsed" href="#task' + value.id + '" data-toggle="collapse">' + value.display_text + '</a></h6>'
                            + '</div>'
                            + '<div id="task' + value.id + '" class="panel-collapse collapse" style="height: 0px;">'
                            + '<div  class="panel-body">'
                            + '<span data-margin-left="' + margin_left + '" data-id="' + value.table_row_id + '" id="" class="btn btn-primary task-up"> <i class="icon-arrow-up11"></i>Track up </span>&nbsp;'
                            + '<span data-margin-left="' + margin_left + '" data-id="' + value.table_row_id + '" id="" class="btn btn-primary task-down"> <i class="icon-arrow-down11"></i>Track down </span>'
                            + '</div>'
                            + '</div>'
                            + '</div>'
                            +  '<div class="ffffff">'
                            + '</div>'
                            + '</div>';
                    })

                    obj.closest('.wrap').find('.ffffff').html(html2)
                }

            })
        })
    })
</script>