<?php

namespace App\Http\Livewire\Admin;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;


class AdminAccountsComponent extends Component
{
    use WithPagination;
    protected $listeners = ['deleteAccount', 'restoreAccount'];

    public $search = '';
    public function render()
    {
        $accounts = User::where('name', 'like', '%' . $this->search . '%')
        ->whereIn('utype', ['SHIP', 'GAR'])
            ->orderBy('id', 'ASC')
            ->withTrashed()
            ->paginate(5);
    
        return view('livewire.admin.admin-accounts-component', ['accounts' => $accounts])->layout('layouts.guest');
    }
    public function deleteAccount($accountId)
    {
        $account = User::find($accountId);

        if ($account) {
            $account->delete();
        }

    }
    public function restoreAccount($accountId)
    {
        $account = User::withTrashed()->find($accountId);

        if ($account && $account->trashed()) {
            $account->restore();
        }

    }
    public function clearSearch()
    {
        $this->search = '';
    }

}
