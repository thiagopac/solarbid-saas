<div class="row">
    <div class="col-md-1">
        <a href="<?=base_url()?>disputes" class="btn btn-primary">
            <?=$this->lang->line('application_back');?>
        </a>
    </div>
    <div class="col-md-12">
        <h2>
            <?=$dispute->dispute_object->owner_name;?>
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-md-3 marginbottom20">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_company_details');?>
            </div>
            <div class="subcont">
                <ul class="details col-md-12">
                    <li>
					<span>
						<?=$this->lang->line('application_company_name');?>:</span>
                        <?php echo $company->name = empty($company->name) ? '-' : $company->name; ?>
                    </li>
                    <li>
                            <span>
						<?=$this->lang->line('application_primary_contact');?>:</span>
                        <?= '-'; ?>
                    </li>
                    <li>
                            <span>
						<?=$this->lang->line('application_email');?>:</span>
                        <?= '-'; ?>
                    </li>

                    <li>
                            <span>
						<?=$this->lang->line('application_phone');?>:</span>
                        <?= '-'; ?>
                    </li>
                    <li>
                            <span>
						<?=$this->lang->line('application_mobile');?>:</span>
                        <?= '-'; ?>
                    </li>

                </ul>
                <span class="visible-xs"></span>
                <ul class="details col-md-12">
                    <li>
                        <span><?=$this->lang->line('application_address');?>:</span>
                        <?= '-'; ?>
                    </li>
                    <li>
                                <span>
							<?=$this->lang->line('application_zip_code');?>:</span>
                        <?= '-'; ?>
                    </li>
                    <li>
                        <span><?=$this->lang->line('application_city');?>:</span>
                        <?= '-'; ?>
                    </li>
                    <li>
                        <span><?=$this->lang->line('application_state');?>:</span>
                        <?= '-'; ?>
                    </li>
                    <li>
                        <span><?=$this->lang->line('application_country');?>:</span>
                        <?= '-'; ?>
                    </li>

                </ul>
                <br clear="all">
            </div>
        </div>

    </div>

    <div class="col-md-9">
        <div class="data-table-marginbottom">
            <div class="box-shadow">
                <div class="table-head">
                    <?=$this->lang->line('application_contacts');?>
                </div>

                <div class="table-div responsive">
                    <table id="contacts" class="table" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
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
                        <?php foreach ($arr = [1,2,3,4] as $value):?>

                            <tr id="<?=$value->id;?>">
                                <td>
                                    <?= '-'; ?>
                                </td>
                                <td>
                                    <?= '-'; ?>
                                </td>
                                <td>
                                    <?= '-'; ?>
                                </td>
                                <td>
                                    <?= '-'; ?>
                                </td>
                                <td>
                                    <?= '-'; ?>
                                </td>
                                <td>
                                    <?= '-'; ?>
                                </td>
                                <td>
                                    <?= '-'; ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>