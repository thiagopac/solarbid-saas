<link href="<?=base_url()?>assets/blueline/css/plugins/video-js.css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url()?>assets/blueline/js/plugins/pdfobject.js"></script>

<div class="row">
    <div class="col-xs-12 col-sm-3">
        <div class="table-head">
            <?=$this->lang->line('application_media_details');?>
        </div>
        <div class="subcont">
            <ul class="details">
                <li><span><?=$this->lang->line('application_filename');?>:</span>
                    <?=$media->filename;?>
                </li>
                <li><span><?=$this->lang->line('application_description');?>:</span>
                    <?=$media->description;?>
                </li>
                <li><span><?=$this->lang->line('application_uploaded_on');?>:</span>
                    <?php $unix = human_to_unix($media->date); echo date($core_settings->date_format, $unix); ?>
                </li>
                <li><a href="<?=base_url()?>disputeobjects/download/<?=$media->id;?>" class="btn btn-xs btn-success"><i class="icon-download icon-white"></i> <?=$this->lang->line('application_download');?></a></li>
            </ul>
            <br clear="both">

            <a class="btn btn-primary" href="<?=base_url()?>disputeobjects/view/<?=$media->dispute_object_id?>"><i class="icon dripicons-arrow-thin-left"></i> <?=$this->lang->line('application_back');?></a>
            <br clear="both">
        </div>
    </div>

    <div class="col-xs-12 col-sm-9">
        <div class="row">
            <div class="col-md-12">
                <?php
                $type = explode('/', $media->type);
                switch ($type[0]) {
                    case "image": ?>
                        <div class="table-head">
                            <?=$this->lang->line('application_media_preview');?>
                        </div>
                        <div class="subcont preview">
                            <div align="center">
                                <img src="<?=base_url()?>files/media/<?=$media->savename;?>">
                            </div>
                        </div>
                        <?php
                        break;
                    case "application":
                        if ($type[1] == "ogg" || $type[1] == "mp4" || $type[1]  == "webm") {
                            ?>
                            <div class="table-head">
                                <?=$this->lang->line('application_media_preview'); ?>
                            </div>
                            <div class="subcont preview">
                                <video id="video" class="video-js vjs-default-skin" controls preload="auto" width="100%" height="350" data-setup="{}">
                                    <source src="<?=base_url()?>files/media/<?=$media->savename; ?>" type='video/<?=$type[1]; ?>'>
                                </video>
                            </div>
                            <?php
                        }

                        if ($type[1] == "pdf") {
                            ?>
                            <div class="table-head">
                                <?=$this->lang->line('application_media_preview'); ?>
                            </div>
                            <div class="subcont preview">
                                <script type='text/javascript'>
                                    function embedPDF() {

                                        var myPDF = new PDFObject({

                                            url: '<?=base_url()?>/files/media/<?=$media->savename; ?>'

                                        }).embed('pdf-viewer');

                                    }

                                    window.onload = embedPDF;
                                </script>
                                <div id="pdf-viewer" style="height:600px; width:100%"></div>

                            </div>
                            <?php
                        }

                        break;
                    case "video":
                        ?>
                        <div class="table-head">
                            <?=$this->lang->line('application_media_preview');?>
                        </div>
                        <div class="subcont preview">
                            <video id="video" class="video-js vjs-default-skin" controls preload="auto" width="100%" height="350" data-setup="{}">
                                <source src="<?=base_url()?>files/media/<?=$media->savename;?>" type='video/<?=$type[1];?>'>
                            </video>
                        </div>
                        <?php

                        break;
                    case "audio":
                        ?>
                        <div class="table-head">
                            <?=$this->lang->line('application_media_preview');?>
                        </div>
                        <div class="subcont preview">
                            <audio controls>
                                <source src="<?=base_url()?>files/media/<?=$media->savename;?>" type="audio/mpeg">
                            </audio>
                        </div>

                        <?php

                        break;

                } ?>
                <br>
            </div>

        </div>

    </div>
</div>