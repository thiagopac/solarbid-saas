<div class="col-sm-12  col-md-12 main">
    <?php include_once ("header_menu.php")?>
</div>
<div class="row">
    <div class="col-md-12">

        <h2>
            <?=$core_settings->company_prefix."".$company->reference;?> - <?=$company->name;?>
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-md-3 marginbottom20">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_company_details');?>
                <span class="pull-right">
					<a href="<?=base_url()?>clients/company/update/<?=$company->id;?>/view" class="btn btn-primary" data-toggle="mainmodal">
						<i class="icon-edit"></i>
						<?=$this->lang->line('application_edit');?>
					</a>
                </span>
            </div>
            <div class="subcont">
                <ul class="details col-md-12">
                    <li>
                        <span>
                            <?=$this->lang->line('application_company_name');?>:
                        </span>
                        <?php echo empty($company->name) ? '-' : $company->name; ?>
                    </li>
                    <li>
                        <span>
                            <?=$this->lang->line('application_corporate_name');?>:
                        </span>
                        <?php echo empty($company->corporate_name) ? '-' : $company->corporate_name; ?>
                    </li>
                    <li>
                        <span>
                            <?=$this->lang->line('application_registered_number');?>:
                        </span>
                        <?php echo empty($company->registered_number) ? '-' : $company->registered_number; ?>
                    </li>
                    <li>
                        <span>
                            <?=$this->lang->line('application_email');?>:
                        </span>
                        <?php echo empty($company->email) ? '-' : $company->email; ?>
                    </li>

                    <li>
                        <span>
						    <?=$this->lang->line('application_phone');?>:
                        </span>
                        <?php echo empty($company->phone) ? '-' : $company->phone; ?>
                    </li>
                    <li>
                        <span>
						    <?=$this->lang->line('application_mobile');?>:
                        </span>
                        <?php echo empty($company->mobile) ? '-' : $company->mobile; ?>
                    </li>

                    <li>
                        <span>
							<?=$this->lang->line('application_address');?>:
                        </span>
                        <?php echo empty($company->address) ? '-' : $company->address; ?>
                    </li>
                    <li>
                        <span>
							<?=$this->lang->line('application_zip_code');?>:
                        </span>
                        <?php echo empty($company->zipcode) ? '-' : $company->zipcode; ?>
                    </li>
                    <li>
                        <span>
							<?=$this->lang->line('application_city');?>:
                        </span>
                        <?php echo empty($company->city) ? '-' : $company->city; ?>
                    </li>
                    <li>
                        <span>
							<?=$this->lang->line('application_state');?>:
                        </span>
                        <?php echo empty($company->state) ? '-' : $company->state; ?>
                    </li>
                    <li>
                        <span>
							<?=$this->lang->line('application_country');?>:
                        </span>
                        <?php echo empty($company->country) ? '-' : $company->country; ?>
                    </li>

                </ul>
                <br clear="all">
            </div>
        </div>

        <p></p>

        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_primary_contact');?>
            </div>
            <div class="subcont">
                <ul class="details col-md-12">

                    <li>
                        <span>
						    <?=$this->lang->line('application_primary_contact');?>:
                        </span>
                        <?php if (is_object($company->client)) {
                            echo $company->client->firstname . ' ' . $company->client->lastname;
                        } else {
                            echo '-';
                        } ?>
                    </li>
                    <li>
                        <span>
						    <?=$this->lang->line('application_email');?>:
                        </span>
                        <?php if (is_object($company->client) && $company->client->email != '') {
                            echo $company->client->email;
                        } else {
                            echo '-';
                        } ?>
                    </li>
                </ul>
                <br clear="all">
            </div>
        </div>
    </div>



    <div class="col-md-9">
        <?php if (!array_key_exists(0, $company->clients)) {
            ?>
            <div class="alert alert-warning">
                <?=$this->lang->line('application_client_has_no_contacts'); ?>
                <a href="<?=base_url()?>clients/create/<?=$company->id; ?>" data-toggle="mainmodal">
                    <?=$this->lang->line('application_add_new_contact'); ?>
                </a>
            </div>
            <?php
        } ?>
        <div class="data-table-marginbottom">
            <div class="box-shadow">
                <div class="table-head">
                    <?=$this->lang->line('application_contacts');?>
                    <span class="pull-right">
								<a href="<?=base_url()?>clients/create/<?=$company->id;?>" class="btn btn-primary" data-toggle="mainmodal">
									<?=$this->lang->line('application_add_new_contact');?>
								</a>
							</span>
                </div>

                <div class="table-div responsive">
                    <table id="contacts" class="data-no-search table" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                        <thead>
                        <th style="width:10px"></th>
                        <th>
                            <?=$this->lang->line('application_name');?>
                        </th>
                        <th class="hidden-xs">
                            <?=$this->lang->line('application_email');?>
                        </th>
                        <th class="hidden-xs">
                            <?=$this->lang->line('application_phone');?>
                        </th>
                        <th class="hidden-xs">
                            <?=$this->lang->line('application_mobile');?>
                        </th>
                        <th class="hidden-xs">
                            <?=$this->lang->line('application_last_login');?>
                        </th>
                        <th>
                            <?=$this->lang->line('application_action');?>
                        </th>
                        </thead>
                        <?php foreach ($company->clients as $value):?>

                            <tr id="<?=$value->id;?>">
                                <td style="width:10px" class="sorting_disabled">
                                    <img class="minipic" src="<?=$value->userpic?>" />
                                </td>
                                <td>
                                    <?=$value->firstname;?>
                                    <?=$value->lastname;?>
                                </td>
                                <td class="hidden-xs">
                                    <?=$value->email;?>
                                </td>
                                <td class="hidden-xs">
                                    <?=$value->phone;?>
                                </td>
                                <td class="hidden-xs">
                                    <?=$value->mobile;?>
                                </td>

                                <td class="hidden-xs">
                                    <?php if (!empty($value->last_login)) {
                                        echo date($core_settings->date_format . ' ' . $core_settings->date_time_format, $value->last_login);
                                    } else {
                                        echo '-';
                                    } ?>
                                </td>

                                <td class="option" style="text-align:left; text-wrap:nowrap " width="9%">
                                    <a href="<?=base_url()?>clients/credentials/<?=$value->id;?>" class="btn-option tt" title="<?=$this->lang->line('application_email_login_details');?>" data-toggle="mainmodal">
                                        <i class="icon dripicons-mail"></i>
                                    </a>
                                    <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>clients/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                        <i class="icon dripicons-cross"></i>
                                    </button>
                                    <a href="<?=base_url()?>clients/update/<?=$value->id;?>" title="<?=$this->lang->line('application_edit');?>" class="btn-option" data-toggle="mainmodal">
                                        <i class="icon dripicons-gear"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div>&nbsp;</div>

    <div class="col-md-9">
        <?php if (!array_key_exists(0, $company->user)) {
            ?>
            <div class="alert alert-warning">
                <?=$this->lang->line('application_client_has_no_admins'); ?>
                <?php if ($this->user->admin == 1) {
                    ?>
                    <a href="<?=base_url()?>clients/assign/<?=$company->id; ?>" data-toggle="mainmodal">
                        <?=$this->lang->line('application_assign_admin'); ?>
                    </a>
                    <?php
                } ?>
            </div>
            <?php
        } ?>
        <div class="data-table-marginbottom">
            <div class="box-shadow">
                <div class="table-head">
                    <?=$this->lang->line('application_client_admins');?>
                    <?php if ($this->user->admin == 1) {
                        ?>
                        <span class="pull-right">
								<a href="<?=base_url()?>clients/assign/<?=$company->id; ?>" class="btn btn-primary" data-toggle="mainmodal">
									<?=$this->lang->line('application_assign_admin'); ?>
								</a>
                        </span>
                        <?php
                    } ?>
                </div>
                <div class="table-div responsive">
                    <table id="clientadmins" class="data-no-search table" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                        <thead>
                        <th style="width:10px"></th>
                        <th>
                            <?=$this->lang->line('application_name');?>
                        </th>
                        <th class="hidden-xs">
                            <?=$this->lang->line('application_email');?>
                        </th>
                        <th class="hidden-xs">
                            <?=$this->lang->line('application_last_login');?>
                        </th>
                        <?php if ($this->user->admin == 1) {
                            ?>
                            <th>
                                <?=$this->lang->line('application_action'); ?>
                            </th>
                            <?php
                        } ?>
                        </thead>
                        <?php foreach ($company->user as $value):?>

                            <tr id="<?=$value->id;?>">
                                <td style="width:10px" class="sorting_disabled">
                                    <img class="minipic" src="<?=$value->userpic?>" />
                                </td>
                                <td>
                                    <?=$value->firstname;?>
                                    <?=$value->lastname;?>
                                </td>
                                <td class="hidden-xs">
                                    <?=$value->email;?>
                                </td>
                                <td class="hidden-xs">
                                    <?php if (!empty($value->last_login)) {
                                        echo date($core_settings->date_format . ' ' . $core_settings->date_time_format, $value->last_login);
                                    } else {
                                        echo '-';
                                    } ?>
                                </td>
                                <?php if ($this->user->admin == 1) {
                                    ?>
                                    <td class="option" style="text-align:center; text-wrap:nowrap " width="4%">
                                        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>clients/removeassigned/<?=$value->id; ?>/<?=$company->id?>'><?=$this->lang->line('application_yes_im_sure'); ?></a> <button class='btn po-close'><?=$this->lang->line('application_no'); ?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id; ?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete'); ?></b>">
                                            <i class="icon dripicons-cross"></i>
                                        </button>
                                    </td>
                                    <?php
                                } ?>
                            </tr>

                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div>&nbsp;</div>

    <div class="col-md-5">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_profile_and_portfolio'); ?>
                <span class="pull-right">
                        <a href="<?=base_url() ?>clients/edit_profile/<?=$company->id?>" class="btn btn-primary" data-toggle="mainmodal">
                            <?=$this->lang->line('application_edit_profile_and_portfolio'); ?>
                        </a>
                </span>
            </div>
            <div class="table-div responsive">
                <p></p>
                <ul class="list-group ">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <label class="stats-label"><i class="dripicons-arrow-right orangered stats-icon"></i> <?=$this->lang->line('application_warranty_lowest')?></label>
                        <span class="pull-right stats-number"><?=$company_profile->warranty_lowest?> <small>meses</small></span>
                    </li>
                    <hr class="stats-separator" />
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <label class="stats-label"><i class="dripicons-arrow-up orangered stats-icon"></i> <?=$this->lang->line('application_warranty_highest')?></label>
                        <span class="pull-right stats-number"><?=$company_profile->warranty_highest?> <small>meses</small></span>
                    </li>
                    <hr class="stats-separator" />
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <label class="stats-label"><i class="dripicons-view-thumb orangered stats-icon"></i> <?=$this->lang->line('application_power_plants_installed')?></label>
                        <span class="pull-right stats-number"><?=$company_profile->power_plants_installed?> <small>usinas</small></span>
                    </li>
                    <hr class="stats-separator" />
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <label class="stats-label"><i class="dripicons-pulse orangered stats-icon"></i> <?=$this->lang->line('application_power_executed')?></label>
                        <span class="pull-right stats-number"><?=$company_profile->power_executed?> <small><?=$core_settings->rated_power_measurement?></small></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_photos'); ?>
                <span class="pull-right">
                        <a href="<?=base_url() ?>clients/add_photo/<?=$company->id?>" class="btn btn-primary" data-toggle="mainmodal">
                            <?=$this->lang->line('application_add_photo'); ?>
                        </a>
                </span>
            </div>
            <div class="table-div">
                <table id="photos" class="table data-media noclick" rel="<?=base_url() ?>clients/photo/<?=$this->client->company_id; ?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th class="no-sort" style="width:20px">
                            <?=$this->lang->line('application_filename'); ?>
                        </th>
                        <th class="no-sort" style="width:10px;">
                            <?=$this->lang->line('application_download')?>
                        </th>
                        <th class="no-sort"  style="width:20px">
                            <?=$this->lang->line('application_action'); ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="div-photos" name="div-photos">
                    <?php foreach ($company_photos as $file): ?>
                        <tr id="<?=$file->id; ?>">
                            <td>
                                <?=ellipsize($file->filename, 20, .055); ?>
                            </td>
                            <td style="text-align: center">
                                <a href="<?=base_url() ?>clients/download_photo/<?=$file->id?>"><i class="icon dripicons-download"> </i></a>
                            </td>
                            <td class="option">
                                <button type="button" class="btn-option btn-xs po tt" title="<?=$this->lang->line('application_delete'); ?>" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url() ?>clients/delete_photo/<?=$file->id; ?>'><?=$this->lang->line('application_yes_im_sure'); ?></a> <button class='btn po-close'><?=$this->lang->line('application_no'); ?></button> <input type='hidden' name='td-id' class='id' value='<?=$file->id; ?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete'); ?></b>"> <i class="icon dripicons-cross"> </i> </button>
                                <a href="<?=base_url() ?>clients/preview_photo/<?=$file->id; ?>" title="<?=$this->lang->line('application_preview_photo'); ?>" class="btn-option tt" data-toggle="mainmodal"> <i class="icon dripicons-preview"> </i> </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (!$company_photos){?>
                    <div class="no-files"> <i class="icon dripicons-cloud-upload"> </i>
                        <br><?=$this->lang->line('application_no_photo_sent')?></div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>

