<?php
$attributes = array('class' => '', 'id' => '_event');
$classname = "bgColor1";
echo form_open($form_action, $attributes);
$code = $event->store_flow_id != null ? $event->store_flow_id : $event->flow_id;
$disabled = $integrator_approved == true ? "disabled = 'disabled'" : "";

if (isset($event)) {?>
    <input id="token" type="hidden" name="token" value="<?=$code?>"/>
    <input id="view" type="hidden" name="view" value="<?=$view?>"/>
    <?php
} ?>


<div class="form-group read-only" style="color: black">
    <label for="title"><?= $this->lang->line('application_token'); ?></label>
    <input type="text" class="form-control" value="<?=$code?>" disabled/>
</div>

<div class="form-group">
    <label for="description"><?= $this->lang->line('application_date'); ?> *</label>
    <input class="form-control datepicker" name="date" id="date" type="text" value="<?php if($event->date != null){echo ($event->date)->format('Y/m/d');} ?>" required <?=$disabled?>/>
</div>


<div class="form-group">
    <label for="country">
        <?=$this->lang->line('application_appointment_time');?> *
    </label>
    <?php
    $options = array();

    foreach ($appointment_times as $value):
        $options[$value->id] = $value->name;
    endforeach;

    if(isset($event)){}else{$appointment_time_id = "";}

    $label = $this->lang->line('application_select_appointment_time');

    echo form_dropdown('appointment_time_id', $options, $event->appointment_time_id, "style='width:100%' class='chosen-select' required $disabled ");?>
</div>

<div class="form-group">
    <label for="country">
        <?=$this->lang->line('application_concluded_visit');?> *
    </label>
    <?php
    $options = array();

    $options[0] = $this->lang->line('application_no');
    $options[1] = $this->lang->line('application_yes');

    $label = $this->lang->line('application_select');

    echo form_dropdown('completed', $options, $event->completed, "style='width:100%' class='chosen-select' required $disabled ");?>
</div>

<?php if ($disabled == true) : ?>
    <div class="row">
        <div class="col-md-12">
            <?=$this->lang->line('application_cannot_change_appointment');?>
        </div>
    </div>
<?php endif; ?>

<div class="modal-footer">
    <?php if ($view == "cappointments") : ?>
        <a class="btn btn-success pull-left" href="<?= base_url() ?>ctokens/go_to_token/<?=$code?>"><?= $this->lang->line('application_view_token'); ?></a>
    <?php endif; ?>
    <input type="submit" name="send" class="btn btn-primary" value="<?= $this->lang->line('application_save'); ?>" <?=$disabled?> />
    <a class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('application_close'); ?></a>
</div>

<script type="text/javascript">
    $(function () {

        $("#start").on("dp.change", function (e) {
            $('.linkedDateTime').data("DateTimePicker").minDate(e.date);

        });
        $(".linkedDateTime").on("dp.change", function (e) {

            $('#start').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>

<?php echo form_close(); ?>
