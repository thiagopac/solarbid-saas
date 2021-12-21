<?php
    $attributes = array('class' => '', 'id' => 'post');
    echo form_open_multipart($form_action, $attributes);
    if(isset($post)){ ?>
        <input id="id" type="hidden" name="id" value="<?php echo $post->id; ?>" />
    <?php }
?>
<style>
    .note-editable.panel-body {
        min-height: 785px !important;
    }
</style>
<div class="col-sm-12 col-md-12 main">
    <?php include_once ("header_menu.php")?>

    <div class="row">

        <div class="col-md-8">
            <div class="box-shadow">
                <div class="table-head">
                    <?=$this->lang->line('application_post');?>
                </div>
                <div class="subcont">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">
                                    <?=$this->lang->line('application_title');?> *</label>
                                <input id="title" type="text" name="title" class="required form-control" value="<?php if (isset($post)) {
                                    echo $post->title;
                                } ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group read-only">
                                <label for="slug">
                                    <?=$this->lang->line('application_slug');?> <small><?=$this->lang->line('application_slug_desc')?></small></label>
                                <input id="slug" readonly="readonly" type="text" name="slug" class="required form-control" value="<?php if (isset($post)) {
                                    echo $post->slug;
                                } ?>"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="text"><?=$this->lang->line('application_text');?> *</label>
                        <textarea class="form-control summernote" name="text" id="textfield" required><?=$post  ->text;?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box-shadow">
                <div class="table-head">
                    <?=$this->lang->line('application_blog_spec');?>
                </div>
                <div class="subcont">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group read-only">
                                <label for="slug">
                                    <?=$this->lang->line('application_author');?></label>
                                <input id="author" readonly="readonly" type="text" name="author" class="required form-control" value="<?php if (isset($post)) {
                                    echo $post->author;
                                }else{
                                    echo $this->user->firstname . ' ' . $this->user->lastname;
                                } ?>"/>
                            </div>
                            <?php
                            $img = base_url()."assets/blueline/images/empty_img_placeholder.jpeg";
                                if ($post){
                                    $img = $post->image;
                                }
                            ?>
                            <img id="image_preview" name="image_preview" src="<?=$img?>" style="width: 100%"/>
                            <div class="form-group" style="margin-top: 20px">
                                <label for="userfile"><?= $this->lang->line('application_image_url'); ?> </label>
                                <div>
                                    <input id="image" type="text" name="image" class="required form-control" value="<?php if (isset($post)) {
                                        echo $post->image;
                                    } ?>" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($post) : ?>
            <div class="box-shadow" style="margin-top: 20px;">
                <div class="table-head">
                    <?=$this->lang->line('application_publication');?>
                </div>
                <div class="subcont">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?= $this->lang->line('application_program_availability'); ?> <small><?=$this->lang->line('application_leave_blank_availability')?></small> </label>
                                <input class="form-control datepicker-time not-required" data-enable-time=true name="start" id="start" type="text"
                                       value="<?php if ($post->start != null) {
                                           echo $post->start;
                                       } ?>" />
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    <?=$this->lang->line('application_status');?> <small><?=$this->lang->line('application_active_desc')?></small>
                                </label>
                                <input type="checkbox" class="checkbox" id="active" name="active"
                                       data-labelauty="<?=$this->lang->line('application_active')?>"
                                    <?php if ($post->active == 1) {
                                        echo 'checked="checked"';
                                    } ?>>
                            </div>
                            <div class="form-group">
                                <label for="preview"><?=$this->lang->line('application_preview_post');?></label>
                                <a href="https://solarbid.com.br/post?artigo=<?=$post->slug?>" target="_blank"><input type="text" class="form-control" disabled value="https://solarbid.com.br/post?artigo=<?=$post->slug?>"/></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>

    </div>
    <div class="modal-footer" style="margin-top: 20px;">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
    </div>
</div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function(){
        function string_to_slug (str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "ãàáäâèéëêìíïîõòóöôùúüûñç·/_,:;";
            var to   = "aaaaaeeeeiiiiooooouuuunc------";
            for (var i=0, l=from.length ; i<l ; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        }


        $("#title").change(function(){
            $("#slug").val(string_to_slug($("#title").val()))
        });

        // function readURL(input) {
        //
        //     if (input[0].files[0]) {
        //         var reader = new FileReader();
        //
        //         reader.onload = function (e) {
        //             $('#image').attr('src', e.target.result);
        //         };
        //
        //         reader.readAsDataURL(input[0].files[0]);
        //     }
        // }
        //
        // $("#uploadBtn").change(function(){
        //     readURL($(this));
        // });

        function readURL(input) {
            $('#image_preview').attr('src', input.val())
        }

        $("#image").change(function(){
            readURL($(this));
        });

    });
</script>
