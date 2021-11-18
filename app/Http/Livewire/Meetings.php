<?php

namespace App\Http\Livewire;
use App\Models\meeting;

use Livewire\Component;
use Livewire\WithPagination;

class Meetings extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';

    public $name;
    public $start_date;
    public $end_date;

    protected $rules = [
        'name' => ['required', 'string', 'max:150'],
        'start_date' => ['required', 'date_format:Y-m-d\TH:i'],
        'end_date' => ['required', 'date_format:Y-m-d\TH:i']
    ];

    protected $messages = [
        'name.required' => 'The :attribute cannot be empty.',
        'name.string' => 'The :attribute format is not valid.',
        'name.max' => 'The :attribute length cannot exceed 150.',

        'start_date.required' => 'The :attribute cannot be empty.',
        'start_date.date_format' => 'The :attribute format is not valid.',

        'end_date.required' => 'The :attribute cannot be empty.',
        'end_date.date_format' => 'The :attribute format is not valid.'
    ];
    protected $validationAttributes = [
        'name' => 'Meeting name',
        'start_date' => 'Start date and time',
        'end_date' => 'End date and time'
    ];

    public function add_meeting() : void {
        $validatedData = $this->validate();

        if($validatedData['start_date'] == $validatedData['end_date']) {
            session()->flash('fail', 'Start date and End date cannot have the same values');
        }elseif(date('Y-m-d', strtotime($validatedData['start_date'])) > date('Y-m-d', strtotime($validatedData['end_date']))){
            session()->flash('fail', 'Start date must be a date before the End date');
        } else {
            $validatedData['free_from'] = $validatedData['start_date'];
            $validatedData['key'] = hash('sha1', md5(microtime().rand()));
            try {
                $meeting = new meeting();
                foreach($validatedData as $key => $v) {
                    $meeting->{$key} = $v;
                }
                if( $meeting->save() ) {
                    $this->reset();
                    session()->flash('success', 'A new meeting has been created');
                    $this->emit('meetingCreated');
                }
                else
                    session()->flash('fail', 'Unable to create a new meeting');
            } catch (Exception $e) {
                session()->flash('fail', 'Oppss, something went wrong!');
            }
        }
    }

    public function render()
    {
        return view('livewire.meetings', ['meetings' => meeting::paginate(2)]);
    }
}
