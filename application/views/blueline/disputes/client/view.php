<?php

if ($dispute) { ?>

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
                <p class="subtitle">
                    <i style="color: orange; font-size: 16px; vertical-align: middle" class="icon dripicons-warning"></i>
                    <span class="tag tag--orange">
                        <?=$this->lang->line('application_dispute_minimum_bids');?>
                    </span>
                </p>
                <?php endif; ?>
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
                        <p><b><?=$this->lang->line('application_installation_location')?>: </b><a data-toggle='mainmodal' href=<?=base_url()."cdisputes/media/".$dispute->id."/".$plant->id?> ><?=$this->lang->line('application_area')?></a> (<?=$this->lang->line('application_file')?>)</p>

                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
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

            $('.nano').nanoScroller();
            $('.trigger-message-close').on('click', function() {
                $('body').removeClass('show-message');
                $('#main .message-list li').removeClass('active');
                messageIsOpen = false;
                $('body').removeClass('show-main-overlay');
            });
        });
    </script>

<?=$disputes?>