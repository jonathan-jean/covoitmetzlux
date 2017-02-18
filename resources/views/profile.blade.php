@extends('layouts.main')

@section("name")
Mon profil
@stop

@section("content")
<div class="col-md-4 col-md-offset-4">
    <div class="card card-user">
        <div class="image">
            <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&amp;fm=jpg&amp;h=300&amp;q=75&amp;w=400" alt="...">
        </div>
        <div class="content">
            <div class="author">
                <a href="#">
                    <img class="avatar border-gray" src="{{ Auth::user()->avatar }}">

                    <h4 class="title">{{ Auth::user()->name }}<br>
                        <small>{{ Auth::user()->email }}</small>
                    </h4>
                </a>
            </div>
            <hr>
            {{ Form::open(array('url' => '/user')) }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Numéro de téléphone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Numéro de téléphone" value="{{ Auth::user()->phone }}">
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn">
            {{ Form::close() }}
            <hr>
            <p class="text-muted small">Cette information ne sera JAMAIS communiquée sans votre accord</p>
        </div>
    </div>
</div>
@stop