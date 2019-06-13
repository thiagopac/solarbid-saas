<?php
$attributes = array('class' => 'dynamic-form', 'id' => '_plant', 'data-reload' => 'plants');
echo form_open($form_action, $attributes);
?>

<?php if(isset($plant)) { ?>
    <input id="id" type="hidden" name="id" value="<?=$plant->id;?>" />
<?php } ?>

<?php if(isset($view)){ ?>
    <input id="view" type="hidden" name="view" value="true" />
<?php } ?>
    <div class="form-group">
        <label for="global_horizontal_irradiance">
            <?=$this->lang->line('application_global_horizontal_irradiance');?> <?=$this->lang->line('application_ghi_year_measure');?>
        </label>
        <div class="input-group">
            <input id="global_horizontal_irradiance" type="text" inputmode="numeric" name="global_horizontal_irradiance" class="form-control" value="<?php if (isset($plant)) {
                echo $plant->global_horizontal_irradiance;
            } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="performance_ratio">
            <?=$this->lang->line('application_pr_legend');?>
        </label>
        <div class="input-group">
            <input id="performance_ratio" type="text" inputmode="numeric" name="performance_ratio" class="form-control" value="<?php if (isset($plant)) {
                echo $plant->performance_ratio;
            } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="approximate_area">
            <?=$this->lang->line('application_approximate_area');?>
        </label>
        <div class="input-group">
            <div class="input-group-addon"><?=$core_settings->area_measurement;?></div>
            <input id="approximate_area" type="number" name="approximate_area" class="form-control" value="<?php if (isset($plant)) {
                echo $plant->approximate_area;
            } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="installation_location">
            <?=$this->lang->line('application_installation_location');?>
        </label>
        <div class="input-group">
            <input id="installation_location" type="text" name="installation_location" class="form-control" value="<?php if (isset($plant)) {
                echo $plant->installation_location;
            } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="compensate_consumn">
            <?=$this->lang->line('application_compensate_consumn');?> (<?=$core_settings->consumn_power_measurement?>)
        </label>
        <div class="input-group">
            <input id="compensate_consumn" style="text-align:left !important" type="text" name="compensate_consumn" class="form-control" value="<?php if (isset($plant)) {
                echo $plant->compensate_consumn;
            } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="inactive">
            <?=$this->lang->line('application_inactive');?>
        </label>
        <?php $options = array();
        $options['no'] = $this->lang->line('application_no');
        $options['yes'] = $this->lang->line('application_yes');

        if (isset($plant) && is_object($plant)) {
            $inactive = $plant->inactive;
        }
        echo form_dropdown('inactive', $options, $inactive, 'style="width:100%" class="chosen-select"'); ?>
    </div>

    <?php

    if ($plant->global_horizontal_irradiance != null && $plant->performance_ratio != null) {
        //$average = array_sum($arrAvg) / count($arrAvg);
        $power = $plant->compensate_consumn / (0.08219178 * $plant->global_horizontal_irradiance * $plant->performance_ratio);

        $power = round($power, 2);
    }

    ?>

    <input type="hidden" id="minimum_power_pvs" name="minimum_power_pvs" value="<?=$power?>"/>

    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>

<script>
    $(document).ready(function(){

        $("#global_horizontal_irradiance").mask("9999", {reverse: false});
        $("#performance_ratio").mask("0.00", {reverse: false});
        // $("#compensate_consumn").mask("000000.00", {reverse: true});

        $("#compensate_consumn").inputmask("decimal", {
            digits: 2,
            digitsOptional: false,
            integerDigits: 5,
            radixPoint: ".",
            autoGroup: false,
            allowPlus: false,
            allowMinus: false,
            clearMaskOnLostFocus: false,
            removeMaskOnSubmit: false,
            autoUnmask: true,
            rightAlign: false
        });

        $("#_plant").submit(function( event ) {
            document.getElementById("minimum_power_pvs").value = parseFloat(document.getElementById("compensate_consumn").value / (0.08219178082 * document.getElementById("global_horizontal_irradiance").value * document.getElementById("performance_ratio").value)).toFixed(2);
        });

    });
</script>

