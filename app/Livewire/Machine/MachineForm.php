<?php

namespace App\Livewire\Machine;

use App\Livewire\Forms\MachineForm as FormsMachineForm;
use App\Models\Machine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class MachineForm extends Component
{
    use LivewireAlert;

    public $name, $ip_address, $port, $comkey, $password, $is_active = 1;
    public $machine_id;
    public $machine;
    public $statusForm = 'store';

    public function resetFormFields()
    {
        $this->name = null;
        $this->ip_address = null;
        $this->port = null;
        $this->comkey = null;
        $this->password = null;
        $this->is_active = 1;

        $this->statusForm = 'store';
    }

    #[On('set-machine')]
    public function getDataMachine($machine_id)
    {
        $this->machine = Machine::find($machine_id);
        $this->name = $this->machine->name;
        $this->ip_address = $this->machine->ip_address;
        $this->port = $this->machine->port;
        $this->comkey = $this->machine->comkey;
        $this->password = $this->machine->password;
        $this->is_active = $this->machine->is_active;

        $this->statusForm = 'update';
        $this->dispatch('change-status-form');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'ip_address' => 'required|ip',
            'port' => 'required',
            'comkey' => 'required',
            'password' => 'required',
        ]);

        try {
            if ($this->statusForm == 'store') {
                $machine = Machine::create([
                    'name' => $this->name,
                    'ip_address' => $this->ip_address,
                    'port' => $this->port,
                    'comkey' => $this->comkey,
                    'password' => $this->password,
                    'is_active' => $this->is_active,
                ]);

                $this->alert('success', 'Machine Created Successfully', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);

                $this->dispatch('refreshIndex');
                $this->resetFormFields();
            } else {
                $this->machine->update([
                    'name' => $this->name,
                    'ip_address' => $this->ip_address,
                    'port' => $this->port,
                    'comkey' => $this->comkey,
                    'password' => $this->password,
                    'is_active' => $this->is_active,
                ]);

                $this->alert('success', 'Machine Updated Successfully', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                ]);

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
