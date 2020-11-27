
    <?php if ($this->session->flashdata('message')) {
        $exp = explode(':', $this->session->flashdata('message'));
    } ?>

    <div id="message-nano-wrapper" class="nano ">
        <div class="nano-content">
            <div class="header">
                <div class="message-content-menu">
                    <?if ($exp != null):?>
                        <div class="alert alert-<?=$exp[0]?>">
                            <button id="alert-close" class="close" type="button" data-dismiss="alert">×</button>
                            <?=$exp[1]?>
                        </div>
                    <?php endif;?>
                    <h4 class="page-title"><?=$item->title?></h4>
                </div>

                <span class="page-title">
                    <a class="icon glyphicon glyphicon-chevron-right trigger-message-close"></a>
                </span>

            </div>

            <div class="message-container">
                <?=$item->content;?>
                <p></p>
                <small style="float: right;"><?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($item->created_at))?></small>
            </div>

        </div>
    </div>

    <br />
    <br />
<script>
    jQuery(document).ready(function($) {

        $('#alert-close').on('click', function () {
           $(this).closest('.alert').hide();
        });

        $('.nano').nanoScroller();

        $('.trigger-message-close').on('click', function() {
            $('body').removeClass('show-message');
            $('#main .message-list li').removeClass('active');
            $("#main .message-list li .indicator").removeClass('dripicons-chevron-right');
            $("#main .message-list li .indicator").addClass('dripicons-chevron-down');
            messageIsOpen = false;
            $('body').removeClass('show-main-overlay');
        });

    });
</script>