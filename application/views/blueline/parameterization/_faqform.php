<?php
$attributes = ['class' => '', 'id' => 'faq_customer_form'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_question');?> *
        </label>
        <input id="question" type="text" name="question" class="required form-control"  value="<?php if(isset($object)){echo $object->question;}?>"  required/>
    </div>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_answer');?> *
        </label>
        <textarea id="answer" name="answer" class="required form-control" required><?php if(isset($object)){echo $object->answer;}?></textarea>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>