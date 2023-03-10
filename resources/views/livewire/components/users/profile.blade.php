<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <main class="container">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <a href="{{route('posts.index')}}" class="btn btn-sm btn-outline-dark fst-italic bold">
                                More Articles
                            </a>
                            <div class="btn-toolbar mb-2 mb-md-0">
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

                        <div class="row g-5">


                          <div class="col-md-4">
                            <div class="position-sticky" style="top: 2rem;">
                              <div class="p-4 mb-3 bg-light rounded">
                                <h4 class="fst-italic">{{ auth()->user()->first_name }}  {{ auth()->user()->last_name }}</h4>
                                <p class="mb-0">{{ auth()->user()->email }}</p>
                              </div>

                              <div class="p-4">
                                <h4 class="fst-italic">Settings</h4>
                                <ol class="list-unstyled">
                                    <li><button class="col-12 my-2 btn btn-outline-{{$showEditForm == true ? 'primary active': 'dark'}}" wire:click="showEditFormComponent">Edit Profile</button></li>
                                    <li><button class="col-12 my-2 btn btn-outline-{{$showPosts == true ? 'primary active': 'dark'}}"wire:click="showPostsComponent">My Posts</button></li>
                                    <li><button class="col-12 my-2 btn btn-outline-{{$showComments == true ? 'primary active': 'dark'}}"wire:click="showCommentsComponent">My Comments</button></li>
                                    <li><button class="col-12 my-2 btn btn-outline-{{$showNotifications == true ? 'primary active': 'dark'}}"wire:click="showNotificationsComponent">My Notifications <span class="badge text-bg-danger">{{$notifications->count()}}</span></button></li>
                                    <li><button class="col-12 my-2 btn btn-outline-dark">Logout</button></li>
                                </ol>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-8">
                            @if ($showEditForm)
                                @include('users.components.updateForm')
                            @elseif ($showPosts)
                                @include('users.components.posts')
                            @elseif ($showComments)
                                @include('users.components.comments')
                            @else
                                @include('users.components.notifications')
                            @endif

                            {{-- {{ $notifications->links() }} --}}
                            {{-- <nav class="blog-pagination" aria-label="Pagination">
                              <a class="btn btn-outline-primary rounded-pill" href="#">Older</a>
                              <a class="btn btn-outline-secondary rounded-pill disabled">Newer</a>
                            </nav> --}}

                          </div>
                        </div>

                      </main>
                </div>
            </div>
        </div>
    </div>
</div>
