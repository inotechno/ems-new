<?php

namespace App\Livewire\EmailTemplateManager;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Schema;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EmailTemplateManagerForm extends Component
{
    use LivewireAlert;
    public $type = 'create';

    public $name;
    public $subject;
    public $template_id;
    public $body;
    public $slug;
    public $preview;

    public function mount($slug = null)
    {
        if ($slug) {
            $template = \App\Models\EmailTemplate::where('slug', $slug)->first();
            $this->template_id = $template->id;
            $this->type = 'update';
            $this->name = $template->name;
            $this->subject = $template->subject;
            $this->body = $template->body;
            $this->slug = $template->slug;

            $this->dispatch('contentChanged', $this->body);
        }
    }

    #[On('previewContent')]
    public function previewContent($content)
    {
        $content = htmlspecialchars_decode($content);
        $this->preview = $content;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ]);

        try {
            if ($this->type == 'create') {
                EmailTemplate::create([
                    'slug' => Str::slug($this->name),
                    'name' => $this->name,
                    'subject' => $this->subject,
                    'body' => $this->body,
                ]);
            } else {
                $template = EmailTemplate::find($this->template_id);
                $template->update([
                    'slug' => Str::slug($this->name),
                    'name' => $this->name,
                    'subject' => $this->subject,
                    'body' => $this->body,
                ]);
            }

            $this->alert('success', 'Success', [
                'text' => 'Email Template has been saved',
            ]);

            return redirect()->route('email-template.index');
        } catch (\Exception $e) {
            $this->alert('error', 'Error', [
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        $users = Schema::getColumnListing('users');
        $placeholders = $users; // Data yang akan digunakan sebagai placeholder
        return view('livewire.email-template-manager.email-template-manager-form', [
            'placeholders' => $placeholders
        ])->layout('layouts.app', ['title' => 'Email Template Manager']);
    }
}
