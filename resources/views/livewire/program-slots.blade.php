
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mt-3">
            <div class="card-header">{{ __('Add Slots') }}</div>
            <div class="card-body">
                <form wire:submit.prevent='add_slot'>
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
                                <label for="{{ __('meeting_key') }}">{{ __('Meeting') }}:</label>
                                <select class="form-control @error($meeting_key) is-invalid @enderror" wire:model="meeting_key"
                                    wire:change="fetch_programs">
                                    <option selected>Choose Meeting</option>
                                    @foreach($meetings as $meeting)
                                    <option value="{{ $meeting->key }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                @error($meeting_key) <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="{{ __('program_key') }}">{{ __('Programs') }}:</label>
                                <select class="form-control @error($program_key) is-invalid @enderror" wire:model="program_key"
                                    wire:target="fetch_programs" wire.loading.attr="disabled">
                                    <option selected>Choose Program</option>
                                    @foreach($programs as $program)
                                    <option value="{{ $program->key }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                                @error($program_key) <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">{{ __('Available Time Range') }}:</label>
                                <input class="form-control"
                                    value="From: {{ $from }}, To: {{ $to }}" readonly />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ __('') }}">{{ __('Start Period') }}:</label>
                                <input class="form-control" type="text" value="{{ date('j M, Y', strtotime($from)) }} {{ date('g:i a', strtotime($from)) }}" readonly />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ __('ends') }}">{{ __('End Period') }}:</label>
                                <input class="form-control @error($ends) is-invalid @enderror" type="datetime-local"
                                    wire:target="fetch_programs" wire.loading.attr="disabled" wire:model="ends"
                                    min="{{ $min_date }}" max="{{ $max_date }}" />
                                @error($ends) <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mx-auto">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" wire:target="add_slot"
                                    wire.loading.attr="disabled">
                                    <span wire:loading wire:target="add_slot">
                                        <span class="spinner-border spinner-border-sm"></span>&nbsp;Loading...
                                    </span>
                                    <span wire:loading.remove wire:target="add_slot">Add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card mt-3">
            <div class="card-header">{{ __('Slots') }}</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Meeting</th>
                            <th>Program</th>
                            <th>Starts By</th>
                            <th>Ends By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($slots as $slot)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $slot->meeting_name }}</td>
                            <td>{{ $slot->program_name }}</td>
                            <td>{{ date('j M, Y', strtotime($slot->begins)) }} <br/> <small>{{ date('g:i a', strtotime($slot->begins)) }}</small> </td>
                            <td>{{ date('j M, Y', strtotime($slot->ends)) }} <br/> <small>{{ date('g:i a', strtotime($slot->ends)) }}</small> </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" align="center">Table is empty</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Meeting</th>
                            <th>Program</th>
                            <th>Starts By</th>
                            <th>Ends By</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>