<div class="col-sm-12  col-md-12 main">

    <div class="row">
        <a href="<?=base_url()?>disputes/create" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_create_dispute');?></a>
        <div class="btn-group pull-right-responsive margin-right-3">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if ($last_uri != 'disputes') {
                    echo $this->lang->line('application_' . $last_uri);
                } else {
                    echo $this->lang->line('application_all');
                } ?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">

                <?php foreach ($submenu as $name => $value):?>

                    <?/* echo "<script>console.log( 'Debug Objects: " . $name . "' );</script>";*/?>
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
    </div>
    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_disputes');?>
            </div>
            <div class="table-div">
                <table class="data table" id="disputes" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th width="70px" class="hidden-xs">
                        <?=$this->lang->line('application_dispute_id');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_client');?>
                    </th>

                    <!--<th style="text-align: center" class="hidden-xs">
                        <?/*=$this->lang->line('application_rated_power');*/?>
                    </th>-->

                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_start_date');?>
                    </th>
                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_due_date');?>
                    </th>
                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_remaining_time');?>
                    </th>
                    <th style="text-align: center">
                        <?=$this->lang->line('application_Sent');?>
                    </th>
                    <th style="text-align: center">
                        <?=$this->lang->line('application_status');?>
                    </th>
                    <th style="text-align: center">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <tbody>
                    <?php foreach ($disputes as $value): ?>
                        <tr <?=$value->inactive == 'yes' ? "style='text-decoration:line-through;'" : ''?>  id="<?=$value->id;?>">
                            <td class="hidden-xs">
                                <?=$core_settings->dispute_prefix;?><?=$value->dispute_reference;?>
                            </td>
                            <td>
                                <?=$value->dispute_object->owner_name;?>
                            </td>

                            <!--<td style="text-align: center">
                                <?/*=$value->dispute_object->rated_power_mod;*/?> <?/*=$core_settings->rated_power_measurement*/?>
                            </td>-->

                            <td style="text-align: center" class="hidden-xs"><span><?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($value->start_date))?></span>
                            </td>
                            <td style="text-align: center" class="hidden-xs"><span><?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($value->due_date))?></span>
                            </td>
                            <td style="text-align: center" class="hidden-xs" id="clock" data-countdown="<?=$value->due_date;?>"></span>
                            </td>
                            <td style="text-align: center"><span class="label <?=$value->dispute_sent == 'yes' ? 'label-success' : 'label-important';?> tt" ><?=$this->lang->line('application_'.$value->dispute_sent) ?></span></td>
                            <?php

                                $label_state = "";

                                switch ($value->status) {
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
                            <td style="text-align: center"><span class="label <?=$label_state;?> tt" ><?=$this->lang->line('application_'.$value->status) ?></span></td>
                            <td class="option" width="8%" style="text-align: center">
                                <button <?=$value->dispute_sent == 'no' ? '' : 'disabled style="color:lightgray"'?> href="<?=base_url()?>disputes/update/<?=$value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>


<script>
$(document).ready(function(){


    $('[data-countdown]').each(function() {
        var $this = $(this), finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function(event) {
            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
            $this.html(event.strftime(totalHours+'hr %Mmin %Ss'));
        });
    });

});
</script>