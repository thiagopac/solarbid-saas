<?php

if ($dispute) { ?>
    <span id="bid_id" style="display: none"><?=$bids[0]->id?></span>
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
                            <b><?=$this->lang->line('application_start')?>:</b> <?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($dispute->start_date))?>
                        </div>
                        <div class="col-md-3">
                            <b><?=$this->lang->line('application_end')?>:</b> <?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($dispute->due_date))?>
                        </div>
                        <div class="col-md-5">
                            <b><?=$this->lang->line('application_remaining_time')?>:</b> <span id="clock"></span>

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

                <div id="label_n_participations" class="warned" style="display: none">
                    <i style="color: #27ae60; font-size: 16px; vertical-align: middle" class="icon dripicons-thumbs-up"></i>
                    <span class="tag tag--green">
                        <?=$this->lang->line('application_you_have_n_participations_dispute');?>
                    </span>
                </div>

                <div id="label_participation_is_editing" class="warned" style="display: none">
                    <i style="color: #3498db; font-size: 16px; vertical-align: middle" class="icon dripicons-document-edit"></i>
                    <span class="tag tag--blue">
                        <?=$this->lang->line('application_participations_dispute_is_not_sent');?>
                    </span>
                </div>

                <div id="label_no_participations_sent" class="warned" style="display: none">
                    <i style="color: #e74c3c; font-size: 16px; vertical-align: middle" class="icon dripicons-document-delete"></i>
                    <span class="tag tag--red">
                        <?=$this->lang->line('application_no_participations_dispute_sent_yet');?>
                    </span>
                </div>

            </div>

            <ul class="message-container">

                <?foreach ($dispute->dispute_object->dispute_object_has_plants as $idx => $plant) :?>
                <li class="item">
                    <div class="details">
                        <div class="left">
                            <label class="">
                                <?=$this->lang->line('application_plant').' '.($idx+1)?>
                            </label>
                        </div>
                        <!--<div class="right">
                            <?php /*echo $plant->id; */?>
                        </div>-->
                    </div>
                    <div class="message">
                        <p><b><?=$this->lang->line('application_minimum_power_pvs')?>: </b><?=$plant->minimum_power_pvs.' '.$core_settings->rated_power_measurement; ?></p>
                        <p><b><?=$this->lang->line('application_location_type')?>: </b><?=$this->lang->line("application_$plant->location_type")?></p>
                        <p><b><?=$this->lang->line('application_installation_location')?>: </b><?=$plant->installation_location;?></p>
                        <p><b><?=$this->lang->line('application_installation_location')?>: </b><a data-toggle='mainmodal' href=<?=base_url()."cdisputes/media/".$dispute->id."/".$plant->id?> > <?=$this->lang->line('application_click_to_view')?></a> </p>

                    </div>
                    <a class="price_plant btn btn-lg"><i class="icon glyphicon glyphicon glyphicon-usd"></i> <?=$this->lang->line('application_price_plant')?></a>
                </li>
                <?php endforeach; ?>
            </ul>

            <span>
                <div class="form-header el_send_proposal_dispute padding-left-25" style="padding-left: 25px;"><?=$this->lang->line('application_all_proposal_plants_filled')?></div>
                <div class="form-header el_participate_dispute padding-left-25" style="padding-left: 25px;"><?=$this->lang->line('application_participation_dispute_needed')?></div>
                <div class="form-header el_participate_dispute_again padding-left-25" style="padding-left: 25px;"><?=$this->lang->line('application_new_proposals_participation_dispute_needed')?></div>
                <div class="row">
                    <div class="col-md-12">
                        <button style="display: none" class="btn_send_proposal_dispute el_send_proposal_dispute pull-right btn btn--lg btn-lg btn--wide btn-success margin-right-15"><i class="icon glyphicon glyphicon glyphicon-ok"></i> <?=$this->lang->line('application_send_proposal')?></button>
                        <button style="display: none" class="btn_participate_dispute el_participate_dispute ajax-silent pull-right btn btn--lg btn-lg btn--wide btn-primary margin-right-15"><i class="icon glyphicon glyphicon glyphicon-log-in"></i> <?=$this->lang->line('application_participate_dispute')?></button>
                        <button style="display: none" class="btn_participate_dispute_again el_participate_dispute_again ajax-silent pull-right btn btn--lg btn-lg btn--wide btn-primary margin-right-15"><i class="icon glyphicon glyphicon glyphicon-pencil"></i> <?=$this->lang->line('application_new_participate_dispute')?></button>
                    </div>
                </div>
            </span>
        </div>
    </div>
