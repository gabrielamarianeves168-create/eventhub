@extends('layouts.app') 
 
@section('title', 'Login') 
 
@section('content') 
 
<div class="row justify-content-center"> 
    <div class="col-md-5"> 
 
        <div class="card shadow-sm"> 
            <div class="card-body"> 
 
                <h1 class="h4 mb-4"> 
                    Entrar 
                </h1> 
 
                <form 
                    method="POST" 
                    action="{{ route('login') }}" 
                > 
                    @csrf 
 
                    <div class="mb-3"> 
                        <label 
                            for="email" 
                            class="form-label" 
                        > 
                            E-mail 
                        </label> 
 
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                        > 
 
 
                        @error('email') 
                            <div class="invalid-feedback"> 
                                {{ $message }} 
                            </div> 
                        @enderror 
                    </div> 
 
                    <div class="mb-3"> 
                        <label 
                            for="password" 
                            class="form-label" 
                        > 
                            Senha 
                        </label> 
 
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control" 
                            required 
                        > 
                    </div> 
 
                    <div class="form-check mb-3"> 
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="remember" 
                            value="1" 
                            id="remember" 
                        > 
 
                        <label 
                            class="form-check-label" 
                            for="remember" 
                        > 
                            Lembrar de mim 
                        </label> 
                    </div> 
 
                    <button 
                        type="submit" 

 
                        class="btn btn-primary w-100" 
                    > 
                        Entrar 
                    </button> 
 
                </form> 
 
                <div class="text-center mt-3"> 
                    <a href="{{ route('register') }}"> 
                        Ainda não tenho uma conta 
                    </a> 
                </div> 
 
            </div> 
        </div> 
 
    </div> 
</div> 
 
@endsection