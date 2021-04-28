<link href="<?=base_url()?>assets/blueline/css/plugins/timeline.css" rel="stylesheet">

<?php
$pv_kit =  json_decode($flow->pv_kit);
$simulation_results =  json_decode($flow->simulation_results);
$integrator =  json_decode($flow->integrator);
$customer_data =  json_decode($financing_request->customer_data);
$simulate_data =  json_decode($financing_request->simulate_data);
$santander_simulation =  json_decode($financing_request->santander_simulation);
?>

<div id="message-nano-wrapper" class="nano ">
        <div class="nano-content">
            <div class="header">
                <div class="message-content-menu">

                    <h4 class="page-title"><?=$item->id?></h4>
                </div>

                <span class="page-title">
                    <a class="icon glyphicon glyphicon-chevron-right trigger-message-close"></a>
                </span>

            </div>

            <div class="message-container">

                <div class="col-md-12">
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
                                            <strong><?=$this->lang->line('application_distance')?></strong>: <?=$integrator->distance ?><br/> km
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

                <?php if (false) : ?>
                    <ul class="timeline" id="timeline">
                    <li class="li complete">
                        <div class="timestamp">
                            <span class="date">11/15/2014<span>
                        </div>
                        <div class="status">
                            <h4>Passo 1</h4>
                        </div>
                    </li>
                    <li class="li complete">
                        <div class="timestamp">
                            <span class="date">11/15/2014<span>
                        </div>
                        <div class="status">
                            <h4>Passo 2</h4>
                        </div>
                    </li>
                    <li class="li complete">
                        <div class="timestamp">
                            <span class="date">11/15/2014<span>
                        </div>
                        <div class="status">
                            <h4>Passo 3</h4>
                        </div>
                    </li>
                    <li class="li">
                        <div class="timestamp">
                            <span class="date">11/15/2014<span>
                        </div>
                        <div class="status">
                            <h4>Passo 4</h4>
                        </div>
                    </li>
                    <li class="li">
                        <div class="timestamp">
                            <span class="date">11/15/2014<span>
                        </div>
                        <div class="status">
                            <h4>Passo 5</h4>
                        </div>
                    </li>
                    <li class="li">
                        <div class="timestamp">
                            <span class="date">11/15/2014<span>
                        </div>
                        <div class="status">
                            <h4>Passo 6</h4>
                        </div>
                    </li>
                </ul>
                    <button id="toggleButton">Toggle</button>
                <?php endif; ?>

            </div>

        </div>
    </div>

    <br />
    <br />
<script>
    jQuery(document).ready(function($) {

        $('.nano').nanoScroller();

        var completes = document.querySelectorAll(".complete");
        var toggleButton = $('toggleButton');

        function toggleComplete(){
            var lastComplete = completes[completes.length - 1];
            lastComplete.classList.toggle('complete');
        }

        toggleButton.onclick = toggleComplete;

        $('.trigger-message-close').on('click', function() {
            $('body').removeClass('show-message');
            messageIsOpen = false;
            $('body').removeClass('show-main-overlay');
        });

    });
</script>