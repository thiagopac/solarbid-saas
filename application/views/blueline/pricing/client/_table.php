<?php
    $attributes = ['class' => '', 'id' => 'table_form'];
    echo form_open_multipart($form_action, $attributes);
?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_start');?>
                </label>
                <input class="form-control datepicker" name="start" id="start" type="text" value="<?php if(isset($pricing_table)){echo ($pricing_table->start)->format('Y/m/d');} ?>" required/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_end');?>
                </label>
                <input class="form-control datepicker-linked" name="end" id="end" type="text" value="<?php if(isset($pricing_table)){echo ($pricing_table->end)->format('Y/m/d');} ?>" required/>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>