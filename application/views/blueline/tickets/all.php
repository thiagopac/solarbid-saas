<div class="col-sm-12  col-md-12 main">

    <div class="row tile-row">

        <div class="tile-button">
            <a href="<?= base_url() ?>tickets/create" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-android-add-circle"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_create_new_ticket'); ?>
                </span>
                    </h1>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xs-12 tile hidden-xs">
            <div style="width:97%; margin-top: -4px; margin-bottom: 17px; height: 80px;">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="btn-group pull-right-responsive margin-right-3">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php if (isset($activeQueue)) {
                    echo $activeQueue->name;
                } else {
                    echo $this->lang->line('application_queue');
                }?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li><a id="" href="<?=base_url()?>tickets/"><?=$this->lang->line('application_all');?></a></li>
                <?php foreach ($queues as $value):?>
                    <li><a id="" href="<?=base_url()?>tickets/queues/<?=$value->id?>" <?php if ($this->user->queue == $value->id) {
                            echo 'style="font-weight: bold;"';
                        }?>><?=$value->name?></a></li>
                <?php endforeach;?>

            </ul>
        </div>
        <div class="btn-group pull-right-responsive margin-right-3">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php if (isset($ticketFilter)) {
                    echo $ticketFilter;
                }else{
                    echo $this->lang->line('application_filter');
                }
                ?>
                <span class="caret"></span>
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
        <div class="btn-group pull-right-responsive margin-right-3 hidden-xs">
            <button id="bulk-button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?=$this->lang->line('application_bulk_actions');?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right bulk-dropdown" role="menu">

                <li data-action="close"><a id="" href="#"><?=$this->lang->line('application_close');?></a></li>

            </ul>
            <?php
            $form_action = base_url() . 'tickets/bulk/';
            $attributes = ['class' => '', 'id' => 'bulk-form'];
            echo form_open($form_action, $attributes); ?>
            <input type="hidden" name="list" id="list-data" />
            </form>
        </div>
    </div>
    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_tickets');?>
            </div>
            <div class="table-div">
                <table class="data-sorting table" id="tickets" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th class="hidden-xs no_sort simplecheckbox" style="width:16px">
                        <input class="checkbox-nolabel" type="checkbox" id="checkAll" name="selectall" value="">
                    </th>
                    <th class="hidden-xs" style="width:70px">
                        <?=$this->lang->line('application_ticket_id');?>
                    </th>
                    <th style="width:50px">
                        <?=$this->lang->line('application_status');?>
                    </th>
                    <th class="hidden-xs no_sort" style="width:5px; padding-right: 5px;"><i class="icon dripicons-star"></i></th>
                    <th>
                        <?=$this->lang->line('application_subject');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_last_reply')?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_queue');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_client');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_owner');?>
                    </th>
                    </thead>
                    <?php foreach ($ticket as $value):?>
                        <?php $lable = false; if ($value->status == 'new') {
                            $lable = 'label-important';
                        } elseif ($value->status == 'open') {
                            $lable = 'label-warning';
                        } elseif ($value->status == 'closed' || $value->status == 'inprogress') {
                            $lable = 'label-success';
                        } elseif ($value->status == 'reopened') {
                            $lable = 'label-warning';
                        } ?>
                        <tr id="<?=$value->id;?>">
                            <td class="hidden-xs noclick simplecheckbox" style="width:16px">
                                <input class="checkbox-nolabel bulk-box" type="checkbox" name="bulk[]" value="<?=$value->id?>">
                            </td>
                            <td class="hidden-xs" style="width:70px">
                                <?=$value->reference;?>
                            </td>
                            <td style="width:50px"><span class="label <?php echo $lable; ?>"><?=$this->lang->line('application_ticket_status_' . $value->status);?></span></td>
                            <?php if (is_object($value->user)) {
                                $user_id = $value->user->id;
                            } else {
                                $user_id = false;
                            }?>
                            <td class="hidden-xs" style="width:15px">
                                <?php if ($value->updated == 1 && $user_id == $this->user->id) {
                                    ?><i class="icon dripicons-star" style="color: #d48b2a;"></i>
                                    <?php
                                } else {
                                    ?> <i class="icon dripicons-star" style="opacity: 0.2;"></i>
                                    <?php
                                } ?>
                            </td>
                            <td>
                                <?=$value->subject;?>
                            </td>
                            <td class="hidden-xs">
                                <?php if (is_object($value->getLastArticle())) : ?> <span class="hidden"><?=$value->getLastArticle()->datetime?></span>
                                    <?=date($core_settings->date_format . ' ' . $core_settings->date_time_format, $value->getLastArticle()->datetime)?>
                                <?php endif; ?>
                            </td>
                            <td class="hidden-xs"><span><?php if (is_object($value->queue)) {
                                        echo $value->queue->name;
                                    }?></span></td>
                            <td class="hidden-xs">
                                <?php if (!is_object($value->company)) {
                                    echo '<span class="label">' . $this->lang->line('application_no_client_assigned') . '</span>';
                                } else {
                                    echo '<span class="label label-info">' . $value->company->name . '</span>';
                                }?></td>
                            <td class="hidden-xs">
                                <?php if (!is_object($value->user)) {
                                    echo '<span class="label">' . $this->lang->line('application_not_assigned') . '</span>';
                                } else {
                                    echo '<span class="label label-info">' . $value->user->firstname . ' ' . $value->user->lastname . '</span>';
                                }?></td>

                        </tr>

                    <?php endforeach;?>
                </table>

            </div>
        </div>
    </div>
</div>