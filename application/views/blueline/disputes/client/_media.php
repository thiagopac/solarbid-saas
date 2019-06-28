<div class="form-group">
    <div class="subcont preview">
        <div align="center">
            <?php if(!empty($media)) { ?>
                <img width="100%" src="<?=base_url()?>files/media/<?=$media->savename;?>">
            <?php }else{ ?>
                <img width="80" src="<?=base_url()?>files/media/no-photo.jpg" />
                <h2><?=$this->lang->line('application_plant_has_no_area_file')?></h2>
            <?php } ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
</div>