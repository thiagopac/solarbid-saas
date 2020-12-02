<div class="col-sm-12  col-md-12 main">

    <?php include_once ("header_menu.php")?>
    <div class="row">

        <div class="btn-group pull-right-responsive margin-right-3 hidden-xs">
            <button id="bulk-button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?=$this->lang->line('application_bulk_actions');?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right bulk-dropdown" role="menu">
                <li data-action="start_at_today"><a id="" href="#"><?=$this->lang->line('application_start_at_today');?></a></li>
                <li data-action="start_at_blank"><a id="" href="#"><?=$this->lang->line('application_start_at_blank');?></a></li>
                <li data-action="stop_at_today"><a id="" href="#"><?=$this->lang->line('application_stop_at_today');?></a></li>
                <li data-action="stop_at_blank"><a id="" href="#"><?=$this->lang->line('application_stop_at_blank');?></a></li>
                <li data-action="inactivate"><a id="" href="#"><?=$this->lang->line('application_inactivate');?></a></li>
                <li data-action="activate"><a id="" href="#"><?=$this->lang->line('application_activate');?></a></li>
                <li data-action="delete"><a id="" href="#"><?=$this->lang->line('application_delete');?></a></li>


            </ul>
            <?php
            $form_action = base_url() . 'pvkits/bulk/';
            $attributes = ['class' => '', 'id' => 'bulk-form'];
            echo form_open($form_action, $attributes); ?>
            <input type="hidden" name="list" id="list-data" />
            </form>
        </div>

        <div class="btn-group pull-right-responsive margin-right-3">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php if (isset($all_filter)) {
                    echo $all_filter;
                }else{
                    echo $this->lang->line('application_filter');
                }
                ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <?php foreach ($submenu as $item):?>
                    <?php foreach ($item as $key => $value):?>
                    <li>
                        <a href="<?=site_url($value);?>">
                            <?=$key?>
                        </a>
                    </li>
                    <?php endforeach;?>
                <?php endforeach;?>

            </ul>
        </div>

    </div>
    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_pvkits');?>
            </div>
            <div class="table-div" id="div-pvkits" name="pv-kits">
                <table class="data-sorting table noclick" id="pvkits" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th class="hidden-xs no_sort simplecheckbox" style="width:16px">
                        <input class="checkbox-nolabel" type="checkbox" id="checkAll" name="selectall" value="">
                    </th>
                    <th style="width:20px">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th style="width:100px">
                        <?=$this->lang->line('application_provider');?>
                    </th>
                    <th style="width:120px">
                        <?=$this->lang->line('application_pv_power');?>
                    </th>
                    <th style="width:100px">
                        <?=$this->lang->line('application_inverter');?>
                    </th>
                    <th style="width:100px">
                        <?=$this->lang->line('application_modules');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_structure_type')?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_price');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_start');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_end');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_inactivated');?>
                    </th>
                    <th class="hidden-xs no-sort">
                        <?=$this->lang->line('application_freight');?>
                    </th>
                    <th class="hidden-xs no-sort">
                        <?=$this->lang->line('application_image');?>
                    </th>
                    <th class="hidden-xs no-sort">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($pv_kits as $kit):?>
                        <tr id="<?=$kit->id;?>">
                            <td class="hidden-xs noclick simplecheckbox" style="width:16px">
                                <input class="checkbox-nolabel bulk-box" type="checkbox" name="bulk[]" value="<?=$kit->id?>">
                            </td>
                            <td class="hidden-xs" style="width:70px">
                                <?=$kit->id;?>
                            </td>
                            <td><?=$kit->kit_provider?></td>
                            <td class="hidden-xs" style="width:15px">
                                <?=$kit->kit_power?> <?=$core_settings->rated_power_measurement?>
                            </td>
                            <td>
                                <?=$kit->pv_inverter?>
                            </td>
                            <td>
                                <?=$kit->pv_module?>
                            </td>
                            <td>
                                <?=$kit->structure_type->name?>
                            </td>
                            <td>
                                <small>
                                    <?= $core_settings->money_symbol; ?>
                                </small>
                                <?= display_money($kit->price); ?>
                            </td>
                            <td>
                                <?= $kit->start_at != null ? date($core_settings->date_format.' '.$core_settings->date_time_format, strtotime($kit->start_at)) : '' ?>
                            </td>
                            <td>
                                <?= $kit->stop_at != null ? date($core_settings->date_format.' '.$core_settings->date_time_format, strtotime($kit->stop_at)) : '' ?>
                            </td>
                            <td>
                                <? if($kit->inactive == 0) : ?> <span class="label label-success"><?=$this->lang->line('application_no')?></span> <?php else: ?> <span class="label label-important"><?=$this->lang->line('application_yes')?> <?endif;?>
                            </td>
                            <td style="text-align: center">
                                <a href="<?=base_url() ?>pvkits/freight/<?=$kit->id; ?>" title="<?=$this->lang->line('application_freight'); ?>" class="btn-option tt" data-toggle="mainmodal"> <i class="ion-android-bus"> </i> </a>
                            </td>
                            <td style="text-align: center">
                                <?php if($kit->image != null) : ?><a href="<?=base_url() ?>pvkits/preview_photo/<?=$kit->id; ?>" title="<?=$this->lang->line('application_preview_photo'); ?>" class="btn-option tt" data-toggle="mainmodal"> <i class="icon dripicons-preview"> </i> </a><?php endif; ?>
                            </td>

                            <td class="option">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>pvkits/delete/<?=$kit->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$kit->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>pvkits/duplicate/<?=$kit->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$kit->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_clone');?></b>">
                                    <i class="icon dripicons-duplicate"></i>
                                </button>
                                <a href="<?=base_url()?>pvkits/update/<?=$kit->id;?>" class="btn-option" data-toggle="mainmodal">
                                    <i class="icon dripicons-gear"></i>
                                </a>
                            </td>
                        </tr>

                    <?php endforeach;?>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('input[name="bulk[]"]').on('change', function () {
        $(this).closest('tr').toggleClass('active');
    })

    $('input[name="selectall"]').on('change', function () {
        if ($(this).prop('checked')) {
            $('tbody>tr').addClass('active');
        }else{
            $('tbody>tr').removeClass('active');
        }

    })
});
</script>