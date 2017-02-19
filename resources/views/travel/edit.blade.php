@extends('layouts.main')

@section("name")
    Modifier un trajet
@stop

@section("content")
    <div class="col-md-8 col-md-offset-2">
        <div class="card">
            <div class="header">
                <h4 class="title">Modifier un trajet</h4>
            </div>
            <div class="content">
                {{ Form::open(array('route' => ['travel-edit', $travel->id])) }}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Départ</label>
                                <input type="text" class="form-control" id="departureBox" placeholder="Départ" name="departure" value="{{ $travel->departure ? $travel->departure : ('departure') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Destination</label>
                                <input type="text" class="form-control" id="arrivalBox" placeholder="Destination" name="arrival" value="{{ $travel->arrival ? $travel->arrival : ('arrival') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <label>Date et heure de départ</label>
                                <div class='input-group date' id="datetimepicker" >
                                    <input type='text' class="form-control" name="date" value="{{ $travel->date ? \Carbon\Carbon::parse($travel->date)->format('d/m/Y H:i') : ('date') }}"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre de places disponibles</label>
                                <select class="selectpicker form-control" value="{{ old('places') }}" name="places">
                                    <option {{ ($travel->places == 0 ? "selected":"") }}>0</option>
                                    <option {{ ($travel->places == 1 ? "selected":"") }}>1</option>
                                    <option {{ ($travel->places == 2 ? "selected":"") }}>2</option>
                                    <option {{ ($travel->places == 3 ? "selected":"") }}>3</option>
                                    <option {{ ($travel->places == 4 ? "selected":"") }}>4</option>
                                    <option {{ ($travel->places == 5 ? "selected":"") }}>5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Informations</label>
                                <textarea rows="5" class="form-control" placeholder="Plus d'informations ici" name="information">{{ $travel->information ? $travel->information : ('information') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-info btn-fill pull-right" value="Modifier mon trajet">
                    <div class="clearfix"></div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{ env('GOOGLE_MAP_API_KEY') }}"></script>
    <script type="text/javascript">

        function initialize() {
            var departure = document.getElementById('departureBox');
            var arrival = document.getElementById('arrivalBox');
            var autocomplete = new google.maps.places.Autocomplete(departure);
            var autocomplete2 = new google.maps.places.Autocomplete(arrival);
        }
        $(document).ready(function(){
            google.maps.event.addDomListener(window, 'load', initialize);
            $('#datetimepicker').datetimepicker({
                locale: 'fr',
                sideBySide: true
            });

        });
    </script>
@stop