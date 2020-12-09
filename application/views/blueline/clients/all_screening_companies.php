<div class="col-sm-12  col-md-12 main">
    <?php include_once ("header_menu.php")?>

    <div class="row">

        <small>
            <label class="header_description"><?=$this->lang->line('application_warning_promote_screeening_companies_mail')?></label>
            <p></p>
        </small>

        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_screening_companies');?>
            </div>
            <div class="table-div">
                <table class="data table" id="screening_companies" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th>
                        <?=$this->lang->line('application_id');?>
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
                        <?=$this->lang->line('application_promoted_to_client');?>
                    </th>
                    <th style="text-align: center">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($screening_companies as $value):?>

                        <tr id="<?=$value->id;?>">
                            <td>
                                <?= $value->id; ?>
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
                                <?php if (!is_null($value->promoted)) {
                                    echo $value->promoted == 1 ? '<span style="color:green">'.$this->lang->line('application_yes').'</span>' :'<span style="color:red">'.$this->lang->line('application_no').'</span>';
                                }?>
                            </td>
                            <td class="option" width="8%">
                                <button type="button" title="<?=$this->lang->line('application_delete'); ?>" class="btn-option delete po tt" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>clients/screening_company/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
                                <?php if ($value->promoted != 1) : ?>
                                <button type="button" title="<?=$this->lang->line('application_promote_to_client'); ?>" class="btn-option delete po tt" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-success po-delete ajax-silent' href='<?=base_url()?>clients/screening_company/promote/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-jewel"></i></button>
                                <?php endif; ?>
                                <a href="<?=base_url()?>clients/screening_company/update/<?=$value->id;?>" title="<?=$this->lang->line('application_edit_client'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <br clear="all">

            </div>
        </div>
    </div>

</div>