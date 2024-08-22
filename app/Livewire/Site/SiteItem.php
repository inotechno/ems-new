<?php

namespace App\Livewire\Site;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class SiteItem extends Component
{
    use LivewireAlert;

    #[Reactive]
    public $site;

    public function deleteConfirm()
    {
        $this->alert(
            'question',
            'Are you sure you want to delete this site?',
            [
                'toast' => false,
                'timer' => 3000,
                'position' => 'center',
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'confirmButtonColor' => '#cc2626',
                'confirmButtonText' => 'Yes, Delete it!',
                'cancelButtonText' => 'No, Cancel!',
                'onConfirmed' => 'delete-site',
                'timerProgressBar' => true,
            ]
        );
    }

    #[On('delete-site')]
    public function delete()
    {
        $this->site->delete();
        $this->alert('success', 'Site deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.site.site-item');
    }
}
