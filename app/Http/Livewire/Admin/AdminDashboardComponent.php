<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminDashboardComponent extends Component
{
    public $selectedYear;
    public $years;

    protected $revenueChart;
    protected $userChart;
    protected $productChart;

    public function mount()
    {
        $this->selectedYear = date('Y');
        $this->years = range(date('Y'), date('Y') - 5);
    }

    public function updatedSelectedYear()
    {
        $this->destroyCharts();
        $this->renderCharts();
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard-component', [
            'monthlyRevenueData' => $this->getMonthlyRevenueData(),
            'monthlyUsers' => $this->getMonthlyUserData(),
            'popularProducts' => $this->getPopularProducts(),
            'number_of_products' => Product::count(),
            'number_of_customers' => User::count(),
            'total_revenue' => (Order::sum('amount')),
            'orders_last_week' => Order::where('created_at', '>=', now()->subWeek())->count(),
        ])->layout('layouts.guest');
    }

    private function destroyCharts()
    {
        if ($this->revenueChart) {
            $this->revenueChart->destroy();
        }
        if ($this->userChart) {
            $this->userChart->destroy();
        }
        if ($this->productChart) {
            $this->productChart->destroy();
        }
    }

    private function renderCharts()
    {
        $this->emit('renderChart', [

            'monthlyRevenue' => $this->getMonthlyRevenueData(),
            'monthlyUsers' => $this->getMonthlyUserData(),
            'popularProducts' => $this->getPopularProducts()
        ]);
    }

    private function getMonthlyRevenueData()
    {
        $monthlyRevenue = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total')
        )
        ->whereYear('created_at', $this->selectedYear)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->get()
        ->pluck('total', 'month');

        return [
            $monthlyRevenue->get(1, 0),
            $monthlyRevenue->get(2, 0),
            $monthlyRevenue->get(3, 0),
            $monthlyRevenue->get(4, 0),
            $monthlyRevenue->get(5, 0),
            $monthlyRevenue->get(6, 0),
            $monthlyRevenue->get(7, 0),
            $monthlyRevenue->get(8, 0),
            $monthlyRevenue->get(9, 0),
            $monthlyRevenue->get(10, 0),
            $monthlyRevenue->get(11, 0),
            $monthlyRevenue->get(12, 0),
        ];
    }

    private function getMonthlyUserData()
    {
        $monthlyUsers = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', $this->selectedYear)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->get()
        ->pluck('total', 'month');

        return [
            $monthlyUsers->get(1, 0),
            $monthlyUsers->get(2, 0),
            $monthlyUsers->get(3, 0),
            $monthlyUsers->get(4, 0),
            $monthlyUsers->get(5, 0),
            $monthlyUsers->get(6, 0),
            $monthlyUsers->get(7, 0),
            $monthlyUsers->get(8, 0),
            $monthlyUsers->get(9, 0),
            $monthlyUsers->get(10, 0),
            $monthlyUsers->get(11, 0),
            $monthlyUsers->get(12, 0),
        ];
    }

    private function getPopularProducts()
    {
        return Product::select('name')
            ->withCount(['orderItems as total' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            }])
            ->orderBy('total', 'desc')
            ->take(5)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'total' => $product->total,
                ];
            });
    }
}
