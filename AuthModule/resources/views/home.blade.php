@extends('adminlte::page')

@section('title', 'Dashboard')
@section('content')

<div class="content-wrapper" style="min-height: 1058.31px;">


    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            @include('home.vistasrecuadros')

            @include('home.vistas')

        </div>

    </section>
    <!-- /.content -->

</div>
@stop


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<!-- estilo personalizado <link rel="stylesheet" href="{{ asset('css/style.css') }}">-->

@stop

@section('js')
<script>
    console.log('Hola!');
</script>
@stop
@section('scripts')
<script src="{{ mix('js/paises.json') }}"></script>
@endsection
