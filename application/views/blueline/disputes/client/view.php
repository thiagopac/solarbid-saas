<?php

if ($dispute->inactive == 'no') { ?>

    <?php if ($this->session->flashdata('message')) {
        $exp = explode(':', $this->session->flashdata('message'));
    } ?>

    <div id="message-nano-wrapper" class="nano ">
        <div class="nano-content">
            <div class="header">
                <div class="message-content-menu">
                    <?if ($exp != null):?>
                        <div class="alert alert-<?=$exp[0]?>">
                            <button id="alert-close" class="close" type="button" data-dismiss="alert">×</button>
                            <?=$exp[1]?>
                        </div>
                    <?php endif;?>
                    <h1 class="page-title"><?=$this->lang->line('application_dispute').": ".$core_settings->dispute_prefix.$dispute->dispute_reference?></h1>
                </div>

                <span class="page-title">
                    <a class="icon glyphicon glyphicon-chevron-right trigger-message-close"></a>

                </span>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <b><?=$this->lang->line('application_start')?>:</b> <?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($dispute->start_date))?>
                        </div>
                        <div class="col-md-3">
                            <b><?=$this->lang->line('application_end')?>:</b> <?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($dispute->due_date))?>
                        </div>
                        <div class="col-md-5">
                            <b><?=$this->lang->line('application_remaining_time')?>:</b> <span class="<?php echo $out_of_date == true ? 'tag tag--red' : 'tag tag--green' ?>" id="clock"></span>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <b><?=$this->lang->line('application_address')?>:</b> <?=$dispute->dispute_object->city."/".$dispute->dispute_object->state?>
                        </div>
                        <div class="col-md-3">
                            <b><?=$this->lang->line('application_compensate_bills')."</b>: ".$dispute->dispute_object->compensated_bills; ?>
                        </div>
                        <div class="col-md-5">
                            <b><?=$this->lang->line('application_minimum_power_pvs')?>:</b> <?=array_sum(array_column($dispute->dispute_object->dispute_object_has_plants, 'minimum_power_pvs'))." ".$core_settings->rated_power_measurement?>
                        </div>
                    </div>
                </div>

                <?php if(count($dispute->dispute_object->dispute_object_has_plants) > 1) : ?>
                <!--<div class="warned" style="display: block">
                    <i style="color: orange; font-size: 16px; vertical-align: middle" class="icon dripicons-warning"></i>
                    <span class="tag tag--orange">
                        <?/*=$this->lang->line('application_dispute_minimum_bids');*/?>
                    </span>
                </div>-->
                <?php endif; ?>

                <!--one of more bids sent-->
                <?php if($sent) : ?>
                <div id="label_n_participations" class="warned">
                    <i style="color: #27ae60; font-size: 16px; vertical-align: middle" class="icon dripicons-thumbs-up"></i>
                    <span class="tag tag--green">
                        <?=sprintf($this->lang->line('application_you_have_n_participations_dispute'), $sent);?>
                    </span>
                </div>
                <?php endif; ?>

                <!--current bit not sent-->
                <?php if($viewing_bid->bid_sent == 'no') : ?>
                <div id="label_participation_is_editing" class="warned">
                    <i style="color: #3498db; font-size: 16px; vertical-align: middle" class="icon dripicons-document-edit"></i>
                    <span class="tag tag--blue">
                        <?=$this->lang->line('application_participations_dispute_is_not_sent');?>
                    </span>
                </div>
                <?php endif; ?>

                <!--no bids at all-->
                <?php if(count($bids) < 1) : ?>
                <div id="label_no_participations_sent" class="warned">
                    <i style="color: orange; font-size: 16px; vertical-align: middle" class="icon dripicons-document-delete"></i>
                    <span class="tag tag--orange">
                        <?=$this->lang->line('application_no_participations_dispute_sent_yet');?>
                    </span>
                </div>
                <?php endif; ?>

                <!--out of date-->
                <?php if($out_of_date == true) : ?>
                    <div id="label_out_of_date" class="warned">
                        <i style="color: #e74c3c; font-size: 16px; vertical-align: middle" class="icon dripicons-clock"></i>
                        <span class="tag tag--red">
                        <?=$this->lang->line('application_dispute_out_of_date');?>
                    </span>
                    </div>
                <?php endif; ?>

            </div>

            <ul class="message-container">

                <?foreach ($dispute->dispute_object->dispute_object_has_plants as $idx => $plant) :?>
                <li class="dispute-plant">
                    <div class="details" style="padding-top: 20px">
                        <div class="left">
                            <label style="font-size: 15px" class="">
                                <?=$this->lang->line('application_plant').' <span style="font-family:Monospace; font-size: 16px;">'.strtoupper(substr(md5($plant->id), 20, 5)).'</span>'?>
                            </label>
                        </div>

                        <?php if ($viewing_bid->bid_sent == "no" && $out_of_date == false) : ?>
                            <?php if (in_array($plant->id, $plants_with_proposal) == false) : ?>
                        <div class="right">
                            <a class="price_plant btn btn-small" href="<?=base_url()?>cdisputes/createProposal/<?=$dispute->id;?>/<?=$viewing_bid->id;?>/<?=$plant->id;?>" data-toggle="mainmodal"><i class="icon glyphicon glyphicon glyphicon-usd"></i> <?=$this->lang->line('application_price_plant')?></a>
                        </div>
                            <?php else: ?>
                        <div class="right">
                            <label class="tag tag--grey"> <?=$this->lang->line('application_price_done')?></label>
                        </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="plant">
                        <p><b><?=$this->lang->line('application_minimum_power_pvs')?>: </b><?=$plant->minimum_power_pvs.' '.$core_settings->rated_power_measurement; ?></p>
                        <p><b><?=$this->lang->line('application_location_type')?>: </b><?=$this->lang->line("application_$plant->location_type")?></p>
                        <p><b><?=$this->lang->line('application_installation_location')?>: </b><?=$plant->installation_location;?></p>
                        <p><b><?=$this->lang->line('application_installation_location')?>: </b><a data-toggle='mainmodal' href=<?=base_url()."cdisputes/media/".$dispute->id."/".$plant->id?> > <?=$this->lang->line('application_click_to_view')?></a> </p>

                    </div>

                </li>
                <?php endforeach; ?>
            </ul>
            <span>

                <!-- Listing bids -->
