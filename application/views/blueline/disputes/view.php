<div class="row">
    <div class="col-md-1">
        <a onClick="window.history.go(-1)" class="btn btn-primary">
            <?=$this->lang->line('application_back');?>
        </a>
    </div>


    <!--<div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?/*=$this->lang->line('application_pdf');*/?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="<?/*=base_url()*/?>disputes/preview/<?/*=$dispute->id;*/?>"><?/*=$this->lang->line('application_download_pdf');*/?></a></li>
            <li><a href="<?/*=base_url()*/?>disputes/preview/<?/*=$dispute->id;*/?>/proposal" target="_blank"><?/*=$this->lang->line('application_preview_pdf');*/?></a></li>
        </ul>
    </div>-->

    <div class="pull-right">
        <div class="col-md-4">
            <button <?=$dispute->dispute_sent == 'no' ? '' : 'disabled'?> href="<?=base_url()?>disputes/update/<?=$dispute->id;?>/view" class="btn btn-primary" data-toggle="mainmodal">
                <i class="icon dripicons-pencil visible-xs"></i>
                <span class="hidden-xs"><?=$this->lang->line('application_edit_dispute');?></span>
            </button>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_dispute_details');?>
                <?php

                $label_state = "";

                switch ($dispute->status) {
                    case 'scheduled':
                        $label_state = "label-warning";
                        break;

                    case 'in_progress':
                        $label_state = "label-success";
                        break;

                    case 'suspended':
                        $label_state = "label-important";
                        break;

                    case 'completed':
                        $label_state = "label-info";
                        break;

                    default:
                        $label_state = "label-primary";
                }

                ?>
                <span class="label <?=$label_state?>" style="vertical-align: middle"><?=$this->lang->line("application_".$dispute->status)?></span>
                <div class="pull-right">
                    <span id="clock" style="text-transform: lowercase; font-size: 18px"></span>
                </div>
            </div>
            <div class="subcont">
                <ul class="details col-xs-12 col-sm-6">
                    <li><span><?=$this->lang->line('application_dispute_id');?>:</span>
                        <?=$core_settings->dispute_prefix;?>
                        <?=$dispute->dispute_reference;?>
                    </li>
                    <li class="<?=$dispute->dispute_sent;?>"><span><?=$this->lang->line('application_Sent');?>:</span>
                        <span class="label <?=$dispute->dispute_sent == 'yes' ? 'label-success' : 'label-important';?> tt"><?=$this->lang->line('application_' . $dispute->dispute_sent);?></span>
                    </li>
                    <li><span><?=$this->lang->line('application_start_date');?>:</span>
                        <?=fnDateYMDHItoDMYHI($dispute->start_date);?>
                    </li>

                    <li><span><?=$this->lang->line('application_due_date'); ?>:</span>
                        <?=fnDateYMDHItoDMYHI($dispute->due_date);?>
                    </li>

                    <li><span><?=$this->lang->line('application_dispute_object'); ?>:</span> <a href="<?=base_url()?>disputeobjects/view/<?=$dispute->dispute_object->id; ?>" class="label label-info"><?=$dispute->dispute_object->id.' -     '.$dispute->dispute_object->owner_name; ?></a></li>

                    <span class="visible-xs"></span>
                </ul>
                <ul class="details col-xs-12 col-sm-6">


                    <li><span><?=$this->lang->line('application_city').' / '.$this->lang->line('application_state'); ?>:</span>
                        <?=$dispute->dispute_object->city; ?>/<?=$dispute->dispute_object->state; ?>
                    </li>
                    <li>
                        <span><?=$this->lang->line('application_assign_plants_to_dispute'); ?>:
                            <?php
                                if(!empty($plants)){
                                    foreach ($plants as $plant) : ?>
                                        <?="<span class='minus'> [".$plant->minimum_power_pvs." ".$core_settings->rated_power_measurement."] </span>"?>
                                    <?php endforeach;
                                }else{?>
                                        <?="<span class='minus'> [".$this->lang->line('application_no_plant_assigned')."] </span>"?>
                                <?php } ?>
                        </span>
                        <button <?=$dispute->dispute_sent == 'no' ? '' : 'disabled'?> href="<?=base_url()?>disputes/assignplant/<?=$dispute->id;?>" style="padding: 3px 12px; width: 180px;" class="btn btn-danger" data-toggle="mainmodal">
                            <span class="hidden-xs"><?=$this->lang->line('application_select_plants');?></span>
                        </button>

                    </li>
                    <li>
                        <span><?=$this->lang->line('application_select_dispute_participation_rule'); ?>:
                        <?php
                        if($dispute->rule_name != ""){ ?>
                            <?='<span class="minus"> ['.$this->lang->line("application_rule").': '.$this->lang->line("application_$dispute->rule_name").'] ['.$this->lang->line("application_selection").': '.count(explode(',',$dispute->rule_value)).'] ['.$this->lang->line("application_level").": ".$dispute->rule_level.']</span>'?>
                        <?}else{?>
                            <?="<span class='minus'> [".$this->lang->line('application_no_rule_assigned')."] </span>"?>
                        <?php } ?>
                        </span>
                        <button <?=$dispute->dispute_sent == 'no' ? '' : 'disabled'?> href="<?=base_url()?>disputes/ruleparticipation/<?=$dispute->id;?>" style="padding: 3px 12px; width: 180px" class="btn btn-warning" data-toggle="mainmodal">
                            <span class="hidden-xs"><?=$this->lang->line('application_dispute_participation_rule');?></span>
                        </button>
                    </li>
                    <li>
                        <span>
                            <?=$this->lang->line('application_calculate_range_dispute'); ?>:
                            <?=$range=is_numeric($dispute->range_participants) && $dispute->range_participants > 0 ? "<a data-toggle='mainmodal' href=".base_url()."disputes/participants/".$dispute->id."><span class='minus'> [".$dispute->range_participants." ".$this->lang->line('application_recipients')."] <span style='text-transform: capitalize; text-decoration: underline'>".$this->lang->line('application_show_participants')."</span> </span></a>" : "<span class='minus'> [".$this->lang->line('application_range_must_be_calculated')."] </span>";?>
                        </span>
                        <a id="calculate_link" <?=$dispute->dispute_sent == 'no' ? '' : 'disabled'?> href="<?=base_url()?>disputes/calculateparticipants/<?=$dispute->id;?>" style="padding: 3px 12px; width: 180px" class="btn btn-primary">
                            <span class="hidden-xs"><?=$this->lang->line('application_calculate_participants');?></span>
                        </a>
                    </li>
                    <li>
                        <a id="start_link" <?=(is_numeric($dispute->range_participants) && $dispute->range_participants > 0) && $dispute->dispute_sent == 'no' ? '' : 'disabled'?> href="<?=base_url()?>disputes/startdispute/<?=$dispute->id;?>" style="padding: 12px 12px; width: 180px" class="btn btn-success">
                            <span class="hidden-xs"><?=$this->lang->line('application_start_dispute');?></span>
                        </a>
                    </li>
                    <span class="visible-xs"></span>
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
                <?=$this->lang->line('application_bids');?>
            </div>
            <div class="table-div min-height-200">
                <table class="data table noclick" id="bids_" data-page-length='100' rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th class="no-sort" width="2%">

                    </th>
                    <th width="4%">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th width="15%">
                        <?=$this->lang->line('application_integrator');?>
                    </th>
                    <th width="10%" style="text-align:center;">
                        <?=$this->lang->line('application_value');?>
                    </th>
                    <th width="5%" style="text-align:center;" class="hidden-xs">
                        <?=$this->lang->line('application_rated_power');?>
                    </th>
                    <th style="text-align:center;" class="hidden-xs" width="15%">
                        <?=$this->lang->line('application_modules');?>
                    </th>
                    <th style="text-align:center;" class="hidden-xs" width="15%">
                        <?=$this->lang->line('application_inverters');?>
                    </th>
                    <th style="text-align:center;" class="hidden-xs" width="8%">
                        <?=$this->lang->line('application_sent_date');?>
                    </th>
                    <th style="text-align:right;" class="hidden-xs" width="8%">
                        <?=$this->lang->line('application_occupied_area');?>
                    </th>
                    </thead>
                    <?php foreach ($bids as $value):?>
                        <tr id="<?=$value->id;?>" data-proposals="<?=$value->html?>">
