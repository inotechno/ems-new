<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class TestComponent extends Component
{
    public array $components = [];
    public $component = '';
    public $is_click = false;

    public function mount()
    {
        $this->components = [
            'button' => [
                'button.default-button',
                'button.button-group',
                'button.check-radio-button',
            ],
        ];
    }

    public function selectComponent($component)
    {
        $this->component = $component;
    }

    #[On('button-click')]
    public function handleClickButton()
    {
        dd($this->component);
    }

    public function render()
    {
        $buttons = [
            ['text' => 'Button 1', 'action' => 'handleButton1', 'color' => 'primary'],
            ['text' => 'Button 2', 'action' => 'handleButton2', 'color' => 'secondary'],
            ['text' => 'Button 3', 'disabled' => true, 'color' => 'danger'],
        ];

        return view('livewire.test-component', compact('buttons'))->layout('layouts.default', ['title' => 'Test Component']);
    }
}
