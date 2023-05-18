@extends('members.layouts.master')

@section('title', 'Dashboard')

@section('page-css')
    <style>
        .transcations.table td{
            padding: 6px 0 !important;
        }
    </style>
@endsection

@section('content')
    
    @include('members.pages.dashboard.partials.pageheader')

    <div class="row row-sm">
        <div class="col-sm-12 col-lg-12 col-xl-12">

            <!--row-->
            <div class="row row-sm">
                <div class="col-sm-12 col-md-8">
                    <div>
                        <!--Boxes-->
                        @include('members.pages.dashboard.partials.'.$boxType)
                        <!--End Boxes-->
                    </div>
                    <div class="card custom-card overflow-hidden">
                        <div class="card-header border-bottom-0 row">
                            <div class="col-md-12 col-12">
                                <label class="main-content-label mb-2">Total Earnings & Withdrawals</label>
                            </div>
                        </div>
                        <div class="card-body pl-0">
                            <div class>
                                <div class="container">
                                    <div id="earnings-withdrawals-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card custom-card overflow-hidden">
                        <div class="card-header border-bottom-0 row">
                            <div class="col-md-12 col-12">
                                <label class="main-content-label mb-2">News & Notifications</label>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($news as $nitem)
                                            <tr>
                                                <td>{{ $nitem->created_at  }}</td>
                                                <td>{{ $nitem->title }}</td>
                                                <td>{{ $nitem->content }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                                
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="mb-4">
                        @if($remaining_ads > 0)
                            <div class="card bg-gray-800 tx-white">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6 light-br">
                                            <div class="text-center">
                                                <h4 class="display-35">{{ $total_ads }}</h4>
                                                <h5 class="mt-2">Total Ads</h5>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center">
                                                <h4 class="display-35">{{ $remaining_ads }}</h4>
                                                <h5 class="mt-2">Remaining Ads</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="{{ asset('member/view-ads/index') }}" class="btn btn-block btn-primary my-2 text-white">View Ads</a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        @else
                            <div class="card custom-card bg-gray-800 tx-white">
                                <div class="card-body text-center">
                                    <div class="rounded-circle text-primary">
                                        <img src="{{ asset('assets/img/check.png') }}" style="width: 70px; margin: 0 auto;" alt="complete" />
                                    </div>
                                    <div class="mt-3">
                                        <h4 class="tx-18">You have viewed all available ads.</h4>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card custom-card card-dashboard-calendar pb-0">
                        <label class="main-content-label mb-2 pt-1">Scan & Pay</label>
                        <!-- <span class="d-block tx-12 mb-2 text-muted">Projects where development work is on completion</span> -->
                        <div style="display:flex; justify-content:center; align-items:center;">
                            <img src="{{ asset('assets/img/scan-pay.jpeg') }}" width="200" alt="scan-pay"  />
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
                                                    <h6 class="mb-2 tx-15 font-weight-semibold">
                                                        {{ $transaction->amount }}
                                                        @if($transaction->type == 'credit')
                                                            <i class="fas fa-level-up-alt ml-2 text-success m-l-10" title="Credit"></i>
                                                        @else
                                                            <i class="fas fa-level-down-alt ml-2 text-danger m-l-10" title="Debit"></i>
                                                        @endif
                                                    </h6>
                                                    <p class="mb-0 tx-11 text-muted">{{ $transaction->created_at->format('d-m-Y H:i A') }}</p>
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
                </div>
            </div>
        
        </div>
    </div>

@endsection

@section('page-js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script type="text/javascript">
        let month_wise_earnings = @json($month_wise_earnings);
        let month_wise_withdrawals = @json($month_wise_withdrawals);
    </script>

    <script>

        // Joinings & Activations Chart Start
        var options = {
            series: [
                {
                    name: 'Total Earnings',
                    data: month_wise_earnings
                }, 
                {
                    name: 'Total Withdrawals',
                    data: month_wise_withdrawals
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
            colors:['#00cc66', '#ff471a'],
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

        var chart = new ApexCharts(document.querySelector("#earnings-withdrawals-chart"), options);
        chart.render();
        // Joinings & Activations Chart End

    </script>

@endsection