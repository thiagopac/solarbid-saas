<?php
$attributes = array('class' => 'dynamic-form', 'id' => '_bill', 'data-reload' => 'bills');
echo form_open($form_action, $attributes);
?>

<?php if(isset($bill)) { ?>
    <input id="id" type="hidden" name="id" value="<?=$bill->id;?>" />
<?php } ?>

<?php if(isset($view)){ ?>
    <input id="view" type="hidden" name="view" value="true" />
<?php } ?>
    <div class="form-group">
        <label for="type">
            <?=$this->lang->line('application_type');?>
        </label>
        <?php $options = array();
        $options['generator'] = $this->lang->line('application_generator');
        $options['receiver'] = $this->lang->line('application_receiver');

        if (isset($bill) && is_object($bill)) {
            $type = $bill->type;
        }
        echo form_dropdown('type', $options, $type, 'style="width:100%" class="chosen-select"'); ?>
    </div>
    <div class="form-group">
        <label for="proposal_value">
            <?=$this->lang->line('application_average');?>
        </label>
        <?php if(!empty($core_settings->consumn_power_measurement)){ ?>
            <div class="input-group">
                <div class="input-group-addon"><?=$core_settings->consumn_power_measurement;?></div>
                <input id="average" type="text" name="average" class="form-control" value="<?php if (isset($bill)) {
                    echo $bill->average;
                } ?>" />
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="type">
            <?=$this->lang->line('application_number_of_phases');?>
        </label>
        <?php $options = array();
        $options['single_phase'] = $this->lang->line('application_single_phase');
        $options['two_phase'] = $this->lang->line('application_two_phase');
        $options['three_phase'] = $this->lang->line('application_three_phase');

        if (isset($bill) && is_object($bill)) {
            $number_of_phases = $bill->number_of_phases;
        }
        echo form_dropdown('number_of_phases', $options, $number_of_phases, 'style="width:100%" class="chosen-select"'); ?>
    </div>
    <div class="form-group">
        <label for="proposal_value">
            <?=$this->lang->line('application_tariff');?>
        </label>
        <?php if(!empty($core_settings->money_symbol)){ ?>
            <div class="input-group">
                <div class="input-group-addon"><?=$core_settings->money_symbol;?></div>
                <input id="tariff" type="text" name="tariff" class="form-control" value="<?php if (isset($bill)) {
                    echo $bill->tariff;
                } ?>" />
            </div>
        <?php } ?>
    </div>
    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>

<script>
    $(document).ready(function(){

        $("#tariff").mask("0,00", {reverse: true});

    });
</script>

