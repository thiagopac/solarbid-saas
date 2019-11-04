<?php
    $attributes = ['class' => '', 'id' => 'activate_form'];
    echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <input type="hidden" id="pricing_table_id" name="pricing_table_id" value="<?=$pricing_table->id?>">
        <label>
            <?php if($pricing_table->active) : ?>
                <?=$this->lang->line('application_deactivate_pricing_table_desc');?>
            <?php else : ?>
                <?=$this->lang->line('application_activate_pricing_table_desc');?>
            <?php endif; ?>
        </label>
    </div>
    <div class="modal-footer">
        <?php if($pricing_table->active) : ?>
            <input type="submit" class="btn btn-danger" value="<?=$this->lang->line('application_deactivate');?>"/>
        <?php else : ?>
            <input type="submit" class="btn btn-success" value="<?=$this->lang->line('application_activate');?>"/>
        <?php endif; ?>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_cancel');?>
        </a>
    </div>
<?php echo form_close(); ?>