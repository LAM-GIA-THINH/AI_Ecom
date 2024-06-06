<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportPDF()
    {
        $products = Product::with(['brand', 'category'])->get();
    

        $pdf = PDF::loadView('pdf.products', compact('products'));

        return $pdf->download('products.pdf');

    }
}
