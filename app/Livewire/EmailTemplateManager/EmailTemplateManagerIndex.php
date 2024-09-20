<?php

namespace App\Livewire\EmailTemplateManager;

use App\Models\EmailTemplate;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class EmailTemplateManagerIndex extends Component
{
    use WithPagination;

    #[Url(except:'')]
    public $search = '';
    public $perPage = 12;

    public function render()
    {
        $templates = EmailTemplate::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('subject', 'like', '%' . $this->search . '%')
                ->orWhere('body', 'like', '%' . $this->search . '%');
        });

        $templates = $templates->paginate($this->perPage);

        return view('livewire.email-template-manager.email-template-manager-index', compact('templates'))->layout('layouts.app', ['title' => 'Email Template Manager']);
    }
}
