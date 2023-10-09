<?php


namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\Customers\Customers;
use App\Services\Orders\Orders;
use Illuminate\Http\Request;

class MedianisController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        return view('medianis.index', compact('countries'));
    }

    public function store(Request $request)
    {
        $data = Orders::create($request);

        if ($data){
            if ($data->success) {
                return redirect()->back()->with('flash-success', trans('Na vašu e-mail adresu' . ' ' . $request->email . ' ' .  'poslat je link za verifikaciju podataka. Verifikacija putem linka je OBAVEZNA (proverite spam/junk folder).'));
            }
            else{
                return redirect()->back()->with('flash-danger', trans('Došlo je do greške prilikom registracije naloga!'))->withErrors($data->errors)->withInput();
            }
        }
       else{
           return redirect()->back()->with('flash-danger', trans('Došlo je do greške prilikom registracije naloga!'))->withInput();
       }
    }

    public function verifyEmail($encrypted)
    {
        $data = Customers::verifyEmail($encrypted);
        $status = $data->success;
        $email = $data->email ?? false;

        return view('medianis.verify-email', compact('status', 'email'));
    }
}