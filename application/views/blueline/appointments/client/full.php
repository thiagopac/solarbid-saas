<div class="col-sm-12  col-md-12 main">

    <div class="row">
        <div class="box-shadow">
            <div class="table-head"><?= $this->lang->line('application_appointments'); ?></div>
            <div class="table-div">

                <div id='fullcalendar'></div>

            </div>
        </div>
    </div>
    <?php
    if ($this->input->cookie('saas_language') != '') {
        $systemlanguage = $this->input->cookie('saas_language');
    } else {
        $systemlanguage = $core_settings->language;
    }
    switch ($systemlanguage) {
        case 'english':
            $lang = 'en';
            break;
        case 'portuguese':
            $lang = 'pt';
            break;
        default:
            $lang = 'pt';
            break;
    }

    ?>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#fullcalendar').fullCalendar({
                lang: '<?=$lang;?>',
                header: {
                    left: 'month,agendaWeek,agendaDay',
                    center: 'title',
                    right: 'today prev,next'
                },

                events: [<?php if (isset($events_list)) { echo $events_list;} ?>],
                timeFormat: 'hh:mm',
                displayEventTime:false,

                eventRender: function (event, element) {
                    element.attr('title', event.description);

                    if (event.modal == 'true') {
                        element.attr('data-toggle', "mainmodal");
                    }

                    if (event.description != '') {
                        // element.attr('title', event.description);

                        var tooltip = event.description;
                        $(element).attr("data-original-title", tooltip)
                        $(element).tooltip({container: "body", trigger: 'hover', delay: {"show": 300, "hide": 50}})
                    }

                    element.css('background-color', event.bgColor);
                },
                eventClick: function (event) {
                    if (event.url && event.modal == 'true') {
                        NProgress.start();
                        var url = event.url;

                        if (url.indexOf('#') === 0) {
                            $('#mainModal').modal('open');
                        } else {
                            $.get(url, function (data) {
                                $('#mainModal').modal();
                                $('#mainModal').html(data);
                            }).done(function () {
                                NProgress.done();
                            });
                        }
                        return false;
                    }
                }
            });

        });
    </script>
