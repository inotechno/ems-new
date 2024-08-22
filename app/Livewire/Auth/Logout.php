<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Logout extends Component
{
    use LivewireAlert;
    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function confirmLogout()
    {
        // dd($this->user);
        $this->alert('warning', 'Are you sure you want to logout?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Logout',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled',

            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => true,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('confirmed')]
    public function logout()
    {
        try {
            Auth::logout();
            $user = $this->user;

            activity()
                ->causedBy($user) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('logout')
                ->log("$user->name telah melakukan logout");

            $this->alert('success', 'Logout Success');
            return redirect()->route('login');
        } catch (\Exception $e) {
            $this->alert('error', 'Logout Gagal');
        }
    }

    #[On('cancelled')]
    public function cancelled()
    {
        $this->alert('info', 'Logout Cancelled');
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
