<div class="form-group">
    <label>Clique na imagem desejada para copiar seu endereço</label>
    <div class="subcont preview">
        <div align="center" style="height: 70vh; overflow-y: auto;">
            <?php foreach ($files as $file) : ?>
                <a href="<?=base_url()?>files/media/blog/<?=$file?>" style="padding: 10px" class="ajax-silent image_link"><img width="300" height="auto" src=<?=base_url()?>files/media/blog/<?=$file?>"></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn" id="close_button" name="close_button" data-dismiss="modal">
        <?=$this->lang->line('application_close');?>
    </a>
</div>
<script>
    $(document).ready(function(){
        $(".image_link").click(function () {
            const addressValue = $(this).attr("href");
            navigator.clipboard.writeText(addressValue).then(function () {
                $('#close_button').trigger('click');
            }, function () {
                $('#close_button').trigger('click');
            });

        })
    });
</script>