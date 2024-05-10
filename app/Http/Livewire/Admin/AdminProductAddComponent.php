<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AdminProductAddComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $content;
    public $user;
    public $slug;
    public $description;
    public $regular_price = 10000;
    public $sale_price = 10000;
    public $quantity = 100;
    public $image;
    public $images;
    public $category_id;
    public $brand_id;
    protected $listeners = ['selectedCategoryChanged', 'selectedBrandChanged','inputContentChanged' => 'inputContentChanged'];

    public function increaseQuantity()
    {
        $this->quantity += 100;
    }

    public function decreaseQuantity()
    {
        $this->quantity -= 100;
    }
    public function increaseWeight()
    {
        $this->weight += 100;
    }

    public function decreaseWeight()
    {
        $this->weight -= 100;
    }
    public function increasePage()
    {
        $this->pages += 100;
    }

    public function decreasePage()
    {
        $this->pages -= 100;
    }
    public function increaseRegularprice()
    {
        $this->regular_price += 10000;
    }

    public function decreaseRegularprice()
    {
        $this->regular_price -= 10000;
    }    
    public function increaseSaleprice()
    {
        $this->sale_price += 10000;
    }

    public function decreaseSaleprice()
    {
        $this->sale_price -= 10000;
    }    
    public function generateSlug()
    {
        $this->slug= Str::slug($this->name);
    }
    public function addProduct()
    {
        $this->validate([
            'name' => 'required|unique:products',
            'slug' => 'required|unique:products',
            'description' => 'required',
            'regular_price' => 'required',
            'quantity' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
            ]);
            $user = auth()->user();
            $product = new Product();
            $product->user_id = $user->id;
            $product->name = $this->name;
            $product->slug = $this->slug;
            $product->description = $this->description;

            $product->regular_price = $this->regular_price;
            $product->quantity = $this->quantity;

            $imageName = Carbon::now()->timestamp . '.' . $this->image->extension();
            $this->image->storeAs('products', $imageName);
            $product->image = $imageName;
            $product->category_id = $this->category_id;
            $product->brand_id = $this->brand_id;

            $product->save();

            session()->flash('message', 'Thêm sản phẩm thành công!');
            return redirect()->route('admin.product.add');
    }
    public function render()
    { 
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('livewire.admin.admin-product-add-component', [
            'categories' => $categories,
            'brands' => $brands,
        ])->layout('layouts.guest');
    }
    

    public function selectedCategoryChanged($value)
    {
        $this->category_id = $value;
    }
    
    public function selectedBrandChanged($value)
    {
        $this->brand_id = $value;
    }
    public function mount()
    {
        $this->listeners[] = 'inputContentChanged';
    }
    
    public function inputContentChanged($value)
    {
        $this->description = $value;
    }
}
