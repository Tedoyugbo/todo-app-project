<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use App\Models\Todo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $description;

    protected $rules = [
        'description' => 'required'
    ];


    protected $messages = [
        'description.required' => 'The Description Field cannot be empty.',
    ];

    public $todo;
    public $status = 4;
    protected LengthAwarePaginator $todos;

    //set form validation rules
    public $search = '';

    public function updatingSearch()
    {
        $this->searchTodos();
    }

    public function render()
    {
        switch ($this->status) {
            case Todo::PENDING:
                $this->getPendingTodos();
                break;
            case Todo::ONGOING:
                $this->getOngoingTodos();
                break;
            case Todo::COMPLETED:
                $this->getCompletedTodos();
                break;
            case 3:
                $this->getTrashedTodos();
                break;
            default:
                $this->getTodos();
                break;
        }
        return view('livewire.home',[
            'todos' => $this->todos
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->description = '';
    }

    public function storeTodo()
    {
        $this->validate();

        if (!$this->description) {
            $this->dispatchBrowserEvent('toast-error', ['message' => 'Description is empty']);
            return;
        }

        $task = $this->createTask();

        if($task){
            //flash success message
            $this->dispatchBrowserEvent('toast-success', ['message' => 'You Successfully Created a Task']);
        }else{
            $this->dispatchBrowserEvent('toast-error', ['message' => 'Something went wrong!!!']);
        }
        $this->resetInputFields();
        $this->getTodos();
    }

    public function markAsPending($id)
    {
        $this->getTodo($id);
        if($this->todo){
            $this->todo->status = Todo::PENDING;
            if ($this->todo->completed_at) {
                $this->todo->completed_at = null;
            }
            $this->todo->save();
        }
        $this->resetInputFields();
        $this->getTodos();
    }

    public function markAsOngoing($id)
    {
        $this->getTodo($id);
        if($this->todo){
            $this->todo->status = Todo::ONGOING;
            if ($this->todo->completed_at) {
                $this->todo->completed_at = null;
            }
            $this->todo->save();
        }
        $this->resetInputFields();
        $this->getTodos();
    }

    public function markAsCompleted($id)
    {
        $this->getTodo($id);
        if($this->todo){
            $this->todo->status = Todo::COMPLETED;
            $this->todo->completed_at = now();
            $this->todo->save();
        }
        $this->resetInputFields();
        $this->getTodos();
    }

    public function trashTodo($id)
    {
        $this->getTodo($id);
        if($this->todo){
            $this->todo->delete();
        }
        $this->resetInputFields();
        $this->getTodos();
    }

    private function createTask()
    {
        $todo = new Todo();
        $todo->description = $this->description;
        $todo->user_id = auth()->user()->id;
        $todo->save();

        return $todo;
    }

    private function getTodo($id)
    {

        $this->todo = Todo::where('user_id','=',auth()->user()->id)->where('id', '=', $id)
            ->first();
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    private function getTodos()
    {
        $this->todos = Todo::where('user_id','=',auth()->user()->id)->paginate(10);
    }

    private function getPendingTodos()
    {
        $this->todos = Todo::where('user_id','=',auth()->user()->id)->where('status', '=', Todo::PENDING)->paginate(10);
    }

    private function getOngoingTodos()
    {
        $this->todos = Todo::where('user_id','=',auth()->user()->id)->where('status', '=', Todo::ONGOING)->paginate(10);
    }

    private function getCompletedTodos()
    {
        $this->todos = Todo::where('user_id','=',auth()->user()->id)->where('completed_at', '!=', null)->paginate(10);
    }

    private function getTrashedTodos()
    {
        $this->todos = Todo::onlyTrashed()->where('user_id','=',auth()->user()->id)->paginate(10);
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function update()
    {
        //set form validation rules
        $this->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:3',
        ]);

        session()->flash('message', 'Task Updated Successfully.');
        $this->resetInputFields();
        $this->dispatchBrowserEvent('close-modal');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete()
    {
        session()->flash('message', 'Task Deleted Successfully.');
    }
}
