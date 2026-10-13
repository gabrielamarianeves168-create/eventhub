<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('events.index') }}">EventHub</a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-menu">
                @auth 
                    <li>
                        <a href="{{ route('events.index') }}">Eventos</a>
                    </li>
                    <li>
                        <a href="{{ route('subscriptions.index') }}">Minhas inscrições</a>
                    </li>

                    @if(auth()->user()->isAdmin()) 
                        <li>
                            <a href="{{ route('admin.dashboard') }}">Administração</a>
                        </li>
                    @endif 
                @endauth 
            </ul>

            <ul class="navbar-user">
                @guest 
                    <li>
                        <a href="{{ route('login') }}">Entrar</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Criar conta</a>
                    </li>
                @else 
                    <li>
                        <span>{{ auth()->user()->name }}</span>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf 
                            <button type="submit">Sair</button>
                        </form>
                    </li>
                @endguest 
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
    {{-- Mensagens de feedback do sistema --}}
    @if(session('success'))  
        <div class="alert alert-success">
            {{ session('success') }} 
        </div>
    @endif 

    @if(session('error'))  
        <div class="alert alert-danger">
            {{ session('error') }} 
        </div>
    @endif 

    @if($errors->any())
        <div class="alert alert-warning">
            <p>Verifique os dados informados:</p>
            <ul>
                @foreach($errors->all() as $error) 
                    <li>{{ $error }}</li>
                @endforeach 
            </ul>
        </div>
    @endif 

    {{-- Conteúdo principal da página --}}
    @yield('content')
</main>