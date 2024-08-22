<div>
    <form wire:submit="save" class="needs-validation form-horizontal" wire:ignore.self>
        <div class="row">
            <div class="col-md">
                <label for="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" id="name" placeholder="Machine Name">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md">
                <label for="form-label">IP Address</label>
                <input type="text" class="form-control @error('ip_address') is-invalid @enderror" wire:model="ip_address" placeholder="IP Address">

                @error('ip_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md">
                <label for="form-label">Port</label>
                <input type="text" class="form-control @error('port') is-invalid @enderror" wire:model="port" placeholder="Port">

                @error('port')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md">
                <label for="form-label">COM Key</label>
                <input type="text" class="form-control @error('comkey') is-invalid @enderror" wire:model="comkey" placeholder="COM Key">

                @error('comkey')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md">
                <label for="form-label">Password</label>
                <input type="text" class="form-control @error('password') is-invalid @enderror" wire:model="password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-sm btn-primary mt-3">Submit</button>
        {{-- Button Clear --}}
        <button type="button" class="btn btn-sm btn-danger mt-3" wire:click="resetFormFields()">Clear</button>
    </form>
</div>
