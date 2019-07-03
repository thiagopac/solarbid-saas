<?php
$attributes = array('class' => 'ajaxform', 'id' => '_participate', 'data-reload' => 'proposals');
echo form_open($form_action, $attributes);
?>

<?php if(isset($dispute)){ ?>
    <input id="id" type="hidden" name="id" value="<?=$dispute->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
    <input id="view" type="hidden" name="view" value="true" />
<?php } ?>
    <div class="form-group">
        <div style="text-align: center;"><?=$this->lang->line('application_dispute_confirm_participate'.$again)?></div>
    </div>


    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_sure');?>" />
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
