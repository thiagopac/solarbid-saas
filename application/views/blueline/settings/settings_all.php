<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_settings');?>
		</div>
		<?php
$attributes = ['class' => '', 'id' => 'settings_form'];
echo form_open_multipart($form_action, $attributes);
?>
		<div class="table-div">

			<div class="form-header">
				<?=$this->lang->line('application_company_info');?>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_system_name');?>
						</label>
						<input type="text" name="company" class="form-control" value="<?=$settings->company;?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_contact');?>
						</label>
						<input type="text" name="contact" class="required form-control" value="<?=$settings->contact;?>" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_address');?>
						</label>
						<input type="text" name="solarbid_address" class="required form-control" value="<?=$settings->solarbid_address;?>" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_city');?>
						</label>
						<input type="text" name="city" class="required form-control" value="<?=$settings->city;?>" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_phone');?>
						</label>
						<input type="text" name="tel" class="required form-control" value="<?=$settings->tel;?>" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_email');?>
						</label>
						<input type="text" name="email" class="required form-control" value="<?=$settings->email;?>" required>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_domain');?>
								<button type="button" class="btn-option po pull-right" data-toggle="popover" data-placement="left" data-content="Full URL to your Freelance Cockpit installation. Including subfolder i.e. http://www.yoursite.com/FC/"
								 data-original-title="Domain URL">
									<i class="icon dripicons-information"></i>
								</button>
						</label>
						<input type="text" name="domain" class="required form-control" value="<?=$settings->domain;?>" required>
					</div>
				</div>
			</div>
			<div class="form-header">
				<?=$this->lang->line('application_branding');?>
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_logo');?> (max 160x200)
						<button type="button" class="btn-option po pull-right" data-toggle="popover" data-placement="right" data-content="<div class='logo' style='padding:10px'><img src='<?=$core_settings->logo;?>'></div>"
						 data-original-title="<?=$this->lang->line('application_logo');?>">
							<i class="icon dripicons-preview"></i>
						</button>
				</label>
				<div>
					<input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled"
					/>
					<div class="fileUpload btn btn-primary">
						<span>
							<i class="icon dripicons-upload"></i>
							<span class="hidden-xs">
								<?=$this->lang->line('application_select');?>
							</span>
						</span>
						<input id="uploadBtn" type="file" name="userfile" class="upload" />
					</div>
				</div>

			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_solarbid_logo');?> (max 160x200)
							<button type="button" class="btn-option po " data-toggle="popover" data-placement="right" data-content="<div style='padding:10px'><img src='<?=$core_settings->solarbid_logo;?>'></div>"
							 data-original-title="<?=$this->lang->line('application_solarbid_logo');?>">
								<i class="icon dripicons-preview"></i>
							</button>
				</label>
				<div>
					<input id="uploadFile2" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>"
					 disabled="disabled" />
					<div class="fileUpload btn btn-primary">
						<span>
							<i class="icon dripicons-upload"></i>
							<span class="hidden-xs">
								<?=$this->lang->line('application_select');?>
							</span>
						</span>
						<input id="uploadBtn2" type="file" name="userfile2" class="upload" />
					</div>
				</div>

			</div>

			<div class="form-header">
				<?=$this->lang->line('application_reference_prefix');?>
			</div>
			<div class="row">

				<div class="col-md-2">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_company');?>
						</label>


						<div class="input-group ">

							<input type="text" name="company_prefix" value="<?=$settings->company_prefix;?>" class="form-control">

						</div>

					</div>
				</div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>
                            <?=$this->lang->line('application_rated_power_measurement');?>
                        </label>


                        <div class="input-group">

                            <input type="text" name="rated_power_measurement" value="<?=$settings->rated_power_measurement;?>" class="form-control">

                        </div>

                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>
                            <?=$this->lang->line('application_consumn_power_measurement');?>
                        </label>


                        <div class="input-group">

                            <input type="text" name="consumn_power_measurement" value="<?=$settings->consumn_power_measurement;?>" class="form-control">

                        </div>

                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>
                            <?=$this->lang->line('application_area_measurement');?>
                        </label>


                        <div class="input-group">

                            <input type="text" name="area_measurement" value="<?=$settings->area_measurement;?>" class="form-control">

                        </div>

                    </div>
                </div>

				<div class="col-md-2">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_dispute');?>
						</label>
						<div class="input-group">
							<input type="text" name="dispute_prefix" value="<?=$settings->dispute_prefix;?>" class="form-control" placeholder="">
						</div>
					</div>
				</div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>
                            <?=$this->lang->line('application_dispute_object');?>
                        </label>
                        <div class="input-group">
                            <input type="text" name="disputeobject_prefix" value="<?=$settings->disputeobject_prefix;?>" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>

			</div>

            <!--      AJUSTES FISCAIS DE IMPOSTOS, IVA E MOEDA PADRÃO / ESCONDIDO     -->
			<!--<div class="form-header">
				<?/*=$this->lang->line('application_tax_settings');*/?>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_default_currency');?>
						</label>


						<div class="input-group col-md-12">

							<input type="text" name="currency" list="currencylist" class="form-control" value="<?=$settings->currency;?>">
							<datalist id="currencylist">
								<option value="AUD"></option>
								<option value="BRL"></option>
								<option value="CAD"></option>
								<option value="CZK"></option>
								<option value="DKK"></option>
								<option value="EUR"></option>
								<option value="HKD"></option>
								<option value="HUF"></option>
								<option value="ILS"></option>
								<option value="JPY"></option>
								<option value="MYR"></option>
								<option value="MXN"></option>
								<option value="NOK"></option>
								<option value="NZD"></option>
								<option value="PHP"></option>
								<option value="PLN"></option>
								<option value="GBP"></option>
								<option value="SGD"></option>
								<option value="SEK"></option>
								<option value="CHF"></option>
								<option value="TWD"></option>
								<option value="THB"></option>
								<option value="TRY"></option>
								<option value="USD"></option>
							</datalist>
						</div>

					</div>
				</div>
			</div>
			-->

			<div class="form-header">
				<?=$this->lang->line('application_formats');?>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_date_format');?>
						</label>
						<?php $options = [
                        'F j, Y' => date('F j, Y'),
                        'Y/m/d' => date('Y/m/d'),
                        'm/d/Y' => date('m/d/Y'),
                        'd/m/Y' => date('d/m/Y'),
                        'd.m.Y' => date('d.m.Y'),
                        'd-m-Y' => date('d-m-Y'),
                        'Y-m-d' => date('Y-m-d'),
                        'd-m-Y' => date('Y-m-d'),
                        'j F, Y' => date('j F, Y')
                        ];
                        echo form_dropdown('date_format', $options, $settings->date_format, 'style="width:250px" class="chosen-select"'); ?>

					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_date_time_format');?>
						</label>
						<?php $options = [
                        'g:i a' => date('g:i a'),
                        'g:i A' => date('g:i A'),
                        'H:i' => date('H:i'),
                        ];
                        echo form_dropdown('date_time_format', $options, $settings->date_time_format, 'style="width:250px" class="chosen-select"'); ?>

					</div>
				</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            <?=$this->lang->line('application_money_symbol');?>
                        </label>
                        <input type="text" name="money_symbol" value="<?=$settings->money_symbol;?>" class="form-control">
                    </div>
                </div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_timezone');?>
						</label>
						<?php
                        $options = [];
                        foreach (timezone_abbreviations_list() as $abbr => $timezone) {
                            foreach ($timezone as $val) {
                                if (isset($val['timezone_id'])) {
                                    $options[$val['timezone_id']] = $val['timezone_id'];
                                }
                            }
                        }
                        echo form_dropdown('timezone', $options, $settings->timezone, 'style="width:250px" class="chosen-select"'); ?>

					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_money_format');?>
						</label>
						<?php $options = [
                        '1' => '1,234.56',
                        '2' => '1.234,56',
                        '3' => '1234.56',
                        '4' => '1234,56',
                        '5' => "1'234.56",
                        ];
                        echo form_dropdown('money_format', $options, $settings->money_format, 'style="width:100%" class="chosen-select"'); ?>

					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_currency_position');?>
						</label>
						<?php $options = [
                        '1' => '$ 100',
                        '2' => '100 $',
                        ];
                        echo form_dropdown('money_currency_position', $options, $settings->money_currency_position, 'style="width:100%" class="chosen-select"'); ?>

					</div>
				</div>
                <!--        CONFIGURAÇÃO DE IDIOMA PADRÃO / ESCONDIDO        -->
				<!--<div class="col-md-12">
					<div class="form-group">
						<label>
							<?/*=$this->lang->line('application_default_languag');*/?>
						</label>
						<?php /*$options = [];
                        if ($handle = opendir('application/language/')) {
                            while (false !== ($entry = readdir($handle))) {
                                if ($entry != '.' && $entry != '..') {
                                    $options[$entry] = ucwords($entry);
                                }
                            }
                            closedir($handle);
                        }
                        echo form_dropdown('language', $options, $settings->language, 'style="width:250px" class="chosen-select"'); */?>

					</div>
				</div>-->
			</div>
            <div class="form-header">
                <?=$this->lang->line('application_push_notification_settings');?>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label>
                            <?=$this->lang->line('application_push_notification_active');?>
                        </label>
                        <input name="push_active" type="checkbox" class="checkbox" data-labelauty="<?=$this->lang->line('application_push_notification_active');?>"
                               value="1" <?php if ($settings->push_active == '1') {
                            ?> checked="checked"
                            <?php
                        } ?>>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            <?=$this->lang->line('application_push_notification_app_id');?>
                        </label>
                        <input type="text" name="push_app_id" class="form-control" value="<?=$settings->push_app_id;?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            <?=$this->lang->line('application_push_notification_rest_api_key');?>
                        </label>
                        <input type="text" name="push_rest_api_key" class="required form-control" value="<?=$settings->push_rest_api_key;?>">
                    </div>
                </div>
            </div>

			<div class="form-group no-border">
				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />

			</div>

			</table>

			<?php echo form_close(); ?>
		</div>
	</div>
	</div>
</div>