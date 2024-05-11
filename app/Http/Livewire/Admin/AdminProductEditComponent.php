<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use Livewire\WithFileUploads;
use Carbon\Carbon;


class AdminProductEditComponent extends Component
{
    use WithFileUploads;
    public $product_id;
    public $content;
    public $name;
    public $slug;
    public $description;
    public $regular_price;

    public $quantity;

    public $image;
    public $pages;
    public $category_id;
    public $brand_id;
    public $newimage;
    protected $listeners = ['selectedCategoryChanged', 'selectedBrandChanged','inputContentChanged' => 'inputContentChanged'];

    public function mount($product_id){
        
        $product = Product::find($product_id);
        $this->listeners[] = 'inputContentChanged';
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->regular_price = $product->regular_price;
        $this->image = $product->image;
        $this->quantity = $product->quantity;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;

    }
    public function increasePage()
    {
        $this->pages += 100;
    }

    public function decreasePage()
    {
        $this->pages -= 100;
    }
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
    public function updateProduct()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'quantity' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            ]);
            $product = Product::find($this->product_id);
            $product->name = $this->name;
            $product->slug = $this->slug;
            $product->description = $this->description;
            $product->regular_price = $this->regular_price;
            $product->quantity = $this->quantity;
            $product->brand_id =$this->brand_id;
            if($this->newimage){
                unlink('img/products/products/'.$product->image);
                $imageName = Carbon::now()->timestamp . '.' . $this->newimage->extension();
                $this->newimage->storeAs('products', $imageName);
                $product->image = $imageName;
            }
            $product->category_id = $this->category_id;
            $product->save();
    
            session()->flash('message', 'Đã cập nhật sản phẩm thành công!');
            return redirect()->route('admin.product.edit', ['product_id' => $this->product_id]);
    }

    public function render()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('livewire.admin.admin-product-edit-component', [
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

    
    public function inputContentChanged($value)
    {
        $this->description = $value;
    }
}
