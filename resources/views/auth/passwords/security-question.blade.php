@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Security Question') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.verify_security_question') }}">
                        @csrf

                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group row">
                            <label for="security_question" class="col-md-4 col-form-label text-md-right">{{ __('Security Question') }}</label>

                            <div class="col-md-6">
                                <p>{{ $user->security_question }}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="security_answer" class="col-md-4 col-form-label text-md-right">{{ __('Security Answer') }}</label>

                            <div class="col-md-6">
                                <input id="security_answer" type="text" class="form-control @error('security_answer') is-invalid @enderror" name="security_answer" required autocomplete="off">

                                @error('security_answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify Answer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
