<?php

namespace App\Http\Livewire;
use App\Models\meeting;
use App\Models\program;
use App\Models\programSlot;

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
        'meeting_key' => ['required', 'string', 'exists:meetings,key'],
        'program_key' => ['required', 'string', 'exists:programs,key'],
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

    protected $listeners = ['meetingCreated'];

    public function mount()
    {
        $this->programs = [];
        $this->from = "00-00-00 00:00";
        $this->to = "00-00-00 00:00";
    }

    public function meetingCreated(): bool {
        return true;
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
        $this->reset(['min_date', 'max_date', 'begins', 'ends', 'meeting_key', 'program_key']);
        $this->programs = [];
        $this->from = "00-00-00 00:00";
        $this->to = "00-00-00 00:00";
    }

    public function add_slot() {
        $validatedData = $this->validate();

        if($validatedData['ends'] < date("Y-m-d H:i:s", strtotime($this->begins))) {
            session()->flash('fail', 'End date cannot have a lesser than the first available date');
        }elseif(date("Y-m-d H:i:s", strtotime($this->begins)) == $validatedData['ends']) {
            session()->flash('fail', 'End date cannot have the same values as the first available date');
        } else {
            $validatedData['begins'] = $this->begins;
            $validatedData['key'] = hash('sha1', md5(microtime().rand()));
            try {
                $programSlot = new programSlot();
                foreach($validatedData as $key => $v) {
                    $programSlot->{$key} = $v;
                }
                if( $programSlot->save() ) {
                    meeting::where('key', $this->meeting_key)->update(["free_from" => $this->ends]);
                    $this->default_state();
                    session()->flash('success', 'A new slot has been created');
                }
                else
                    session()->flash('fail', 'Unable to create a new slot');
            } catch (Exception $e) {
                session()->flash('fail', 'Oppss, something went wrong!');
            }
        }
    }

    public function render()
    {
        return view('livewire.program-slots', [
            'meetings' => meeting::whereNotNull('free_from')->get(),
            'slots' => programSlot::join('meetings', 'meetings.key', '=', 'program_slots.meeting_key')
                        ->join('programs', 'programs.key', '=', 'program_slots.program_key')
                        ->select('program_slots.*', 'meetings.name as meeting_name', 'programs.name as program_name')
                        ->get()
        ]);
    }
}
