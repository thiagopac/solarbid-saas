<?php
    $attributes = ['class' => '', 'id' => 'table_form'];
    echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-header">
        <?=$this->lang->line('application_select_validity_range_and_type')?>
    </div>
    <div class="row">
        <div class="col-md-6">

            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_start');?>
                </label>
                <input class="form-control datepicker" name="start" id="start" type="text" value="<?php if($pricing_table->start != null){echo ($pricing_table->start)->format('Y/m/d');} ?>" required/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_end');?>
                </label>
                <input class="form-control datepicker-linked" name="end" id="end" type="text" value="<?php if($pricing_table->end != null){echo ($pricing_table->end)->format('Y/m/d');} ?>" />
            </div>
        </div>
    </div>

    <?php if($pricing_schemas != null) : ?>
    <div class="form-group">
        <label for="schema_id">
            <?=$this->lang->line('application_select_pricing_schema');?>
        </label>
        <?php
        $options = array();
//        $pricing_schemas = array();

        //Add label as first item
//        $options[null] = $this->lang->line('application_select');

        foreach ($pricing_schemas as $value):
            $options[$value->id] = $value->name;
        endforeach;

        $label = $this->lang->line('application_select');

        echo form_dropdown('schema_id', $options, null, "style='width:100%' required class='chosen-select' data-placeholder='$label'");
        ?>
    </div>
    <?php endif; ?>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>