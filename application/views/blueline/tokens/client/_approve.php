<?php
    $attributes = ['class' => '', 'id' => '_approve'];
    echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <input type="hidden" id="code" name="code" value="<?=$flow->code?>">
        <label style="text-transform: none">
            <?=$this->lang->line('application_approve_project_are_you_sure');?>
        </label>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="<?=$this->lang->line('application_approve_yes_sure');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_cancel');?>
        </a>
    </div>
<?php echo form_close(); ?>