<?php } ?>
    <br>
    <br>
    <script>
        jQuery(document).ready(function($) {

            var due_date = moment.tz("<?=$dispute->due_date?>", "America/Sao_Paulo");

            $('#clock').countdown(due_date.toDate(), function(event) {
                var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                $(this).html(event.strftime(totalHours + 'hr %Mmin %Ss'));
            });

            UIrender();

            function participateDispute(){

                //async participate service
                $.ajax({
                    type: "GET",
                    url: "<?=base_url()?>cdisputes/participateDisputeService/<?=$dispute->id;?>",
                    success: function(response, status, xhr) {
                        $('#count_participations').html(response.data.bids.length);
                        //update UI

                        UIrender();

                    },
                    complete: function() {

                    }
                });
            };

            $('.nano').nanoScroller();

            $('.trigger-message-close').on('click', function() {
                $('body').removeClass('show-message');
                $('#main .message-list li').removeClass('active');
                $("#main .message-list li .indicator").removeClass('dripicons-chevron-right');
                $("#main .message-list li .indicator").addClass('dripicons-chevron-down');
                messageIsOpen = false;
                $('body').removeClass('show-main-overlay');
            });


            $(".btn_participate_dispute, .btn_participate_dispute_again").confirmation({
                placement       : 'top',
                title           : '<?=$this->lang->line('application_are_you_sure')?>',
                btnOkClass      : 'btn btn-sm btn-success',
                btnOkLabel      : '<?=$this->lang->line('application_sure')?>',
                btnOkIcon       : 'glyphicon glyphicon-ok',
                btnCancelClass  : 'btn btn-sm btn-danger',
                btnCancelLabel  : '<?=$this->lang->line('application_no')?>',
                btnCancelIcon   : 'glyphicon glyphicon-remove',
                onConfirm: function() {
                    participateDispute();
                },
                onCancel: function() {
                    //do nothing
                }
            });

            $(".btn_send_proposal_dispute").confirmation({
                placement       : 'top',
                title           : '<?=$this->lang->line('application_are_you_sure')?>',
                btnOkClass      : 'btn btn-sm btn-success',
                btnOkLabel      : '<?=$this->lang->line('application_sure')?>',
                btnOkIcon       : 'glyphicon glyphicon-ok',
                btnCancelClass  : 'btn btn-sm btn-danger',
                btnCancelLabel  : '<?=$this->lang->line('application_no')?>',
                btnCancelIcon   : 'glyphicon glyphicon-remove',
                onConfirm: function() {
                    //send bid and proposal
                },
                onCancel: function() {
                    //do nothing
                }
            });

            //get all screen components
            function UIrender() {
                $.ajax({
                    type: "GET",
                    url: "<?=base_url()?>cdisputes/allBidsByCompanyInDispute/<?=$this->client->company_id;?>/<?=$dispute->id;?>",
                    success: function(response, status, xhr) {

                        //already created one or more bids
                        if (response.data.bids.length > 0) {

                            var viewing_bid = response.data.bids[0];

                            $('#bid_id').html(response.data.bids[0].id);


                            $('#count_participations').html(response.data.bids_sent); //inside language file

                            //already sent one or more bids
                            if (response.data.bids_sent > 0){
                                $('#label_n_participations').attr('style', 'display: initial');
                                $('#el_participate_dispute').attr('style', 'display: none');
                            }

                            //viewing bid is sent
                            if (viewing_bid.bid_sent == 'yes'){
                                $('.price_plant').attr('style', 'display: none');

                                $('.el_send_proposal_dispute').attr('style', 'display: none');
                                $('.el_participate_dispute').attr('style', 'display: none');
                                $('.el_participate_dispute_again').attr('style', 'display: block');

                                $('#label_n_participations').attr('style', 'display: block');
                                $('#label_participation_is_editing').attr('style', 'display: none');
                            }else{//viewing bid not sent yet
                                $('.price_plant').attr('style', 'display: initial');

                                $('.el_send_proposal_dispute').attr('style', 'display: block');
                                $('.el_participate_dispute').attr('style', 'display: none');
                                $('.el_participate_dispute_again').attr('style', 'display: none');

                                $('#label_n_participations').attr('style', 'display: none');
                                $('#label_participation_is_editing').attr('style', 'display: block');
                                $('#label_no_participations_sent').attr('style', 'display: none');
                            }

                        }else{ //no bids created for this dispute

                            $('.el_send_proposal_dispute').attr('style', 'display: none');
                            $('.el_participate_dispute').attr('style', 'display: block');
                            $('.el_participate_dispute_again').attr('style', 'display: none');

                            $('.price_plant').attr('style', 'display: none');

                            $('#label_no_participations_sent').attr('style', 'display: initial');
                        }

                    },
                    complete: function() {}
                });
            }

        });
    </script>

<?=$disputes?>