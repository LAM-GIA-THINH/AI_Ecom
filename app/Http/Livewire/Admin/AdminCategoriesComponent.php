<?php

namespace App\Http\Livewire\Admin;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
class AdminCategoriesComponent extends Component
{    
    public $category_id;
    use WithPagination;
    protected $listeners = ['deleteCategory'];
    public $search = '';
    
    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'ASC')
            ->paginate(5);
    
            return view('livewire.admin.admin-categories-component')
            ->layout('layouts.guest') // Set your layout file here
            ->with(['categories' => $categories]);
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            $category->delete();
        }
    }
    public function clearSearch()
    {
        $this->search = '';
    }
}