<!--                <div class="form-header el_table_proposals padding-left-25" style="padding-left: 25px;">--><?//=$this->lang->line('application_your_proposals_for_dispute')?><!--</div>-->
<!--                <input type="button" class=" dynamic-reload" data-reload="proposals" />-->

                <?php if (count($proposals) > 0) : ?>
                <div style="width: auto; display: block; margin: 0 auto;" id="el_table_proposals" class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="">
                                <div class="table-head" style="color: #0081ff;font-weight: 600; font-size: 11px; padding: 5px 25px 5px; text-transform: uppercase; height: 40px; letter-spacing: normal">
                                    <?=$this->lang->line('application_your_proposals_for_dispute')?>
                                </div>
                                <div class="table-div">
                                    <table class="table" id="proposals" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <th width="15%">
                                                <?=$this->lang->line('application_plant');?>
                                            </th>
                                            <th>
                                                <?=$this->lang->line('application_value');?>
                                            </th>
                                            <th width="25%" style="text-align: center">
                                                <?=$this->lang->line('application_rated_power');?>
                                            </th>
                                            <?php if ($viewing_bid->bid_sent == no) : ?>
                                            <th style="text-align: center">
                                                <?=$this->lang->line('application_edit');?>
                                            </th>
                                            <?php endif; ?>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($proposals as $proposal): ?>
                                                <tr id="<?=$proposal->id;?>">
                                                        <td>
                                                            <?=strtoupper(substr(md5($proposal->plant_id), 20, 5));?>
                                                        </td>
                                                        <td>
                                                            <?=$core_settings->money_symbol." ".display_money(sprintf('%01.2f', $proposal->value))?>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?=$proposal->rated_power_mod;?>
                                                            <?=$core_settings->rated_power_measurement;?>
                                                        </td>
                                                        <?php if ($viewing_bid->bid_sent == no) : ?>
                                                        <td style="text-align: center" class="option" width="8%">
                                                            <a href="<?=base_url()?>cdisputes/updateProposal/<?=$dispute->id;?>/<?=$proposal->id;?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                                                        </td>
                                                        <?php endif; ?>
                                                </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php endif; ?>

                <!--no bids at all-->
                <?php if(count($bids) < 1 && $out_of_date == false) : ?>
                    <!-- Participate Dispute -->
                    <div class="form-header el_participate_dispute padding-left-25" style="padding-left: 25px;"><?=$this->lang->line('application_participation_dispute_needed')?></div>
                    <div id="el_participate_dispute" class="row">
                    <div class="col-md-12">
                        <a class="btn_participate_dispute el_participate_dispute ajax-silent pull-right btn btn--lg btn-lg btn--wide btn-primary margin-right-15" href=<?=base_url()."cdisputes/participateDispute/".$dispute->id?> data-toggle='mainmodal' ><i class="icon glyphicon glyphicon glyphicon-log-in"></i> <?=$this->lang->line('application_participate_dispute')?></a>
                    </div>
                </div>
                <?php endif; ?>

                <!--bid is sent-->
                <?php if(count($bids) > 0 && $viewing_bid->bid_sent == 'yes' && $out_of_date == false) : ?>
                    <!-- Participate Dispute again -->
                    <div class="form-header el_participate_dispute_again padding-left-25" style="padding-left: 25px;"><?=$this->lang->line('application_new_proposals_participation_dispute_needed')?></div>
                    <div id="el_participate_dispute_again" class="row">
                    <div class="col-md-12">
                        <a class="btn_participate_dispute_again el_participate_dispute_again ajax-silent pull-right btn btn--lg btn-lg btn--wide btn-primary margin-right-15" href=<?=base_url()."cdisputes/participateDispute/".$dispute->id?> data-toggle='mainmodal'><i class="icon glyphicon glyphicon glyphicon-pencil"></i> <?=$this->lang->line('application_new_participate_dispute')?></a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Qty of plants equal number of proposals -->
                <?php if (count($dispute->dispute_object->dispute_object_has_plants) == count($proposals) && $viewing_bid->bid_sent == "no" && $out_of_date == false) : ?>
                <!-- Send Proposal -->
                <div class="form-header el_send_proposal_dispute padding-left-25" style="padding-left: 25px;"><?=$this->lang->line('application_all_proposal_plants_filled')?></div>
                <div id="el_send_proposal_dispute" class="row">
                    <div class="col-md-12">
                        <a class="btn_send_proposal_dispute el_send_proposal_dispute pull-right btn btn--lg btn-lg btn--wide btn-success margin-right-15" href=<?=base_url()."cdisputes/sendBid/".$dispute->id."/".$viewing_bid->id?> data-toggle='mainmodal'><i class="icon glyphicon glyphicon glyphicon-ok"></i> <?=$this->lang->line('application_send_proposal')?></a>
                    </div>
                </div>
                <?php endif; ?>

            </span>
        </div>
    </div>
