<?php
if($items) : ?>
    <?php foreach ($items as $item): ?>
        <li class="hidden <?=$item->status?>-dot" data-link="<?=base_url()?>cinbox/view/<?=$item->id;?>">
            <div class="col col-1"><span class="dot "></span>
                <span class="indicator icon dripicons-chevron-down"></span><p class="title"><?php echo $item->title; ?></p>
            </div>

            <div class="col col-2">
                <div class="subject">
                    <?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($item->created_at))?>
                </div>
<!--                <div class="date">-->
<!--                    <span class="hidden-sm hidden-xs">--><?//=$this->lang->line('application_received_ago');?><!-- --><?//=$item->created_at?><!--</span>-->
<!--                    <span data-countdown="--><?//=$comp_has_disp->dispute->due_date?><!--" class="visible-xs visible-sm clock --><?php //echo strtotime($comp_has_disp->dispute->due_date) < time() == true ? 'label label-width-constant label-pill label-important' : 'label label-width-constant label-pill label-success' ?><!--" style="margin-top: 15px; font-weight: bold !important; vertical-align: middle; margin-left: 10px"></span>-->
<!--                </div>-->
            </div>
        </li>
    <?php endforeach; ?>

<?php else: ?>
    <li style="padding-left:21px"><?=$this->lang->line('application_no_messages');?></li>
<?php endif; ?>
<script>
jQuery(document).ready(function($) {
    $
    $("#main .message-list li").removeClass("hidden").delay(300).addClass("visible");
    var cols = {},

        messageIsOpen = false;

        cols.showOverlay = function() {
            $('body').addClass('show-main-overlay');s
        };
        cols.hideOverlay = function() {
            $('body').removeClass('show-main-overlay');
        };


        cols.showMessage = function() {
            $('body').addClass('show-message');
            messageIsOpen = true;
        };
        cols.hideMessage = function() {
            $('body').removeClass('show-message');
            $('#main .message-list li').removeClass('active');
            $("#main .message-list li .indicator").removeClass('dripicons-chevron-right');
            $("#main .message-list li .indicator").addClass('dripicons-chevron-down');
         messageIsOpen = false;
        };

        cols.showSidebar = function() {
            $('body').addClass('show-sidebar');
        };
        cols.hideSidebar = function() {
            $('body').removeClass('show-sidebar');
        };

        // Show sidebar when trigger is clicked

        $('.trigger-toggle-sidebar').on('click', function() {
            cols.showSidebar();
            cols.showOverlay();
        });


        $('.trigger-message-close').on('click', function() {
            cols.hideMessage();
            cols.hideOverlay();
        });


      // When you click on a message, show it

        $('#main .message-list li').on('click', function(e) {
            var item = $(this),
            target = $(e.target);
            NProgress.start();

            if(target.is('label')) {
                item.toggleClass('selected');
            }else{
                if(messageIsOpen && item.is('.active')) {
                    cols.hideMessage();
                    cols.hideOverlay();

                    item.find(".indicator").addClass('dripicons-chevron-down');
                    item.find(".indicator").removeClass('dripicons-chevron-right');

                    NProgress.done();
                } else {
                    if(messageIsOpen) {
                        cols.hideMessage();
                        item.addClass('active');

                        item.find(".indicator").addClass('dripicons-chevron-right');
                        item.find(".indicator").removeClass('dripicons-chevron-down');

                        setTimeout(function() {
                        var url = item.data('link');
                        if (url.indexOf('#') === 0) {

                        }else{
                            $.get(url, function(data) {
                            $('#message').html(data);
                        }).done(function() {
                            NProgress.done();
                            cols.showMessage();
                                });
                            }
                        }, 300);
                    } else {

                        item.find(".indicator").addClass('dripicons-chevron-right');
                        item.find(".indicator").removeClass('dripicons-chevron-down');

                        item.addClass('active');

                        var url = item.data('link');
                        if (url.indexOf('#') === 0) {
                        }else{
                            $.get(url, function(data) {
                            $('#message').html(data);
                        }).done(function() {
                        NProgress.done();
                        cols.showMessage();

                            });
                        }
                    }
                    cols.showOverlay();
                }
            }
        });

        // This will prevent click from triggering twice when clicking checkbox/label

        $('input[type=checkbox]').on('click', function(e) {
            e.stopImmediatePropagation();
        });


      // When you click the overlay, close everything

        $('#main > .overlay').on('click', function() {
            cols.hideOverlay();
            cols.hideMessage();
            cols.hideSidebar();
        });


      // Enable sexy scrollbars
        $('.nano').nanoScroller();

});
</script>