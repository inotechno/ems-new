<?php

namespace App\Livewire\Site;

use App\Models\Site;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SiteIndex extends Component
{
    use LivewireAlert, WithPagination;
    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public function render()
    {
        $sites = Site::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('uid', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.site.site-index', compact('sites'))->layout('layouts.app', ['title' => 'Site List']);
    }
}
