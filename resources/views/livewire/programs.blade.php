<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong> {{ session('success') }}
            </div>
            @endif
            @if (session()->has('fail'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Failed!</strong> {{ session('fail') }}
            </div>
            @endif
        </div>
    </div>
    <p>
        @error($name) <span class="error">{{ $message }}</span> @enderror
    </p>
    <form class="form-inline" wire:submit.prevent="addProgram">
        <input type="text" class="form-control @error($name) is-invalid @enderror pr-2 " wire:model="name"
            placeholder="Program Name">&nbsp;
        <button type="submit" class="btn btn-primary" wire:target="addProgram" wire.loading.attr="disabled">
            <span wire:loading="" wire:target="addProgram">
                <span class="spinner-border spinner-border-sm"></span>&nbsp;Loading...
            </span>
            <span wire:loading.remove="" wire:target="addProgram">Add Program</span>
        </button>
    </form>
    <div class="border p-2 mb-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h4><span class="badge badge-secondary p-2">{{ $meeting_name }}</span></h4>
            </div>
            <div class="col-md-12">
                <ul class="list-group">
                    @forelse($programs as $program)
                    <li class="list-group-item">
                        <b>{{ $loop->iteration }}.</b> {{ $program->name }} <button type="button"
                            class="btn btn-clear"></button>
                    </li>
                    @empty
                    <p align="center">No Program has be added to this meeting</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <hr />
</div>