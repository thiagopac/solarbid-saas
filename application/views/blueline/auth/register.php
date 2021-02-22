<?php $attributes = ['class' => 'form-signin form-register box-shadow hidden', 'role' => 'form', 'id' => 'register']; ?>
<?= form_open($form_action, $attributes) ?>
<div class="logo"><img width="200" src="<?= base_url() ?><?php if ($core_settings->login_logo == '') {
        echo $core_settings->solarbid_logo;
    } else {
        echo $core_settings->login_logo;
    } ?>" alt="<?= $core_settings->company; ?>"></div>
<?php if ($error != 'false') {
    ?>
    <div id="error" style="display:block">
        <?= $error ?>
    </div>
    <?php
} ?>

<div class="row">
    <div class="header">
        <?= $this->lang->line('application_registration_header_desc'); ?>
    </div>
    <br />
    <hr>

    <div class="form-header">
        <?=$this->lang->line('application_registration_company_desc')?>
    </div>
    <div class="form-group">
        <label for="name">
            <?= $this->lang->line('application_fancy_name'); ?> *</label>
        <input id="name" type="text" name="name" <?= $disabled ?> class="required form-control" tabindex="1"
               value="" required/>
    </div>

    <div class="form-group">
        <label for="name">
            <?= $this->lang->line('application_corporate_name'); ?> *</label>
        <input id="corporate_name" type="text" <?= $disabled ?> name="corporate_name" class="required form-control" tabindex="2"
               value="" required/>
    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="form-group">
                <label for="name">
                    <?= $this->lang->line('application_registered_number'); ?> *
                </label>
                <input id="registered_number" type="text" name="registered_number" tabindex="3"
                       class="required form-control" value="" required/>
            </div>

            <div class="form-group">
                <label for="address"><?= $this->lang->line('application_address'); ?> *</label> <small>(<?= $this->lang->line('application_address_desc'); ?>)</small>
                <input id="address" type="text" name="address" class="form-control" tabindex="5"
                       value="" required/>
            </div>

            <div class="form-group">
                <label for="city"><?= $this->lang->line('application_city'); ?> *</label>
                <input id="city" type="text" name="city" class="form-control" tabindex="7" value="" required/>
            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">
                <label for="zipcode"><?= $this->lang->line('application_zip_code'); ?> *</label>
                <input id="zipcode" type="text" name="zipcode" class="form-control" tabindex="4"
                       value="" required/>
            </div>

            <div class="form-group">
                <label for="phone"><?= $this->lang->line('application_phone'); ?> *</label>
                <input id="phone" type="text" name="phone" class="form-control rect-auto" tabindex="6" value="" required/>
            </div>

            <div class="form-group">
                <label for="state">
                    <?=$this->lang->line('application_state');?> *
                </label>
                <?php
                $options = array();
                $state = array();

                $options[null] = $this->lang->line('application_select_state');

                foreach ($states as $value):
                    $options[$value->letter] = $value->name;
                endforeach;

                $state = "";

                $label = $this->lang->line('application_select_state');

                echo form_dropdown('state', $options, $company_state, 'style="width:100%" class="chosen-select"');?>
            </div>

        </div>

        <div class="col-md-12">

            <div class="form-header">
                <?=$this->lang->line('application_registration_client_desc')?>
            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">
                <label for="firstname"><?= $this->lang->line('application_firstname'); ?> *</label>
                <input id="firstname" type="text" name="firstname" class=" form-control" tabindex="9"
                       value="" required/>
            </div>

            <div class="form-group <?php if (isset($registerdata)) {
                echo 'has-error';
            } ?>">
                <label for="email"><?= $this->lang->line('application_email'); ?> *</label>
                <input id="email" type="email" name="email" class="required email form-control" tabindex="11"
                       value="" required/>
            </div>

            <div class="form-group">
                <label for="password"><?= $this->lang->line('application_password'); ?> *</label>
                <input id="password" type="password" name="password" class="form-control" value="" tabindex="13" required/>
            </div>

            <div class="">
                <label for="captcha"><?= $this->lang->line('application_captcha_desc'); ?> </label>
            </div>

        </div>
        <div class="col-md-6">

            <div class="form-group">
                <label for="lastname"><?= $this->lang->line('application_lastname'); ?> *</label>
                <input id="lastname" type="text" name="lastname" class="required form-control" tabindex="10"
                       value="" required/>
            </div>

            <div class="form-group">
                <label for="mobile"><?= $this->lang->line('application_mobile'); ?></label>
                <input id="mobile" type="text" name="mobile" class="form-control" tabindex="12"
                       value=""/>
            </div>

            <div class="form-group">
                <label for="password"><?= $this->lang->line('application_confirm_password'); ?> *</label>
                <input id="confirm_password" type="password" class="form-control" data-match="#password" tabindex="14" required/>
            </div>

            <?php $number1 = rand(1, 10);
            $number2 = rand(1, 10);
            $captcha = $number1 + $number2;

            //captcha
            $html_fields = '<input type="hidden" id="captcha" name="captcha" value="' . $captcha . '"><div class="form-group">';
            $html_fields .= '<label class="control-label-e">' . $number1 . '+' . $number2 . ' = ?</label>';
            $html_fields .= '<input tabindex="15" type="text" id="confirmcaptch" name="confirmcaptcha" data-match="#captcha" class="form-control" required/></div>';
            echo $html_fields;
            ?>
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-6">
        <a href="<?= site_url('login'); ?>"><?= $this->lang->line('application_go_to_login'); ?></a>
    </div>
    <div class="col-md-6">
        <input type="submit" style="height: 40px" class="btn btn-success" tabindex="16" value="<?= $this->lang->line('application_send'); ?>"/>
    </div>
</div>

<div class="col-md-12" style="margin-top: 20px; display: inline-block">
    <div class="pull-left">
        <img width="30" style="margin-left: -30px; float: left" height="30" src="<?=base_url()?>assets/blueline/img/whatsapp-icon.png"/>
        <label style="padding-left: 5px; float: left; padding-right: 0px"><?= $this->lang->line('application_issue_register_whatsapp_desc'); ?> </label>
        <label style="float: left; padding-left: 2px"><a href="https://api.whatsapp.com/send?phone=5531991340000" target="_blank"><?=$this->lang->line('application_issue_register_whatsapp_link')?></a></label>

    </div>
</div>

<?= form_close() ?>
<script>
    $(document).ready(function() {

        $('#registered_number').mask('00.000.000/0000-00', {reverse: false});
        $('#phone').mask('(00)000000000', {reverse: false});
        $('#mobile').mask('(00)000000000', {reverse: false});
        $('#zipcode').mask('00000-000', {reverse: false});

        $('#register').removeClass('hidden');

    });
</script>

