

<div class="row">

    <div class="col-md-12">
        <h2>
            <?=$core_settings->company_prefix."".$screening_company->reference;?> - <?=$screening_company->name;?>
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-md-3 marginbottom20">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_company_details');?>
                <span class="pull-right">
					<a href="<?=base_url()?>clients/screening_company/update/<?=$screening_company->id;?>/view" class="btn btn-primary" data-toggle="mainmodal">
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
                        <?php echo empty($screening_company->name) ? '-' : $screening_company->name; ?>
                    </li>
                    <li>
                        <span>
                            <?=$this->lang->line('application_corporate_name');?>:
                        </span>
                        <?php echo empty($screening_company->corporate_name) ? '-' : $screening_company->corporate_name; ?>
                    </li>
                    <li>
                        <span>
                            <?=$this->lang->line('application_registered_number');?>:
                        </span>
                        <?php echo empty($screening_company->registered_number) ? '-' : $screening_company->registered_number; ?>
                    </li>
                    <li>
                        <span>
                            <?=$this->lang->line('application_email');?>:
                        </span>
                        <?php echo empty($screening_company->email) ? '-' : $screening_company->email; ?>
                    </li>

                    <li>
                        <span>
						    <?=$this->lang->line('application_phone');?>:
                        </span>
                        <?php echo empty($screening_company->phone) ? '-' : $screening_company->phone; ?>
                    </li>
                    <li>
                        <span>
						    <?=$this->lang->line('application_mobile');?>:
                        </span>
                        <?php echo empty($screening_company->mobile) ? '-' : $screening_company->mobile; ?>
                    </li>

                    <li>
                        <span>
							<?=$this->lang->line('application_address');?>:
                        </span>
                        <?php echo empty($screening_company->address) ? '-' : $screening_company->address; ?>
                    </li>
                    <li>
                        <span>
							<?=$this->lang->line('application_zip_code');?>:
                        </span>
                        <?php echo empty($screening_company->zipcode) ? '-' : $screening_company->zipcode; ?>
                    </li>
                    <li>
                        <span>
							<?=$this->lang->line('application_city');?>:
                        </span>
                        <?php echo empty($screening_company->city) ? '-' : $screening_company->city; ?>
                    </li>
                    <li>
                        <span>
							<?=$this->lang->line('application_state');?>:
                        </span>
                        <?php echo empty($screening_company->state) ? '-' : $screening_company->state; ?>
                    </li>
                    <li>
                        <span>
							<?=$this->lang->line('application_country');?>:
                        </span>
                        <?php echo empty($screening_company->country) ? '-' : $screening_company->country; ?>
                    </li>

                </ul>
                <br clear="all">
            </div>
        </div>

        <p></p>


    </div>

    <div class="col-md-9">
        <?php if (!array_key_exists(0, $screening_company->screening_clients)) {
            ?>
            <div class="alert alert-warning">
                <?=$this->lang->line('application_client_has_no_contacts'); ?>
                <a href="<?=base_url()?>clients/create/<?=$screening_company->id; ?>" data-toggle="mainmodal">
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
								<a href="<?=base_url()?>clients/create/<?=$screening_company->id;?>" class="btn btn-primary" data-toggle="mainmodal">
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
                        <?php foreach ($screening_company->screening_clients as $value):?>

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
                                    <a href="<?=base_url()?>clients/update_screening/<?=$value->id;?>" title="<?=$this->lang->line('application_edit');?>" class="btn-option" data-toggle="mainmodal">
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

</div>

