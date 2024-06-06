<div>
    <main class="main">
        <div class="container"
            style="background-color: #f0f0f0; text-align: center; padding: 20px; margin-bottom: 20px">
            <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">Thống kê
                <select id="yearFilter" wire:model="selectedYear"
                    style="padding: 5px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc;">
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </h2>
        </div>

        <div class="chart-container">
            <div class="row">
                <div class="col-xl-6 col-xxl-5 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Sản phẩm</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="truck"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $number_of_products }}</h1>
                                        <div class="mb-0">
                                            <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65%
                                            </span>
                                            <span class="text-muted">Từ tuần trước</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Khách hàng</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="users"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $number_of_customers }}</h1>
                                        <div class="mb-0">
                                            <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25%
                                            </span>
                                            <span class="text-muted">Từ tuần trước</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Tổng doanh thu</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ number_format($total_revenue) }} ₫</h1>
                                        <div class="mb-0">
                                            <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65%
                                            </span>
                                            <span class="text-muted">Từ tuần trước</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Đơn hàng tuần qua</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="shopping-cart"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h1 class="mt-1 mb-3">{{ $orders_last_week }}</h1>
                                        <div class="mb-0">
                                            <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25%
                                            </span>
                                            <span class="text-muted">Từ tuần trước</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-xxl-7">
                    <div class="card flex-fill w-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Doanh thu</h5>
                        </div>
                        <div class="card-body py-3">
                            <div class="chart chart-sm">
                                <canvas id="revenueChart" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Khách hàng</h5>
            </div>
            <div class="card-body">
                <div class="chart chart-sm">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Sản phẩm bán chạy</h5>
            </div>
            <div class="card-body">
                <div class="chart chart-sm">
                    <canvas id="productChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>





        </div>

        @push('styles')
            <style>
                .chart-container {
                    display: flex;
                    flex-direction: column;
                }

                .chart-row {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-between;
                }

                .chart {
                    flex: 1;
                    padding: 10px;
                    min-width: 200px;
                }

                canvas {
                    max-width: 100%;
                    height: auto;
                }

                @media (max-width: 768px) {
                    .chart {
                        flex-basis: 100%;
                    }
                }
            </style>
            </style>
        @endpush

        @push('scripts')
            <script>
                document.addEventListener('livewire:load', function () {
                    var revenueCtx = document.getElementById('revenueChart').getContext('2d');
                    var userCtx = document.getElementById('userChart').getContext('2d');
                    var productCtx = document.getElementById('productChart').getContext('2d');
                    var revenueChart;
                    var userChart;
                    var productChart;

                    Livewire.on('renderChart', (data) => {
                        if (revenueChart) {
                            revenueChart.destroy();
                        }
                        if (userChart) {
                            userChart.destroy();
                        }
                        if (productChart) {
                            productChart.destroy();
                        }

                        revenueChart = new Chart(revenueCtx, {
                            type: 'bar',
                            data: {
                                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                                datasets: [{
                                    label: 'Doanh thu',
                                    data: data.monthlyRevenue,
                                    backgroundColor: '#4CAF50'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                aspectRatio: 3
                            }
                        });

                        userChart = new Chart(userCtx, {
                            type: 'line',
                            data: {
                                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                                datasets: [{
                                    label: 'Khách hàng',
                                    data: data.monthlyUsers,
                                    backgroundColor: '#FF6384'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                aspectRatio: 2,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Khách hàng'
                                        }
                                    }
                                }
                            }
                        });

                        productChart = new Chart(productCtx, {
                            type: 'doughnut',
                            data: {
                                labels: data.popularProducts.map(p => p.name),
                                datasets: [{
                                    label: 'Quantity Sold',
                                    data: data.popularProducts.map(p => p.total),
                                    backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4CAF50', '#E7E9ED']
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                aspectRatio: 2,
                                title: {
                                    display: true,
                                    text: 'Top Selling Products',
                                    position: 'top'
                                }
                            }
                        });
                    });

                    Livewire.emit('renderChart', {
                        monthlyRevenue: @json($monthlyRevenueData),
                        monthlyUsers: @json($monthlyUsers),
                        popularProducts: @json($popularProducts)
                    });
                });
            </script>
        @endpush
    </main>
</div>