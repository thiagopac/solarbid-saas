<?php
$attributes = array('class' => 'ajaxform', 'id' => '_send', 'data-reload' => 'proposals');
echo form_open($form_action, $attributes);
?>

<?php if($dispute_id != null && $bid_id != null){ ?>
    <input id="dispute_id" type="hidden" name="dispute_id" value="<?=$dispute_id;?>" />
    <input id="bid_id" type="hidden" name="bid_id" value="<?=$bid_id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
    <input id="view" type="hidden" name="view" value="true" />
<?php } ?>
    <div class="form-group">
        <div style="text-align: center;"><?=$this->lang->line('application_bid_confirm_send')?></div>
    </div>


    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-success button-loader" data value="<?=$this->lang->line('application_sure');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>

<script>
    $(document).ready(function(){

        $('#send').on('click', function () {
            $('.modal').modal('hide');
        })

    });

</script>

