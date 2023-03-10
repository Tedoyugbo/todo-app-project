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
                        <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
                          <div class="col-md-6 px-0">
                            <h1 class="display-4 fst-italic">{{ $main_post->title }}</h1>
                            <p class="lead my-3">{!! Str::words($main_post->body, 10, ' ...') !!}</p>
                            <p class="lead mb-0"><a href="{{ route('posts.show',$main_post->slug)}}" class="text-white fw-bold">Continue reading...</a></p>
                          </div>
                        </div>

                        <div class="row mb-2">
                            @foreach ($featured_posts as $post)
                                <div class="col-md-6">
                                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                        <div class="col p-4 d-flex flex-column position-static">
                                        <strong class="d-inline-block mb-2 text-primary">{{$post->category->name}}</strong>
                                        <h3 class="mb-0">{{ $post->title }}</h3>
                                        <div class="mb-1 text-muted">{{ $post->created_at->diffForHumans()}}</div>
                                        <p class="card-text mb-auto">{!! Str::words($post->body, 10, ' ...') !!}</p>
                                        <a href="{{ route('posts.show',$post->slug)}}" class="stretched-link">Continue reading</a>
                                        </div>
                                        <div class="col-auto d-none d-lg-block">
                                            <img class="img-responsive" src="{{ $post->media->url ?? "#" }}" alt="" width="200" height="250"/>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

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
                          <div class="col-md-8">

                            @foreach ($posts as $post)
                                <article class="blog-post">
                                    <h2 class="blog-post-title mb-1">{{ $post->title }}</h2>
                                    <p class="blog-post-meta">Posted  {{ $post->created_at->diffForHumans() }} by <a href="#">{{ $post->user->first_name }} {{ $post->user->last_name }}</a></p>

                                    <div class="card mb-3" style="max-width: 540px;">
                                        <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{ $post->media->url ?? "#" }}" class="img-fluid rounded-start" alt="{{ $post->media->title ?? "#"  }}.">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title text-info">{{ $post->category->name }}</h5>
                                                <p class="card-text">{!! Str::words($post->body, 10, ' ...') !!}</p>
                                                <p class="card-text"><small class="text-muted">Last updated {{ $post->updated_at->diffForHumans()}}</small></p>
                                                <p class="card-text">
                                                    <small class="text-muted">
                                                        <span data-feather="message-circle" class="align-text-center text-primary text-lg"></span>
                                                        {{ $post->comments->count()}} Comment(s)
                                                    </small>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="card-footer bg-dark">
                                            <a href="{{route('posts.show',$post->slug)}}" class="stretched-link text-white">Continue reading</a>
                                        </div>
                                        </div>
                                    </div>
                                    <br/>
                                </article>
                            @endforeach

                            {{ $posts->links() }}
                            {{-- <nav class="blog-pagination" aria-label="Pagination">
                              <a class="btn btn-outline-primary rounded-pill" href="#">Older</a>
                              <a class="btn btn-outline-secondary rounded-pill disabled">Newer</a>
                            </nav> --}}

                          </div>

                          <div class="col-md-4">
                            <div class="position-sticky" style="top: 2rem;">
                              <div class="p-4 mb-3 bg-light rounded">
                                <h4 class="fst-italic">About</h4>
                                <p class="mb-0">Project By Trust Edoyugbo.</p>
                              </div>

                              <div class="p-4">
                                <h4 class="fst-italic">Socials</h4>
                                <ol class="list-unstyled">
                                  <li><a href="#">GitHub</a></li>
                                  <li><a href="#">Twitter</a></li>
                                  <li><a href="#">Facebook</a></li>
                                </ol>
                              </div>
                            </div>
                          </div>
                        </div>

                      </main>
                </div>
            </div>
        </div>
    </div>
</div>

