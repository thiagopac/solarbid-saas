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
        <label for="modules_arr">
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
        <label for="inverters_arr">
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

        echo form_dropdown('inverters_arr[]', $options, $selected_inverters, 'style="width:100%" class="chosen-select" data-placeholder="'.$this->lang->line('application_select_inverters').'" multiple id="inverters_arr" tabindex="3"');
        ?>
    </div>

    <div class="form-group">
        <label for="payment_conditions">
            <?=$this->lang->line('application_payment_conditions'); ?> *
        </label>
        <?php $options = [
            'own_installment' => $this->lang->line('application_own_installment'),
            'direct_billing_and_own_installment' => $this->lang->line('application_direct_billing_and_own_installment')
        ]; ?>

        <?php

        echo form_dropdown('payment_conditions', $options, $proposal->payment_conditions, 'style="width:100%" class="chosen-select" id="payment_conditions" '); ?>
    </div>

    <div class="form-group" id="div_direct_billing_percentage">
        <label for="direct_billing_percentage">
            <?=$this->lang->line('application_direct_billing_percentage');?> *
        </label>
        <div class="input-group">
            <div class="input-group-addon">
                %
            </div>
            <input id="direct_billing_percentage" maxlength="2" type="text" name="direct_billing_percentage" class="integerInput form-control" value="<?php if($proposal->direct_billing_percentage != null){echo $proposal->direct_billing_percentage;}else{echo '0';}?>" required />
        </div>
    </div>

    <div class="form-group" id="div_own_installment_percentage">
        <label for="own_installment_percentage">
            <?=$this->lang->line('application_own_installment_percentage');?> *
        </label>
        <div class="input-group">
            <div class="input-group-addon">
                %
            </div>
            <input id="own_installment_percentage" maxlength="3" type="text" name="own_installment_percentage" class="integerInput form-control" value="100" required />
        </div>
    </div>

    <div class="form-group" id="div_own_installment_payment_trigger">
        <label for="own_installment_payment_trigger">
            <?=$this->lang->line('application_own_installment_payment_trigger'); ?> *
        </label>
        <?php $options = [
            '' => $this->lang->line('application_select'),
            'per_month' => $this->lang->line('application_per_month'),
            'per_event' => $this->lang->line('application_per_event')
        ]; ?>

        <?php

        $disabled = 'disabled = "disabled"';

        echo form_dropdown('own_installment_payment_trigger', $options, $proposal->own_installment_payment_trigger, 'style="width:100%" class="chosen-select" id="own_installment_payment_trigger" '); ?>
    </div>

    <div class="form-group hidden" id="div_own_installment_quantity">
        <label for="own_installment_quantity">
            <?=$this->lang->line('application_own_installment_quantity'); ?> *
        </label>
        <?php $options = [
            '' => $this->lang->line('application_select'),
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13'
        ]; ?>

        <?php

        echo form_dropdown('own_installment_quantity', $options, $proposal->own_installment_quantity, 'style="width:100%" class="chosen-select" id="own_installment_quantity" '); ?>
    </div>

    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>
<script>
    $(document).ready(function(){

        $("#value").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false});

        $("#rated_power_mod").mask("#.00", {reverse: true});

        $('#send').on('click', function () {
            $('.modal').modal('hide');
        });

        $("#inverters_arr").multiselect("disable");

        set_own_installment_percentage($('#direct_billing_percentage').val());
        prepareUI();

        /* Modal Algor */

        $(function() {
            $('.integerInput').on('input', function() {
                this.value = this.value
                    .replace(/[^\d]/g, '');// numbers and decimals only
            });
        });

        $('#payment_conditions').on('change',function(e){
            prepareUI();
        });

        $('#own_installment_payment_trigger').on('change',function(e){
            prepareUI();
        });

        function set_own_installment_percentage(value){
            $('#own_installment_percentage').val(100-value);
        };

        function prepareUI(){
            var payment_condition = $('#payment_conditions option:selected').index();
            var own_installment_payment_trigger = $('#own_installment_payment_trigger option:selected').index();

            if (payment_condition == 0){
                $('#div_direct_billing_percentage').addClass('hidden');
                $('#direct_billing_percentage').val('0');
                $('#own_installment_percentage').val('100');
            } else {
                $('#div_direct_billing_percentage').removeClass('hidden');
            }

            if (own_installment_payment_trigger == 1){ //per month
                console.log(own_installment_payment_trigger);
                $('#div_own_installment_quantity label').html('<?=$this->lang->line('application_own_installment_quantity_per_month')?> *');
                $('#div_own_installment_quantity').removeClass('hidden');
            }else if (own_installment_payment_trigger == 2){
                console.log(own_installment_payment_trigger);
                $('#div_own_installment_quantity label').html('<?=$this->lang->line('application_own_installment_quantity_per_event')?> *');
                $('#div_own_installment_quantity').removeClass('hidden');
            }
        };

        $('#direct_billing_percentage').on('change paste',function(e){
            set_own_installment_percentage($(this).val())
        });


    });

</script>