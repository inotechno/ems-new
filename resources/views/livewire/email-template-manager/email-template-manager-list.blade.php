<div>
    <div class="row">
        @foreach ($templates as $template)
            @livewire('email-template-manager.email-template-manager-item', ['template' => $template], key($template->id))
        @endforeach
    </div>
</div>
