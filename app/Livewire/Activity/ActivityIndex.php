<?php

namespace App\Livewire\Activity;

use App\Livewire\BaseComponent;
use Spatie\Activitylog\Models\Activity;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\User;

class ActivityIndex extends BaseComponent
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    #[Url]
    public $perPage = 10;
    public $start_date;
    public $end_date;
    public $user_ids = [];

    public $users;
    protected $paginationTheme = 'bootstrap'; // opsional, untuk Bootstrap

    public function mount()
    {
        $this->users = User::all();
    }

    public function render()
    {
        $activities = Activity::with('causer')->when($this->search, function ($query) {
            $query->where('description', 'like', '%' . $this->search . '%')
            ->orWhere('subject_type', 'like', '%' . $this->search . '%');
        })->when($this->user_ids, function ($query) {
            $query->whereIn('causer_id', $this->user_ids)->orWhereIn('subject_id', $this->user_ids);
        })->when($this->start_date, function ($query) {
            $query->whereDate('created_at', '>=', $this->start_date);
        })->when($this->end_date, function ($query) {
            $query->whereDate('created_at', '<=', $this->end_date);
        })->latest();

        if($this->authUser->can('view:activity-all')) {
            $activities = $activities->paginate($this->perPage);
        }else {
            $activities = $activities->where('causer_id', $this->authUser->id)->paginate($this->perPage);
        }

        return view('livewire.activity.activity-index', compact('activities'))->layout('layouts.app', ['title' => 'Activity']);
    }
}