<!--                        <tr id="--><?//=$value->id;?><!--" data-proposals=''>-->
                            <td class="noclick <?=count($value->bid_has_proposals) > 1 ? 'details-control' : '' ;?>  no-sort">
                                <i class="btn-option icon dripicons-plus <?=count($value->bid_has_proposals) > 1 ? '' : 'hidden' ;?>"></i>
                            </td>
                            <td class="option" style="text-align:left;"  width="4%">
                                <?=$value->id;?>
                            </td>
                            <td style="text-align:left;">
                                <?=$value->company->name?>
                            </td>
                            <td style="text-align:center;">
                                <?=count($value->bid_has_proposals) == 1 ? $core_settings->money_symbol." ".display_money(sprintf('%01.2f',$value->bid_has_proposals[0]->value)) : count($value->bid_has_proposals)." valores (".$core_settings->money_symbol.' '.display_money(array_sum(array_column($value->bid_has_proposals, 'value'))).")"?>
                            </td>
                            <td style="text-align:center;">
                                <?=count($value->bid_has_proposals) == 1 ?  $value->bid_has_proposals[0]->rated_power_mod." ".$core_settings->rated_power_measurement : count($value->bid_has_proposals)." valores (".array_sum(array_column($value->bid_has_proposals, 'rated_power_mod'))." ".$core_settings->rated_power_measurement.")"?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?php if (count($value->bid_has_proposals) == 1) {
                                    echo $value->bid_has_proposals[0]->module_brands;
                                }else{
                                    echo count($value->bid_has_proposals)." valores";
                                }
                                ?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?php if (count($value->bid_has_proposals) == 1) {
                                    echo $value->bid_has_proposals[0]->inverter_brands;
                                }else{
                                    echo count($value->bid_has_proposals)." valores";
                                }
                                ?>
                            </td>
                            <td style="text-align:center;" class="hidden-xs">
                                <?=fnDateYMDHItoDMYHI($value->timestamp)?>
                            </td>
                            <td style="text-align:right;">
                                <?=count($value->bid_has_proposals) == 1 ? $value->bid_has_proposals[0]->occupied_area_mod." ".$core_settings->area_measurement : count($value->bid_has_proposals)." valores (".array_sum(array_column($value->bid_has_proposals, 'occupied_area_mod'))." ".$core_settings->area_measurement.")"?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </table>
            </div>
        </div>
        <div class="row">

            <div class=" col-md-12" align="right">

            </div>
        </div>

        <br>
    </div>
