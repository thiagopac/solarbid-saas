<?php $active = $pricing_table->active == 1 ? 'active' : 'inactive'; ?>
<div class="col-md-12 col-lg-12">
    <div class="row tile-row">
        <div class="tile-button">
            <a href="<?= base_url() ?>cpricing/update_table/<?=$pricing_table->id?>" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">
                    <div class="icon-frame">
                        <i class="ion-edit"></i>
                    </div>
                    <h1>
                        <span>
                            <?= $this->lang->line('application_edit_table'); ?>
                        </span>
                    </h1>
                    <h2><?= $this->lang->line('application_edit_table_desc'); ?></h2>
                </div>
            </a>
        </div>
        <?php if($pricing_table_complete == true) : ?>
            <?php if($pricing_table->active == false) : ?>
                <div class="tile-button">
                    <a href="<?= base_url() ?>cpricing/activate/<?=$pricing_table->id?>" data-toggle="mainmodal">
                        <div class="col-md-4 col-xs-4 tile">
                            <div class="icon-frame btn-success">
                                <i class="ion-checkmark"></i>
                            </div>
                            <h1>
                                <span>
                                    <?= $this->lang->line('application_activate_table'); ?>
                                </span>
                            </h1>
                            <h2><?= $this->lang->line('application_activate_table_desc'); ?></h2>
                        </div>
                    </a>
                </div>
            <?php elseif($pricing_table->active == true) : ?>
                <div class="tile-button">
                    <a href="<?= base_url() ?>cpricing/activate/<?=$pricing_table->id?>" data-toggle="mainmodal">
                        <div class="col-md-4 col-xs-4 tile">
                            <div class="icon-frame btn-danger">
                                <i class="ion-close"></i>
                            </div>
                            <h1>
                                <span>
                                    <?= $this->lang->line('application_deactivate_table'); ?>
                                </span>
                            </h1>
                            <h2><?= $this->lang->line('application_deactivate_table_desc'); ?></h2>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        <?php elseif($pricing_table_complete == false) : ?>
            <div class="col-md-4 col-xs-4 tile">

            </div>
        <?php endif; ?>
        <div class="col-md-5 col-xs-5">
            <div style="text-align: right">
                <p style="margin-top: 0px">
                    <small>
                        <small>
                            <span style="text-transform: uppercase">
                                <?= $this->lang->line('application_valid_from') ?>:
                            </span>
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
                                <span style="text-transform: uppercase"><?= $this->lang->line('application_valid_to') ?>: </span>
                            </small>
                        </small>
                        <strong>
                            <small>
                                <?= date($core_settings->date_format, strtotime($pricing_table->end)) ?>
                            </small>
                        </strong>
                    <?php else: ?>
                        <br />
                    <?php endif; ?>
                </p>
                <?php if($pricing_table_complete == true): ?>
                    <label class=""><?=$this->lang->line('application_price_table_complete')?>: </label>
                <?php else: ?>
                    <label class=""><?=$this->lang->line('application_price_table_incomplete')?>: </label>
                <?php endif; ?>
                <label><?=2*count($pricing_fields)?></label>/<label><?=count($pricing_records)?></label>
                <br />
                <div class="pull-right small-text-grey"><span><?=$this->lang->line('application_table_'.$active)?> </span><span class="dot-colored <?=$active?>"></span></div>

            </div>
        </div>
        <div class="col-md-1 col-xs-1 tile">
            <div style="margin-bottom: 3px;"></div>
        </div>
    </div>
    <div class="grid__col-md-7 dashboard-header">
        <h1><?= $this->lang->line('application_price_table') ?>: <span style="font-size: 15px" class="badge">#<?= ellipsize($pricing_table->name, 35, .8);?></span></h1>
        <small>
            <?= $this->lang->line('application_at_least_one_pricing_table'); ?>
        </small>
    </div>
    <div class="box-shadow">

        <div class="table-div">

            <p></p>

            <?php
            $last_pricing_field = null;
            $repeat = true;
            $i = -1;

            ?>

            <? foreach ($pricing_fields as $pricing_field) : $i++ ?>

                <?php if ($pricing_field->power_bottom === $last_pricing_field->power_bottom
                    && $pricing_field->power_top === $last_pricing_field->power_top) {
                    $repeat = true;
                } else {
                    $repeat = false;
                } ?>
                <?php

                if ($repeat === false && $i != 0) {

                    echo '<hr style="height:3px;border:none;color:#333;background-color:#efefef;" />';
                }

                $last_pricing_field = $pricing_field;
                ?>
                <div class="row">

                    <div class="col-md-3">
                        <ul class="details">
                            <li>
                                <?php if ($repeat === false): ?>
                                    <span><?=$this->lang->line('application_power_of_plant');?></span>
                                    <h2>
                                        <?php if ($pricing_field->power_top < 1000) : ?>
                                            <small>
                                                <?= $this->lang->line('application_from') ?>
                                            </small>
                                            <?= $pricing_field->power_bottom ?><?=$core_settings->rated_power_measurement;?>
                                            <small>
                                                <?= $this->lang->line('application_until') ?>
                                            </small>
                                            <?= $pricing_field->power_top ?><?= $core_settings->rated_power_measurement; ?>
                                        <?php else : ?>
                                            <small>
                                                <?= $this->lang->line('application_from_number') ?>
                                            </small>
                                            <?= $pricing_field->power_bottom ?><?= $core_settings->rated_power_measurement; ?>
                                        <?php endif; ?>
                                    </h2>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul class="details">
                            <li>
                                <span><?= $this->lang->line('application_distance_installation_location') ?></span>
                                <h2>
                                    <?php if ($pricing_field->distance_top < 1000) : ?>
                                        <small>
                                            <?= $this->lang->line('application_from') ?>
                                        </small>
                                        <?= $pricing_field->distance_bottom ?>km
                                        <small>
                                            <?= $this->lang->line('application_until') ?>
                                        </small>
                                        <?= $pricing_field->distance_top ?>km
                                    <?php else: ?>
                                        <small>
                                            <?= $this->lang->line('application_from_number') ?>
                                        </small>
                                        <?= $pricing_field->distance_bottom ?>km
                                    <?php endif; ?>
                                </h2>
                            </li>
                        </ul>
                    </div>
                    <?php
                    //filter price for Field ID in row and Structure Type ID = 1,2,3
                    $price123 = array_values(array_filter($pricing_records, function ($pricing_record) use ($pricing_field) {
                        return $pricing_record->field_id === $pricing_field->id && $pricing_record->structure_type_ids === "1,2,3";
                    }));
                    //filter price for Field ID in row and Structure Type ID = 4,5
                    $price45 = array_values(array_filter($pricing_records, function ($pricing_record) use ($pricing_field) {
                        return $pricing_record->field_id === $pricing_field->id && $pricing_record->structure_type_ids === "4,5";
                    }));
                    ?>
                    <div class="col-md-6">
                        <ul class="details" style="text-align: right; padding-right: 40px;">
                            <li>
                                <span><?= $this->lang->line('application_Wp_value'); ?> / <?=$this->lang->line('application_delivery_time')?></span>
                                <?php if ($price123[0]->value != null) : ?>
                                    <h2>
                                  <span class="label label-success">
                                    <?= $this->lang->line('application_metallic') ?>
                                  </span>
                                        <span class="label label-success">
                                    <?= $this->lang->line('application_fiber_cement') ?>
                                  </span>
                                        <span class="label label-success">
                                      <?= $this->lang->line('application_ceramic') ?>
                                  </span>
                                        <small>
                                            <?= $core_settings->money_symbol; ?>
                                        </small>
                                        <?= display_money($price123[0]->value); ?>
                                        <small>(<?=$price123[0]->delivery_time_days?> <?=$this->lang->line('application_days')?>)</small>
                                        <a href="<?= base_url() ?>cpricing/update/<?= $price123[0]->id ?>"
                                           class="btn-define-price"
                                           style="font-size: 20px!important; padding: 0px 20px !important;"
                                           data-toggle="mainmodal">
                                            <i title="<?= $this->lang->line('application_edit') ?>"
                                               class="icon dripicons-document-edit"></i>
                                        </a>
                                    </h2>
                                <?php else : ?>
                                    <h2>
                                        <span class="label label-success"><?= $this->lang->line('application_metallic') ?></span>
                                        <span class="label label-success"><?= $this->lang->line('application_fiber_cement') ?></span>
                                        <span class="label label-success"><?= $this->lang->line('application_ceramic') ?></span>
                                        <span class="badge btn-danger"
                                              style="font-size: 14px"><?= $this->lang->line('application_undefined') ?></span>
                                        <a href="<?= base_url() ?>cpricing/create/<?= $pricing_table->id ?>/<?= $pricing_field->id ?>/123"
                                           class="btn-define-price"
                                           style="font-size: 20px!important; padding: 0px 20px !important;"
                                           data-toggle="mainmodal"><i
                                                    title="<?= $this->lang->line('application_edit') ?>"
                                                    class="icon dripicons-document-edit"></i></a></h2>
                                <?php endif; ?>

                                <?php if ($price45[0]->value) : ?>
                                    <h2>
                                        <span class="label label-success"><?= $this->lang->line('application_slab') ?></span>
                                        <span class="label label-success"><?= $this->lang->line('application_soil') ?> </span>
                                        <small><?= $core_settings->money_symbol; ?></small><?= display_money($price45[0]->value); ?>
                                        <small>(<?=$price45[0]->delivery_time_days?> <?=$this->lang->line('application_days')?>)</small>
                                        <a href="<?= base_url() ?>cpricing/update/<?= $price45[0]->id ?>"
                                           class="btn-define-price"
                                           style="font-size: 20px!important; padding: 0px 20px !important;"
                                           data-toggle="mainmodal"><i
                                                    title="<?= $this->lang->line('application_edit') ?>"
                                                    class="icon dripicons-document-edit"></i></a></h2>
                                <?php else : ?>
                                    <h2>
                                        <span class="label label-success"><?= $this->lang->line('application_slab') ?></span>
                                        <span class="label label-success"><?= $this->lang->line('application_soil') ?> </span>
                                        <span class="badge btn-danger"
                                              style="font-size: 14px"><?= $this->lang->line('application_undefined') ?></span>
                                        <a href="<?= base_url() ?>cpricing/create/<?= $pricing_table->id ?>/<?= $pricing_field->id ?>/45"
                                           class="btn-define-price"
                                           style="font-size: 20px!important; padding: 0px 20px !important;"
                                           data-toggle="mainmodal"><i
                                                    title="<?= $this->lang->line('application_edit') ?>"
                                                    class="icon dripicons-document-edit"></i></a></h2>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <?php $repeat = true; ?>
            <? endforeach; ?>

        </div>
    </div>
    <p></p>
</div>
<?php //var_dump($var_dump);  ?>