<div>
    <div class="row mt-3">
        @foreach ($sites as $site)
            @livewire('site.site-item', ['site' => $site], key('site-item-' . $site->id))
        @endforeach
    </div>
</div>
