
    <div class="col-sm-12">
    <?php if (array_key_exists(0, $project_images) || array_key_exists(0, $project_videos)) { ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title"><i class="icon-table2"></i><?= 'Investigation Details' ?></h6>
                    </div>
                    <div class="panel-body">
                        <?php if (array_key_exists(0, $project_images)) { ?>
                            <table class="table table-striped table-responsive table-hover">
                                <tr>
                                    <td width="25%">Image</td>
                                    <td width="35%">Location</td>
                                    <td width="10%">Capture Time</td>
                                    <td width="15%">Capture Date</td>
                                    <td width="15%">Capture By</td>
                                </tr>

                                <?php
                                foreach ($project_images as $project_image) {
                                    ?>
                                    <tr>
                                        <td width="25%"><img style=" height: 100px;"
                                                             src="<?= $this->request->webroot . 'api/images/' . $project_image['image_path']; ?>"
                                                             alt=""/>
                                        </td>

                                        <td width="35%">
                                            <div style=" height: 100px;" class="map"
                                                 data-lat="<?= $project_image['latitude'] ?>"
                                                 data-lon="<?= $project_image['longitude'] ?>">

                                            </div>

                                        </td>
                                        <td>
                                            <?= date('h:i:s A', $project_image['created_date']) ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', $project_image['created_date']) ?>

                                        </td>
                                        <td>
                                            <?= $project_image['users']['name_bn'] ?>

                                        </td>

                                    </tr>

                                    <?php
                                } ?>

                            </table>
                            <br/>
                            <hr/>
                            <?php
                        }
                        if (isset($project_videos)) { ?>
                            <table class="table table-striped table-responsive table-hover">
                                <tr>
                                    <td width="25%">Video</td>
                                    <td width="35%">Location</td>
                                    <td width="10%">Capture Time</td>
                                    <td width="15%">Capture Date</td>
                                    <td width="15%">Capture By</td>
                                </tr>

                                <?php foreach ($project_videos as $project_video) { ?>
                                    <tr>
                                        <td>
                                            <video width="100%" height="100" controls="controls">
                                                <source
                                                    src="<?= $this->request->webroot . 'api/videos/' . $project_video['video_path']; ?>"
                                                    type="video/mp4">
                                            </video>
                                        </td>
                                        <td>
                                            <div style="height: 100px;" class="map"
                                                 data-lat="<?= $project_video['latitude'] ?>"
                                                 data-lon="<?= $project_video['longitude'] ?>"></div>
                                        </td>
                                        <td>
                                            <?= date('h:i:s A', $project_video['created_date']) ?>
                                        </td>

                                        <td><?= date('d/m/Y', $project_video['created_date']) ?> </td>
                                        <td>    <?= $project_video['users']['name_bn'] ?> </td>

                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }else{ ?>

    <p>No Picture And Video Found </p>
    <?php }?>
</div>

<script>
    $('.map').each(function (index, Element) {
        var latitude = parseFloat($(this).data('lat'));
        var longitude = parseFloat($(this).data('lon'));
        var latlng = new google.maps.LatLng(latitude, longitude);
        var myOptions =
        {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        var map = new google.maps.Map(Element, myOptions);

        var myMarker = new google.maps.Marker(
            {
                position: latlng,
                map: map,
                labelClass: "labels", // the CSS class for the label
                title: "The picture/video was taken here"
            });
    });

</script>