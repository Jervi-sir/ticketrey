<?php

namespace App\Http\Controllers;

use App\Models\Advertiser;
use App\Models\Offer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdvertiserConctroller extends Controller
{
    //request a registery as an Advertiser
    public function become(Request $request) {
        //[username, email, password, userdetails]
        //[companyName, companyDetails, images, phone_number]

        $user = new User();
        $user->role_id = Role::where('name', 'advertiser')->first()->id;
        $user->name = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->details = $request->userdetails ? $request->userdetails : null;
        $user->save();

        $adv = new Advertiser();
        $adv->user_id = $user->id;
        $adv->name = $request->companyName;
        $adv->details = $request->companyDetails;
        $adv->images = $request->images;
        $adv->phone_number = $request->phone_number;
        $adv->save();

        return [$adv, $user];
    }

    public function addOffer(Request $request) {
        //[template_id, amount_tickets, images, details]
        //[campaign_starts, campaign_ends]

        $offer = new Offer();
        $offer->advertiser_id = Auth()->user->advertiser()->first()->id;
        $offer->template = $request->template_id;
        $offer->tickets_left = $request->amount_tickets;
        $offer->images = $request->images;
        $offer->details = $request->details;

        $offer->campaign_starts = $request->campaign_starts;
        $offer->campaign_ends = $request->campaign_ends;

        $offer->save();

        return $offer;
    }

    public function manageOffers() {

    }

    public function showOffer($id) {
        $advertiser = Auth()->user;
        $offers = $advertiser->offers();
        $offer = $offers->find($id);

        return $offer;
    }

    public function updateOffer(Request $request) {

    }

    public function deleteOffer(Request $request) {

    }

}
