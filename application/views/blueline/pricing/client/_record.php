<?php

    $label_power = '';

    if ($pricing_field->power_top < 1000) {
        $label_power = $this->lang->line('application_from')." ".$pricing_field->power_bottom."".$core_settings->rated_power_measurement." ".$this->lang->line('application_until')." ".$pricing_field->power_top."".$core_settings->rated_power_measurement;
    }else{
        $label_power = $this->lang->line('application_from_number')." ".$pricing_field->power_bottom."".$core_settings->rated_power_measurement;
    }

    $label_distance = '';

    if ($pricing_field->distance_top < 1000) {
        $label_distance = $this->lang->line('application_from')." ".$pricing_field->distance_bottom."km ".$this->lang->line('application_until')." ".$pricing_field->distance_top."km";
    }else{
        $label_distance = $this->lang->line('application_from_number')." ".$pricing_field->distance_bottom."km";
    }

    $label_structure_types = '';
    if($pricing_record_structure_types === "1,2,3"){
        $label_structure_types = $this->lang->line('application_metallic').', '.$this->lang->line('application_fiber_cement').', '.$this->lang->line('application_ceramic');
    }else{
        $label_structure_types = $this->lang->line('application_slab').', '.$this->lang->line('application_soil');
    }

?>

<?php
    $attributes = ['class' => '', 'id' => 'record_form'];
    echo form_open_multipart($form_action, $attributes);
?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group read-only">
                <label>
                    <?=$this->lang->line('application_power_of_plant');?>
                </label>
                <input type="text" value="<?=$label_power;?>" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group read-only">
                <label>
                    <?=$this->lang->line('application_distance_installation_location');?>
                </label>
                <input type="text" value="<?=$label_distance;?>" class="form-control" readonly>
            </div>
        </div>
    </div>

    <div class="form-group read-only">
        <label>
            <?=$this->lang->line('application_structure_types');?>
        </label>
        <input type="text" value="<?=$label_structure_types;?>" class="form-control" readonly/>
    </div>
    <div class="form-group">
        <label for="value">
            <?=$this->lang->line('application_Wp_value');?> *
        </label>
        <div class="input-group">
            <div class="input-group-addon">
                <?=$core_settings->money_symbol?>/Wp
            </div>
            <input id="value" type="text" name="value" class="required form-control"  value="<?php if(isset($pricing_record)){echo display_money(sprintf('%01.2f',$pricing_record->value));}?>"  required/>
        </div>
    </div>
    <div class="help-block" style="margin-top: -20px;">
        <small><?=$this->lang->line('application_wp_value_help')?></small>
    </div>
    <div class="form-group">
        <label for="delivery_time_days">
            <?=$this->lang->line('application_delivery_time_days');?> *
        </label>
        <input id="delivery_time_days" type="text" name="delivery_time_days" onkeypress="return event.keyCode >= 48 && event.keyCode <= 57" class="required form-control"  value="<?php if(isset($pricing_record)){echo $pricing_record->delivery_time_days;}?>"  required/>
    </div>
    <div class="help-block" style="margin-top: -20px;">
        <small><?=$this->lang->line('application_delivery_time_days_help')?></small>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>

<script>
    $(document).ready(function(){
        $("#value").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
    });
</script>