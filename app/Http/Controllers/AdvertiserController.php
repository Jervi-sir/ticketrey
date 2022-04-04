<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Offer;
use App\Models\Advertiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdvertiserController extends Controller
{

    public function joinAdvertiserPage()
    {
        return view('test.advertiser.join');
    }

    //? joined as a new one
    public function joinAdvertiser(Request $request)
    {
        $user = new User();
        $user->role_id = Role::where('name', 'advertiser')->first()->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $adv = new Advertiser();
        $adv->user_id = $user->id;
        $adv->company_name = $request->company_name;
        $adv->phone_number = $request->phone_number;
        $adv->details = $request->details;
        //TODO: $adv->images = $request->images;
        $adv->save();

        dd($user, $adv);

    }


    public function addOfferPage()
    {
        return view('test.advertiser.addOffer');
    }


    public function addOffer(Request $request)
    {

        $offer = new Offer();
        $offer->advertiser_id = Auth::user()->advertiser()->first()->id;
        //TODO: set template id
        $offer->template_id = 1;
        $offer->tickets_left = $request->tickets_left;
        $offer->images = '$request->images';
        $offer->details = $request->details;
        $offer->campaign_name = $request->campaign_name;
        $offer->campaign_starts = $request->campaign_starts;
        $offer->campaign_ends = $request->campaign_ends;
        $offer->save();

        dd($offer);
    }


    public function manageOffers()
    {
        $offers = Auth::user()->advertiser()->first()->offers()->get();
        dd($offers);
        return view('test.advertiser.allOffers');
    }


    public function showOffer($id)
    {
        $advertiser = Auth::user()->advertiser()->first();
        $offers = $advertiser->offers();
        $offer = $offers->find($id);

        //TODO: if u arent the owner
        dd($offer);

    }


    public function destroy($id)
    {
        //
    }
}
