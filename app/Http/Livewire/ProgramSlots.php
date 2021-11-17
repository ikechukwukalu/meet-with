<?php

namespace App\Http\Livewire;
use App\Models\meeting;
use App\Models\program;

use Livewire\Component;

class ProgramSlots extends Component
{
    public $meeting_key;
    public $program_key;
    public $min_date;
    public $max_date;
    public $begins;
    public $ends;
    public $from;
    public $to;

    public $programs;

    protected $rules = [
        'meeting_key' => ['required', 'string', 'exists:meetings'],
        'program_key' => ['required', 'string', 'exists:programs'],
        'ends' => ['required', 'date_format:Y-m-d\TH:i']
    ];

    protected $messages = [
        'meeting_key.required' => 'The :attribute cannot be empty.',
        'meeting_key.date_format' => 'The :attribute format is not valid.',
        'meeting_key.exists' => 'The :attribute cannot be found.',

        'program_key.required' => 'The :attribute cannot be empty.',
        'program_key.date_format' => 'The :attribute format is not valid.',
        'program_key.exists' => 'The :attribute cannot be found.',

        'ends.required' => 'The :attribute cannot be empty.',
        'ends.date_format' => 'The :attribute format is not valid.'
    ];
    protected $validationAttributes = [
        'meeting_key' => 'Meeting',
        'program_key' => 'Program',
        'ends' => 'End date and time'
    ];

    public function mount()
    {
        $this->programs = [];
        $this->from = "00-00-00 00:00";
        $this->to = "00-00-00 00:00";
    }

    public function fetch_programs() {
        if(isset($this->meeting_key) && !empty(trim($this->meeting_key))) {
            $this->programs = program::where('meeting_key', $this->meeting_key)->get();
            $meeting = meeting::where('key', $this->meeting_key)->first();
            if(isset($meeting->id)) {
                $this->min_date = date("Y-m-d\TH:i", strtotime($meeting->free_from));
                $this->max_date = date("Y-m-d\TH:i", strtotime($meeting->end_date));
                $this->begins = $meeting->free_from;
                $this->from = $meeting->free_from;
                $this->to = $meeting->end_date;
            } else
                $this->default_state();
        } else
            $this->default_state();
    }

    private function default_state() {
        $this->reset(['min_date', 'max_date', 'begins', 'ends']);
        $this->programs = [];
        $this->from = "00-00-00 00:00";
        $this->to = "00-00-00 00:00";
    }

    public function add_slot() {
        $validatedData = $this->validate();
        
    }

    public function render()
    {
        return view('livewire.program-slots', ['meetings' => meeting::whereNotNull('free_from')->get()]);
    }
}
