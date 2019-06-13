<?php
$attributes = array('class' => '', 'id' => '_assign_plants');
echo form_open($form_action, $attributes);
if(isset($dispute)){ ?>
    <input id="id" type="hidden" name="id" value="<?php echo $dispute->id; ?>" />
<?php } ?>

    <div class="form-group">
        <label for="rule_name">
            <?=$this->lang->line('application_rule_type');?>
        </label>
        <?php $options = array();
        $rule_name = "";
        $options['city'] = $this->lang->line('application_city');
        $options['state'] = $this->lang->line('application_state');
        $options['country'] = $this->lang->line('application_country');

        if (isset($dispute) && is_object($dispute)) {
            $rule_name = $dispute->rule_name;
        }
        echo form_dropdown('rule_name', $options, $rule_name, 'style="width:100%" id="rule_name" class="chosen-select"'); ?>
    </div>

    <div class="form-group hidden rule-select" id="city_group">
        <label for="cities_ids">
            <?=$this->lang->line('application_select_cities');?>
        </label>
        <?php
        $options = array();
        $city = array();

        foreach ($cities as $value):
            $options[$value->id] = $value->name."/".$value->state;
        endforeach;

        if(isset($dispute)){}else{$city = "";}

        $disabled = ''; //$this->user->admin == 0 ? 'disabled' : '';

        $label = $this->lang->line('application_select_cities');

        echo form_dropdown('cities_ids[]', $options, $dispute_cities, "style='width:100%' class='chosen-select' $disabled data-placeholder='$label' multiple tabindex='3'");
        ?>
    </div>

    <div class="form-group hidden rule-select" id="state_group">
        <label for="states_ids">
            <?=$this->lang->line('application_select_states');?>
        </label>
        <?php
        $options = array();
        $state = array();

        foreach ($states as $value):
            $options[$value->id] = $value->name;
        endforeach;

        if(isset($dispute)){}else{$state = "";}

        $disabled = ''; //$this->user->admin == 0 ? 'disabled' : '';

        $label = $this->lang->line('application_select_states');

        echo form_dropdown('states_ids[]', $options, $dispute_states, "style='width:100%' class='chosen-select' $disabled data-placeholder='$label' multiple tabindex='3'");
        ?>
    </div>

    <div class="form-group hidden rule-select" id="country_group">
        <label for="states_ids">
            <?=$this->lang->line('application_select_countries');?>
        </label>
        <?php
        $options = array();
        $country = array();

        foreach ($countries as $value):
            $options[$value->id] = $value->name;
        endforeach;

        if(isset($dispute)){}else{$country = "";}

        $disabled = ''; //$this->user->admin == 0 ? 'disabled' : '';

        $label = $this->lang->line('application_select_countries');

        echo form_dropdown('countries_ids[]', $options, $dispute_countries, "style='width:100%' class='chosen-select' $disabled data-placeholder='$label' multiple tabindex='3'");
        ?>
    </div>

    <div class="form-group">
        <label for="rule_level">
            <?=$this->lang->line('application_minimum_level_participants');?>
        </label>
        <?php $options = array();
        $rule_level = "";
        $options['1'] = $this->lang->line('application_one');
        $options['2'] = $this->lang->line('application_two');
        $options['3'] = $this->lang->line('application_three');
        $options['4'] = $this->lang->line('application_four');
        $options['5'] = $this->lang->line('application_five');
        $options['6'] = $this->lang->line('application_six');
        $options['7'] = $this->lang->line('application_seven');
        $options['8'] = $this->lang->line('application_eight');
        $options['9'] = $this->lang->line('application_nine');
        $options['10'] = $this->lang->line('application_ten');

        if (isset($dispute) && is_object($dispute)) {
            $rule_level = $dispute->rule_level;
        }
        echo form_dropdown('rule_level', $options, $rule_level, 'style="width:100%" id="rule_level" class="chosen-select"'); ?>
    </div>

    <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>

<script>
    $(document).ready(function(){

        $("#"+$("#rule_name option:selected").val()+"_group").removeClass("hidden");

        $("#rule_name").change(function() {

            $(".rule-select").addClass("hidden");

            $("#"+$("#rule_name option:selected").val()+"_group").removeClass("hidden");


        });


    });
</script>
