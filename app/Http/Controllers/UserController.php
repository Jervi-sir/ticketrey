<?php

namespace App\Http\Controllers;

use App\Models\Advertiser;
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

    }

    public function refund(Request $request) {

    }

    public function allMyTickets(Request $request) {

    }

    public function getThisTicket(Request $request) {

    }

}
