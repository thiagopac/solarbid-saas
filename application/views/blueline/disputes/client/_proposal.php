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
            <?=$this->lang->line('application_module_manufacturers');?> * <small>(<?=$this->lang->line('application_choose_max_brands');?>)</small>
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
            <?=$this->lang->line('application_inverter_manufacturers');?> * <small>(<?=$this->lang->line('application_choose_max_brands');?>)</small>
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
            <input id="own_installment_percentage" maxlength="3" type="text" name="own_installment_percentage" class="integerInput form-control" value="<?php if($proposal->own_installment_percentage != null){echo $proposal->own_installment_percentage;}else{echo '0';}?>" required />
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

//        $disabled = 'disabled = "disabled"';

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

    <div id="dynamic_months">

        <!-- month 1 -->
        <div class="form-group hidden" id="div_month_1">
            <label>
                <?=$this->lang->line('application_month');?> 1 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_1_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 0){echo $months[0];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 2 -->
        <div class="form-group hidden" id="div_month_2">
            <label>
                <?=$this->lang->line('application_month');?> 2 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_2_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 1){echo $months[1];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 3 -->
        <div class="form-group hidden" id="div_month_3">
            <label>
                <?=$this->lang->line('application_month');?> 3 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_3_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 2){echo $months[2];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 4 -->
        <div class="form-group hidden" id="div_month_4">
            <label>
                <?=$this->lang->line('application_month');?> 4 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_4_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 3){echo $months[3];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 5 -->
        <div class="form-group hidden" id="div_month_5">
            <label>
                <?=$this->lang->line('application_month');?> 5 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_5_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 4){echo $months[4];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 6 -->
        <div class="form-group hidden" id="div_month_6">
            <label>
                <?=$this->lang->line('application_month');?> 6 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_6_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 5){echo $months[5];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 7 -->
        <div class="form-group hidden" id="div_month_7">
            <label>
                <?=$this->lang->line('application_month');?> 7 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_7_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 6){echo $months[6];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 8 -->
        <div class="form-group hidden" id="div_month_8">
            <label>
                <?=$this->lang->line('application_month');?> 8 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_8_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 7){echo $months[7];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 9 -->
        <div class="form-group hidden" id="div_month_9">
            <label>
                <?=$this->lang->line('application_month');?> 9 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_9_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 8){echo $months[8];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 10 -->
        <div class="form-group hidden" id="div_month_10">
            <label for="month_10">
                <?=$this->lang->line('application_month');?> 10 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_10_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 9){echo $months[9];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 11 -->
        <div class="form-group hidden" id="div_month_11">
            <label for="month_11">
                <?=$this->lang->line('application_month');?> 11 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_11_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 10){echo $months[10];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 12 -->
        <div class="form-group hidden" id="div_month_12">
            <label for="month_12">
                <?=$this->lang->line('application_month');?> 12 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_12_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 11){echo $months[11];}else{echo '0';}?>" required />
            </div>
        </div>

        <!-- month 13 -->
        <div class="form-group hidden" id="div_month_13">
            <label for="month_13">
                <?=$this->lang->line('application_month');?> 13 *
            </label>
            <div class="input-group">
                <div class="input-group-addon">
                    %
                </div>
                <input id="month_13_percent" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php if(count($months) > 12){echo $months[12];}else{echo '0';}?>" required />
            </div>
        </div>

    </div>

    <div id="dynamic_events">

        <!-- event 1 -->
        <div class="row hidden" id="div_event_1">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 1 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[0], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 1 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_1_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 0){echo $event_values[0];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 2 -->
        <div class="row hidden" id="div_event_2">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 2 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[1], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 2 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_2_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 1){echo $event_values[1];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 3 -->
        <div class="row hidden" id="div_event_3">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 3 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[2], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 3 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_3_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 2){echo $event_values[2];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 4 -->
        <div class="row hidden" id="div_event_4">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 4 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[3], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 4 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_4_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 3){echo $event_values[3];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 5 -->
        <div class="row hidden" id="div_event_5">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 5 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[4], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 5 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_5_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 4){echo $event_values[4];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 6 -->
        <div class="row hidden" id="div_event_6">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 6 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[5], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 6 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_6_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 5){echo $event_values[5];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 7 -->
        <div class="row hidden" id="div_event_7">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 7 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[6], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 7 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_7_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 6){echo $event_values[6];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 8 -->
        <div class="row hidden" id="div_event_8">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 8 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[7], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 8 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_8_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 7){echo $event_values[7];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 9 -->
        <div class="row hidden" id="div_event_9">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 9 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[8], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 9 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_9_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 8){echo $event_values[8];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 10 -->
        <div class="row hidden" id="div_event_10">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 10 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[9], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 10 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_10_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 9){echo $event_values[9];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 11 -->
        <div class="row hidden" id="div_event_11">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 11 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[10], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 11 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_11_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 10){echo $event_values[10];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 12 -->
        <div class="row hidden" id="div_event_12">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 12 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[11], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 12 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_12_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 11){echo $event_values[11];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

        <!-- event 13 -->
        <div class="row hidden" id="div_event_13">
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_event'); ?> 13 *
                    </label>
                    <?php
                    $options = array();

                    $options[null] = $this->lang->line('application_select_event');

                    foreach ($payment_events as $value):
                        $options[$value->name] = $this->lang->line("application_event_$value->name");
                    endforeach;

                    echo form_dropdown('event[]', $options, $payment_events_selected[12], 'style="width:100%" class="chosen-select"');?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_percentage_event');?> 13 *
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            %
                        </div>
                        <input id="event_13_percent" maxlength="2" type="text" name="event_percent[]" class="integerInput form-control" value="<?php if(count($event_values) > 12){echo $event_values[12];}else{echo '0';}?>" required />
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>

<!--<div class="form-group hidden" id="div_dynamic_field_month">
    <label for="direct_billing_percentage">
        <?/*=$this->lang->line('application_month');*/?> <span class="month_number">1</span> *
    </label>
    <div class="input-group">
        <div class="input-group-addon">
            %
        </div>
        <input id="dynamic_field_month" maxlength="2" type="text" name="month_percent[]" class="integerInput form-control" value="<?php /*if(count($months) > 0){echo $months[0];}else{echo '0';}*/?>" required />
    </div>
</div>-->

<script>
    $(document).ready(function(){

        $("#value").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false});

        $("#rated_power_mod").mask("#.00", {reverse: true});

        $('#send').on('click', function () {
            $('.modal').modal('hide');
        });

        //set_own_installment_percentage($('#direct_billing_percentage').val());
        prepareUI();

        /* Modal Algol */

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

        $('#own_installment_quantity').on('change',function(e){
            prepareUI();
        });

        $('#direct_billing_percentage').on('change paste',function(e){

            set_own_installment_percentage($(this).val())
        });

        function set_own_installment_percentage(value){
            $('#own_installment_percentage').val(100-value);
        };

        function prepareUI(){
            var payment_condition = $('#payment_conditions option:selected').index();
            var own_installment_payment_trigger = $('#own_installment_payment_trigger option:selected').index();
            var own_installment_quantity = $('#own_installment_quantity option:selected').index();

            if (payment_condition == 0){
                $('#div_direct_billing_percentage').addClass('hidden');
                $('#direct_billing_percentage').val('0');
                $('#own_installment_percentage').val('100');
            } else {
                $('#div_direct_billing_percentage').removeClass('hidden');
            }

            if (own_installment_payment_trigger == 1){ //per month
                $('#div_own_installment_quantity label').html('<?=$this->lang->line('application_own_installment_quantity_per_month')?> *');
                $('#div_own_installment_quantity').removeClass('hidden');
                $('#dynamic_months').removeClass('hidden');
            }else if (own_installment_payment_trigger == 2){ //per event
                $('#div_own_installment_quantity label').html('<?=$this->lang->line('application_own_installment_quantity_per_event')?> *');
                $('#div_own_installment_quantity').removeClass('hidden');
                $('#dynamic_events').removeClass('hidden');
            }


            preparePaymentFields(own_installment_quantity);
            // console.log(own_installment_quantity);

        };

        function preparePaymentFields(timesLoop){

            var elementIncrease = 0;

            console.log(timesLoop);

            $('#dynamic_months').children().addClass('hidden');
            $('#dynamic_events').children().addClass('hidden');

            if ($('#own_installment_payment_trigger option:selected').index() == 1){ //per month


                while (elementIncrease < timesLoop){

                    var field = $('#dynamic_months').find($("#div_month_"+(elementIncrease+1)));

                    $(field).removeClass('hidden');

                    if (elementIncrease % 2 == 0){
                        $(field).attr('style', 'width: 48%; display: inline-block;');
                    }else{
                        $(field).attr('style', 'width: 48%; display: inline-block; float: right;');
                    }

                    elementIncrease++;
                }
            }else if ($('#own_installment_payment_trigger option:selected').index() == 2) { //per event


                while (elementIncrease < timesLoop){

                    var field = $('#dynamic_events').find($("#div_event_"+(elementIncrease+1)));

                    $(field).removeClass('hidden');

                    elementIncrease++;
                }
            }

        };

        /*var div_dynamic_field_month = $('#div_dynamic_field_month');
        var dynamic_months = $('#dynamic_months');

        function preparePaymentFields(timesLoop){

            $(dynamic_months).empty();

            var timesLoopDecrease = timesLoop;
            var countSequencial = 1;

            while (timesLoopDecrease != 0){

                var clone_div_dynamic_field_month =  $(div_dynamic_field_month).clone(true);

                $(clone_div_dynamic_field_month).find('.month_number').html(countSequencial);
                $(clone_div_dynamic_field_month).removeClass('hidden');

                $(dynamic_months).append($(clone_div_dynamic_field_month));

                timesLoopDecrease--;
                countSequencial++;
            }
        };*/


    });

</script>