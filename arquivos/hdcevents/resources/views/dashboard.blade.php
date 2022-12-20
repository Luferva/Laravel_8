@extends ('layouts.main')

@section ('title', "Dashboard")

@section ('content')

<div class="col-md-10 offset-md-1 dashborad-title-container">
    <h1>Meus Eventos</h1>
</div>
<div class="col-md-10 offset-md-1 dashborad-title-container">
    @if($events>0)
    @else
        <p>Você ainda não tem eventos, <a href="/events/create">Criar Eventos</a></p>
    @endif
</div>




@endsection