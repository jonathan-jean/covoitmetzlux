<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Notifications\AcceptContactNotification;
use App\Notifications\DeclineContactNotification;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getIndex()
    {
        return view('contact.index');
    }

    public function getDecline(Request $request, Contact $contact)
    {
        $contact->answered = true;
        $contact->save();
        $contact->fromUser->notify(new DeclineContactNotification($contact));
        $request->session()->flash('info', "Vous avez décliné la demande.");
        return redirect(route('contact-index'));
    }

    public function getAccept(Request $request, Contact $contact)
    {
        $contact->answered = true;
        $contact->save();
        $contact->fromUser->notify(new AcceptContactNotification($contact));
        $request->session()->flash('info', "Vous avez accepté la demande.");
        return redirect(route('contact-index'));
    }
}
