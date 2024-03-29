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

<div class="col-sm-12  col-md-12 main">
    <div class="row tile-row">

        <div class="tile-button">
            <a href="<?= base_url() ?>cpricing/create_table" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-android-add-circle"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_create_new_table'); ?>
                </span>
                    </h1>
                </div>
            </a>
            <div class="col-md-6 col-xs-12 tile hidden-xs">
                <div style="width:97%; margin-top: -4px; margin-bottom: 17px; height: 80px;">
                </div>
            </div>
        </div>
    </div>
    <div class="grid">

        <div class="grid__col-md-12 dashboard-header">
            <div class="btn-group pull-right pull-right-responsive margin-right-15">
                <button type="button" class="btn btn-primary dropdown-toggle" style="position: inherit; float: right;" data-toggle="dropdown">
                    <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if ($last_uri != 'cpricing') {
                        echo $this->lang->line('application_' . $last_uri);
                    } else {
                        echo $this->lang->line('application_all');
                    } ?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <?php foreach ($submenu as $name => $value):?>
                        <li>
                            <a id="<?php $val_id = explode('/', $value); if (!is_numeric(end($val_id))) {
                                echo end($val_id);
                            } else {
                                $num = count($val_id) - 2;
                                echo $val_id[$num];
                            } ?>" href="<?=site_url($value);?>">
                                <?=$name?>
                            </a>
                        </li>
                    <?php endforeach;?>

                </ul>
            </div>
            <h1 style="position: absolute;"><?= $this->lang->line('application_price_tables') ?></h1>
            <small>
                <label class="header_description"><?=$pricing_tables_current_status_desc;?></label>
            </small>
        </div>

        <div class="grid__col-sm-12 grid__col-md-9 grid__col-lg-9 grid__col--bleed">
            <div class="grid grid--align-content-start">
                <?php if (1 == 1) { ?>

                    <?php foreach ($pricing_tables as $pricing_table): ?>
                        <?php $active = $pricing_table->active == 1 ? 'active' : 'inactive'; ?>


                        <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6 grid__col-md-6 grid__col-lg-3">
                            <a href="<?= base_url() . 'cpricing/view/' . $pricing_table->id ?>">
                                <div class="tile-base box-shadow tile-with-icon">
                                    <div class="tile-icon hidden-md hidden-xs"><i style="color: #d1d1d1"
                                                                                  class="la la-money"></i></div>
                                    <div class="tile-small-header">
                                        <?= $this->lang->line('application_table') ?>: #<?= ellipsize($pricing_table->name, 15, .8);  ?>

                                        <?php if((strtotime($pricing_table->end) < strtotime(date("Y-m-d"))) && $pricing_table->expiration_locked == 0) : ?>
                                             <small class="badge btn-danger btn-xs" style="font-size: 9px !important; font-weight: 600; margin-top: -2px; margin-left: 2px">
                                                 <?=$this->lang->line('application_deadline_reached')?>
                                             </small>
                                        <?php endif; ?>

                                    </div>
                                    <div class="tile-body">
                                        <p style="margin-top: 20px">
                                            <small>
                                                <small>
                                                    <small>
                                                        <span style="text-transform: uppercase">
                                                            <?= $this->lang->line('application_valid_from') ?>:
                                                        </span>
                                                    </small>
                                                </small>
                                            </small>
                                            <strong>
                                                <small>
                                                    <?= date($core_settings->date_format, strtotime($pricing_table->start)) ?>
                                                </small>
                                            </strong>
                                            <br/>
                                            <?php if ($pricing_table->end != null) : ?>
                                                <small>
                                                    <small>
                                                        <small>
                                                            <span style="text-transform: uppercase"><?= $this->lang->line('application_valid_to') ?>: </span>
                                                        </small>
                                                    </small>
                                                </small>
                                                <strong>
                                                    <small>
                                                        <?= date($core_settings->date_format, strtotime($pricing_table->end)) ?>
                                                    </small>
                                                    <?php if ($pricing_table->expiration_locked == 1) : ?>
                                                        <small class="badge btn-xs" style="font-size: 9px !important; font-weight: 600; margin-top: -2px; margin-left: 2px; text-transform: uppercase; background-color: #9c78db">
                                                            <?=$this->lang->line('application_expiration_deactivated')?>
                                                        </small>
                                                    <?php endif; ?>
                                                </strong>
                                            <?php else: ?>
                                                    <br />
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="tile-bottom">
                                        <small style="color: grey;"><?= $pricing_table->pricing_schema->name ?></small>
                                        <div class="pull-right small-text-grey">
                                            <small><?= $this->lang->line('application_table_' . $active) ?> </small>
                                            <span class="dot-colored <?= $active ?>"></span></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php endforeach; ?>

                <?php } ?>
            </div>
        </div>

        <?php if ($active_pricing_table != null) : ?>
        <div class="grid__col-sm-12 grid__col-md-3 grid__col-lg-3 grid__col--bleed">
            <div class="grid grid--align-content-start">
                <div class="grid__col-12 ">
                    <div class="stdpad box-shadow" style="height: auto">
                        <div class="table-head">
                            <?=$this->lang->line('application_active_pricing_table')?>: #<?= ellipsize($active_pricing_table->name, 15, .8);?>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-md-12">
                                <ul class="list-group ">
                                    <? foreach ($pricing_records as $pricing_record) : $i++ ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <label style="font-size: 11px; text-transform: none" class="stats-label">
                                                <i class="dripicons-view-apps orangered stats-icon"></i>
                                                <?=$pricing_record->pricing_field->power_bottom.$core_settings->rated_power_measurement?> - <?=$pricing_record->pricing_field->power_top > 100000 ? '♾️' : $pricing_record->pricing_field->power_top.$core_settings->rated_power_measurement ?> | <?=$pricing_record->pricing_field->distance_bottom?>km - <?=$pricing_record->pricing_field->distance_top > 100000 ? '♾️': $pricing_record->pricing_field->distance_top.'km';?>
                                                | <small>
                                                        <?php if ($pricing_record->structure_type_ids == '1,2,3') : ?>
                                                            <?=$this->lang->line('application_met_fib_cer')?>
                                                        <?php else: ?>
                                                            <?=$this->lang->line('application_slab_soil')?>
                                                        <?php endif; ?>
                                                </small>
                                            </label>
                                            <span class="pull-right stats-number" style="font-size: 15px">
                                                <small>
                                                    <?= $core_settings->money_symbol; ?>
                                                </small>
                                                <?= display_money($pricing_record->value); ?>
                                            </span>
                                        </li>
                                        <?php if (count($pricing_records) > $i) : ?>
                                            <hr class="stats-separator" />
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php endif; ?>

    </div>

</div>