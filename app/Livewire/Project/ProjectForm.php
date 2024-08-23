<?php

namespace App\Livewire\Project;

use App\Models\Employee;
use App\Models\Project;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectForm extends Component
{
    use LivewireAlert;
    public $project;
    public $name, $description, $start_date, $end_date, $status, $employee_id;
    public $selectedEmployees = [];
    public $employees;
    public $type = 'create';

    public function mount($id = null)
    {
        if ($id) {
            $this->project = \App\Models\Project::find($id);
            $this->name = $this->project->name;
            $this->description = $this->project->description;
            $this->start_date = $this->project->start_date;
            $this->end_date = $this->project->end_date;
            $this->status = $this->project->status;
            $this->employee_id = $this->project->employee_id;
            $this->type = 'update';

            $this->selectedEmployees = $this->project->employees()->pluck('employee_id')->toArray();
            $this->dispatch('change-select-form');
        }

        $this->employees = Employee::with('user')->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required',
        ]);

        if ($this->employee_id == null) {
            $this->alert('error', 'Please select project manager');
            return;
        }

        if ($this->selectedEmployees == null) {
            $this->alert('error', 'Please select at least one employee');
            return;
        }

        if ($this->type == 'create') {
            $this->project = Project::create([
                'name' => $this->name,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
                'employee_id' => $this->employee_id,
            ]);

            $this->project->employees()->attach($this->selectedEmployees);
        } else {
            $this->project->update([
                'name' => $this->name,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
                'employee_id' => $this->employee_id,
            ]);

            $this->project->employees()->sync($this->selectedEmployees);
        }

        $this->alert('success', 'Project has been ' . $this->type . ' successfully');
        return redirect()->route('project.index');
    }

    #[On('changeSelectForm')]
    public function changeSelectForm($param, $value)
    {
        $this->$param = $value;
    }

    public function render()
    {
        return view('livewire.project.project-form')->layout('layouts.app', ['title' => 'Project']);
    }
}
