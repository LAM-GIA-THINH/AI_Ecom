<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfileComponent extends Component
{
    use WithFileUploads;

    public $avatar;

    

    public function handleSaveAvatar()
    {
        if(!$this->avatar) {
            session()->flash('errorMessage', 'Vui lòng chọn ảnh');
            return;
        }
        // Kiểm tra xem tệp tồn tại trước khi thực hiện unlink
        $avatarPath = 'img/products/avatars/' . Auth::user()->profile_photo_path;

        if (file_exists($avatarPath) && Auth::user()->profile_photo_path) {
            unlink($avatarPath);
        }

        // Tiến hành lưu tệp mới
        $imageName = Carbon::now()->timestamp . '.' . $this->avatar->extension();
        $this->avatar->storeAs('avatars', $imageName);

        // Cập nhật đường dẫn tệp trong cơ sở dữ liệu
        Auth::user()->update(['profile_photo_path' => $imageName]);
        session()->flash('status', 'Lưu ảnh thành công');
        return redirect()->route('profile.edit');
    }
    public function render()
    {
        return view('livewire.user.user-profile-component');
    }
}
