<?php

namespace App\Http\Livewire\Admin;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReviewsComponent extends Component
{
    use WithPagination;

    protected $listeners = ['deleteReview'];
    public $search = '';
    public $filterNSFW = '';

    public function render()
    {
        $query = Review::query();

        if (!empty($this->search)) {
            $query->where('comment', 'like', '%' . $this->search . '%');
        }

        if ($this->filterNSFW !== '') {
            $query->where('status', $this->filterNSFW);
        }

        $reviews = $query->orderBy('id', 'ASC')->paginate(5);

        return view('livewire.admin.admin-reviews-component', ['reviews' => $reviews])->layout('layouts.guest');
    }

    public function deleteReview($reviewId)
    {
        $review = Review::find($reviewId);
        if ($review) {
            $review->delete();
        }
    }

    public function restoreReview($reviewId)
    {
        $review = Review::find($reviewId);
        if ($review) {
            $review->status = 0;
            $review->save();
        }
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->filterNSFW = '';
    }
}
