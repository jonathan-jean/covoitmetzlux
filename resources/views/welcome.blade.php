@extends("layouts.main")

@section("content")
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h2 class="title">#CoVoitMetzLux</h2>
                    <p class="category">Le site communautaire pour mettre fin aux galères</p>
                </div>
                <div class="content">

                    <div class="typo-line">
                    </div>

                    <div class="typo-line">
                        <blockquote>
                            <p>
                                Afin de faciliter la gestion du #CoVoitMetzLux lors des problèmes sur la ligne, ce site a été mis en place.
                                <br>Ce projet est participatif et <a href="https://github.com/jonathan-jean/covoitmetzlux">open source</a>
                            </p>
                            <small>
                                Jonathan JEAN, <a href="https://twitter.com/jonathanjeanfr">@jonathanjeanfr</a>
                            </small>
                        </blockquote>
                    </div>

                    <div class="typo-line">
                        <p class="text-muted">
                            Proposez ou consultez, facilement, les covoiturages mis en place par les usagers
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h4 class="title">Les prochains trajets</h4>
                    <p class="category">Les 5 prochains trajets</p>
                </div>
                <div class="content">
                    <div class="table-responsive table-full-width">
                        <table class="table">
                            <tbody>
                            @foreach($travels as $travel)
                            <tr>
                                <td>{{ $travel->departure }}</td>
                                <td>{{ $travel->arrival }}</td>
                                <td>{{ \Carbon\Carbon::parse($travel->date)->format('d/m/Y H:i') }}</td>
                                <td class="td-actions text-right">
                                    <a href="{{ route('travel-details', $travel->id) }}" class="btn btn-bg btn-info btn-simple btn-xs">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop