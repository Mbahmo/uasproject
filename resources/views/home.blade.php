@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<h1>Selamat Datang, {{$user->name}}</h1>
<h2>Email : {{$user->email}}</h2>
<img src={{asset('images/'.$user->image)}} alt="user-image" width="300">
<div class="container">
    <form action="{{route('upload')}}" enctype="multipart/form-data" method="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{$user->id}}">
      <div class="form-group">
        <label>Gambar:</label>
        <input type="file" name="gambar" class="form-control">
      </div>

      <div class="form-group">
        <button class="btn btn-success upload-image" type="submit">Change Image</button>
      </div>
    </form>
</div>
@stop
