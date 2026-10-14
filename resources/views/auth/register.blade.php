@extends('layouts.app') 
 
@section('title', 'Criar conta') 
 
@section('content') 
 
<div class="row justify-content-center"> 
    <div class="col-md-6"> 
 
        <div class="card shadow-sm"> 
            <div class="card-body"> 
 
                <h1 class="h4 mb-4"> 
                    Criar conta 
 
                </h1> 
 
                <form 
                    method="POST" 
                    action="{{ route('register.store') }}" 
                > 
                    @csrf 
 
                    <div class="mb-3"> 
                        <label class="form-label"> 
                            Nome 
                        </label> 
 
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control" 
                            value="{{ old('name') }}" 
                            required 
                        > 
                    </div> 
 
                    <div class="mb-3"> 
                        <label class="form-label"> 
                            E-mail 
                        </label> 
 
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control" 
                            value="{{ old('email') }}" 
                            required 
                        > 
                    </div> 
 
                    <div class="mb-3"> 
                        <label class="form-label"> 
                            Senha 
                        </label> 
 
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control" 
                            required 
                        > 
                    </div> 
 
                    <div class="mb-3"> 
                        <label class="form-label"> 
                            Confirmar senha 
                        </label> 
 
                    <input 
                            type="password" 
                            name="password_confirmation" 
                            class="form-control" 
                            required 
                        > 
                    </div> 

                    <button 
                            type="submit" 
                            class="btn btn-primary" 
                    > 
                            Criar conta 
                    </button> 
                </form> 
            </div> 
        </div> 
    </div> 
</div> 
@endsection