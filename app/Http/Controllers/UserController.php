<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Ticket;
use App\Models\Advertiser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function upgrade(Request $request) {
        //[companyName, companyDetails, images, phone_number]
        $adv = new Advertiser();
        $adv->user_id = Auth()->user->id;
        $adv->name = $request->companyName;
        $adv->details = $request->companyDetails;
        $adv->images = $request->images;
        $adv->phone_number = $request->phone_number;
        $adv->save();

        return $adv;
    }

    public function search($keyword) {

    }

    public function purchase(Request $request, $ticket_id) {
        //[offer_id, details, place]
        $offer = Offer::find($request->offer_id);
        $ticket = new Ticket();
        $ticket->user_id = Auth()->user()->id;
        $ticket->offer_id = $request->offer_id;
        $ticket->qrcode = Str::random(16);
        $ticket->details = $request->details;
        $ticket->type = $offer->type;
        $ticket->palce = $request->place; //use random code for place

        $ticket->save();

        if($left = $offer->tickets_left != 0) {
            $offer->tickets_left--;
        }

        else {
            //disavtivate the offer
        }

        $offer->save();

        return $ticket;
    }

    public function refund(Request $request) {
        //[qrcode]
        $user = Auth()->user;
        //get targeted ticket
        $tickets = $user->tickets()->get();
        $ticket = $tickets->where('qrcode', $request->qrcode)->first();


        //refund first

        //if successfully do
        //get its parrent offer
        $offer = $ticket->offer()->first();
        $offer->tickets_left++;

        //delete current ticket
        $ticket->delete();


        return $offer;

    }

    public function allMyTickets() {
        $user = Auth()->user;
        $tickets = $user->tickets()->get();

        return $tickets;

    }

    public function getThisTicket(Request $request) {
        //[qrcode]
        $user = Auth()->user;
        $tickets = $user->tickets()->get();

        $ticket = $tickets->where('qrcode', $request->qrcode)->first();

        return $ticket;

    }

}
