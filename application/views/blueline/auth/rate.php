<?php $attributes = ['class' => 'form-signin box-shadow', 'role' => 'form', 'id' => 'rate']; ?>

<?= form_open($form_action, $attributes) ?>

<div class="logo">
    <img src="<?= base_url() ?><?= $core_settings->solarbid_logo; ?>" alt="<?= $core_settings->company; ?>">
</div>

<div class="header">
    <h3><?= sprintf($this->lang->line('application_customer_rate_integrator_desc'), $rating_post->firstname, $company->name); ?></h3>
</div>
<br/>
<hr/>

<div class="rate-container" style="display: grid; justify-content: center">

    <input type="hidden" id="company_id" name="company_id" value="<?= $rating_post->company_id ?>">

    <?php foreach ($categories as $category) : ?>

        <div class="rate-item">
            <h2 style="text-align: center"><?= $this->lang->line("application_rate_$category->type"); ?>: <span
                        id="grade_<?= $category->type ?>">2.5</span></h2>
            <div class="rate" id="rate_<?= $category->type ?>" style="color: #f1c946; font-size: 50px;width: 225px;"
                 data-rate-value=2.5></div>
            <input type="hidden" id="<?= $category->id ?>" name="<?= $category->id ?>">
        </div>
        <hr/>

    <?php endforeach; ?>

    <h2 style="text-align: center"><?= $this->lang->line('application_comment'); ?>: </h2>
    <textarea id="comment" name="comment" rows="5" style="width: 100%"></textarea>
<br/>
    <div style="text-align: center;">
        <input type="submit" style="width: 100%; height: 40px" class="btn btn-primary"
               value="<?= $this->lang->line('application_send'); ?>"/>
    </div>
</div>



<?= form_close() ?>

<script>
    $(document).ready(function () {

        <?php foreach ($categories as $category) : ?>

        $("#rate_<?=$category->type ?>").rate({
            max_value: 5,
            step_size: 0.5,
            selected_symbol_type: 'utf8_star',
            initial_value: 2.5,
            update_input_field_name: $("#<?=$category->id ?>")
        });

        $("#rate_<?=$category->type ?>").on("change", function (ev, data) {
            $('#grade_<?=$category->type ?>').html(data.to);
        });

        <?php endforeach; ?>

        $('input[type="submit"]').attr('disabled', true);
        $('textarea').on('keyup', function () {
            var textarea_value = $("#comment").val();
            if (textarea_value != '') {
                $('input[type="submit"]').attr('disabled', false);
            } else {
                $('input[type="submit"]').attr('disabled', true);
            }
        });


    });
</script>

