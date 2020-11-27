<div class="col-sm-12  col-md-12 main">
    <?php include_once ("header_menu.php")?>

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
                        <?=$this->lang->line('application_unlocked');?>
                    </th>
                    <th style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_inactive');?>
                    </th>
                    <th style="text-align: center">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($companies as $company):?>

                        <tr id="<?=$company->id;?>">
                            <td class="hidden-xs" style="width:70px">
                                <?=$core_settings->company_prefix;?><?php if (isset($company->reference)) {echo $company->reference;} ?>
                            </td>

                            <td><span class="bold"><?php if (is_object($company)) {
                                        echo $company->name;
                                    } else {
                                        echo $this->lang->line('application_no_company_assigned');
                                    }?></span>
                            </td>
                            <td>
                                <?= $company->registered_number; ?>
                            </td>
                            <td class="hidden-xs">
                                <?php if (is_object($company->client)) {
                                    echo $company->client->firstname . ' ' . $company->client->lastname;
                                } else {
                                    echo $this->lang->line('application_no_contact_assigned');
                                } ?>
                            </td>
                            <td class="hidden-xs">
                                <?php if (is_object($company->client)) {
                                    echo $company->client->email;
                                } else {
                                    echo $this->lang->line('application_no_contact_assigned');
                                }?>
                            </td>
                            <!-- <td class="hidden-xs"><?php echo $company->website = empty($company->website) ? '-' : '<a target="_blank" href="http://' . $company->website . '">' . $company->website . '</a>' ?></td> -->
                            <td class="hidden-xs">
                                <?php echo $company->city ?>/
                                <?php echo $company->state ?>
                            </td>
                            <td style="text-align: center" class="hidden-xs">
                                <?php if (!is_null($company->unlocked)) {
                                    echo $company->unlocked == 1 ? '<span style="color:red">'.$this->lang->line('application_yes').'</span>' : $this->lang->line('application_no');
                                }?>
                            </td>
                            <td style="text-align: center" class="hidden-xs">
                                <?php if (!is_null($company->inactive)) {
                                    echo $company->inactive == 1 ? '<span style="color:red">'.$this->lang->line('application_yes').'</span>' : $this->lang->line('application_no');
                                }?>
                            </td>
                            <td class="option" width="8%">
                                <button type="button" title="<?=$this->lang->line('application_delete'); ?>" class="btn-option delete po tt" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>clients/company/delete/<?=$company->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$company->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
                                <a href="<?=base_url()?>clients/company/update/<?=$company->id;?>" title="<?=$this->lang->line('application_edit_client'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <br clear="all">

            </div>
        </div>
    </div>
</div>