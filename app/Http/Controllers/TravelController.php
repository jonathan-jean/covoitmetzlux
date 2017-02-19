<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Travel;
use Carbon\Carbon;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Cornford\Googlmapper\Models\Map;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Location {
    protected $address;
    protected $latitude;
    protected $longitude;

    /**
     * Location constructor.
     * @param $address
     * @param $latitude
     * @param $longitude
     */
    public function __construct($address, $latitude, $longitude)
    {
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }


}

class TravelController extends Controller
{

    public function getIndex()
    {
        return view('travel.index');
    }

    public function getDetails($id)
    {
        $travel = Travel::findOrFail($id);
        Mapper::map($travel->departure_lat, $travel->departure_long, ['zoom' => 9]);
        Mapper::marker($travel->arrival_lat, $travel->arrival_long);
        Mapper::marker($travel->departure_lat, $travel->departure_long);
        return view('travel.details')->with("travel", $travel);
    }

    public function distance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);
    }

    public function getAdress($place)
    {
        if ($place == "P+R Bouillon, Rue de Bouillon, Luxembourg")
            return new Location($place, 49.5997333, 6.1062028);
        else if ($place == 'Luxembourg')
            return new Location("Gare de Luxembourg", 49.6000243,6.131863);
        else
            return Mapper::location($place);
    }

    public function getSearch(Request $request)
    {
        if ($request->has('search'))
        {
            $this->validate($request, [
                'departure' => 'required',
                'radius' => 'required|min:1|max:15',
                'date' => 'required|date_format:d/m/Y H:i',
            ]);

            try {
                $departure = $this->getAdress($request->get('departure'));
            } catch (Exception $e)
            {
                return view('travel.search')->withErrors(['placesD' => 'Impossible de trouver votre lieu de départ']);
            }

            if ($request->has('arrival')) {
                try {
                    $arrival = $this->getAdress($request->get('arrival'));
                } catch (Exception $e) {
                    return view('travel.search')->withErrors(['placesA' => 'Impossible de trouver votre lieu de destination']);
                }
            }
            $date = Carbon::createFromFormat('d/m/Y H:i', $request->get('date'));
            $travels = Travel::where('date', '>=', $date)
                ->where('places', '>', 0)
                ->orderBy('date')
                ->get()
                ->reject(function ($travel) use ($departure, $request) {
                    return $this->distance($departure->getLatitude(), $departure->getLongitude(), $travel->departure_lat, $travel->departure_long) > $request->get('radius');
                });
            if ($request->has('arrival'))
            {
                $travels = $travels->reject(function ($travel) use ($arrival, $request) {
                    return $this->distance($arrival->getLatitude(), $arrival->getLongitude(), $travel->arrival_lat, $travel->arrival_long) > $request->get('radius');
                });
            }
            Mapper::map($departure->getLatitude(), $departure->getLongitude(), ['zoom' => 13]);
            Mapper::circle([['latitude' => $departure->getLatitude(), 'longitude' => $departure->getLongitude()]], ['strokeColor' => '#000000', 'strokeOpacity' => 0.1, 'strokeWeight' => 2, 'fillColor' => '#FFFFFF', 'radius' => $request->get('radius') * 1000]);
            foreach ($travels as $travel)
            {
                $text = "
                    <div class=\"content\">
                        <h6>Départ :</h6><p class=\"category\"> " . $travel->departure . "</p>
                        <h6>Destination :</h6><p class=\"category\">" . $travel->arrival . "</p>
                        <h6>Date :</h6><p class=\"category\">" . \Carbon\Carbon::parse($travel->date)->format('d/m/Y H:i') . "</p>
                        <a class=\"btn btn-primary btn-bg\" href=\"" . route('travel-details', $travel->id) . "\"><span class=\"fa fa-search\"></span> Voir les détails</a>
                    </div>
                ";
                Mapper::informationWindow($travel->departure_lat, $travel->departure_long, $text);
            }
            return view('travel.search')->with('travels', $travels);

        }
        else
        {
            Mapper::map(49.357571, 6.168426, ['zoom' => 13]);
            return view('travel.search');
        }
    }

    public function getCreate()
    {
        return view('travel.create');
    }

    public function getContact(Request $request, Travel $travel)
    {
        if ($travel->contactRequests()->where('to', $travel->user_id)->where('from', auth()->user()->id)->count() > 0)
        {
            $request->session()->flash("info", "Vous avez déjà envoyé une demande de contact à ce membre, attendez une réponse et vérfiez votre boite mail.");
        } else {
            $contact = new Contact;
            $contact->from = auth()->user()->id;
            $contact->to = $travel->user->id;
            $contact->answered = false;
            $travel->contactRequests()->save($contact);
            $request->session()->flash("info", "Votre demande a été transmise. Vous recevrez un mail avec les informations de contact une fois que le conducteur l'aura accepté.");

        }
        return redirect(route('travel-details', $travel->id));
    }

    public function getEdit(Request $request, Travel $travel)
    {
        if ($travel->user != auth()->user())
        {
            $request->session()->flash('info', 'Vous ne pouvez pas modifier une annonce qui ne vous appartient pas!');
            return redirect(route('home'));
        }
        return view('travel.edit')->with('travel', $travel);
    }

    public function getDelete(Request $request, Travel $travel)
    {
        if ($travel->user != auth()->user())
        {
            $request->session()->flash('info', 'Vous ne pouvez pas modifier une annonce qui ne vous appartient pas!');
            return redirect(route('home'));
        }
        $travel->delete();
        $request->session()->flash('info', 'Votre annonce a été supprimé');
        return redirect(route('home'));
    }

    public function postEdit(Request $request, Travel $travel)
    {
        $this->validate($request, [
            'departure' => 'required',
            'arrival' => 'required',
            'date' => 'required|date_format:d/m/Y H:i',
            'places' => "required|min:1|max:5",
            'information' => "required"
        ]);

        if ($travel->user != auth()->user())
        {
            $request->session()->flash('info', 'Vous ne pouvez pas modifier une annonce qui ne vous appartient pas!');
            return redirect(route('home'));
        }
        try {
            $departure = $this->getAdress($request->get('departure'));
        } catch (Exception $e)
        {
            return redirect(route('travel-edit'), $travel->id)->withErrors(['places' => 'Impossible de trouver votre lieu de départ'])->withInput();
        }

        try {
            $arrival = $this->getAdress($request->get('arrival'));
        } catch (Exception $e)
        {
            return redirect(route('travel-edit'), $travel->id)->withErrors(['places' => 'Impossible de trouver votre lieu de destination'])->withInput();
        }

        $travel->departure = $departure->getAddress();
        $travel->departure_lat = $departure->getLatitude();
        $travel->departure_long = $departure->getLongitude();
        $travel->arrival = $arrival->getAddress();
        $travel->arrival_lat = $arrival->getLatitude();
        $travel->arrival_long = $arrival->getLongitude();
        $travel->date = Carbon::createFromFormat('d/m/Y H:i', $request->get('date'));
        $travel->places = $request->get('places');
        $travel->information = $request->get('information');
        $travel->save();

        $request->session()->flash('info', 'Votre trajet a bien été mis à jour.');
        return redirect(route('travel-details', $travel->id));
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'departure' => 'required',
            'arrival' => 'required',
            'date' => 'required|date_format:d/m/Y H:i',
            'places' => "required|min:1|max:5",
            'information' => "required"
        ]);

        try {
            $departure = $this->getAdress($request->get('departure'));
        } catch (Exception $e)
        {
            return redirect(route('travel-create'))->withErrors(['places' => 'Impossible de trouver votre lieu de départ'])->withInput();
        }

        try {
            $arrival = $this->getAdress($request->get('arrival'));
        } catch (Exception $e)
        {
            return redirect(route('travel-create'))->withErrors(['places' => 'Impossible de trouver votre lieu de destination'])->withInput();
        }

        $travel = new Travel;
        $travel->departure = $departure->getAddress();
        $travel->departure_lat = $departure->getLatitude();
        $travel->departure_long = $departure->getLongitude();
        $travel->arrival = $arrival->getAddress();
        $travel->arrival_lat = $arrival->getLatitude();
        $travel->arrival_long = $arrival->getLongitude();
        $travel->date = Carbon::createFromFormat('d/m/Y H:i', $request->get('date'));
        $travel->places = $request->get('places');
        $travel->information = $request->get('information');
        $user = auth()->user();
        $user->travels()->save($travel);

        $request->session()->flash('info', 'Votre trajet a bien été créé.');
        return redirect(route('travel-index'));
    }
}
