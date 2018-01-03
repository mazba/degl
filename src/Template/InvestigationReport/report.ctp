<div class="col-md-12" style="margin-top: 20px; padding: 5px; border: 1px solid #eee">
    <?php
        foreach($project_images as $project_image)
        {
            ?>
            <div class="block col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <img style="width: 100%; height: 336px;" src="<?= $this->request->webroot.'api/images/'.$project_image['image_path']; ?>" alt=""/>
                        </div>
                        <div class="col-md-6">
                            <div style="width:447px; height: 336px;" class="map" data-lat="<?= $project_image['latitude'] ?>" data-lon="<?= $project_image['longitude'] ?>"></div>
                        </div>
                    </div>
                    <div class="section-details text-center container-fluid">
                        <div class="row">
                          <div class="col-xs-3">
                            <?= $project_image['image_caption'] ? $project_image['image_caption'] : "&nbsp"  ?> <span><?= __('Picture Caption'); ?></span>
                          </div>
                            <div class="col-xs-3">
                                <?= date('h:i:s A',$project_image['created_date']) ?> <span><?= __('Picture Capture Time'); ?></span>
                            </div>
                            <div class="col-xs-3">
                                <?= date('d/m/Y',$project_image['created_date']) ?> <span><?= __('Picture Capture Date'); ?></span>
                            </div>
                            <div class="col-xs-3">
                                <img style="width: 40px;height: 40px" src="<?= $this->request->webroot; ?>img/<?= $project_image['users']['picture'] ?>" alt=""/>
                                <?= $project_image['users']['name_bn'] ?> <span><?= __('Picture Captured By'); ?></span>
                            </div>
                        </div>
                    </div>
            </div>
            <?php
        }
        foreach($project_videos as $project_video)
        {
            ?>
            <div class="block col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <video width="100%" height="336" controls="controls">
                                <source src="<?= $this->request->webroot.'api/videos/'.$project_video['video_path']; ?>" type="video/mp4">
                            </video>

                        </div>
                        <div class="col-md-6">
                            <div style="width:447px; height: 336px;" class="map" data-lat="<?= $project_video['latitude'] ?>" data-lon="<?= $project_video['longitude'] ?>"></div>
                        </div>
                    </div>
                    <div class="section-details text-center container-fluid">
                        <div class="row">
                          <div class="col-xs-3">
                            <?= $project_video['video_caption'] ? $project_video['video_caption'] : "&nbsp"  ?> <span><?= __('Video Caption'); ?></span>
                          </div>
                          <div class="col-xs-3">
                                <?= date('h:i:s A',$project_video['created_date']) ?> <span><?= __('Video Capture Time'); ?></span>
                            </div>
                            <div class="col-xs-3">
                                <?= date('d/m/Y',$project_video['created_date']) ?> <span>Video Capture Date</span>
                            </div>
                            <div class="col-xs-3">
                                <img style="width: 40px;height: 40px" src="<?= $this->request->webroot; ?>img/<?= $project_video['users']['picture'] ?>" alt=""/>
                                <?= $project_video['users']['name_bn'] ?> <span><?= __('Video Captured By'); ?></span>
                            </div>
                        </div>
                    </div>
            </div>
            <?php
        }
    ?>
</div>

<script>
        $('.map').each(function(index, Element){
            var latitude = parseFloat($(this).data('lat'));
            var longitude = parseFloat($(this).data('lon'));
            var latlng = new google.maps.LatLng(latitude,longitude);
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
                title:"The picture/video was taken here"
            });
        });

</script>