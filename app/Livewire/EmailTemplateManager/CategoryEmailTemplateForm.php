<?php

namespace App\Livewire\EmailTemplateManager;

use App\Livewire\BaseComponent;
use Illuminate\Support\Str;
use App\Models\CategoryEmailTemplate;

class CategoryEmailTemplateForm extends BaseComponent
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

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('create')
            ->log("{$this->authUser->name} telah membuat category email template");

        $this->dispatch('refreshCategories');
    }

    public function render()
    {
        return view('livewire.email-template-manager.category-email-template-form');
    }
}