<?php }else{ ?>
    <div id="message-nano-wrapper" class="nano ">
        <div class="nano-content">
            <div class="header">
                <div class="message-content-menu">
                    <h1 class="page-title"><?=$this->lang->line('application_dispute').": ".$core_settings->dispute_prefix.$dispute->dispute_reference?></h1>
                </div>

                <span class="page-title">
                    <a class="icon glyphicon glyphicon-chevron-right trigger-message-close"></a>

                </span>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <b><?=$this->lang->line('application_start')?>:</b> <i style="vertical-align: text-top; color: lightslategrey" class="icon glyphicon glyphicon glyphicon-ban-circle"></i>
                        </div>
                        <div class="col-md-3">
                            <b><?=$this->lang->line('application_end')?>:</b> <i style="vertical-align: text-top; color: lightslategrey" class="icon glyphicon glyphicon glyphicon-ban-circle"></i>
                        </div>
                        <div class="col-md-5">
                            <b><?=$this->lang->line('application_remaining_time')?>:</b> <i style="vertical-align: text-top; color: lightslategrey" class="icon glyphicon glyphicon glyphicon-ban-circle"></i>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <b><?=$this->lang->line('application_address')?>:</b> <i style="vertical-align: text-top; color: lightslategrey" class="icon glyphicon glyphicon glyphicon-ban-circle"></i>
                        </div>
                        <div class="col-md-3">
                            <b><?=$this->lang->line('application_compensate_bills')?>:</b><i style="vertical-align: text-top; color: lightslategrey" class="icon glyphicon glyphicon glyphicon-ban-circle"></i>
                        </div>
                        <div class="col-md-5">
                            <b><?=$this->lang->line('application_minimum_power_pvs')?>:</b> <i style="vertical-align: text-top; color: lightslategrey" class="icon glyphicon glyphicon glyphicon-ban-circle"></i>
                        </div>
                    </div>
                </div>

                <div id="label_no_participations_sent" class="warned">
                    <i style="color: #e74c3c; font-size: 16px; vertical-align: middle" class="icon dripicons-flag"></i>
                    <span class="tag tag--red">
                        <?=$this->lang->line('application_dispute_inactive');?>
                    </span>
                </div>

            </div>

            <ul class="message-container"></ul>
        </div>
    </div>
<?php }?>
    <br>
    <br>
<script>
    jQuery(document).ready(function($) {

        var due_date = moment.tz("<?=$dispute->due_date?>", "America/Sao_Paulo");

        $('#clock').countdown(due_date.toDate(), function(event) {
            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
            $(this).html(event.strftime(totalHours + 'hr %Mmin %Ss'));
        });

        $('#alert-close').on('click', function () {
           $(this).closest('.alert').hide();
        });

        $('.nano').nanoScroller();

        $('.trigger-message-close').on('click', function() {
            $('body').removeClass('show-message');
            $('#main .message-list li').removeClass('active');
            $("#main .message-list li .indicator").removeClass('dripicons-chevron-right');
            $("#main .message-list li .indicator").addClass('dripicons-chevron-down');
            messageIsOpen = false;
            $('body').removeClass('show-main-overlay');
        });

    });
</script>