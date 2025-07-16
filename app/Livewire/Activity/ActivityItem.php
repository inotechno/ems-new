<?php

namespace App\Livewire\Activity;

use Spatie\Activitylog\Models\Activity;
use Livewire\Component;

class ActivityItem extends Component
{
    public $activity;
    public $iteration;

    public function mount(Activity $activity, $iteration)
    {
        $this->activity = $activity;
        $this->iteration = $iteration;
    }

    public function render()
    {
        return view('livewire.activity.activity-item', [
            'activity' => $this->activity,
        ]);
    }
}
