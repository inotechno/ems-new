<?php

namespace App\Livewire\Component\Widget;

use App\Livewire\BaseComponent;
use Spatie\Activitylog\Models\Activity;

class ActivityCard extends BaseComponent
{
    public $activities;
    public $events = [
        'create' => 'bx bx-plus',
        'update' => 'bx bx-edit',
        'delete' => 'bx bx-trash',
        'approve' => 'bx bx-check',
        'reject' => 'bx bx-x',
        'read' => 'bx bx-book',
        'login' => 'bx bx-log-in',
        'logout' => 'bx bx-log-out',
    ];

    public function mount()
    {
        $this->activities = Activity::with('causer')->latest()->take(5);

        if(!$this->authUser->can('view:activity-all')) {
            $this->activities = $this->activities->where('causer_id', $this->authUser->id);
        }

        $this->activities = $this->activities->get();

        $this->activities->map(function ($activity) {
            $activity->icon = $this->events[$activity->event ?? 'create'] ?? 'bx bx-plus';
            $activity->description = str_replace($this->authUser->name, 'Anda', $activity->description).' ('.$activity->created_at->format('H:i').')';
        });
    }

    public function render()
    {
        return view('livewire.component.widget.activity-card');
    }
}
