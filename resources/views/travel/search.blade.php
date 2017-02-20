@extends('layouts.main')

@section("name")
    Rechercher un trajet
@stop

@section("content")
    <div class="row">
        <div class="card col-md-12">
            {{ Form::open(['method' => 'GET']) }}
            <div class="content">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Lieu de départ</label>
                        <input type="text" class="form-control" id="departureBox" placeholder="Départ" name="departure" value="{{ request('departure') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Destination</label>
                        <input type="text" class="form-control" id="arrivalBox" placeholder="Destination" name="arrival" value="{{ request('arrival') }}">
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class="form-group">
                        <label>Date de départ</label>
                        <div class='input-group date' id="datetimepicker" >
                            <input type='text' class="form-control" name="date" value="{{ request('date') ?  request('date') : \Carbon\Carbon::now()->format('d/m/Y H:i') }}"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Distance (en km)</label>
                        <input type="text" name="radius" class="span2" data-slider-value="{{ request('radius') ? request('radius') : 5 }}" data-slider-min="1" data-slider-max="15" data-slider-step="1" data-slider-id="BC" id="B" data-slider-tooltip="hide" data-slider-handle="round" />
                    </div>
                </div>
                <div class='col-md-1 text-center'>
                    <div class="form-group">
                        <button name="search" class="btn btn-primary btn-bg" value="search" type="submit">
                            <span class="fa fa-search"></span>
                        </button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-5">
                @if(!isset($travels) || !count($travels))
                    <div class="row card">
                        <div class="content">
                            @if(!isset($travels))
                                <p class="category">Veuillez effectuer une recherche afin d'obtenir des résultats</p>
                            @elseif (!count($travels))
                                <p class="category">Aucun trajets ne correspond à vos critères.<br> Essayez une autre recherche.</p>
                            @endif
                        </div>
                    </div>
                @else
                    @foreach($travels as $travel)
                    <div class="row card" id="travel-{{ $travel->id }}">
                        <div class="header col-md-3">
                            <div class="author card-user">
                            <a href="#">
                                <img class="avatar border-gray" src="{{ $travel->user->avatar }}">
                            </a>
                            </div>
                        </div>
                        <div class="content col-md-7">
                            <h6>Départ :</h6><p class="category">{{ $travel->departure }}</p>
                            <h6>Destination :</h6><p class="category">{{ $travel->arrival }}</p>
                            <h6>Date :</h6><p class="category">{{ \Carbon\Carbon::parse($travel->date)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="content col-md-2 vcenter">
                            <a class="btn btn-primary btn-bg" href="{{ route('travel-details', $travel->id) }}"><span class="fa fa-search"></span></a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="col-md-7" style="height: 600px;">
                {!! Mapper::render() !!}
            </div>
        </div>
    </div>

@stop

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/bootstrap-slider.min.js"></script>
    <script type="text/javascript">

        function initialize() {
            var departure = document.getElementById('departureBox');
            var arrival = document.getElementById('arrivalBox');
            var autocomplete = new google.maps.places.Autocomplete(departure);
            var autocomplete2 = new google.maps.places.Autocomplete(arrival);
        }

        $(document).ready(function(){
            $("#B").slider({
                'tooltip': 'bottom'
            });
            google.maps.event.addDomListener(window, 'load', initialize);
            $('#datetimepicker').datetimepicker({
                locale: 'fr',
                sideBySide: true
            });
        });


    </script>
@stop