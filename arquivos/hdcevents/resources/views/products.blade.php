@extends ('layouts.main')

@section('title', 'HDC Events')

@section ('content')

<h1>Pesquisa</h1>

@if($busca != '')
    <p>O usário está buscando {{$busca}}</p>
@endif

<h1>teste</h1>




@endsection