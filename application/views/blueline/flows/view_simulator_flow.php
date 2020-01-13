<style>
    @media (max-width: 767px) {
        .content-area {
            padding: 0;
        }
        .row.mainnavbar {
            margin-bottom: 0px;
            margin-right: 0px;
        }
    }
</style>
<div class="col-sm-12 col-md-12 main">

    <div class="row tile-row">

        <div class="tile-button">
            <a href="<?= base_url() ?>flows/find" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-search"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_find_flow'); ?>
                </span>
                    </h1>
                </div>
            </a>

        </div>
        <div class="tile-button">
            <a href="<?= base_url() ?>flows/list_simulator">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-stats-bars"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_simulator_flows'); ?>
                </span>
                    </h1>
                </div>
            </a>
        </div>
        <div class="tile-button">

            <a href="<?= base_url() ?>flows/list_store">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-android-cart"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_store_flows'); ?>
                </span>
                    </h1>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-xs-3 tile hidden-xs">
            <div style="width:97%; margin-top: -4px; margin-bottom: 17px; height: 80px;">
            </div>
        </div>
    </div>

    <?php
    $pv_kit =  json_decode($flow->pv_kit);
    $simulation_results =  json_decode($flow->simulation_results);
    $integrator =  json_decode($flow->integrator);
    $customer_data =  json_decode($financing_request->customer_data);
    $simulate_data =  json_decode($financing_request->simulate_data);
    $santander_simulation =  json_decode($financing_request->santander_simulation);
    ?>

    <div class="grid">
        <div class="grid__col-md-7 dashboard-header">
            <h1> <?=$this->lang->line('application_simulator_flow') ?>: <label class="badge" style="font-size: 15px; text-transform: none">#<?=$flow->code?></label> </h1> </div>
        <div class="grid__col-sm-12 grid__col-md-12 grid__col-lg-12 grid__col--bleed">
            <div class="grid grid--align-content-start">

                <div class="col-md-3">
                    <?php if(empty($flow->pv_kit)) : ?>
                        <div class="alert alert-warning"><?=$this->lang->line('application_flow_incomplete')?></div>
                    <?php endif; ?>
                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_flow'); ?></div>
                        <div class="subcont">
                            <ul class="details">
                                <li> <span> <?=$this->lang->line('application_id'); ?>: </span>
                                    <?php echo empty($flow->id) ? '-' : $flow->id; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_city'); ?> / <?=$this->lang->line('application_state'); ?>: </span>
                                    <?php echo empty($flow->city) ? '-' : $flow->city_obj->name; ?> / <?php echo empty($flow->state) ? '-' : $flow->state_obj->name; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_type'); ?> / <?=$this->lang->line('application_activity'); ?>: </span>
                                    <?php echo empty($flow->type) ? '-' : $this->lang->line("application_flow_$flow->type") ?> / <?php echo empty($flow->state) ? '-' : $flow->activity_obj->name; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_energy_dealer'); ?>: </span>
                                    <?php echo empty($flow->state) ? '-' : $flow->energy_dealer->name; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_monthly_average'); ?>: </span>
                                    <?php echo empty($flow->monthly_average) ? '-' : $core_settings->money_symbol.display_money($flow->monthly_average) ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_name'); ?>: </span>
                                    <?php echo empty($flow->name) ? '-' : $flow->name; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_email'); ?>: </span>
                                    <?php echo empty($flow->email) ? '-' : $flow->email; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_simulation_results'); ?>: </span>
                                    <?php if (empty($simulation_results)) : ?>
                                        -
                                    <?php else : ?>
                                        <small>
                                            <strong><?=$this->lang->line('application_tariff')?>:</strong> <?=$core_settings->money_symbol;?><?=display_money($simulation_results->tariff->value).' ('.$simulation_results->tariff->value.')' ?><br/>
                                            <strong><?=$this->lang->line('application_min_area')?></strong>: <?=$simulation_results->min_area ?> <?=$core_settings->area_measurement;?><br/>
                                            <strong><?=$this->lang->line('application_modules_qty')?></strong>: <?=$simulation_results->modules_qty ?><br/>
                                            <strong><?=$this->lang->line('application_payback_time')?></strong>: <?=$simulation_results->payback_time ?> <?=$this->lang->line('application_years')?><br/>
                                            <strong><?=$this->lang->line('application_annual_savings')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($simulation_results->annual_savings) ?><br/>
                                            <strong><?=$this->lang->line('application_plant_peak_power')?></strong>: <?=$simulation_results->plant_peak_power ?> <?=$core_settings->rated_power_measurement;?><br/>
                                            <strong><?=$this->lang->line('application_generator_savings')?></strong>: <?=$simulation_results->generator_savings ?>%<br/>
                                            <strong><?=$this->lang->line('application_solarbid_lowest_price')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($simulation_results->solarbid_lowest_price) ?><br/>
                                            <strong><?=$this->lang->line('application_market_average_price')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($simulation_results->market_average_price) ?><br/>
                                            <strong><?=$this->lang->line('application_anual_production')?></strong>: <?=$simulation_results->anual_production ?> <?=$core_settings->consumn_power_measurement;?>/<?=$this->lang->line('application_year')?><br/>
                                            <strong><?=$this->lang->line('application_monthly_average_production')?></strong>: <?=$simulation_results->monthly_average_production ?> <?=$core_settings->consumn_power_measurement;?>/<?=$this->lang->line('application_month')?><br/>
                                        </small>
                                    <?php endif; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_pvkit'); ?>: </span>
                                    <?php if (empty($flow->pv_kit)) : ?>
                                        -
                                    <?php else : ?>
                                    <small>
                                        <strong><?=$this->lang->line('application_id')?>:</strong> <?=$pv_kit->id ?><br/>
                                        <strong><?=$this->lang->line('application_price')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($pv_kit->price) ?><br/>
                                        <strong><?=$this->lang->line('application_freight')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($pv_kit->freight) ?><br/>
                                        <strong><?=$this->lang->line('application_insurance')?></strong>: <?=$pv_kit->insurance ?><br/>
                                        <strong><?=$this->lang->line('application_pv_power')?></strong>: <?=$pv_kit->kit_power ?> <?=$core_settings->rated_power_measurement;?><br/>
                                        <strong><?=$this->lang->line('application_modules')?></strong>: <?=$pv_kit->pv_module ?><br/>
                                        <strong><?=$this->lang->line('application_desc_module')?></strong>: <?=$pv_kit->desc_module ?><br/>
                                        <strong><?=$this->lang->line('application_inverter')?></strong>: <?=$pv_kit->pv_inverter ?><br/>
                                        <strong><?=$this->lang->line('application_desc_inverter')?></strong>: <?=$pv_kit->desc_inverter ?><br/>
                                        <strong><?=$this->lang->line('application_provider')?></strong>: <?=$pv_kit->kit_provider ?><br/>
                                        <strong><?=$this->lang->line('application_structure_type')?></strong>: <?=StructureType::find($pv_kit->structure_type_id)->name ?><br/>
                                        <strong><?=$this->lang->line('application_savings_power_month')?></strong>: <?=$pv_kit->savings_power_month ?> <?=$core_settings->consumn_power_measurement;?>/<?=$this->lang->line('application_month')?><br/>
                                    </small>
                                    <?php endif; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_integrator'); ?>: </span>
                                    <?php if (empty($flow->integrator)) : ?>
                                        -
                                    <?php else : ?>
                                        <small>
                                            <strong><?=$this->lang->line('application_id')?>:</strong> <?=$integrator->company_id ?><br/>
                                            <strong><?=$this->lang->line('application_name')?></strong>: <?=$integrator->company_name ?><br/>
                                            <strong><?=$this->lang->line('application_location')?></strong>: <?=$integrator->location ?><br/>
                                            <strong><?=$this->lang->line('application_distance')?></strong>: <?=$integrator->distance ?><br/>
                                            <strong><?=$this->lang->line('application_price')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($integrator->price) ?><br/>
                                            <strong><?=$this->lang->line('application_average_rating')?></strong>: <?=$integrator->average_rating ?> <br/>
                                            <strong><?=$this->lang->line('application_power_executed')?></strong>: <?=$integrator->power_executed ?> <?=$core_settings->rated_power_measurement;?><br/>
                                            <strong><?=$this->lang->line('application_warranty_months')?></strong>: <?=$integrator->warranty_months ?><br/>
                                            <strong><?=$this->lang->line('application_number_of_ratings')?></strong>: <?=$integrator->number_of_ratings ?><br/>
                                            <strong><?=$this->lang->line('application_delivery_time_days')?></strong>: <?=$integrator->delivery_time_days ?><br/>
                                            <strong><?=$this->lang->line('application_power_plants_installed')?></strong>: <?=$integrator->power_plants_installed ?><br/>
                                        </small>
                                    <?php endif; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_created_at'); ?>: </span>
                                    <?=empty($flow->created_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($flow->created_at))?>
                                </li>
                            </ul>
                            <br clear="all"> </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php if(empty($purchase->data)) : ?>
                        <div class="alert alert-warning"><?=$this->lang->line('application_flow_incomplete')?></div>
                    <?php endif; ?>
                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_purchase_pagarme'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">
                                <li> <span> <?=$this->lang->line('application_id'); ?>: </span>
                                    <?php echo empty($purchase->id) ? '-' : $purchase->id; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_type'); ?>: </span>
                                    <?php echo empty($purchase->type) ? '-' : $purchase->type; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_name'); ?>: </span>
                                    <?php echo empty($purchase->name) ? '-' : $purchase->name; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_value'); ?>: </span>
                                    <?php echo empty($purchase->value) ? '-' : $core_settings->money_symbol.display_money($purchase->value) ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_Status'); ?>: </span>
                                    <?php echo empty($purchase->status) ? '-' : $purchase->status; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_processor_id'); ?>: </span>
                                    <?php echo empty($purchase->processor_id) ? '-' : $purchase->processor_id; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_created_at'); ?>: </span>
                                    <?=empty($purchase->created_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($purchase->created_at))?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_updated_at'); ?>: </span>
                                    <?=empty($purchase->updated_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($purchase->updated_at))?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_transaction_data'); ?>: </span>
                                    <small><?php echo empty($purchase->data) ? '-' : '<pre id="transaction_data">'.$purchase->data.'</pre>'; ?></small>
                                </li>
                            </ul>
                            <br clear="all"> </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <?php if(empty($financing_request->simulate_data)) : ?>
                        <div class="alert alert-warning"><?=$this->lang->line('application_flow_incomplete')?></div>
                    <?php endif; ?>
                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_financing_request'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">
                                <li> <span> <?=$this->lang->line('application_id'); ?>: </span>
                                    <?php echo empty($financing_request->id) ? '-' : $financing_request->id; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_customer_data'); ?>: </span>
                                    <?php if (empty($financing_request->customer_data)) : ?>
                                        -
                                    <?php else : ?>
                                        <small>
                                            <strong><?=$this->lang->line('application_phone')?>:</strong> <?=$customer_data->mobile ?><br/>
                                            <strong><?=$this->lang->line('application_birthday')?></strong>: <?=date($core_settings->date_format, strtotime($customer_data->birthday))?><br/>
                                            <strong><?=$this->lang->line('application_document')?></strong>: <?=$customer_data->document ?><br/>
                                        </small>
                                    <?php endif; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_simulate_input'); ?>: </span>
                                    <?php if (empty($financing_request->simulate_data)) : ?>
                                        -
                                    <?php else : ?>
                                        <small>
                                            <strong><?=$this->lang->line('application_value')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($simulate_data->value) ?><br/>
                                            <strong><?=$this->lang->line('application_down_payment')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($simulate_data->down_payment) ?><br/>
                                            <strong><?=$this->lang->line('application_payment_form')?></strong>: <?=$simulate_data->payment_form == 9 ? $this->lang->line('application_payment_slip') : $this->lang->line('application_account_debit') ?><br/>
                                            <strong><?=$this->lang->line('application_installment_amount')?></strong>: <?=$simulate_data->installment_amount ?><br/>
                                        </small>
                                    <?php endif; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_simulate_response'); ?>: </span>
                                    <?php if (empty($financing_request->santander_simulation)) : ?>
                                        -
                                    <?php else : ?>
                                        <small>
                                            <strong><?=$this->lang->line('application_tc_value')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($santander_simulation->tcValue) ?><br/>
                                            <strong><?=$this->lang->line('application_payment_form')?></strong>: <?=$santander_simulation->paymentFormId == 9 ? $this->lang->line('application_payment_slip') : $this->lang->line('application_account_debit') ?><br/>
                                            <strong><?=$this->lang->line('application_released_value')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($santander_simulation->releasedValue) ?><br/>
                                            <strong><?=$this->lang->line('application_installment_value')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($santander_simulation->installmentValue) ?><br/>
                                            <strong><?=$this->lang->line('application_installment_amount')?></strong>: <?=$santander_simulation->installmentAmount ?><br/>
                                            <strong><?=$this->lang->line('application_total_financed_value')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($santander_simulation->totalFinancedValue) ?><br/>
                                            <strong><?=$this->lang->line('application_initial_installment_value')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($santander_simulation->initialInstallmentValue) ?><br/>
                                            <strong><?=$this->lang->line('application_last_installment_value')?></strong>: <?=$core_settings->money_symbol;?><?=display_money($santander_simulation->lastInstallmentValue) ?><br/>
                                        </small>
                                    <?php endif; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_created_at'); ?>: </span>
                                    <?=empty($financing_request->created_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($financing_request->created_at))?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_updated_at'); ?>: </span>
                                    <?=empty($financing_request->updated_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($financing_request->updated_at))?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_customer_accepted'); ?>: </span>
                                    <?php if ($financing_request->customer_accepted != null) : ?>

                                        <?php if ($financing_request->customer_accepted == 0) : ?>
                                            <label class="label label-important"><?=$this->lang->line('application_no')?></label>
                                        <?php else : ?>
                                            <label class="label label-success"><?=$this->lang->line('application_yes')?></label>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </li>
                            </ul>
                            <br clear="all"> </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php if(empty($installation_local->full_name)) : ?>
                        <div class="alert alert-warning"><?=$this->lang->line('application_flow_incomplete')?></div>
                    <?php endif; ?>
                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_installation_local'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">
                                <li> <span> <?=$this->lang->line('application_id'); ?>: </span>
                                    <?php echo empty($installation_local->id) ? '-' : $installation_local->id; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_full_name'); ?>: </span>
                                    <?php echo empty($installation_local->full_name) ? '-' : $installation_local->full_name; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_email'); ?>: </span>
                                    <?php echo empty($installation_local->email) ? '-' : $installation_local->email; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_zip_code'); ?>: </span>
                                    <?php echo empty($installation_local->zip_code) ? '-' : $installation_local->zip_code; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_street'); ?>: </span>
                                    <?php echo empty($installation_local->street) ? '-' : $installation_local->street; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_number'); ?>: </span>
                                    <?php echo empty($installation_local->number) ? '-' : $installation_local->number; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_complement'); ?>: </span>
                                    <?php echo empty($installation_local->complement) ? '-' : $installation_local->complement; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_city'); ?> / <?=$this->lang->line('application_state'); ?>: </span>
                                    <?php echo empty($installation_local->city_id) ? '-' : City::find($installation_local->city_id)->name; ?> / <?php echo empty($installation_local->state_id) ? '-' : State::find($installation_local->state_id)->name; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_phone'); ?>: </span>
                                    <?php echo empty($installation_local->phone) ? '-' : $installation_local->phone; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_created_at'); ?>: </span>
                                    <?=empty($installation_local->created_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($installation_local->created_at))?>
                                </li>
                            </ul>
                            <br clear="all"> </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <p> </p>
</div>

<script>
    $(document).ready(function(){
        var tmpData = JSON.parse(<?=json_encode($purchase->data)?>);

        var formattedData = JSON.stringify(tmpData, null, '   ');
        $('#transaction_data').text(formattedData);
    });
</script>