<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="my-5 text-center display-3">{{ __('Register')}}</h1>
        </div>

        <div class="col-md-6 mx-auto">
            <form wire:submit.prevent="handleSubmit">
                @csrf

                @if ($error)
                    <p class="alert alert-danger my-2">
                        <strong>{{ $error }}</strong>
                    </p>
                @endif
                <div class="form-group my-2">
                    <input
                        type="text"
                        class="form-control @error('first_name') is-invalid @enderror"
                        value="{{ old('first_name') }}"
                        placeholder="First Name"
                        wire:model="first_name"/>

                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group my-2">
                    <input
                        type="text"
                        class="form-control @error('last_name') is-invalid @enderror"
                        value="{{ old('last_name') }}"
                        placeholder="Last Name"
                        wire:model="last_name"/>

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group my-2">
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        wire:model="email"/>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group my-2">
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password"
                        wire:model="password"/>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group my-2">
                    <input
                        type="password"
                        class="form-control @error('confirmPass') is-invalid @enderror"
                        placeholder="Confirm Password"
                        wire:model="confirmPass"/>
                    @error('confirmPass')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-dark">
                        {{ __('Register') }}
                    </button>
                  </div>
            </form>
        </div>
    </div>
</div>
