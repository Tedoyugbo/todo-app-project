<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="my-5 text-center display-3">{{ __('Login')}}</h1>
        </div>

        <div class="col-md-6 mx-auto">
            @if (Session::has('success'))
                <p class="alert alert-success my-2">
                    <strong>{{ Session::get('success') }}</strong>
                </p>
            @endif
            @if ($error)
                <p class="alert alert-danger my-2">
                    <strong>{{ $error }}</strong>
                </p>
            @endif
            <form wire:submit.prevent="handleSubmit">
                @csrf
                <div class="form-group my-2">
                    <input
                        id="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        autocomplete="name"
                        autofocus placeholder="Email"
                        wire:model="email"/>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group my-2">
                    <input id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="new-password"
                        placeholder="Password"
                        wire:model="password"/>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-dark">
                        {{ __('Login') }}
                    </button>
                  </div>
            </form>
        </div>
    </div>
</div>
