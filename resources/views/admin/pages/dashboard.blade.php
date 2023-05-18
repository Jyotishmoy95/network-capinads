@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('page-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .transcations.table td{
            padding: 6px 0 !important;
        }
    </style>
@endsection

@section('content')
    
    @include('admin.pages.dashboard.partials.pageheader')

    <div class="row row-sm">
        <div class="col-sm-12 col-lg-12 col-xl-8">

            <!--Boxes-->
            @include('admin.pages.dashboard.partials.'.$boxType)
            <!--End Boxes-->

            <!--row-->
            <div class="row row-sm">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-header border-bottom-0 row">
                            <div class="col-md-8 col-12">
                                <label class="main-content-label mb-2">Total Joinings & Activations</label> 
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="d-flex flex-row-reverse">
                                    <div id="date_range" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pl-0">
                            <div class>
                                <div class="container">
                                    <div id="joinings-activations-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- col end -->
            </div><!-- Row end -->

            <!--row-->
            <div class="row row-sm">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-header border-bottom-0 row">
                            <div class="col-md-8 col-12">
                                <label class="main-content-label mb-2">Total Activations & Income Generated Chart</label> 
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="d-flex flex-row-reverse">
                                    <div id="date_range_2" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pl-0">
                            <div class>
                                <div class="container">
                                    <div id="incomes-activation-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- col end -->
            </div><!-- Row end -->

        </div><!-- col end -->
        <div class="col-sm-12 col-lg-12 col-xl-4">

            <div class="card custom-card">
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="col-6">
                            <div class="card-item-title">
                                <label class="main-content-label tx-13 font-weight-bold mb-2">Project Launch Days</label>
                                <span class="d-block tx-12 mb-0 text-muted">Number of days since project launch</span>
                            </div>
                            <p class="mb-0 tx-24 mt-2"><b class="text-primary">{{ $launchDays }} days</b></p>
                            <a href="#" class="text-muted"> {{ $launchDate }} </a>
                        </div>
                        <div class="col-6">
                            <img src="{{ asset('assets/img/pngs/work.png') }}" alt="image" class="best-emp">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card custom-card">
                <div class="card-body">
                    <label class="main-content-label mb-2 pt-1">Actice - Inactive Users</label>
                    <span class="d-block tx-12 mb-2 text-muted">Actice - Inactive users chart displays the ratio of active and inactive members</span>
                    <div class="row row-sm">
                        <div id="active-inactive-chart"></div>
                    </div>
                </div>
            </div>

            <div class="card custom-card card-dashboard-calendar pb-0">
                <label class="main-content-label mb-2 pt-1">Recent transcations</label>
                <!-- <span class="d-block tx-12 mb-2 text-muted">Projects where development work is on completion</span> -->
                <table class="table table-hover m-b-0 transcations mt-2">
                    <tbody>

                        @if($recentTransactions && $recentTransactions->count() > 0)
                            @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td class="wd-5p">
                                        <div class="main-img-user avatar-md">
                                            <img alt="avatar" class="rounded-circle mr-3" src="{{ asset('assets/img/blank-user.webp') }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-middle ml-3">
                                            <div class="d-inline-block">
                                                <h6 class="mb-1">{{ $transaction->username }}</h6>
                                                <p class="mb-0 tx-13 text-muted">{{ $transaction->remark }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-inline-block">
                                            <h6 class="tx-15 font-weight-semibold">
                                                {{ $transaction->amount }}
                                                @if($transaction->type == 'credit')
                                                    <i class="fas fa-level-up-alt ml-2 text-success m-l-10" title="Credit"></i>
                                                @else
                                                    <i class="fas fa-level-down-alt ml-2 text-danger m-l-10" title="Debit"></i>
                                                @endif
                                            </h6>
                                            <p class="mb-0 tx-11 text-muted">{{ $transaction->created_at->format('d-m-Y h:i A') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">No recent transactions</td>
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>

            <div class="card custom-card">
                <div class="card-header border-bottom-0 pb-1">
                    <label class="main-content-label mb-2 pt-1">Recent Joinings</label>
                </div>
                <div class="card-body pt-0">
                    @if($recentJoinings && $recentJoinings->count() > 0)
                        <ul class="top-selling-products pb-0 mb-0 pl-0">
                            @foreach($recentJoinings as $recentJoining)
                                <li class="product-item pb-1">
                                    <div class="product-img"><img alt="avatar" src="{{ asset('assets/img/blank-user.webp') }}"></div>
                                    <div class="product-info">
                                        <div class="product-name">{{ $recentJoining->member->full_name }}</div>
                                        <div class="price">{{ $recentJoining->member_id }}</div>
                                    </div>
                                    <div class="product-amount">
                                        <div class="product-price">@if($recentJoining->activation_amount > 0) <span class="badge badge-pill badge-success">Active</span> @else <span class="badge badge-pill badge-danger">Inactive</span> @endif</div>
                                        <div class="items-sold">{{ $recentJoining->created_at->format('d-m-Y h:i A') }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center">No recent joinings</div>
                    @endif
                </div>
            </div>
        </div>
            
        </div><!-- col end -->
    </div><!-- Row end -->

@endsection

@section('page-js')
	<!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script type="text/javascript">

        let month_wise_joinings = @json($month_wise_joinings);
        let month_wise_activations = @json($month_wise_activations);

        let monthly_revenue = @json($monthly_revenue);
        let monthly_incentives = @json($monthly_incentives);

        let x_axis_data = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        $(function() {

            var start = moment().startOf('year');
            var end = moment().endOf('year');

            function cb(start, end) {
                $('#date_range span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            }

            $('#date_range').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {

                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')]
                }
            }, cb);

            cb(start, end);
            
            //Chart 2

            function ch2(start, end) {
                $('#date_range_2 span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            }

            $('#date_range_2').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {

                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')]
                }
            }, ch2);

            ch2(start, end);

            // Joinings & Activations Chart Update
            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                
                let sDate = picker.startDate._d;
                let eDate = picker.endDate._d;

                let sDateFull = `${sDate.getFullYear()}-${(sDate.getMonth() < 9 ? '0' : '') + (sDate.getMonth() + 1)}-${(sDate.getDate() < 10 ? '0' : '') +sDate.getDate()}`;
                let eDateFull = `${eDate.getFullYear()}-${(eDate.getMonth() < 9 ? '0' : '') + (eDate.getMonth() + 1)}-${(eDate.getDate() < 10 ? '0' : '') +eDate.getDate()}`;

                let defaultStart = `${start._d.getFullYear()}-${(start._d.getMonth() < 10 ? '0' : '') + (start._d.getMonth() + 1)}-${(start._d.getDate() < 10 ? '0' : '') +start._d.getDate()}`
                let defaultEnd = `${end._d.getFullYear()}-${(end._d.getMonth() < 10 ? '0' : '') + (end._d.getMonth() + 1)}-${(end._d.getDate() < 10 ? '0' : '') +end._d.getDate()}`

                if(defaultStart == sDateFull && defaultEnd == eDateFull){
                    renderChart(month_wise_joinings, month_wise_activations, x_axis_data);
                }else{
                    
                    $.ajax({
                    url:"{{ route('admin.dashboard.filter-joinings-activations') }}",
                    method:"GET",
                    data:{ start: sDateFull, end: eDateFull },
                    success:function(data)
                    {
                        renderChart(data.joinings, data.activations, data.range);
                    },
                    error: function(xhr, textStatus, errorThrown) { 
                        alert('Something went wrong. Please refresh the page!');
                    }  
                    });  

                }
            });

            // Joinings & Activations Chart Update
            $('#date_range_2').on('apply.daterangepicker', function(ev, picker) {
                let sDate = picker.startDate._d;
                let eDate = picker.endDate._d;

                let sDateFull = `${sDate.getFullYear()}-${(sDate.getMonth() < 9 ? '0' : '') + (sDate.getMonth() + 1)}-${(sDate.getDate() < 10 ? '0' : '') +sDate.getDate()}`;
                let eDateFull = `${eDate.getFullYear()}-${(eDate.getMonth() < 9 ? '0' : '') + (eDate.getMonth() + 1)}-${(eDate.getDate() < 10 ? '0' : '') +eDate.getDate()}`;

                let defaultStart = `${start._d.getFullYear()}-${(start._d.getMonth() < 10 ? '0' : '') + (start._d.getMonth() + 1)}-${(start._d.getDate() < 10 ? '0' : '') +start._d.getDate()}`
                let defaultEnd = `${end._d.getFullYear()}-${(end._d.getMonth() < 10 ? '0' : '') + (end._d.getMonth() + 1)}-${(end._d.getDate() < 10 ? '0' : '') +end._d.getDate()}`

                if(defaultStart == sDateFull && defaultEnd == eDateFull){
                    renderAreaChart(monthly_revenue, monthly_incentives, x_axis_data);
                }else{
                    
                    $.ajax({
                    url:"{{ route('admin.dashboard.filter-revenue-incentives') }}",
                    method:"GET",
                    data:{ start: sDateFull, end: eDateFull },
                    success:function(data)
                    {
                        renderAreaChart(data.revenue, data.incentives, data.range);
                    },
                    error: function(xhr, textStatus, errorThrown) { 
                        alert('Something went wrong. Please refresh the page!');
                    }  
                    });  

                }
            });
        
        });
    </script>

    <script>

        // Joinings & Activations Chart Start
        var options = {
            series: [
                {
                    name: 'Total Joinings',
                    data: month_wise_joinings
                }, 
                {
                    name: 'Total Activations',
                    data: month_wise_activations
                }
            ],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                    return parseInt(val)
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#joinings-activations-chart"), options);
        chart.render();
        // Joinings & Activations Chart End

        function renderChart(joining_data, activation_data, label_data){

            chart.updateOptions({
                series: [
                    {
                        name: 'Total Joinings',
                        data: joining_data
                    }, 
                    {
                        name: 'Total Activations',
                        data: activation_data
                    }
                ],
                xaxis: {
                    categories: label_data
                },
                chart: {
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                }
            });

        }


        // Incomes & Activations Chart Start
        var options2 = {
            series: [
                {
                    name: "Total Activations",
                    data: monthly_revenue
                },
                {
                    name: "Total Income Generated",
                    data: monthly_incentives
                }
            ],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', "Oct", "Nov", "Dec"],
            }
        };

        var chart2 = new ApexCharts(document.querySelector("#incomes-activation-chart"), options2);
        chart2.render();

        function renderAreaChart(revenue_data, incentives_data, label_data){

            chart2.updateOptions({
                series: [
                    {
                        name: 'Total Activations',
                        data: revenue_data
                    }, 
                    {
                        name: 'Total Income Generated',
                        data: incentives_data
                    }
                ],
                xaxis: {
                    categories: label_data
                },
                chart: {
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                }
            });

        }

    </script>

    <script>
        // Active & Inactive Users Chart Start
        var pie_options = {
            series: [@json($totalActiveUsers), @json($totalInactiveUsers)],
            chart: {
            type: 'pie',
            },
            labels: ['Active Users', 'Inactive Users'],
            colors:['#00cc66', '#ff471a'],
            responsive: [{
                breakpoint: 576,
                options: {
                    chart: {
                    width: 200
                    },
                    legend: {
                    position: 'bottom'
                    }
                }
            }]
        };

        var pie_chart = new ApexCharts(document.querySelector("#active-inactive-chart"), pie_options);
        pie_chart.render();

    </script>

@endsection