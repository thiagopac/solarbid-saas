<?php
if($comp_has_disps) : ?>
    <?php foreach ($comp_has_disps as $comp_has_disp): ?>
        <li class="hidden Read-dot" data-link="<?=base_url()?>cdisputes/view/<?=$comp_has_disp->dispute->id;?>">
            <div class="col col-1"><span class="dot "></span>
                <span class="indicator icon dripicons-chevron-down"></span><p class="title"><?php echo $core_settings->dispute_prefix.$comp_has_disp->dispute->dispute_reference; ?></p>
            </div>
            <div class="col col-2">
                <div class="subject">
                    <?=$this->lang->line('application_valid_until');?> <?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($comp_has_disp->dispute->due_date))?>
                    <span data-countdown="<?=$comp_has_disp->dispute->due_date?>" class="clock <?php echo strtotime($comp_has_disp->dispute->due_date) < time() == true ? 'label label-important' : 'label label-success' ?>" style="font-weight: normal !important; vertical-align: middle; margin-left: 50px"></span>
                </div>
                <div class="date">
                    <?=$this->lang->line('application_received_ago');?> <?=fnTimeElapsed($comp_has_disp->time, false, 'pt_BR') ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>

<?php else: ?>
    <li style="padding-left:21px"><?=$this->lang->line('application_no_messages');?></li>
<?php endif; ?>
<script>
jQuery(document).ready(function($) {

    $('[data-countdown]').each(function() {

        var $this = $(this), finalDate = $(this).data('countdown');

        $this.countdown(finalDate, function(event) {
            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
            $this.html(event.strftime(totalHours+'hr %Mmin %Ss'));
        })

         if($this.html() == '0hr 00min 00s'){
        $this.html("<?=$this->lang->line('application_deadline_reached')?>");
    }

    });




    $("#main .message-list li").removeClass("hidden").delay(300).addClass("visible");
    var cols = {},

        messageIsOpen = false;

        cols.showOverlay = function() {
            $('body').addClass('show-main-overlay');
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