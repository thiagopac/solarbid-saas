<?php
$attributes = array('class' => 'ajaxform', 'id' => '_proposal', 'data-reload' => 'proposals');
echo form_open($form_action, $attributes);
?>

<?php if(isset($proposal)){ ?>
    <input id="proposal_id" type="hidden" name="proposal_id" value="<?=$proposal_id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
    <input id="view" type="hidden" name="view" value="true" />
<?php } ?>
    <div class="form-group">
        <label for="value">
            <?=$this->lang->line('application_value');?> *</label>
        <div class="input-group">
            <div class="input-group-addon">
                <?=$core_settings->money_symbol;?>
            </div>
            <input id="value" type="text" name="value" class="form-control" value="<?php if(isset($proposal)){echo display_money(sprintf('%01.2f',$proposal->value));}?>" required />
        </div>
    </div>

    <div class="form-group">
        <label for="rated_power_mod">
            <?=$this->lang->line('application_rated_power');?> *
        </label>
        <div class="input-group">
            <div class="input-group-addon">
                <?=$core_settings->rated_power_measurement;?>
            </div>
            <input id="rated_power_mod" type="text" name="rated_power_mod" class="form-control" value="<?php if(isset($proposal)){echo display_money(sprintf('%01.2f',$proposal->rated_power_mod));}?>" required />
        </div>
    </div>

    <div class="form-group">
        <label for="delivery_time">
            <?=$this->lang->line('application_delivery_time');?> *
        </label>
        <div class="input-group">
            <input id="delivery_time" type="number" name="delivery_time" class="form-control" value="<?php if(isset($proposal)){echo $proposal->delivery_time;}?>" required />
        </div>
    </div>

    <div class="form-group">
        <label for="tags">
            <?=$this->lang->line('application_module_manufacturers');?> *
        </label>
        <?php
        $options = array();
        $selected_modules = array();

        foreach ($modules as $value):
            $options[$value] = $value;
        endforeach;

        if(isset($proposal)){}else{$module = "";}

        $proposal_modules = explode(',', $proposal->module_brands);

        foreach ($proposal_modules as $module):
            $selected_modules[$module] = $module;
        endforeach;

        echo form_dropdown('modules_arr[]', $options, $selected_modules, 'style="width:100%" class="chosen-select" data-placeholder="'.$this->lang->line('application_select_modules').'" multiple tabindex="3"');
        ?>
    </div>

    <div class="form-group">
        <label for="tags">
            <?=$this->lang->line('application_inverter_manufacturers');?> *
        </label>
        <?php
        $options = array();
        $selected_inverters = array();

        foreach ($inverters as $value):
            $options[$value] = $value;
        endforeach;

        if(isset($proposal)){}else{$inverter = "";}

        $proposal_inverters = explode(',', $proposal->inverter_brands);

        foreach ($proposal_inverters as $inverter):
            $selected_inverters[$inverter] = $inverter;
        endforeach;

        echo form_dropdown('inverters_arr[]', $options, $selected_inverters, 'style="width:100%" class="chosen-select" data-placeholder="'.$this->lang->line('application_select_inverters').'" multiple tabindex="3"');
        ?>
    </div>

    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>
<script>
    $(document).ready(function(){

        $('#send').on('click', function () {
            $('.modal').modal('hide');
        })

        $("#value").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false});

        $("#rated_power_mod").mask("#.00", {reverse: true});

    });

</script>