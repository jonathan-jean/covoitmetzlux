@extends('layouts.main')

@section("name")
    Ajouter un trajet
@stop

@section("content")
    <div class="col-md-8 col-md-offset-2">
        <div class="card">
            <div class="header">
                <h4 class="title">Ajouter un trajet</h4>
            </div>
            <div class="content">
                {{ Form::open(array('route' => 'travel-create')) }}
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
                                <label>Lieu de départ</label>
                                <input type="text" class="form-control" id="departureBox" placeholder="Départ" name="departure" value="{{ old('departure') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Destination</label>
                                <input type="text" class="form-control" id="arrivalBox" placeholder="Destination" name="arrival" value="{{ old('arrival') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <label>Date de départ</label>
                                <div class='input-group date' id="datetimepicker" >
                                    <input type='text' class="form-control" name="date" value="{{ old('date') }}"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre de places disponibles</label>
                                <select class="selectpicker form-control" name="places">
                                    <option {{ (old("places") == 1 ? "selected":"") }}>1</option>
                                    <option {{ (old("places") == 2 ? "selected":"") }}>2</option>
                                    <option {{ (old("places") == 3 ? "selected":"") }}>3</option>
                                    <option {{ (old("places") == 4 ? "selected":"") }}>4</option>
                                    <option {{ (old("places") == 5 ? "selected":"") }}>5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Informations</label>
                                <textarea rows="5" class="form-control" placeholder="Plus d'informations ici" name="information">{{ old('information') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-info btn-fill pull-right" value="Ajouter mon trajet">
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