@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Invoices</h1>
@stop

@section('content')
    @if (session('response'))
        <div class="alert alert-success">
            {{ session('response') }}
        </div>
    @endif
    <div class="btn-group">
        <a href="{{ URL::route('importWfirma') }}" type="button">
            <x-adminlte-button label="Import WF" theme="primary" icon="fas fa-key"/>
        </a>
        <x-adminlte-button label="Secondary" theme="secondary" icon="fas fa-hashtag"/>
        <x-adminlte-button label="Info" theme="info" icon="fas fa-info-circle"/>
    </div>

    <x-adminlte-card title="" theme="lightblue" theme-mode="outline"
                     icon="fas fa-lg fa-envelope">
    {{-- Minimal example / fill data using the component slot --}}
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach($config['data'] as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </x-adminlte-datatable>

        {{-- Compressed with style options / fill data using the plugin config --}}
        <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config"
                              striped hoverable bordered compressed/>
    </x-adminlte-card>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