</div>

<script>
$(document).ready(function(){

    var detailRows = [];

    if ($('#calculate_link').attr("disabled") == "disabled") {
        $('#calculate_link').removeAttr("href");
    }

    if ($('#start_link').attr("disabled") == "disabled") {
        $('#start_link').removeAttr("href");
    }

    $('#bids_ tbody').on('click', 'tr td.details-control', function () {

        var dt = $("#bids_").DataTable();

        var tr = $(this).closest('tr');
        var td = $(this).closest('td');
        var icon = td.closest('i');
        var row = dt.row(tr);
        var idx = $.inArray(tr.attr('id'),detailRows);

        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();
            td.html('<i class="btn-option icon dripicons-plus"></i> ');
            // Remove from the 'open' array
            detailRows.splice(idx,1);
        }
        else {
            tr.addClass('details');
            td.html('<i class="btn-option icon dripicons-minus"></i> ');
            row.child(tr.attr('data-proposals')).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });

    var due_date = moment.tz("<?=$dispute->due_date?>", "America/Sao_Paulo");

    $('#clock').countdown(due_date.toDate(), function(event) {
        var totalHours = event.offset.totalDays * 24 + event.offset.hours;
        $(this).html(event.strftime(totalHours + 'hr %Mmin %Ss'));
    });

    /*$('#clock').countdown(due_date.toDate(), function(event) {

        var str_day = event.strftime('%d') != 1 ? 'dias' : 'dia';

        $(this).html(event.strftime('%D '+str_day+' %H:%M:%S'));
    });*/

    /*$('#clock').countdown(due_date.toDate()).on('update.countdown', function(event) {

        var str_week = event.strftime('%w') != 1 ? 'semanas' : 'semana';
        var str_day = event.strftime('%d') != 1 ? 'dias' : 'dia';
        var str_hour = event.strftime('%H') != 1 ? 'horas' : 'hora';
        var str_minute = event.strftime('%M') != 1 ? 'minutos' : 'minuto';
        var str_second = event.strftime('%s') != 1 ? 'segundos' : 'segundo';

        var $this = $(this).html(event.strftime(''
            + '<span>%-w</span> '+str_week+' %!w '
            + '<span>%-d</span> '+str_day+' %!d '
            + '<span>%H</span> '+str_hour+' '
            + '<span>%M</span> '+str_minute+' '
            + '<span>%S</span> '+str_second+' '));
    });*/

});
</script>