<div class="col-sm-12 col-md-12 main">
    <?php include_once ("header_menu.php")?>

    <?php
    $pv_kit = json_decode($flow->pv_kit);
    $pv_kit_revised = json_decode($flow->pv_kit_revised);

    $complements_revised = json_decode($flow->complements_revised);

    $integrator = json_decode($flow->integrator);
    $integrator_revised = json_decode($flow->integrator_revised);
    ?>

    <div class="grid">
        <div class="grid__col-md-12 dashboard-header">
            <h1> <?= $this->lang->line('application_analyze_store_token') ?>:
                <label class="badge" style="padding:6px; font-size: 15px; text-transform: none; border-radius: 4px">
                    <?= $flow->code ?>
                </label>
                <?php if ($flow->integrator_approved == 1) : ?>
                    ❯
                    <label class="badge btn-warning" style="padding:6px; font-size: 15px; text-transform: none; border-radius: 4px">
                        <?=$this->lang->line('application_submited_project');?>
                    </label>
                <?php endif; ?>
                <?php if ($flow->customer_approved == 1) : ?>
                    ❯
                    <label class="badge btn-secondary" style="padding:6px; font-size: 15px; text-transform: none; border-radius: 4px">
                        <?=$this->lang->line('application_approved_project_solarbid');?>
                    </label>
                <?php endif; ?>
                <?php if ($flow->solarbid_approved == 1) : ?>
                    ❯
                    <label class="badge btn-success" style="padding:6px; font-size: 15px; text-transform: none; border-radius: 4px">
                        <?=$this->lang->line('application_approved_project_solarbid');?>
                    </label>
                <?php endif; ?>
            </h1>
        </div>
        <div class="grid__col-sm-12 grid__col-md-12 grid__col-lg-12 grid__col--bleed">
            <div class="grid grid--align-content-start">

                <div class="col-md-3">
                    <?php if (empty($flow->pv_kit)) : ?>
                        <div class="alert alert-warning"><?= $this->lang->line('application_flow_incomplete') ?></div>
                    <?php endif; ?>
                    <div class="box-shadow">
                        <div class="table-head">
                            <?= $this->lang->line('application_client_inputs'); ?></div>
                        <div class="subcont">
                            <ul class="details">
                                <li>
                                    <span> <?= $this->lang->line('application_city'); ?> / <?= $this->lang->line('application_state'); ?>: </span>
                                    <?php echo empty($flow->city) ? '-' : $flow->city_obj->name; ?>
                                    / <?php echo empty($flow->state) ? '-' : $flow->state_obj->name; ?>
                                </li>
                                <li><span> <?= $this->lang->line('application_pvkit'); ?>: </span>
                                    <?php if (empty($flow->pv_kit)) : ?>
                                        -
                                    <?php else : ?>
                                        <small>
                                            <strong><?= $this->lang->line('application_price') ?></strong>: <?= $core_settings->money_symbol; ?><?= display_money($pv_kit->price) ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_freight') ?></strong>: <?= $core_settings->money_symbol; ?><?= display_money($pv_kit->freight) ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_insurance') ?></strong>: <?= $pv_kit->insurance ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_pv_power') ?></strong>: <?= $pv_kit->kit_power ?> <?= $core_settings->rated_power_measurement; ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_modules') ?></strong>: <?= $pv_kit->pv_module ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_desc_module') ?></strong>: <?= $pv_kit->desc_module ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_inverter') ?></strong>: <?= $pv_kit->pv_inverter ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_desc_inverter') ?></strong>: <?= $pv_kit->desc_inverter ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_provider') ?></strong>: <?= $pv_kit->kit_provider ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_structure_type') ?></strong>: <?= StructureType::find($pv_kit->structure_type_id)->name ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_savings_power_month') ?></strong>: <?= $pv_kit->savings ?> <?= $core_settings->consumn_power_measurement; ?>
                                            /<?= $this->lang->line('application_month') ?><br/>
                                        </small>
                                    <?php endif; ?>
                                </li>
                                <li><span> <?= $this->lang->line('application_integrator'); ?>: </span>
                                    <?php if (empty($flow->integrator)) : ?>
                                        -
                                    <?php else : ?>
                                        <small>
                                            <strong><?= $this->lang->line('application_name') ?></strong>: <?= $integrator->company_name ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_location') ?></strong>: <?= $integrator->location ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_distance') ?></strong>: <?= $integrator->distance ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_price') ?></strong>: <?= $core_settings->money_symbol; ?><?= display_money($integrator->price) ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_average_rating') ?></strong>: <?= $integrator->average_rating ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_power_executed') ?></strong>: <?= $integrator->power_executed ?> <?= $core_settings->rated_power_measurement; ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_warranty_months') ?></strong>: <?= $integrator->warranty_months ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_number_of_ratings') ?></strong>: <?= $integrator->number_of_ratings ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_delivery_time_days') ?></strong>: <?= $integrator->delivery_time_days ?>
                                            <br/>
                                            <strong><?= $this->lang->line('application_power_plants_installed') ?></strong>: <?= $integrator->power_plants_installed ?>
                                            <br/>
                                        </small>
                                    <?php endif; ?>
                                </li>
                                <li><span> <?= $this->lang->line('application_created_at'); ?>: </span>
                                    <?= empty($flow->created_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($flow->created_at)) ?>
                                </li>
                            </ul>
                            <br clear="all"></div>
                    </div>
                    <p></p>
                </div>

                <div class="col-md-9">

                    <div class="box-shadow">
                        <div class="table-head">
                            <?= $this->lang->line('application_technical_visit'); ?>
                        </div>
                        <div class="subcont">
                            <div class="row">

                                <div class="col-md-3">
                                    <ul class="details">
                                        <li>
                                            <span><?=$this->lang->line('application_visit_date_agreed');?></span>
                                            <h2>
                                                <?= date($core_settings->date_format, strtotime($company_appointment->date)) ?>
                                            </h2>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-3">
                                    <ul class="details">
                                        <li>
                                            <span><?= $this->lang->line('application_appointment_time') ?></span>
                                            <h2>
                                                <?= $company_appointment->appointment_time->name ?>
                                            </h2>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-3">
                                    <ul class="details" style="text-align: left;">
                                        <li>
                                            <span><?= $this->lang->line('application_completed_visit'); ?></span>
                                            <h2>
                                                <span style="vertical-align: middle; <?=$company_appointment->completed == 1 ? 'color: green' : 'color: red' ?>"><?= $company_appointment->completed == 1 ? $this->lang->line('application_yes') : $this->lang->line('application_no') ?></span>
                                            </h2>
                                        </li>
                                    </ul>
                                </div>

                                <?php if ($company_appointment->completed_date != null) : ?>
                                    <div class="col-md-3">
                                        <ul class="details" style="text-align: left;">
                                            <li>
                                                <span><?= $this->lang->line('application_completed_visit_date'); ?></span>
                                                <h2>
                                                    <?= date($core_settings->date_format, strtotime($company_appointment->completed_date)) ?>
                                                </h2>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <?php if ($company_appointment->comments != null) : ?>
                                    <div class="col-md-12">
                                        <ul class="details" style="text-align: left;">
                                            <li>
                                                <span><?= $this->lang->line('application_relevant_appointment_comments'); ?></span>
                                                <p></p>
                                                <span>
                                                <?=$company_appointment->comments ?>
                                            </span>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <p></p>

                    <?php $pv_kit_view = $pv_kit_revised != null ? $pv_kit_revised : $pv_kit ?>

                    <div class="box-shadow" style="<?=$company_appointment->completed != 1 ? 'opacity:20%' : '' ;?>">
                        <div class="table-head">
                            <?= $this->lang->line('application_revise_pv_kit_and_complement'); ?>
                        </div>
                        <div class="subcont">

                            <div class="grid__col-sm-12 grid__col-md-9 grid__col-lg-12 grid__col--bleed">
                                <div class="grid grid--align-content-start">

                                    <div class="grid__col-5 grid__col-xs-5 grid__col-sm-5 grid__col-md-5 grid__col-lg-5">
                                    <div class="tile-base box-shadow tile-with-icon">
                                        <div class="tile-icon hidden-md hidden-xs"><i style="color: #d1d1d1"
                                                                                      class="las la-solar-panel"></i>
                                        </div>
                                        <div class="tile-header">
                                            <?= $this->lang->line('application_pv_kit') ?>
                                            <strong><?= ellipsize($pv_kit_view->kit_provider, 15, .8); ?></strong>
                                        </div>
                                        <div class="tile-body" style="min-height: 275px;">
                                            <p style="margin-top: 20px">
                                                <small>
                                                    <small>
                                                        <strong><?= $this->lang->line('application_pv_power') ?></strong>: <?= $pv_kit_view->kit_power ?> <?= $core_settings->rated_power_measurement; ?><br/>
                                                        <strong><?= $this->lang->line('application_inverter') ?></strong>: <?= $pv_kit_view->pv_inverter ?><br/>
                                                        <strong><?= $this->lang->line('application_desc_inverter') ?></strong>: <?= $pv_kit_view->desc_inverter ?><br/>
                                                        <strong><?= $this->lang->line('application_modules') ?></strong>: <?= $pv_kit_view->pv_module ?><br/>
                                                        <strong><?= $this->lang->line('application_desc_module') ?></strong>: <?= $pv_kit_view->desc_module ?><br/>
                                                        <strong><?= $this->lang->line('application_structure_type') ?></strong>: <?= StructureType::find($pv_kit_view->structure_type_id)->name ?><br/>
                                                        <strong><?= $this->lang->line('application_price') ?></strong>: <?= $core_settings->money_symbol; ?><?= display_money($pv_kit_view->price) ?><br/>
                                                        <strong><?= $this->lang->line('application_freight') ?></strong>: <?= $core_settings->money_symbol; ?><?= display_money($pv_kit_view->freight) ?><br/>
                                                        <strong><?= $this->lang->line('application_insurance') ?></strong>: <?= $pv_kit_view->insurance ?><br/>
                                                    </small>
                                                </small>
                                            </p>
                                        </div>
                                        <div class="tile-bottom">
                                            <?php if ($flow->pv_kit_revised != null) : ?>
                                                <div class="pull-left"><div class="badge btn-danger"><?=$this->lang->line('application_kit_revised_integrator');?></div></div>
                                            <?php endif; ?>
                                            <?php if ($flow->solarbid_approved != 1) : ?>
                                            <a data-toggle="mainmodal" href="<?= base_url() ?>tokens/update_pvkit/<?= $flow->code; ?>"
                                                    class="pull-right btn btn-primary flat-invert"><?= $this->lang->line('application_change_pv_kit') ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid__col-7 grid__col-xs-7 grid__col-sm-7 grid__col-md-7 grid__col-lg-7">
                                <div class="tile-base box-shadow tile-with-icon">
                                    <div class="tile-icon hidden-md hidden-xs"><i style="color: #d1d1d1"
                                                                                  class="las la-plug"></i></div>
                                    <div class="tile-header">
                                        <?= $this->lang->line('application_complements') ?>
                                    </div>
                                    <div class="tile-body" style="min-height: 275px;">
                                        <p style="margin-top: 20px">
                                            <small>
                                                <small>
                                                    <?php foreach ($complements_revised as $complement) : ?>
                                                        <strong><?= $this->lang->line('application_description') ?></strong>: <?= $complement->name ?>
                                                        <br/>
                                                        <strong><?= $this->lang->line('application_price') ?></strong>: <?= $core_settings->money_symbol; ?><?= $complement->price ?>
                                                        <hr>
                                                    <?php endforeach; ?>
                                                </small>
                                            </small>
                                        </p>
                                    </div>
                                    <div class="tile-bottom">
                                        <?php if ($flow->complements_revised != null) : ?>
                                            <div class="pull-left"><div class="badge btn-danger"><?=$this->lang->line('application_complements_revised_integrator');?></div></div>
                                        <?php endif; ?>
                                        <?php if ($flow->solarbid_approved != 1) : ?>
                                            <a data-toggle="mainmodal" href="<?= base_url() ?>tokens/update_complements/<?= $flow->code; ?>"
                                                class="pull-right btn btn-primary flat-invert"><?= $this->lang->line('application_change_complements') ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br clear="all">
                        </div>
            </div>

                    <p></p>

                    <div class="box-shadow" style="<?=$company_appointment->completed != 1 ? 'opacity:20%' : '' ;?>">
                        <div class="table-head">
                            <?= $this->lang->line('application_calculated_project_value'); ?>
                        </div>
                        <div class="subcont">

                            <?php $integrator_view = $integrator_revised != null ? $integrator_revised : $integrator ?>

                            <div class="row">

                                <div class="col-md-3">
                                    <ul class="details">
                                        <li>
                                            <span><?=$this->lang->line('application_power_of_plant');?></span>
                                            <h2>
                                                <?= $pv_kit_view->kit_power ?><?= $core_settings->rated_power_measurement; ?>
                                            </h2>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-3">
                                    <ul class="details">
                                        <li>
                                            <span><?= $this->lang->line('application_distance_installation_location') ?></span>
                                            <h2>
                                                <?= $integrator->distance ?>km
                                            </h2>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-6">
                                    <ul class="details" style="text-align: right;">
                                        <li>
                                            <span><?= $this->lang->line('application_value'); ?> / <?=$this->lang->line('application_delivery_time')?></span>
                                            <h2>
                                                <span class="label label-success">
                                                    <?php switch ($pv_kit_view->structure_type_id) : case 1 : ?>
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
                                                    </span>
                                                <small>
                                                    <?= $core_settings->money_symbol; ?>
                                                </small>
                                                <?= display_money($current_price); ?>
                                                <small>(<?=$pricing_record->delivery_time_days?> <?=$this->lang->line('application_days')?>)</small>
                                            </h2>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <?php if ($pricing_table->active != 1 || $pricing_table == null) : ?>
                                <a href="<?= base_url() ?>cpricing"><div class="pull-right label label-important"><?= $this->lang->line('application_no_pricing_table_active_found_analyze'); ?></div></a>
                            <?php else : ?>
                                <div class="pull-right">
                                    <small>
                                        <?= $this->lang->line('application_based_in_your_pricing_table_analyze'); ?>: <a data-toggle="mainmodal" href="<?= base_url() ?>tokens/view_pricing_table/<?=$pricing_table->id?>">#<?=$pricing_table->name?></a>
                                    </small>
                                </div>
                            <?php endif; ?>

                            <br clear="all"></div>
                    </div>
                    <div>
                        <br clear="all"></div>
                        <div class="pull-right">
                            <?php if ($flow->solarbid_approved != 1) : ?>
                                <a data-toggle="mainmodal" href="<?= base_url() ?>tokens/solarbid_approve/<?= $flow->code; ?>"
                                   class="pull-right btn btn-success"><?= $this->lang->line('application_approve_project') ?></a>
                            <?php endif; ?>
                        </div>

                    </div>
                <p>&nbsp;</p>
        </div>
        </div>
    </div>
</div>
<p></p>
</div>