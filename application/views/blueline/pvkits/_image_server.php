<div class="form-group">
    <label>Clique na imagem desejada para utilizá-la no Kit</label>
    <div class="subcont preview">
        <div align="center">
            <?php foreach ($files as $file) : ?>
                <a href="<?=base_url()?>pvkits/save_image_server/<?=$pvkit_id?>/<?=$file?>" class="ajax-silent image_link"><img width="300" height="auto" src="./files/media/pvkits/<?=$file ?>"></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a href="<?=base_url()?>pvkits/update/<?=$pvkit_id;?>" class="btn btn-primary pull-left" id="back_button" data-toggle="mainmodal">
        <?=$this->lang->line('application_back');?>
    </a>
    <a class="btn" data-dismiss="modal">
        <?=$this->lang->line('application_close');?>
    </a>
</div>
<script>
    $(document).ready(function(){
        $(".image_link").click(function () {
            $('#back_button').trigger('click');
        })
    });
</script>