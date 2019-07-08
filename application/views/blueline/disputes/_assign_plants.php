<?php
$attributes = array('class' => '', 'id' => '_assign_plants');
echo form_open($form_action, $attributes);
if(isset($dispute)){ ?>
    <input id="id" type="hidden" name="id" value="<?php echo $dispute->id; ?>" />
<?php } ?>

    <div class="form-group">
        <label for="plants_ids">
            <?=$this->lang->line('application_plants');?>
        </label>
        <?php
        $options = array();
        $plant = array();

        foreach ($plants as $value):
            $options[$value->id] = $this->lang->line('application_plant')." ".$value->id." (".DisputeObjectHasPlant::plantNickname($value->id).")"." - "."[".$value->compensate_consumn." ".$core_settings->consumn_power_measurement."] ".$value->minimum_power_pvs." ".$core_settings->rated_power_measurement;
        endforeach;

        if(isset($dispute)){}else{$plant = "";}

        $disabled = ''; //$this->user->admin == 0 ? 'disabled' : '';

        $label = $this->lang->line('application_select_plants');

        echo form_dropdown('plants_ids[]', $options, $dispute_plants, "style='width:100%' class='chosen-select' $disabled data-placeholder='$label' multiple tabindex='3'");
        ?>
    </div>

    <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>