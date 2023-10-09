<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormDC;
use Illuminate\Http\Request;

class DcPageController extends Controller
{
    public function aboutUs(Request $request)
    {
        return view('pages-dc.about');
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


            if($request->subject == 'DC-problem sa hostingom, serverom, domenom, SSL sertifikatom'){
                \Mail::to('helpdesk@webglobe.rs')->send(new ContactFormDC($request->all()));
            }
            elseif($request->subject == 'DC-želim Reseller saradnju' || $request->subject == 'DC-potrebno mi je više informacija i detalja' || $request->subject == 'DC-zaposli se u Webglobu' || $request->subject == 'DC-želim da postanem DC korisnik'){
                \Mail::to('helpdesk@webglobe.rs')->send(new ContactFormDC($request->all()));
            }

            return redirect()->back()->with('flash-success', __('main.contact_form_submitted'));
        }

        return view('pages-dc.contact');
    }

    public function news(Request $request)
    {
        return view('pages-dc.news');
    }

    public function newsSingle(Request $request)
    {
        return view('pages-dc.news-single');
    }

    public function privacyPolicy(Request $request)
    {
        return view('pages-dc.privacy-policy');
    }

    public function termsAndConditions(Request $request)
    {
        return view('pages-dc.terms-and-conditions');
    }

    public function paymentAndRefundPolicy(Request $request)
    {
        return view('pages-dc.payment-and-refund-policy');
    }

    public function deliveryPolicy(Request $request)
    {
        return view('pages-dc.delivery-policy');
    }

    public function support()
    {
        return view('pages-dc.support');
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

    public function upcomingPriceChange()
    {
        return view('pages-dc.price-change-gtld');
    }
}
