<?php

namespace App\Livewire\Machine;

use App\Livewire\BaseComponent;
use App\Livewire\Forms\MachineForm as FormsMachineForm;
use App\Models\Helper;
use App\Models\Machine;
use App\Models\Site;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class MachineForm extends BaseComponent
{
    use LivewireAlert;

    public $name, $ip_address, $port, $site_id, $comkey, $password, $is_active = 1, $machine_type_id;
    public $machine_id;
    public $machine;
    public $statusForm = 'store';
    public $machineTypes;
    public $sites;

    public function mount()
    {
        $this->sites = Site::select('id', 'name')->get();
        $this->machineTypes = Helper::where('code', 'machine_type')->get();
    }

    public function resetFormFields()
    {
        $this->name = null;
        $this->ip_address = null;
        $this->port = null;
        $this->comkey = null;
        $this->site_id = null;
        $this->password = null;
        $this->is_active = 1;

        $this->machine_type_id = null;

        $this->statusForm = 'store';
        $this->dispatch('refreshIndex');
    }

    #[On('set-machine')]
    public function getDataMachine($machine_id)
    {
        $this->machine = Machine::find($machine_id);
        $this->name = $this->machine->name;
        $this->ip_address = $this->machine->ip_address;
        $this->site_id = $this->machine->site_id;
        $this->port = $this->machine->port;
        $this->comkey = $this->machine->comkey;
        $this->password = $this->machine->password;
        $this->is_active = $this->machine->is_active;

        $this->machine_type_id = $this->machine->machine_type_id;

        $this->statusForm = 'update';
        $this->dispatch('change-status-form');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'site_id' => 'required',
            'ip_address' => 'required|ip',
            'port' => 'nullable|numeric',
            'comkey' => 'nullable|numeric',
            'password' => 'nullable',
            'machine_type_id' => 'required',
        ]);

        try {
            if ($this->statusForm == 'store') {
                $machine = Machine::create([
                    'name' => $this->name,
                    'ip_address' => $this->ip_address,
                    'site_id' => $this->site_id,
                    'port' => $this->port,
                    'comkey' => $this->comkey,
                    'password' => $this->password,
                    'is_active' => $this->is_active,
                    'machine_type_id' => $this->machine_type_id
                ]);

                $this->alert('success', 'Machine Created Successfully', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);

                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['ip' => request()->ip()])
                    ->event('create')
                    ->log($this->authUser->name . ' telah membuat data machine');

                $this->dispatch('refreshIndex');
                $this->resetFormFields();
            } else {
                $this->machine->update([
                    'name' => $this->name,
                    'site_id' => $this->site_id,
                    'ip_address' => $this->ip_address,
                    'port' => $this->port,
                    'comkey' => $this->comkey,
                    'password' => $this->password,
                    'is_active' => $this->is_active,
                    'machine_type_id' => $this->machine_type_id
                ]);

                $this->alert('success', 'Machine Updated Successfully', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);

                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['ip' => request()->ip()])
                    ->event('update')
                    ->log($this->authUser->name . ' telah mengubah data machine');

                $this->dispatch('refreshIndex');
                $this->resetFormFields();
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage(), [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.machine.machine-form');
    }
}
