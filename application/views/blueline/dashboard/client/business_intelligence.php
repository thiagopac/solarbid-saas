<style>
    @media (max-width: 767px) {
        .content-area {
            padding: 0;
        }
        .row.mainnavbar {
            margin-bottom: 0px;
            margin-right: 0px;
        }
    }
</style>

<div class="grid">
    <div class="grid__col-md-7 dashboard-header">
        <h1><?=sprintf($this->lang->line('application_welcome_back'), $this->client->firstname);?></h1>
        <!--                <small>-->
        <?//=sprintf($this->lang->line('application_welcome_subline'), $messages_new[0]->amount, $event_count_for_today);?>
        <!--</small>-->
    </div>

    <div class="grid__col-md-5 dashboard-header hidden-xs">

        <div class="">
            <div class="btn-group pull-right margin-right-3">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <?php if (isset($active_task_filter)) {
                        echo $this->lang->line('application_due_' . $active_task_filter);
                    } else {
                        echo 'filtro '.$this->lang->line('test');
                    } ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>
                        <a id="all" href="<?=base_url()?>dashboard/taskfilter/all">
                            <?=$this->lang->line('test');?>
                        </a>
                    </li>
                    <li>
                        <a id="delayed" href="<?=base_url()?>dashboard/taskfilter/delayed">
                            <?=$this->lang->line('test');?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="grid__col-sm-12 grid__col-md-8 grid__col-lg-9 grid__col--bleed">
        <div class="grid grid--align-content-start">
            <?php if(1==1){ ?>

                <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6 grid__col-md-6 grid__col-lg-3">
                    <div class="tile-base box-shadow tile-with-icon">
                        <div class="tile-icon hidden-md hidden-xs"><i style="color: #d1d1d1" class="la la-bar-chart-o"></i></div>
                        <div class="tile-small-header">
                            Nº de vendas
                        </div>
                        <div class="tile-body">
                            <div class="number" id="number1">
                                5º lugar <small>(15 vendas)</small>
                            </div>
                        </div>
                        <div class="tile-bottom">
                            <div class="progress tile-progress tt" title="<?=display_money($payments);?> / <?=display_money($paymentsOutstandingMonth);?>">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?=$paymentsForThisMonthInPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$paymentsForThisMonthInPercent?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6 grid__col-md-6 grid__col-lg-3">
                    <div class="tile-base box-shadow">
                        <div class="tile-icon hidden-md hidden-xs"><i style="color: #d1d1d1" class="la la-area-chart"></i></div>
                        <div class="tile-small-header">
                            <span style="text-transform: none">kWp</span> vendidos
                        </div>
                        <div class="tile-body">
                            <div class="number" id="number2">
                                3º lugar <small>(2000 kWp)</small>
                            </div>
                        </div>
                        <div class="tile-bottom">
                            <div class="progress tile-progress tile-progress--red tt" title="<?=display_money($totalIncomeForYear);?> / <?=display_money($paymentsoutstanding);?>">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?=$paymentsOutstandingPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$paymentsOutstandingPercent?>%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6  grid__col-md-6 grid__col-lg-3">
                    <div class="tile-base box-shadow">
                        <div class="tile-icon hidden-md hidden-xs"><i style="color: #d1d1d1" class="la la-certificate"></i></div>
                        <div class="tile-small-header">
                            Média geral
                        </div>
                        <div class="tile-body">
                            3º lugar <small>(8,7)</small>
                        </div>
                        <div class="tile-bottom">
                            <div class="progress tile-progress tile-progress--green">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?=$openProjectsPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$openProjectsPercent?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6  grid__col-md-6 grid__col-lg-3">
                    <div class="tile-base box-shadow">
                        <div class="tile-icon hidden-md hidden-xs"><i style="color: #d1d1d1" class="la la-star-half-o"></i></div>
                        <div class="tile-small-header">
                            Avaliação geral
                        </div>
                        <div class="tile-body">
                            <img style="filter: sepia(30%) brightness(1.1)" src="https://wpshealth.com/assets/img/pdp-star-rating.png" width="140" /> <small>(4.5)</small>
                        </div>
                        <div class="tile-bottom">
                            <div class="progress tile-progress tile-progress--orange">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?=$openProjectsPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$openProjectsPercent?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
            <div class="grid__col-12">

                        <span id="task-list" class="">
                    <div class="box-shadow">
                        <div class="table-head">
                            Vendas x quantidade e kWp
                        </div>
                    <div class="table-div">
                        <div id="chart1"></div>
                    </div>
        </div>
        </span>
            </div>

            <div class="grid__col-12">

                        <span id="task-list" class="">
                    <div class="box-shadow" style="height: 515px">
                        <div class="table-head">
                            Preço x Faixa x Volume
                        </div>
                    <div class="table-div">
                        <div id="chart2"></div>
                    </div>
        </div>
        </span>
            </div>

        </div>
    </div>

    <div class="grid__col-sm-12 grid__col-md-4 grid__col-lg-3 grid__col--bleed">
        <div class="grid grid--align-content-start">

            <div class="grid__col-12">
                <div class="stdpad box-shadow">
                    <div class="table-head">
                        Estatísticas
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-12">
                            <ul class="list-group ">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <label class="stats-label"><i class="dripicons-preview orangered stats-icon"></i> Nº de visualizações</label>
                                    <span class="pull-right stats-number">516</span>
                                </li>
                                <hr class="stats-separator" />
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <label class="stats-label"><i class="dripicons-expand-2 orangered stats-icon"></i> Propostas expandidas</label>
                                    <span class="pull-right stats-number">314</span>
                                </li>
                                <hr class="stats-separator" />
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <label class="stats-label"><i class="dripicons-photo orangered stats-icon"></i> Visualização das suas fotos</label>
                                    <span class="pull-right stats-number">189</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid__col-12 ">
                <div class="stdpad box-shadow">
                    <div class="table-head">
                        Qualificações
                    </div>
                    <div id="chart3"></div>
                </div>
            </div>

            <div class="grid__col-12 ">
                <div class="stdpad box-shadow">
                    <div class="table-head">
                        Maior relevância para clientes
                    </div>
                    <div id="chart4"></div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        var options = {
            chart: {
                height: 370,
                type: 'line',
                toolbar: {
                    show: false
                },
            },
            colors: ["#8bd2ff", "#ff0083"],
            markers: {
                size: 6,
                hover: {
                    size: 10
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0,
                    opacityFrom: 1,
                    opacityTo: 1,
                    type: 'vertical',
                }
            },
            series: [{
                name: 'Website Blog',
                type: 'column',
                data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
            }, {
                name: 'Social Media',
                type: 'line',
                data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
            }],
            stroke: {
                width: [0, 6],
                curve: 'smooth'
            },
            legend: {
                show: true,
                floating: false,
                height: 20,
                horizontalAlign: 'left',
                onItemClick: {
                    toggleDataSeries: false
                },
                position: 'bottom',
                offsetY: -15,
                offsetX: 40
            },
            // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
            xaxis: {
                type: 'datetime'
            },
            yaxis: [{
                title: {
                    text: 'Website Blog',
                },

            }, {
                opposite: true,
                title: {
                    text: 'Social Media'
                }
            }]

        }

        var chart = new ApexCharts(
            document.querySelector("#chart1"),
            options
        );

        chart.render();

        function generateData(baseval, count, yrange) {
            var i = 0;
            var series = [];
            while (i < count) {
                //var x =Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
                var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
                var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

                series.push([baseval, y, z]);
                baseval += 86400000;
                i++;
            }
            console.log(series);
            return series;
        }

        var options = {
            chart: {
                height: 420,
                type: 'bubble',
                toolbar: {
                    show: false
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Product1',
                data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
                    min: 10,
                    max: 60
                })
            },
                {
                    name: 'Product2',
                    data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
                        min: 10,
                        max: 60
                    })
                },
                {
                    name: 'Product3',
                    data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
                        min: 10,
                        max: 60
                    })
                },
                {
                    name: 'Product4',
                    data: generateData(new Date('11 Feb 2017 GMT').getTime(), 10, {
                        min: 10,
                        max: 60
                    })
                }
            ],
            fill: {
                type: 'gradient',
            },
            title: {
            },
            xaxis: {
                tickAmount: 12,
                type: 'datetime',

                labels: {
                    rotate: 0,
                }
            },
            yaxis: {
                max: 70
            },
            theme: {
                palette: 'palette2'
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#chart2"),
            options
        );

        chart.render();


        var options = {
            chart: {
                height: 340,
                type: 'radar',
                toolbar: {
                    show: false
                },
            },plotOptions: {
                radar: {
                    size: 105,
                    polygons: {
                        strokeColor: '#e9e9e9',
                        fill: {
                            colors: ['#f8f8f8', '#fff']
                        }
                    }
                }
            },
            series: [{
                name: 'Series 1',
                data: [86, 73, 82, 79, 89],
            }],
            colors:['#8d9bdb'],
            labels: ['QUALIDADE', 'AGILIDADE', 'SEGURANÇA', 'ATENDIMENTO', 'TREINAMENTO']
        }

        var chart = new ApexCharts(
            document.querySelector("#chart3"),
            options
        );

        chart.render();

        var options = {
            chart: {
                height: 310,
                type: 'bar',
                toolbar: {
                    show: false
                },
            },
            plotOptions: {
                bar: {
                    barHeight: '50%',
                    distributed: true,
                    endingShape: 'rounded',
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    },
                }
            },
            colors: ['#27ae60', '#2980b9', '#c0392b', '#8e44ad', '#f39c12'],
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['#fff']
                },
                formatter: function(val, opt) {
                    return opt.w.globals.labels[opt.dataPointIndex]
                },
                offsetX: 0,
                dropShadow: {
                    enabled: false
                }
            },
            series: [{
                data: [490, 360, 330, 280, 190]
            }],
            stroke: {
                colors: ['#fff']
            },
            xaxis: {
                categories: ['1º Média geral', '2º Estrelas', '3º Preço', '4º Preço', '5º Preço'],
                labels: {
                    show: false
                },
                axisBorder: {
                    show: false,
                },
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            grid: {
                show: false,
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "horizontal",
                    shadeIntensity: 0.1,
                    gradientToColors: ['#66cc50', '#1aa8db', '#e72538', '#ad25b6', '#f19b2a'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                },
            },

        }

        var chart = new ApexCharts(
            document.querySelector("#chart4"),
            options
        );

        chart.render();


    });
</script>