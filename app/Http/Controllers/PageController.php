<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function aboutUs(Request $request)
    {
        return view('pages.about');
    }

    public function contact(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'g-recaptcha-response' => 'required|captcha',
                'name'                 => 'required|string|max:20',
                'email'                => 'required|email',
                'phone'                => 'required|max:20',
                'subject'              => 'required',
                'message'              => 'required|string|min:20|max:500',
                'documents'            => 'sometimes|array|between:0,5',
                'documents.*'          => 'sometimes|file|mimes:doc,docx,pdf,jpeg,bmp,png|max:5120',
            ]);

            if($request->subject == 'INT-želim da postanem internet korisnik' || $request->subject == 'INT-problem sa internetom' || $request->subject == 'INT-zaposli se u NiNetu' || $request->subject == 'INT-potrebno mi je više informacija i detalja') {
                \Mail::to('support@ninet.rs')->send(new ContactForm($request->all()));
            }

            return redirect()->back()->with('flash-success', __('main.contact_form_submitted'));
        }

        return view('pages.contact');
    }

    public function news(Request $request)
    {
        return view('pages.news');
    }

    public function newsSingle(Request $request)
    {
        return view('pages.news-single');
    }

    public function privacyPolicy(Request $request)
    {
        return view('pages.privacy-policy');
    }

    public function termsAndConditions(Request $request)
    {
        return view('pages.terms-and-conditions');
    }

    public function paymentAndRefundPolicy(Request $request)
    {
        return view('pages.payment-and-refund-policy');
    }

    public function deliveryPolicy(Request $request)
    {
        return view('pages.delivery-policy');
    }

    public function support()
    {
        return view('pages.support');
    }

    public function supportDc()
    {
        return view('pages.support');
    }
    public function spinOffPlan(Request $request)
    {
        $file = \Storage::disk('local')->get('spin-off-plan.pdf');
        return response($file, 200)->header('Content-Type', 'application/pdf');
    }

    public function contractAndNameOfRepresentative(Request $request)
    {
        $file = \Storage::disk('local')->get('contract-and-name-of-representative.pdf');
        return response($file, 200)->header('Content-Type', 'application/pdf');
    }
}
