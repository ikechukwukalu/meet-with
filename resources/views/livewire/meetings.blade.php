<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">{{ __('Meetings') }}</div>

            <div class="card-body">
                <form wire:submit.prevent='add_meeting'>
                    @csrf
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="{{ __('name') }}">{{ __('Name') }}:</label>
                                <input class="form-control @error($name) is-invalid @enderror" type="text"
                                    wire:model="name" />
                                @error($name) <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ __('start_date') }}">{{ __('Start Date') }}:</label>
                                <input class="form-control @error($start_date) is-invalid @enderror"
                                    type="datetime-local" wire:model="start_date" />
                                @error($start_date) <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ __('end_date') }}">{{ __('End Date') }}:</label>
                                <input class="form-control @error($end_date) is-invalid @enderror" type="datetime-local"
                                    wire:model="end_date" />
                                @error($end_date) <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mx-auto">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" wire:target="add_meeting"
                                    wire.loading.attr="disabled">
                                    <span wire:loading wire:target="add_meeting">
                                        <span class="spinner-border spinner-border-sm"></span>&nbsp;Loading...
                                    </span>
                                    <span wire:loading.remove wire:target="add_meeting">Add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">{{ __('Programs') }}</div>

            <div class="card-body">
                @forelse($meetings as $meeting)
                <livewire:programs :meeting_key="$meeting->key" :meeting_name="$meeting->name" :key="$meeting->key" />
                @empty
                <p align="center">No Meeting has be added</p>
                @endforelse

                <div class="card-footer bg-white">
                    <div class="row justify-content-center">
                        {{ $meetings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>