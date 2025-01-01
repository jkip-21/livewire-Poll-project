<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{
    public $title = '';
    public $options = [''];

    protected $rules = [
        'title' => 'required|min:3|max:255',
        // How to validate arrays it needs to be validated twice
        'options' => 'required|min:1|array|max:10',
        'options.*' => 'required|min:1|max:255'
    ];
    // Error message to be rendered when user fails to enter anything on the options

    protected $messages = [
        'options.*' => "The option can't be empty "
    ];
    // function to validate when someone is typing
    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        $this->options[] = '';
    }
    public function removeOption($index)
    {
        unset($this->options[$index]);
        // to make sure the indexes are continuous i.e 1,2,3,4
        $this->options = array_values($this->options);
    }

    public function createPoll()
    {
        // storing options since it is in form of an array
        //    creating a relationship between the option and the poll

        $this->validate();

        Poll::create([

            'title' => $this->title,
        ])->options()->createMany(
            collect($this->options)->map(fn($option) => ['name' => $option])->all()
        );

        $this->reset(['title', 'options']);

        $this->dispatch('pollCreated');
    }
}
