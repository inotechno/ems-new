<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <script>
                2024
            </script> {{ config('setting.app_copyright') }}.
        </div>
        <div class="col-sm-6">
            <div class="text-sm-end d-none d-sm-block">
                Design & Develop by <a href="{{ config('setting.app_author_url') }}" target="_blank">{{ config('setting.app_author') }}</a>
            </div>
        </div>
    </div>

    @livewire('component.button-tour-guide', key('button-tour-guide'))

</div>
