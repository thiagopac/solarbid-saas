<div class="form-group">
    <div class="subcont preview">
        <div>
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
<div class="modal-footer">
    <a class="btn" data-dismiss="modal">
        <?=$this->lang->line('application_close');?>
    </a>
</div>