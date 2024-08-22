<div wire:ignore.self>
    <div class="modal fade" id="{{ $modal_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ $title }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="$dispatch('close-modal', {{ $modal_id }})" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! $body !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', (event) => {
                $('#' + event.modal).modal('show');
            });

            Livewire.on('close-modal', (event) => {
                $('#' + event.modal).modal('hide');
            })
        });
    </script>
</div>
