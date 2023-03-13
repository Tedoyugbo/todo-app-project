<section class="vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-9 col-xl-7">
          <div class="card rounded-3">
            <div class="card-body p-4">

              <h4 class="text-center my-3 pb-3">To Do App</h4>
              <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <ul>
                    <button wire:click="setStatus(5)" class="btn btn-sm mx-2 btn-outline-secondary fst-italic bold">
                        All Tasks
                    </button>
                    <button wire:click="setStatus(0)" class="btn btn-sm mx-2 btn-outline-danger fst-italic bold">
                        Pending
                    </button>
                    <button wire:click="setStatus(1)" class="btn btn-sm mx-2 btn-outline-info fst-italic bold">
                        Ongoing
                    </button>
                    <button wire:click="setStatus(2)" class="btn btn-sm mx-2 btn-outline-success fst-italic bold">
                        Completed
                    </button>
                    <button wire:click="setStatus(3)" class="btn btn-sm mx-2 btn-outline-dark fst-italic bold">
                        Trashed
                    </button>
                </ul>
                <div class="btn-toolbar mb-4 mb-md-0">
                    <div class="btn-group me-2">
                        <input
                            type="text"
                            class="form-control float-end mx-2"
                            value="{{ old('search') }}"
                            placeholder="Search"
                            wire:model="search"/>
                    </div>
                </div>
            </div>

              <form wire:submit.prevent="storeTodo" class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                @csrf
                <div class="col-12">

                  <div class="form-outline">
                    <input
                        type="text"
                        class="form-control float-end mx-2 @error('description') is-invalid @enderror"
                        value="{{ old('description') }}"
                        placeholder="Enter a task here"
                        wire:model="description"/>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <button type="submit" class="btn btn-success">Create</button>
                </div>
              </form>

              <table class="table mb-4">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Todo item</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($todos as $key => $todo)
                    <tr>
                        <th scope="row">{{$key + 1}}</th>
                        <td>{{$todo->description}}</td>
                        <td>
                            @if ($todo->status == 0)
                                <span class="badge bg-primary">{{$todo->getStatus()}}</span>
                            @elseif ($todo->status == 1)
                                <span class="badge bg-secondary">{{$todo->getStatus()}}</span>
                            @else
                                <span class="badge bg-success">{{$todo->getStatus()}}</span>
                            @endif
                        </td>
                        <td>
                            @if ($todo->status == 0)
                                <button wire:click="markAsOngoing({{ $todo->id }})"  type="button" class="btn btn-secondary btn-sm ms-1">
                                    <span class="align-text-center text-white text-lg"><i class="fa fa-arrow-up" aria-hidden="true"></i></span>
                                </button>
                            @elseif ($todo->status == 1)
                                <button wire:click="markAsPending({{ $todo->id }})" type="button" class="btn btn-primary btn-sm text-sm">
                                    <span class="align-text-center text-white text-lg"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                                </button>
                                <button wire:click="markAsCompleted({{ $todo->id }})" type="button" class="btn btn-success btn-sm ms-1 text-sm">
                                    <span class="align-text-center text-white text-lg"><i class="fa fa-arrow-up" aria-hidden="true"></i></span>
                                </button>
                            @else
                                <button wire:click="markAsOngoing({{ $todo->id }})" type="button" class="btn btn-secondary btn-sm text-sm">
                                    <span class="align-text-center text-white text-lg"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                                </button>
                            @endif
                            @if (!$todo->trashed())
                                <button  wire:click="trashTodo({{ $todo->id }})" type="button" class="btn btn-danger btn-sm text-sm">
                                    <span><i class="fa fa-trash" aria-hidden="true"></i></span>
                                    {{-- <span data-feather="trash-2" class="align-text-center text-white text-lg"></span> --}}
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <p class="text-center">
                                No Todo Found
                            </p>
                        </td>
                    </tr>
                @endforelse

                  {{ $todos->links() }}
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


