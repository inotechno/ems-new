<div class="row row-cols-lg-auto g-3 align-items-center mb-3">
    <div class="col-12">
        <input type="text" class="form-control form-control-sm" wire:model="name" placeholder="Enter Name ...">
    </div>

    <div class="col-12">
        <input type="text" class="form-control form-control-sm" wire:model="description" placeholder="Enter Description ...">
    </div>

    <div class="col-12">
        <button type="button" class="btn btn-primary btn-sm" wire:click="submit">Submit</button>
    </div>
</div>
