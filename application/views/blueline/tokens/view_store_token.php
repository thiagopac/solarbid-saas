<style>
    .subcont {
        display: flex;
    }
</style>
<div class="col-sm-12 col-md-12 main">

    <?php include_once ("header_menu.php")?>

    <?php
    $pv_kit =  json_decode($flow->pv_kit);
    $integrator =  json_decode($flow->integrator);
    $customer_data =  json_decode($financing_request->customer_data);
    $simulate_data =  json_decode($financing_request->simulate_data);
    $santander_simulation =  json_decode($financing_request->santander_simulation);
    ?>

    <div class="grid">
        <div class="grid__col-md-7 dashboard-header">
            <h1> <?=$this->lang->line('application_store_token') ?>: <label class="badge" style="font-size: 15px; text-transform: none">#<?=$flow->code?></label>
                <?php if ($flow->integrator_approved == 1) : ?>
                    <label class="badge btn-success" style="font-size: 15px; text-transform: none">
                        <?=$this->lang->line('application_approved_project');?>
                    </label>
                <?php endif; ?>
            </h1>
        </div>
        <div class="grid__col-sm-12 grid__col-md-12 grid__col-lg-12 grid__col--bleed">
            <div class="grid grid--align-content-start">

                <div class="col-md-3">

                    <span style="text-align: center"><h3><?=$this->lang->line('application_customer_entries'); ?></h3></span>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_token'); ?></div>
                        <div class="subcont">
                            <ul class="details">
                                <li> <span> <?=$this->lang->line('application_id'); ?>: </span>
                                    <?php echo empty($flow->id) ? '-' : $flow->id; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_city'); ?> / <?=$this->lang->line('application_state'); ?>: </span>
                                    <?php echo empty($flow->city) ? '-' : City::find($flow->city)->name; ?> / <?php echo empty($flow->state) ? '-' : State::find($flow->state)->name; ?>
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

                    <p></p>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_appointment'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">
                                <li> <span> <?=$this->lang->line('application_id'); ?>: </span>
                                    <?= $company_appointment->id ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_date'); ?>: </span>
                                    <?= date($core_settings->date_format, strtotime($company_appointment->date)) ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_appointment_time'); ?>: </span>
                                    <?= $company_appointment->appointment_time->name ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_completed_visit'); ?>: </span>
                                    <h4 style="vertical-align: middle; <?=$company_appointment->completed == 1 ? 'color: green' : 'color: red' ?>"><?= $company_appointment->completed == 1 ? $this->lang->line('application_yes') : $this->lang->line('application_no') ?></h4>
                                </li>
                            </ul>
                            <br clear="all"> </div>
                    </div>

                    <p></p>

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

                <div class="col-md-3">

                    <span style="text-align: center"><h3><?=$this->lang->line('application_integrator_entries'); ?></h3></span>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_revised_pv_kit'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">
                                <li> <span> <?=$this->lang->line('application_pv_kit'); ?>: </span>
                                    <?php if (empty($pv_kit_revised)) : ?>
                                        -
                                    <?php else : ?>
                                        <small>
                                            <strong><?= $this->lang->line('application_id') ?></strong>: <?= $pv_kit_revised->id ?><br/>
                                            <strong><?= $this->lang->line('application_pv_power') ?></strong>: <?= $pv_kit_revised->kit_power ?> <?= $core_settings->rated_power_measurement; ?><br/>
                                            <strong><?= $this->lang->line('application_inverter') ?></strong>: <?= $pv_kit_revised->pv_inverter ?><br/>
                                            <strong><?= $this->lang->line('application_desc_inverter') ?></strong>: <?= $pv_kit_revised->desc_inverter ?><br/>
                                            <strong><?= $this->lang->line('application_modules') ?></strong>: <?= $pv_kit_revised->pv_module ?><br/>
                                            <strong><?= $this->lang->line('application_desc_module') ?></strong>: <?= $pv_kit_revised->desc_module ?><br/>
                                            <strong><?= $this->lang->line('application_structure_type') ?></strong>: <?= StructureType::find($pv_kit_revised->structure_type_id)->name ?><br/>
                                            <strong><?= $this->lang->line('application_price') ?></strong>: <?= $core_settings->money_symbol; ?><?= display_money($pv_kit_revised->price) ?><br/>
                                            <strong><?= $this->lang->line('application_freight') ?></strong>: <?= $core_settings->money_symbol; ?><?= display_money($pv_kit_revised->freight) ?><br/>
                                            <strong><?= $this->lang->line('application_insurance') ?></strong>: <?= $pv_kit_revised->insurance ?>
                                        </small>
                                    <?php endif; ?>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <p></p>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_revised_complements'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">
                                <li> <span> <?=$this->lang->line('application_complements'); ?>: </span>
                                    <br />
                                    <?php if (empty($complements_revised)) : ?>
                                        -
                                    <?php else : ?>
                                        <small>
                                            <?php foreach ($complements_revised as $complement) : ?>
                                                <strong><?= $this->lang->line('application_description') ?></strong>: <?= $complement->name ?>
                                                <br/>
                                                <strong><?= $this->lang->line('application_price') ?></strong>: <?= $core_settings->money_symbol; ?><?= $complement->price ?>
                                                <hr>
                                            <?php endforeach; ?>
                                        </small>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <p></p>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_calculated_project_value'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">
                                <li> <span> <?=$this->lang->line('application_pricing'); ?>: </span>
                                    <small>
                                        <?php if (empty($integrator_revised)) : ?>
                                            -
                                        <?php else : ?>
                                            <strong><?= $this->lang->line('application_power_of_plant') ?></strong>: <?= $pv_kit_revised->kit_power ?><?= $core_settings->rated_power_measurement; ?><br/>
                                            <strong><?= $this->lang->line('application_distance_installation_location') ?></strong>: <?= $integrator_revised->distance ?>km<br/>
                                            <strong><?= $this->lang->line('application_delivery_time') ?></strong>: <?=$integrator_revised->delivery_time_days?> <?=$this->lang->line('application_days')?><br/>
                                            <strong><?= $this->lang->line('application_structure_type') ?></strong>:
                                            <?php switch ($pv_kit_revised->structure_type_id) : case 1 : ?>
                                                <?= $this->lang->line('application_metallic') ?>
                                                <?php break; case 2 : ?>
                                                <?= $this->lang->line('application_fiber_cement') ?>
                                                <?php break; case 3 : ?>
                                                <?= $this->lang->line('application_ceramic') ?>
                                                <?php break; case 4 : ?>
                                                <?= $this->lang->line('application_slab') ?>
                                                <?php break; case 5 : ?>
                                                <?= $this->lang->line('application_soil') ?>
                                                <?php break; default : ?>
                                                <?= $this->lang->line('application_soil') ?>
                                                <?php break ?>
                                            <?php endswitch; ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_value') ?></strong>: <?= $core_settings->money_symbol; ?><?= display_money($integrator_revised->price) ?><br/>
                                        <?php endif; ?>
                                    </small>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-md-3">

                    <span style="text-align: center"><h3><?=$this->lang->line('application_payment_transactions'); ?></h3></span>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_referral_program'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">
                                <li> <span> <?=$this->lang->line('application_referral_code_used'); ?>: </span>
                                    <?php echo empty($flow->referral_code) ? '-' : $flow->referral_code; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_discount'); ?>: </span>
                                    <?php echo empty($referral_code->discount) ? '-' : $referral_code->discount.'%'; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_commission'); ?>: </span>
                                    <?php echo empty($referral_code->commission) ? '-' : $referral_code->commission.'%'; ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <p></p>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_appointment_purchase_gateway'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">
                                <li> <span> <?=$this->lang->line('application_id'); ?>: </span>
                                    <?php echo empty($appointment_purchase->id) ? '-' : $appointment_purchase->id; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_type'); ?>: </span>
                                    <?php echo empty($appointment_purchase->type) ? '-' : $appointment_purchase->type; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_name'); ?>: </span>
                                    <?php echo empty($appointment_purchase->name) ? '-' : $appointment_purchase->name; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_value'); ?>: </span>
                                    <?php echo empty($appointment_purchase->value) ? '-' : $core_settings->money_symbol.display_money($appointment_purchase->value) ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_Status'); ?>: </span>
                                    <?php echo empty($appointment_purchase->status) ? '-' : $appointment_purchase->status; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_processor_id'); ?>: </span>
                                    <?php echo empty($appointment_purchase->processor_id) ? '-' : $appointment_purchase->processor_id; ?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_created_at'); ?>: </span>
                                    <?=empty($appointment_purchase->created_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($appointment_purchase->created_at))?>
                                </li>
                                <li> <span> <?=$this->lang->line('application_updated_at'); ?>: </span>
                                    <?=empty($appointment_purchase->updated_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($appointment_purchase->updated_at))?>
                                </li>
                                <!--                                <li> <span> --><?//=$this->lang->line('application_transaction_data'); ?><!--: </span>-->
                                <!--                                    <small>--><?php //echo empty($appointment_purchase->data) ? '-' : '<pre id="purchase_data">'.$appointment_purchase->data.'</pre>'; ?><!--</small>-->
                                <!--                                </li>-->
                            </ul>
                            <br clear="all"> </div>
                    </div>

                    <p></p>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_total_purchase_gateway'); ?></div>
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

                    <p></p>

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

                    <span style="text-align: center"><h3><?=$this->lang->line('application_webhook_data'); ?></h3></span>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_appointment_webhooks'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">

                                <?php foreach ($appointment_webhooks as $appointment_webhook) : ?>

                                    <li> <span> <?=$this->lang->line('application_webhook'); ?> <?=$this->lang->line('application_id'); ?># <?= $appointment_webhook->id ?> </span>
                                        <small>
                                            <strong><?= $this->lang->line('application_type') ?></strong>: <?= $appointment_webhook->type ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_status') ?></strong>: <?= $appointment_webhook->status ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_hook_id') ?></strong>: <?= $appointment_webhook->hook_id ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_processor_id') ?></strong>: <?= $appointment_webhook->pedido_id ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_created_at') ?></strong>: <?= date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($appointment_webhook->created_at)) ?>
                                            <br/>
                                            <strong><?=$this->lang->line('application_transaction_data'); ?>: </strong>
                                            <small><?php echo empty($appointment_purchase->data) ? '-' : '<pre id="purchase_data">'.$appointment_purchase->data.'</pre>'; ?></small>
                                        </small>
                                    </li>

                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>

                    <p></p>

                    <div class="box-shadow">
                        <div class="table-head">
                            <?=$this->lang->line('application_purchase_webhooks'); ?></div>
                        <div class="subcont">
                            <ul class="details col-md-12">

                                <?php foreach ($purchase_webhooks as $purchase_webhook) : ?>

                                    <li> <span> <?=$this->lang->line('application_webhook'); ?> <?= $purchase_webhook->id ?> </span>
                                        <small>
                                            <strong><?= $this->lang->line('application_type') ?></strong>: <?= $purchase_webhook->type ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_status') ?></strong>: <?= $purchase_webhook->status ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_hook_id') ?></strong>: <?= $purchase_webhook->hook_id ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_processor_id') ?></strong>: <?= $purchase_webhook->pedido_id ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_created_at') ?></strong>: <?= date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($purchase_webhook->created_at)) ?>
                                            <br/>
                                            <strong><?=$this->lang->line('application_transaction_data'); ?>: </strong>
                                            <small><?php echo empty($purchase_webhook->data) ? '-' : '<pre id="purchase_data">'.$purchase_webhook->data.'</pre>'; ?></small>
                                        </small>
                                    </li>

                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
    <p> </p>
</div>
<script>
    //$(document).ready(function(){
    //    var tmpData = JSON.parse(<?//=json_encode($purchase->data)?>//);
    //
    //    var formattedData = JSON.stringify(tmpData, null, '   ');
    //    $('#transaction_data').text(formattedData);
    //});
</script>