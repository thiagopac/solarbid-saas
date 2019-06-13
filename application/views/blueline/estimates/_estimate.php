<?php   
$attributes = array('class' => '', 'id' => '_invoices');
echo form_open($form_action, $attributes); 
?>

<?php if(isset($estimate)){ ?>
<input id="id" type="hidden" name="id" value="<?=$estimate->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
<input id="view" type="hidden" name="view" value="true" />
<?php } ?>
<input id="status" name="status" type="hidden" value="Open"> 
 <div class="form-group">
        <label for="reference"><?=$this->lang->line('application_reference_id');?> *</label>
        <div class="input-group">
        <div class="input-group-addon"><?=$core_settings->estimate_prefix;?></div>
            <input id="reference" type="text" name="estimate_reference" class="form-control"  value="<?php if(isset($estimate)){echo $estimate->estimate_reference;} else{ echo $core_settings->estimate_reference; } ?>" />
        </div>
 </div>
    <div class="form-group">
        <label for="client"><?=$this->lang->line('application_dispute_object');?></label>
        <?php $options = array();
        $options['0'] = '-';
        foreach ($companies as $value):
            $options[$value->id] = $value->name;
        endforeach;
        $client = ""; $project = "";
        echo form_dropdown('company_id', $options, $client, 'style="width:100%" data-destination="getProjects" class="chosen-select getProjects"');?>
    </div>
 <div class="form-group">
        <label for="issue_date"><?=$this->lang->line('application_issue_date');?> *</label>
        <input id="issue_date" type="text" name="issue_date" data-time-enable=true class="required datepicker-time form-control" value="<?php if(isset($estimate)){echo $estimate->issue_date;} ?>"  required/>
 </div>
 <div class="form-group">
        <label for="due_date"><?=$this->lang->line('application_due_date');?> *</label>
        <input id="due_date" type="text" name="due_date" data-time-enable=true class="required datepicker-time form-control" value="<?php if(isset($estimate)){echo $estimate->due_date;} ?>"  required/>
 </div>
 <!--<div class="form-group">
        <label for="currency"><?/*=$this->lang->line('application_currency');*/?></label>
        <input id="currency" type="text" name="currency" class="required form-control" value="<?php /*if(isset($estimate)){ echo $estimate->currency; }else { echo $core_settings->currency; } */?>" required/>
 </div>-->
        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>