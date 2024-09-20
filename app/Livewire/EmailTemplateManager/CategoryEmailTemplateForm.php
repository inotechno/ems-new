<?php

namespace App\Livewire\EmailTemplateManager;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\CategoryEmailTemplate;

class CategoryEmailTemplateForm extends Component
{
    public $slug, $name, $description;

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        CategoryEmailTemplate::create([
            'slug' => Str::slug($this->name),
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->dispatch('refreshCategories');
    }

    public function render()
    {
        return view('livewire.email-template-manager.category-email-template-form');
    }
}
