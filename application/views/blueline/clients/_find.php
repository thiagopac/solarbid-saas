<?php
    $attributes = ['class' => '', 'id' => '_find'];
    echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_registered_number');?> *
        </label>
        <input id="registered_number" type="text" name="registered_number" class="required form-control"  value=""  required/>
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_find');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function() {

        $('#registered_number').mask('00.000.000/0000-00', {reverse: false})

    });
</script>