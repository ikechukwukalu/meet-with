<?php

namespace App\Http\Livewire;
use App\Models\program;

use Livewire\Component;

class Programs extends Component
{
    public $name;
    public $meeting_name;
    public $meeting_key;

    protected $rules = [
        'name' => ['required', 'string', 'max:150'],
        // 'meeting_key' => ['required', 'string', 'exists:meetings']
    ];

    protected $messages = [
        'name.required' => 'The :attribute cannot be empty.',
        'name.string' => 'The :attribute format is not valid.',
        'name.max' => 'The :attribute length cannot exceed 150.',

        // 'meeting_key.required' => 'The :attribute cannot be empty.',
        // 'meeting_key.date_format' => 'The :attribute format is not valid.',
        // 'meeting_key.exists' => 'The :attribute cannot be found.'
    ];
    protected $validationAttributes = [
        'name' => 'Program name',
        // 'meeting_key' => 'Meeting key'
    ];

    public function addProgram() {
        $validatedData = $this->validate();
        $validatedData['key'] = hash('sha1', md5(microtime().rand()));
        $validatedData['meeting_key'] = $this->meeting_key;

        try {
            $program = new program();
            foreach($validatedData as $key => $v) {
                $program->{$key} = $v;
            }
            if( $program->save() ) {
                $this->reset(['name']);
                session()->flash('p_success', 'A new program has been created');
            }
            else
                session()->flash('p_fail', 'Unable to create a new program');
        } catch (Exception $e) {
            session()->flash('p_fail', 'Oppss, something went wrong!');
        }
    }

    public function render()
    {
        return view('livewire.programs', ['programs' => program::where('meeting_key', $this->meeting_key)->get()]);
    }
}
