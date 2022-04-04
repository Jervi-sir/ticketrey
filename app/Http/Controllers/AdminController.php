<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Template;
use App\Models\Advertiser;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function addTemplatePage()
    {
        return view('test.admin.addTemplate');
    }

    public function addTemplate(Request $request)
    {
        $template = new Template();
        $template->template_name = $request->template_name;
        $template->type = $request->type;
        $template->source_code = $request->source_code;
        $template->save();
        dd($template);

    }

    public function listNonVerifiedAdv()
    {
        $advs = Advertiser::where('is_verified', 0)->get();
        dd($advs);
    }


    public function showAdv($id)
    {
        $adv = Advertiser::find($id);

        return view('test.admin.showAdvertiser',['adv' => $adv]);
    }


    public function confirmAdv($id)
    {
        $adv = Advertiser::find($id);
        $adv->is_verified = 1;
        $adv->save();

        dd($adv);
    }


    public function listNonVerifiedOffer()
    {
        $offers = Offer::where('is_verified', 0)->get();
        dd($offers);
    }

    public function showOffer($id)
    {
        $offer = Offer::find($id);

        return view('test.admin.showOffer',['offer' => $offer]);
    }


    public function confirmOffer($id)
    {
        $offer = Offer::find($id);
        $offer->is_verified = 1;
        $offer->save();

        dd($offer);

    }

    public function destroy($id)
    {
        //
    }
}
