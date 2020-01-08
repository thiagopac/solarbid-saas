<?php
$attributes = ['class' => '', 'id' => 'dealer_form'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_name');?> *
        </label>
        <input id="name" type="text" name="name" class="required form-control"  value="<?php if(isset($dealer)){echo $dealer->name;}?>"  required/>
    </div>
    <div class="form-group">
        <label><?=$this->lang->line('application_state');?></label>
        <?php
        $states['0'] = '-';

        foreach ($states as $state):
            $states[$state->letter] = $state->name;
        endforeach;

        if(isset($dealer)){$state_selected = $dealer->state;}
        echo form_dropdown('state', $states, $state_selected, 'style="width:100%" class="chosen-select"');?>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>