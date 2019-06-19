<div class="row">
    <div class="col-md-1">
        <a onClick="window.history.go(-1)" class="btn btn-primary">
            <?=$this->lang->line('application_back');?>
        </a>
    </div>

    <div class="pull-right">
        <div class="col-md-1">
            <a href="<?=base_url()?>disputeobjects/update/<?=$disputeobject->id;?>/view" class="btn btn-primary" data-toggle="mainmodal">
                <i class="icon dripicons-pencil visible-xs"></i>
                <span class="hidden-xs"><?=$this->lang->line('application_edit_dispute_object');?></span>
            </a>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="box-shadow">
                    <div class="table-head">
                        <?=$this->lang->line('application_dispute_object_details');?>
                    </div>
                    <div class="subcont">
                        <ul class="details col-xs-6 col-sm-6">
                            <li><span><?=$this->lang->line('application_dispute_id');?>:</span>
                                <?=$core_settings->disputeobject_prefix;?><?=$disputeobject->disputeobject_reference;?>
                            </li>

                            <li><span><?=$this->lang->line('application_city');?> / <?=$this->lang->line('application_state'); ?>:</span>
                                <?=$disputeobject->city;?>/
                                <?=$disputeobject->state;?>
                            </li>

                            <li><span><?=$this->lang->line('application_phone'); ?>:</span>
                                <?=$disputeobject->phone ?>
                            </li>

                            <li><span><?=$this->lang->line('application_additional_info'); ?>:</span>
                                <?=$disputeobject->additional_info ?>
                            </li>

                            <span class="visible-xs"></span>
                        </ul>
                        <ul class="details col-xs-6 col-sm-6">


                            <li><span><?=$this->lang->line('application_owner_name');?>:</span>
                                <?=$disputeobject->owner_name;?>
                            </li>

                            <!--<li><span><?/*=$this->lang->line('application_rated_power'); */?>:</span>
                                <?/*=$disputeobject->rated_power_mod */?>
                                <?/*=$core_settings->rated_power_measurement */?>
                            </li>-->

                            <li><span><?=$this->lang->line('application_compensated_bills'); ?>:</span>
                                <?=$disputeobject->compensated_bills ?>
                            </li>

                            <!--<li><span><?/*=$this->lang->line('application_approximate_area'); */?>:</span>
                                <?/*=$disputeobject->approximate_area */?>
                                <?/*=$core_settings->area_measurement*/?>
                            </li>-->

                            <!--<li><span><?/*=$this->lang->line('application_installation_location'); */?>:</span>
                                <?/*=$disputeobject->installation_location */?>
                            </li>-->


                            <li><span><?=$this->lang->line('application_email'); ?>:</span>
                                <?=$disputeobject->email ?>
                            </li>

                            <li><span><?=$this->lang->line('application_object_reason'); ?>:</span>
                                <?=$disputeobject->object_reason ?>
                            </li>

                        </ul>

                        <br clear="all">
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="box-shadow">
                    <div class="table-head">
                        <?=$this->lang->line('application_bills');?>
                        <span class="pull-right">
                            <a href="<?=base_url()?>disputeobjects/bills/<?=$disputeobject->id;?>/add" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_add_bill');?></a>
                        </span>
                    </div>
                    <div class="table-div min-height-200">
                        <table class="table data noclick" data-searching="false" id="bills" name="bills" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                            <thead>
                            <th width="4%">
                                <?=$this->lang->line('application_id');?>
                            </th>
                            <th width="20%">
                                <?=$this->lang->line('application_type');?>
                            </th>
                            <th width="8%" style="text-align:center;">
                                <?=$this->lang->line('application_average');?>
                            </th>
                            <th width="8%" style="text-align:center;">
                                <?=$this->lang->line('application_number_of_phases');?>
                            </th>
                            <th width="4%" style="text-align: center">
                                <?=$this->lang->line('application_tariff');?>
                            </th>
                            <th width="4%" style="text-align: center">
                                <?=$this->lang->line('application_action');?>
                            </th>
                            </thead>
                            <?php
                            $arrAvg = array();
                            foreach ($disputeobject->dispute_object_has_bills as $value):?>
                            <?php array_push($arrAvg, $value->average); ?>
                                <tr id="<?=$value->id;?>">
                                    <td class="option" style="text-align:left;" width="4%">
                                        <?=$value->id;?>
                                    </td>
                                    <td style="text-align:left;">
                                        <?=$this->lang->line("application_$value->type");?>
                                    </td>
                                    <td style="text-align:center;" class="hidden-xs">
                                        <?=$value->average?> <?=$core_settings->consumn_power_measurement?>
                                    </td>
                                    <td style="text-align:center;" class="hidden-xs">
                                        <?=$this->lang->line("application_$value->number_of_phases");?>
                                    </td>
                                    <td style="text-align:center;" class="hidden-xs">
                                        <?=$core_settings->money_symbol?> <?=$value->tariff?>
                                    </td>
                                    <td style="text-align: center" class="option">
                                        <button type="button" class="btn-option btn-xs po tt" title="<?=$this->lang->line('application_delete'); ?>" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>disputeobjects/bills/<?=$disputeobject->id;?>/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a>
                  <button class='btn po-close'><?=$this->lang->line('application_no');?></button>
                  <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                            <i class="icon dripicons-cross"></i></button>
                                        <a href="<?=base_url()?>disputeobjects/bills/<?=$disputeobject->id;?>/update/<?=$value->id?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                                    </td>
                                </tr>

                            <?php endforeach;?>

                        </table>
                        <?php
                            if (count($disputeobject->dispute_object_has_bills) != 0) {
                                echo "<div style='padding:10px;text-align:right;' colspan='6'><strong>" . $this->lang->line('application_average_sum') . ":</strong> " . array_sum($arrAvg) . " " . $core_settings->consumn_power_measurement . "</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-6">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_plants');?>
                <span class="pull-right">
                            <a href="<?=base_url()?>disputeobjects/plants/<?=$disputeobject->id;?>/add" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_add_plant');?></a>
                        </span>
            </div>
            <div class="table-div min-height-200">
                <table class="table noclick" data-searching="false" id="plants" name="plants" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th width="4%">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th width="5%">
                        <?=$this->lang->line('application_ghi');?>
                    </th>
                    <th width="5%" style="text-align:center;">
                        <?=$this->lang->line('application_pr');?>
                    </th>
                    <th width="10%" style="text-align:center;">
                        <?=$this->lang->line('application_approximate_area');?>
                    </th>
                    <th width="1%" style="text-align:center;">
                        <?=$this->lang->line('application_type')?>
                    </th>
                    <th width="25%" style="text-align: center">
                        <?=$this->lang->line('application_installation_location');?>
                    </th>
                    <th width="15%" style="text-align: center">
                        <?=$this->lang->line('application_compensate_consumn');?>
                    </th>
                    <th width="20%" style="text-align: center">
                        <?=$this->lang->line('application_minimum_power_pvs');?>
                    </th>
                    <th width="8%" style="text-align: center">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($disputeobject->dispute_object_has_plants as $value):?>
                        <tr id="<?=$value->id;?>">
                            <td class="option" style="text-align:left;">
                                <?=$value->id;?>
                            </td>
                            <td style="text-align:left;">
                                <?=$value->global_horizontal_irradiance?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?=$value->performance_ratio?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?=$value->approximate_area ?>
                                <?=$core_settings->area_measurement?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?=$this->lang->line("application_$value->location_type")?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?=$value->installation_location?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?=$value->compensate_consumn?> <?=$core_settings->consumn_power_measurement;?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                            <?php

                                /*if ($value->global_horizontal_irradiance != null && $value->performance_ratio != null) {
                                    //$average = array_sum($arrAvg) / count($arrAvg);
                                   $power = $value->compensate_consumn / (0.08219178 * $value->global_horizontal_irradiance * $value->performance_ratio);

                                   echo round($power, 2).' '.$core_settings->rated_power_measurement;
                                }*/

                                echo $value->minimum_power_pvs.' '.$core_settings->rated_power_measurement;

                            ?>
                            </td>
                            <td style="text-align: center" class="option">
                                <button type="button" class="btn-option btn-xs po tt" title="<?=$this->lang->line('application_delete'); ?>" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>disputeobjects/plants/<?=$disputeobject->id;?>/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a>
                  <button class='btn po-close'><?=$this->lang->line('application_no');?></button>
                  <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i></button>
                                <a href="<?=base_url()?>disputeobjects/plants/<?=$disputeobject->id;?>/update/<?=$value->id?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                            </td>
                        </tr>

                    <?php endforeach;
                    if (count($disputeobject->dispute_object_has_plants) == 0) {
                        echo "<tr><td style=\"text-align:center;\" colspan='8'>" . $this->lang->line('application_no_plants_yet') . '</td></tr>';
                    }

                    ?>

                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="box-shadow">
                    <div class="table-head">
                        <?=$this->lang->line('application_upload');?>
                        <span class=" pull-right">
    <a href="<?=base_url()?>disputeobjects/media/<?=$disputeobject->id;?>/add" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_add_media');?></a>
</span></div>

                    <div class="media-uploader">
                        <?php $attributes = array('class' => 'dropzone', 'id' => 'dropzoneForm');
                        echo form_open_multipart(base_url()."disputeobjects/dropzone/".$disputeobject->id, $attributes); ?>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="box-shadow">
                    <div class="table-head">
                        <?=$this->lang->line('application_files');?>
                    </div>
                    <div class="table-div" style="margin-bottom: 0px;">
                        <table id="media" class="table data-media" data-searching="false" rel="<?=base_url()?>disputeobjects/media/<?=$disputeobject->id;?>" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th class="hidden"></th>
                                <th class="hidden-xs">
                                    <?=$this->lang->line('application_filename');?>
                                </th>
                                <th class="hidden-xs">
                                    <?=$this->lang->line('application_kind');?>
                                </th>
                                <th class="hidden-xs">
                                    <?=$this->lang->line('application_observations');?>
                                </th>
                                <th style="text-align: center" class="hidden-xs">
                                    <?=$this->lang->line('application_plant');?>
                                </th>
                                <!--<th class="hidden-xs"><i class="icon dripicons-download"></i></th>-->
                                <th>
                                    <?=$this->lang->line('application_action');?>
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($disputeobject->dispute_object_has_files as $file):?>

                                <tr id="<?=$file->id;?>">
                                    <td class="hidden">
                                        <?=human_to_unix($file->date);?>
                                    </td>
                                    <td class="hidden-xs">
                                        <?=$file->filename;?>
                                    </td>
                                    <td class="hidden-xs">
                                        <?php if (!empty($file->kind)) { ?>
                                            <?=$this->lang->line("application_$file->kind")?>
                                        <?php }else{ ?>
                                            <span class="label label-important"><?=$this->lang->line("application_no_kind_defined")?></span>
                                        <?php } ?>

                                    </td>
                                    <td class="hidden-xs">
                                        <?=$file->description;?>
                                    </td>
                                    <td style="text-align: center" class="hidden-xs">
                                        <?=$file->plant_id;?>
                                    </td>
                                    <!--                                    <td class="hidden-xs"><span class="label label-info tt" title="--><?//=$this->lang->line('application_download_counter');?><!--">--><?//=$file->download_counter;?><!--</span></td>-->
                                    <td class="option " width="10%">
                                        <button type="button" class="btn-option btn-xs po tt" title="<?=$this->lang->line('application_delete'); ?>" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>disputeobjects/media/<?=$disputeobject->id;?>/delete/<?=$file->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a>
                  <button class='btn po-close'><?=$this->lang->line('application_no');?></button>
                  <input type='hidden' name='td-id' class='id' value='<?=$file->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                            <i class="icon dripicons-cross"></i></button>
                                        <a href="<?=base_url()?>disputeobjects/media/<?=$disputeobject->id;?>/update/<?=$file->id;?>" title="<?=$this->lang->line('application_edit'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                                    </td>

                                </tr>

                            <?php endforeach;?>

                            </tbody>
                        </table>
                        <?php /*if (!$disputeobject->dispute_object_has_files) {
                            */?><!--
                            <div class="no-files" style="padding-top: 0px">
                                <i class="icon dripicons-cloud-upload"></i>
                                <br> Nenhum arquivo enviado ainda
                            </div>
                            --><?php
                        /*                        } */?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_disputes');?>
            </div>
            <div class="table-div min-height-200">
                <table class="data table" id="disputes" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th width="4%">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th width="20%">
                        <?=$this->lang->line('application_dispute_object_id');?>
                    </th>
                    <th width="5%" style="text-align:center;">
                        <?=$this->lang->line('application_start_date');?>
                    </th>
                    <th width="5%" style="text-align:center;">
                        <?=$this->lang->line('application_due_date');?>
                    </th>
                    </thead>
                    <?php

                    foreach ($disputes as $value):?>
                        <tr id="<?=$value->id;?>">
                            <td class="option" style="text-align:left;" width="4%">
                                <?=$value->id;?>
                            </td>
                            <td style="text-align:left;">
                                <?=$core_settings->dispute_prefix?><?=$value->dispute_reference?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($value->start_date))?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($value->due_date))?>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </table>
                <div class="pull-right">
                    <span style="font-size: 12px; font-weight: bold"><?=$this->lang->line('application_total');?>: <?=count($disputes)?> <?=$this->lang->line('application_disputes');?></span>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
</div>
</div>