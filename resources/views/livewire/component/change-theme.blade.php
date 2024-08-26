<div>
    <button type="button" class="btn header-item noti-icon waves-effect theme-choice" wire:click="toggleTheme">
        @if($theme === 'dark')
            <i class="bx bx-sun"></i>
        @else
            <i class="bx bx-moon"></i>
        @endif
    </button>
</div>
