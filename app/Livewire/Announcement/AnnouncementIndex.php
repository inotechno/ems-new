<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use Livewire\Component;
use Livewire\WithPagination;
use URL;

class AnnouncementIndex extends Component
{
    use WithPagination;

    #[URL(except:'')]
    public $search = '';
    public $perPage = 10;
    public $startDate;
    public $endDate;

    public function render()
    {
        $announcements = Announcement::with(['recipients' => function($query) {
            if(!$this->authUser->can('view:announcement-all')) {
                $query->where('employee_id', $this->authUser->employee->id);
            }
        }])->when($this->search, function($query){
            $query->where('title', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%');
        })->when($this->startDate, function($query){
            $query->whereDate('start_date', '>=', $this->startDate);
        })->when($this->endDate, function($query){
            $query->whereDate('end_date', '<=', $this->endDate);
        })->latest()->paginate($this->perPage);

        return view('livewire.announcement.announcement-index', compact('announcements'))->layout('layouts.app', ['title' => 'Announcements']);
    }
}
