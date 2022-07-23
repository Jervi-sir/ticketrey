<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Offer;
use App\Models\Ticket;
use App\Models\Advertiser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function upgrade(Request $request) {
        $user = Auth::user();
        $user->role_id = Role::where('name', 'advertiser')->first()->id;
        $user->save();

        //[companyName, companyDetails, images, phone_number]
        $adv = new Advertiser();
        $adv->user_id = Auth::user()->id;
        $adv->name = $request->companyName;
        $adv->details = $request->companyDetails;
        $adv->images = $request->images;
        $adv->phone_number = $request->phone_number;
        $adv->save();

        return [
            'advertiser' => $adv,
            'user' => $user,
        ];
    }

    public function search($keyword) {
        $result = $keyword;
        return [
            'result' => $result,
        ];
    }

    public function purchase(Request $request, $offer_id) {
        //? [offer_id, details, place]

        $offer = Offer::find($request->offer_id);
        if($offer->tickets_left == 0) {
            return response([
                'message' => 'tickets out of stock'
            ], 401);
        }

        $user = Auth::user();

        $qrcode = 'name' . $user->name . '&' .
                    'festival' . $offer->id . '&' .
                    'source' . $offer->advertiser()->first()->id . '&' .
                    'secret_code' . Str::random(16) . '&' .
                    'date' . Carbon::now()->format('Y-m-d') . '&' .
                    'place' . $request->place;

        $ticket = new Ticket();
        $ticket->user_id = $user->id;
        $ticket->offer_id = $request->offer_id;
        //TODO: maybe hash the qrcode
        $ticket->qrcode = $qrcode;
        $ticket->details = $request->details;
        $ticket->type = $offer->type;
        $ticket->place = $request->place; //use random code for place

        $ticket->save();

        if($left = $offer->tickets_left != 0) {
            $offer->tickets_left--;
        }

        else {
            //disavtivate the offer
        }

        $offer->save();

        return [
            'ticket' => $ticket,
            'offer' => $offer,
        ];

    }

    public function refund(Request $request) {
        //[qrcode]
        $user = Auth::user();
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
        $user = Auth::user();
        $tickets = $user->tickets()->get();

        return [
            'tickets' => $tickets,
        ];
    }

    public function getThisTicket($qrcode) {

        //[qrcode]
        $user = Auth::user();
        $tickets = $user->tickets()->get();

        $ticket = $tickets->where('qrcode', $qrcode)->first();

        return [
            'ticket' => $ticket,
        ];
    }

}
