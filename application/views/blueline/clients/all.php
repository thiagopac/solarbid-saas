<div class="col-sm-12  col-md-12 main">
    <div class="row tile-row">

        <div class="tile-button">
            <a href="<?=base_url()?>clients/company/create" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-android-add-circle"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_add_new_company'); ?>
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
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_companies');?>
            </div>
            <div class="table-div">
                <table class="data table" id="clients" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>

                    <th class="hidden-xs" style="width:70px">
                        <?=$this->lang->line('application_company_id');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_company_name');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_registered_number');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_primary_contact');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_email');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_city');?>/
                        <?=$this->lang->line('application_state');?>
                    </th>
                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_level');?>
                    </th>
                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_unlocked');?>
                    </th>
                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_inactive');?>
                    </th>
                    <th style="text-align: center">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($companies as $value):?>

                        <tr id="<?=$value->id;?>">
                            <td class="hidden-xs" style="width:70px">
                                <?=$core_settings->company_prefix;?><?php if (isset($value->reference)) {echo $value->reference;} ?>
                            </td>

                            <td><span class="bold"><?php if (is_object($value)) {
                                        echo $value->name;
                                    } else {
                                        echo $this->lang->line('application_no_company_assigned');
                                    }?></span>
                            </td>
                            <td>
                                <?= $value->registered_number; ?>
                            </td>
                            <td class="hidden-xs">
                                <?php if (is_object($value->client)) {
                                    echo $value->client->firstname . ' ' . $value->client->lastname;
                                } else {
                                    echo $this->lang->line('application_no_contact_assigned');
                                } ?>
                            </td>
                            <td class="hidden-xs">
                                <?php if (is_object($value->client)) {
                                    echo $value->client->email;
                                } else {
                                    echo $this->lang->line('application_no_contact_assigned');
                                }?>
                            </td>
                            <!-- <td class="hidden-xs"><?php echo $value->website = empty($value->website) ? '-' : '<a target="_blank" href="http://' . $value->website . '">' . $value->website . '</a>' ?></td> -->
                            <td class="hidden-xs">
                                <?php echo $value->city ?>/
                                <?php echo $value->state ?>
                            </td>
                            <td style="text-align: center" class="hidden-xs">
                                <?php if (!is_null($value->level)) {
                                    echo $value->level;
                                }?>
                            </td>
                            <td style="text-align: center" class="hidden-xs">
                                <?php if (!is_null($value->unlocked)) {
                                    echo $value->unlocked == 1 ? '<span style="color:red">'.$this->lang->line('application_yes').'</span>' : $this->lang->line('application_no');
                                }?>
                            </td>
                            <td style="text-align: center" class="hidden-xs">
                                <?php if (!is_null($value->inactive)) {
                                    echo $value->inactive == 1 ? '<span style="color:red">'.$this->lang->line('application_yes').'</span>' : $this->lang->line('application_no');
                                }?>
                            </td>
                            <td class="option" width="8%">
                                <button type="button" title="<?=$this->lang->line('application_delete'); ?>" class="btn-option delete po tt" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>clients/company/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
                                <a href="<?=base_url()?>clients/company/update/<?=$value->id;?>" title="<?=$this->lang->line('application_edit_client'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <br clear="all">

            </div>
        </div>
    </div>

    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_screening_companies');?>
            </div>
            <div class="table-div">
                <table class="data table" id="screening_companies" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>

                    <th class="hidden-xs" style="width:70px">
                        <?=$this->lang->line('application_company_id');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_company_name');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_registered_number');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_primary_contact');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_email');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_city');?>/
                        <?=$this->lang->line('application_state');?>
                    </th>
                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_level');?>
                    </th>
                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_unlocked');?>
                    </th>
                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_inactive');?>
                    </th>
                    <th style="text-align: center">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($screening_companies as $value):?>

                        <tr id="<?=$value->id;?>">
                            <td class="hidden-xs" style="width:70px">
                                <?=$core_settings->company_prefix;?><?php if (isset($value->reference)) {echo $value->reference;} ?>
                            </td>

                            <td><span class="bold"><?php if (is_object($value)) {
                                        echo $value->name;
                                    } else {
                                        echo $this->lang->line('application_no_company_assigned');
                                    }?></span>
                            </td>
                            <td>
                                <?= $value->registered_number; ?>
                            </td>
                            <td class="hidden-xs">
                                <?php if (is_object($value->screening_client)) {
                                    echo $value->screening_client->firstname . ' ' . $value->screening_client->lastname;
                                } else {
                                    echo $this->lang->line('application_no_contact_assigned');
                                } ?>
                            </td>
                            <td class="hidden-xs">
                                <?php if (is_object($value->screening_client)) {
                                    echo $value->screening_client->email;
                                } else {
                                    echo $this->lang->line('application_no_contact_assigned');
                                }?>
                            </td>
                            <!-- <td class="hidden-xs"><?php echo $value->website = empty($value->website) ? '-' : '<a target="_blank" href="http://' . $value->website . '">' . $value->website . '</a>' ?></td> -->
                            <td class="hidden-xs">
                                <?php echo $value->city ?>/
                                <?php echo $value->state ?>
                            </td>
                            <td style="text-align: center" class="hidden-xs">
                                <?php if (!is_null($value->level)) {
                                    echo $value->level;
                                }?>
                            </td>
                            <td style="text-align: center" class="hidden-xs">
                                <?php if (!is_null($value->unlocked)) {
                                    echo $value->unlocked == 1 ? '<span style="color:red">'.$this->lang->line('application_yes').'</span>' : $this->lang->line('application_no');
                                }?>
                            </td>
                            <td style="text-align: center" class="hidden-xs">
                                <?php if (!is_null($value->inactive)) {
                                    echo $value->inactive == 1 ? '<span style="color:red">'.$this->lang->line('application_yes').'</span>' : $this->lang->line('application_no');
                                }?>
                            </td>
                            <td class="option" width="8%">
                                <button type="button" title="<?=$this->lang->line('application_delete'); ?>" class="btn-option delete po tt" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>clients/screening_company/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
                                <a href="<?=base_url()?>clients/screening_company/update/<?=$value->id;?>" title="<?=$this->lang->line('application_edit_client'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <br clear="all">

            </div>
        </div>
    </div>