<?php

namespace App\Livewire\EmailTemplateManager;

use App\Livewire\BaseComponent;
use App\Models\CategoryEmailTemplate;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Support\Facades\Schema;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EmailTemplateManagerForm extends BaseComponent
{
    use LivewireAlert;
    public $type = 'create';

    public $email_test;
    public $categories;
    public $category_id;
    public $name;
    public $subject;
    public $template_id;
    public $body;
    public $slug;
    public $preview;
    protected $EmailService; // Tambahkan properti EmailService
    public $showCategoryForm = false;

    public function __construct()
    {
        $this->EmailService = app(EmailService::class); // Inisialisasi menggunakan Laravel service container
    }

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
            $this->category_id = $template->category_id;

            $this->dispatch('contentChanged', $this->body);
        }

        $this->categories = CategoryEmailTemplate::doesntHave('template')->get();
    }

    public function toggleCategoryForm()
    {
        $this->showCategoryForm = !$this->showCategoryForm;
    }

    #[On('refreshCategories')]
    public function refreshCategories()
    {
        $this->categories = CategoryEmailTemplate::doesntHave('template')->get();
        $this->showCategoryForm = false;
    }

    #[On('setContent')]
    public function setContent($content)
    {
        $content = htmlspecialchars_decode($content);
        $this->body = $content;
        $this->preview = $content;
    }

    public function save()
    {
        try {
            $this->validate([
                'name' => 'required',
                'subject' => 'required',
                'body' => 'required',
                'category_id' => 'required_if:type,create|exists:category_email_templates,id',
            ]);

            // dd($this->body);

            if ($this->type == 'create') {
                EmailTemplate::create([
                    'category_id' => $this->category_id,
                    'slug' => Str::slug($this->name),
                    'name' => $this->name,
                    'subject' => $this->subject,
                    'body' => $this->body,
                ]);

                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['ip' => request()->ip()])
                    ->event('create')
                    ->log($this->authUser->name . ' telah membuat Email Template');
            } else {
                $template = EmailTemplate::find($this->template_id);
                $template->update([
                    'category_id' => $this->category_id,
                    'slug' => Str::slug($this->name),
                    'name' => $this->name,
                    'subject' => $this->subject,
                    'body' => $this->body,
                ]);

                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['ip' => request()->ip()])
                    ->event('update')
                    ->log($this->authUser->name . ' telah mengubah Email Template');
            }

            $this->alert('success', 'Email Template has been saved');
            return redirect()->route('email-template.index');
        } catch (\Exception $e) {
            $this->alert('error', 'Error', [
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function sendTestEmail()
    {
        $this->validate([
            'category_id' => 'required|exists:category_email_templates,id',
            'email_test' => 'required|email',
        ]);

        $user = User::where('email', $this->email_test)->first();
        $category = CategoryEmailTemplate::find($this->category_id);

        if ($user == null) {
            $this->alert('error', 'User not found');
            return;
        }

        try {
            $emailSent = $this->EmailService->sendTemplateEmail($user, $category->slug);

            if (!$emailSent['success']) {
                $this->alert('error', $emailSent['message']);
                return;
            }

            $this->alert('success', 'Email successfully sent to ' . $user->email);
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
            return;
        }
    }

    public function render()
    {
        $recipient = Schema::getColumnListing('users');
        $absent_request = Schema::getColumnListing('absent_requests');

        // Tambahkan placeholder untuk setiap kolom
        $placeholders_absent_request = $absent_request;
        $placeholders_recipient = $recipient; // Data yang akan digunakan sebagai placeholder

        return view('livewire.email-template-manager.email-template-manager-form', [
            'placeholders_recipient' => $placeholders_recipient,
            'placeholders_absent_request' => $placeholders_absent_request
        ])->layout('layouts.app', ['title' => 'Email Template Manager']);
    }
}
