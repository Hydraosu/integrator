@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    <form action="/settings/profile/update" method="POST">
        @csrf

        <x-adminlte-card title="Lightblue Card" theme="lightblue" theme-mode="outline"
                         icon="fas fa-lg fa-envelope" removable>
            <div class="row">
                <x-adminlte-input name="name" label="Change name" placeholder="Name"
                                  fgroup-class="col-md-4" disable-feedback value="{{ $user->name }}"/>
            </div>
s
            <x-adminlte-button type="submit" label="Save" theme="primary" icon="fas fa-key"/>
        </x-adminlte-card>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
