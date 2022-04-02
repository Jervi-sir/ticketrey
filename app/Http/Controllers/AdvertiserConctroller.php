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
        //* [name, email, password, userdetails]
        //* [companyName, companyDetails, images, phone_number]


        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            //TODO: password confirmed if statement
            'password_confirmed' => 'required|string',
            'userdetails' => 'string',
            'companyName' => 'required|string',
            'companyDetails' => 'string',
            'phone_number' => 'string',
            //TODO: 'images' => compress file
            'images' => 'string'
        ]);

        //if user exists
        $user = User::where('email', $request->email)->first();


        if($user) {
            //check the password if correct
            if(!$user || !Hash::check($fields['password'], $user->password)) {
                return response([
                    'message' => 'Bad creds'
                ], 401);
            }
        }
        //Doesnt exist
        else {
            $user = new User();
            $user->role_id = Role::where('name', 'advertiser')->first()->id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->details = $request->userdetails ? $request->userdetails : null;
            $user->save();
        }
        //create token
        $token = $user->createToken($fields['email'])->plainTextToken;

        $adv = new Advertiser();
        $adv->user_id = $user->id;
        $adv->name = $request->companyName;
        $adv->details = $request->companyDetails;
        $adv->images = '$request->images';
        $adv->phone_number = $request->phone_number;
        $adv->save();

        return [
            'advertiser' => $adv,
            'user' => $user,
            'token' => $token
        ];
    }

    public function addOffer(Request $request) {
        //TODO: limit ammount of offers to 7
        //[template_id, amount_tickets, images, details]
        //[campaign_starts, campaign_ends]
        $offer = new Offer();
        $offer->advertiser_id = Auth::user()->advertiser()->first()->id;
        $offer->template_id = intval($request->template_id);
        $offer->tickets_left = intval($request->amount_tickets);
        $offer->images = $request->images;
        $offer->details = $request->details;

        $offer->campaign_starts = date('Y-m-d',strtotime($request->campaign_starts));
        $offer->campaign_ends = date('Y-m-d',strtotime($request->campaign_ends));

        //TODO: $offer->campaign_name = $request->campaign_name;
        $offer->save();

        return [
            'offer' => $offer,
        ];
    }

    public function manageOffers(Request $request) {
        $offers = Auth::user()->advertiser()->first()->offers()->get();

        return [
            'offer' => $offers,
        ];
    }

    public function showOffer($id) {
        $advertiser = Auth::user()->advertiser()->first();
        $offers = $advertiser->offers();
        $offer = $offers->find($id);

        return [
            'offer' => $offer,
        ];
    }

    public function deleteOffer($id, Request $request) {

        //? check if advertiser is the owner
        $advertiser = Auth::user()->advertiser()->first();
        $offer = Offer::find($id);
        if($offer->advertiser_id != $advertiser->id) {
            return response([
                'message' => 'you are not the owner'
            ], 401);
        }


        $offer->delete();

        return [
            'message' => 'offer deleted',
        ];



    }

}
