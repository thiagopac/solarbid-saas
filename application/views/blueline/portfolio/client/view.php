<style>
    @media (max-width: 767px) {
        .content-area {
            padding: 0;
        }
        .row.mainnavbar {
            margin-bottom: 0px;
            margin-right: 0px;
        }
    }
</style>
<div class="col-sm-12 col-md-12 main">
    <div class="row tile-row">
        <div class="tile-button">
            <a href="<?=base_url() ?>cportfolio/edit_registration" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">
                    <div class="icon-frame"> <i class="ion-ios-location"> </i> </div>
                    <h1> <span> <?=$this->lang->line('application_edit_registration_data'); ?> </span> </h1> </div>

            </a>
        </div>
        <div class="tile-button">
            <a href="<?=base_url() ?>cportfolio/edit_profile" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">
                    <div class="icon-frame"> <i class="ion-information-circled"> </i> </div>
                    <h1> <span> <?=$this->lang->line('application_edit_profile_and_portfolio'); ?> </span> </h1> </div>
            </a>
        </div>
        <div class="tile-button">
            <a href="<?=base_url() ?>cportfolio/add_photo" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">
                    <div class="icon-frame"> <i class="ion-images"> </i> </div>
                    <h1> <span> <?=$this->lang->line('application_add_photo'); ?> </span> </h1> </div>
            </a>
        </div>
        <div class="col-md-1 col-xs-1 tile hidden-xs">
            <div style="height: 93px;"> </div>
        </div>
    </div>
    <div class="grid">
        <div class="grid__col-md-7 dashboard-header">
            <h1> <?=$this->lang->line('application_company_profile_and_portfolio') ?> </h1> <small> <?=$this->lang->line('application_portolio_and_profile_data_fill_to_show'); ?> </small> </div>
        <div class="grid__col-sm-12 grid__col-md-9 grid__col-lg-9 grid__col--bleed">
            <div class="grid grid--align-content-start">
                <?php if (1==1){?>
                    <div class="col-md-5 marginbottom20">
                        <div class="box-shadow">
                            <div class="table-head">
                                <?=$this->lang->line('application_registration_data'); ?></div>
                            <div class="subcont">
                                <ul class="details col-md-12">
                                    <li> <span> <?=$this->lang->line('application_company_name'); ?>: </span>
                                        <?php echo empty($company->name) ? '-' : $company->name; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_corporate_name'); ?>: </span>
                                        <?php echo empty($company->corporate_name) ? '-' : $company->corporate_name; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_registered_number'); ?>: </span>
                                        <?php echo empty($company->registered_number) ? '-' : $company->registered_number; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_email'); ?>: </span>
                                        <?php echo empty($company->email) ? '-' : $company->email; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_phone'); ?>: </span>
                                        <?php echo empty($company->phone) ? '-' : $company->phone; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_mobile'); ?>: </span>
                                        <?php echo empty($company->mobile) ? '-' : $company->mobile; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_address'); ?>: </span>
                                        <?php echo empty($company->address) ? '-' : $company->address; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_zip_code'); ?>: </span>
                                        <?php echo empty($company->zipcode) ? '-' : $company->zipcode; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_city'); ?>: </span>
                                        <?php echo empty($company->city) ? '-' : $company->city; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_state'); ?>: </span>
                                        <?php echo empty($company->state) ? '-' : $company->state; ?>
                                    </li>
                                    <li> <span> <?=$this->lang->line('application_country'); ?>: </span>
                                        <?php echo empty($company->country) ? '-' : $company->country; ?>
                                    </li>
                                </ul>
                                <br clear="all"> </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <?php if (!array_key_exists(0, $company->user)){?>
                            <div class="alert alert-warning">
                                <?=$this->lang->line('application_client_has_no_admins'); ?>
                                <?php if ($this->user->admin==1){?>
                                    <a href="<?=base_url() ?>clients/assign/<?=$company->id; ?>" data-toggle="mainmodal">
                                        <?=$this->lang->line('application_assign_admin'); ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="data-table-marginbottom">
                            <div class="box-shadow">
                                <div class="table-head">
                                    <?=$this->lang->line('application_profile_and_portfolio'); ?>
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
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="media-list-view-container grid__col-sm-12 grid__col-md-3 grid__col-lg-3 grid__col--bleed">
            <div class="box-shadow">
                <div class="table-head">
                    <?=$this->lang->line('application_photos'); ?>
                </div>
                <div class="table-div">
                    <table id="photos" class="table data-media noclick" rel="<?=base_url() ?>cportfolio/photo/<?=$this->client->company_id; ?>" cellspacing="0" cellpadding="0">
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
                                    <a href="<?=base_url() ?>cportfolio/download_photo/<?=$file->id?>"><i class="icon dripicons-download"> </i></a>
                                </td>
                                <td class="option">
                                    <button type="button" class="btn-option btn-xs po tt" title="<?=$this->lang->line('application_delete'); ?>" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url() ?>cportfolio/delete_photo/<?=$file->id; ?>'><?=$this->lang->line('application_yes_im_sure'); ?></a> <button class='btn po-close'><?=$this->lang->line('application_no'); ?></button> <input type='hidden' name='td-id' class='id' value='<?=$file->id; ?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete'); ?></b>"> <i class="icon dripicons-cross"> </i> </button>
                                    <a href="<?=base_url() ?>cportfolio/preview_photo/<?=$file->id; ?>" title="<?=$this->lang->line('application_preview_photo'); ?>" class="btn-option tt" data-toggle="mainmodal"> <i class="icon dripicons-preview"> </i> </a>
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
    <p> </p>
</div>
<?php
