<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Offer;
use App\Models\Template;
use App\Models\Advertiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class AdvertiserController extends Controller
{

    public function joinAdvertiserPage()
    {
        //TODO: if already requests
        return view('tailwind.advertiser.join');
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

        event(new Registered($user));

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);

    }


    public function addOfferPage()
    {
        $templates = Template::all();
        return view('tailwind.advertiser.addOffer', ['templates' => $templates]);
    }


    public function addOffer(Request $request)
    {

        $offer = new Offer();
        $offer->advertiser_id = Auth::user()->advertiser()->first()->id;
        //TODO: set template id
        $offer->template_id = Template::find($request->type)->id;
        $offer->tickets_left = intval($request->tickets_left);
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
        $offers = Auth::user()->advertiser->offers()->get();
        return view('tailwind.advertiser.allOffers', ['offers' => $offers]);
    }


    public function showOffer($id)
    {
        $advertiser = Auth::user()->advertiser;
        $offers = $advertiser->offers();
        $offer = $offers->find($id);

        //TODO: if u arent the owner
        dd($offer);

    }


    public function editOffer($id)
    {
        $offer = Offer::find($id);
        if($offer->advertiser->id != Auth::user()->advertiser->id) {
            return redirect('/');
            //TODO: redirect to 404
        }
        $templates = Template::all();
        return view('tailwind.advertiser.editOffer', ['offer' => $offer,
                                                    'templates' => $templates]);
    }

    public function updateOffer($id, Request $request)
    {
        $offer = Offer::find($id);
        if($offer->advertiser->id != Auth::user()->advertiser->id) {
            return redirect('/');
            //TODO: redirect to 404
        }

        $offer->tickets_left = intval($request->tickets_left);
        $offer->images = '$request->images';
        $offer->details = $request->details;
        $offer->campaign_name = $request->campaign_name;
        $offer->campaign_starts = $request->campaign_starts;
        $offer->campaign_ends = $request->campaign_ends;
        $offer->save();

        return back();
    }
}
