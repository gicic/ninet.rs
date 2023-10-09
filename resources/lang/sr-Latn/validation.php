<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Polje :attribute mora biti prihvaćeno.',
    'active_url'           => 'Vrednost polja :attribute nije validan URL.',
    'after'                => 'Vrednost polja :attribute mora biti datum nakon :date.',
    'after_or_equal'       => 'Vrednost polja :attribute mora biti datum nakon ili jednak :date.',
    'alpha'                => 'Vrednost polja :attribute može sadržati samo slova.',
    'alpha_dash'           => 'Vrednost polja :attribute može sadržati samo slova, brojeve i crte.',
    'alpha_num'            => 'Vrednost polja :attribute može sadržati samo slova i brojeve.',
    'array'                => 'Vrednost polja :attribute mora biti niz.',
    'before'               => 'Vrednost polja :attribute mora biti datum pre :date.',
    'before_or_equal'      => 'Vrednost polja :attribute mora biti datum pre ili jednak :date.',
    'between'              => [
        'numeric' => 'Vrednost polja :attribute mora biti između :min i :max.',
        'file'    => 'Vrednost polja :attribute mora biti između :min i :max kilobajta.',
        'string'  => 'Vrednost polja :attribute mora biti između :min i :max karaktera.',
        'array'   => 'Vrednost polja :attribute mora imati :min i :max stavki.',
    ],
    'boolean'              => 'Vrednost polja :attribute mora biti bulova vrednost.',
    'confirmed'            => 'Vrednost polja :attribute potvrde se ne poklapa.',
    'date'                 => 'Vrednost polja :attribute nije validan datum.',
    'date_format'          => 'Vrednost polja :attribute se ne poklapa sa formatom :format.',
    'different'            => 'Vrednost polja :attribute i :other moraju biti različite.',
    'digits'               => 'Vrednost polja :attribute mora imati :digits cifara.',
    'digits_between'       => 'Vrednost polja :attribute mora imati između :min i :max cifara.',
    'dimensions'           => 'Slika :attribute nije validnih dimenzija.',
    'distinct'             => 'Vrednost polja :attribute je duplikat.',
    'email'                => 'Vrednost polja :attribute mora biti validna email adresa.',
    'exists'               => 'Selektovana vrednost :attribute nije validna.',
    'file'                 => 'Vrednost polja :attribute mora biti datoteka.',
    'filled'               => 'Polje :attribute mora imati neku vrednost.',
    'gt'                   => [
        'numeric' => 'Vrednost polja :attribute mora biti veća od :value.',
        'file'    => 'Vrednost polja :attribute mora biti veća od :value kilobajta.',
        'string'  => 'Vrednost polja :attribute mora biti duža od :value karaktera.',
        'array'   => 'Vrednost polja :attribute mora imati više od :value stavki.',
    ],
    'gte'                  => [
        'numeric' => 'Vrednost polja :attribute mora biti veća od ili jednaka :value.',
        'file'    => 'Vrednost polja :attribute mora biti veća od ili jednaka :value kilobajta.',
        'string'  => 'Vrednost polja :attribute mora biti veća od ili jednaka :value karaktera.',
        'array'   => 'Vrednost polja :attribute mora imati :value ili više stavki.',
    ],
    'image'                => 'Polje :attribute mora biti slika.',
    'in'                   => 'Selektovana vrednost polja :attribute nije validna.',
    'in_array'             => 'Vrednost polja :attribute ne postoji u :other.',
    'integer'              => 'Vrednost polja :attribute mora biti ceo broj.',
    'ip'                   => 'Vrednost polja :attribute mora biti validna IP adresa.',
    'ipv4'                 => 'Vrednost polja :attribute mora biti validna IPv4 adresa.',
    'ipv6'                 => 'Vrednost polja :attribute mora biti validna IPv6 adresa.',
    'json'                 => 'Vrednost polja :attribute mora biti validan JSON string.',
    'lt'                   => [
        'numeric' => 'Vrednost polja :attribute mora biti manja od :value.',
        'file'    => 'Vrednost polja :attribute mora biti manja od :value kilobajta.',
        'string'  => 'Vrednost polja :attribute mora biti manja od :value karaktera.',
        'array'   => 'Vrednost polja :attribute mora imati manje od :value stavki.',
    ],
    'lte'                  => [
        'numeric' => 'Vrednost polja :attribute mora biti manja od ili jednaka :value.',
        'file'    => 'Vrednost polja :attribute mora biti manja od ili jednaka :value kilobajta.',
        'string'  => 'Vrednost polja :attribute mora biti manja od ili jednaka :value karaktera.',
        'array'   => 'Vrednost polja :attribute ne sme imati više od :value stavki.',
    ],
    'max'                  => [
        'numeric' => 'Vrednost :attribute ne sme biti veća od :max.',
        'file'    => 'Vrednost :attribute ne sme biti veća od :max kilobytes.',
        'string'  => 'Vrednost :attribute ne sme biti veća od :max characters.',
        'array'   => 'Vrednost :attribute ne može imati više od :max stavki.',
    ],
    'mimes'                => 'Datoteka :attribute mora biti tipa: :values.',
    'mimetypes'            => 'Datoteka :attribute mora biti tipa: :values.',
    'min'                  => [
        'numeric' => 'Vrednost :attribute ne sme biti manja od :min.',
        'file'    => 'Vrednost :attribute ne sme biti manja od :min kilobytes.',
        'string'  => 'Vrednost :attribute ne sme biti manja od :min characters.',
        'array'   => 'Vrednost :attribute ne sme sadrži manje od :min stavki.',
    ],
    'not_in'               => 'Selektovana vrednost polja :attribute nije validna.',
    'not_regex'            => 'Format vrednosti :attribute nije validan.',
    'numeric'              => 'Vrednost :attribute mora biti broj.',
    'present'              => 'Vrednost :attribute mora biti prisutna.',
    'regex'                => 'Format vrednosti :attribute nije validan.',
    'required'             => 'Polje :attribute je obavezno.',
    'required_if'          => 'Polje :attribute je obavezno kada je :other jednako :value.',
    'required_unless'      => 'Vrednost :attribute field is required unless :other is in :values.',
    'required_with'        => 'Vrednost :attribute field is required when :values is present.',
    'required_with_all'    => 'Vrednost :attribute field is required when :values is present.',
    'required_without'     => 'Vrednost :attribute field is required when :values is not present.',
    'required_without_all' => 'Vrednost :attribute field is required when none of :values are present.',
    'same'                 => 'Vrednost :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'Vrednost :attribute mora biti :size.',
        'file'    => 'Vrednost :attribute mora biti :size kilobajta.',
        'string'  => 'Vrednost :attribute mora biti :size karaktera.',
        'array'   => 'Vrednost :attribute mora imati :size stavki.',
    ],
    'string'               => 'Vrednost polja :attribute mora biti tekst.',
    'timezone'             => 'Vrednost polja :attribute mora biti validna vremenska zona.',
    'unique'               => 'Vrednost polja :attribute je zauzeta.',
    'uploaded'             => 'Datoteka :attribute nije uspešno otpremljena.',
    'url'                  => 'Format vrednosti :attribute nije validan.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'g-recaptcha-response' => [
            'required' => 'Molimo Vas verifikujte da niste robot.',
            'captcha'  => 'Greška sa captchom! Pokušajte ponovo kasnije ili kontaktirajte tehničku podršku.',
        ],

        'email' => [
            'required' => 'Email je obavezan.',
            'email'    => 'Email adresa nije validna.',
            'exists'   => 'Nepostojeća email adresa.',
            'unique'   => 'Ova email adresa je već zauzeta.',
        ],

        'password' => [
            'required' => 'Lozinka je obavezna.',
            'wrong'    => 'Pogrešna lozinka.',
        ],

        'terms_and_conditions' => [
            'required' => 'Morate prihvatiti uslove korišćenja.',
        ],

        'payment' => [
            'required' => 'Izaberite jednu od opcija plaćanja.',
        ],

        'user_login_email' => [
            'required' => 'Unesite vašu email adresu.',
            'email'    => 'Email adresa nije validna.',
            'exists'   => 'Korisnik sa ovom email adresom ne postoji.',
        ],

        'user_login_password' => [
            'required' => 'Unesite lozinku.',
        ],

        'user_type_guest' => [
            'required' => 'Tip naručioca je obavezan.',
        ],

        'first_name' => [
            'required' => 'Ime je obavezno.',
            'alpha'    => 'Ime može sadržati samo slova.'
        ],

        'last_name' => [
            'required' => 'Prezime je obavezno.',
            'alpha'    => 'Prezime može sadržati samo slova.'
        ],

        'phone' => [
            'required' => 'Broj telefona je obavezan.',
        ],

        'country' => [
            'required' => 'Izaberite državu.',
        ],

        'city' => [
            'required' => 'Grad je obavezan.',
        ],

        'address' => [
            'required' => 'Adresa je obavezna.',
        ],

        'postal_code' => [
            'required' => 'Poštanski broj je obavezan.',
        ],

        'company_name' => [
            'required' => 'Naziv kompanije je obavezan.',
        ],

        'company_registration_number' => [
            'required' => 'Matični broj kompanije je obavezan.',
        ],

        'company_tax_number' => [
            'required' => 'PIB je obavezan.',
        ],

        'documents.*' => [
            'mimes' => 'Tip datoteke nije validan.',
        ],

        'domain_tlds' => [
            'required' => 'Morate izabrati bar jednu ekstenziju.',
            'min' => 'Morate izabrati bar jednu ekstenziju.'
        ],

        'domain_sld' => [
            'required' => 'Naziv domena je obavezan.',
            'regex' => 'Naziv domena nije validan.',
        ],

        'domain' => [
            'required' => 'Unesite domen',
        ],

        'region' => [
            'required' => 'Unesite naziv regije / provincije',
        ],

        'organizationName' => [
            'required' => 'Unesite naziv organizacije ili ime i prezime',
        ],

        'department' => [
            'required' => 'Unesite odsek organizacije',
        ],

        'ssl_domain' => [
            'required' => 'Unesite domen',
        ],

        'ssl_confirmation_email' => [
            'required' => 'Izaberite email za potvrdu',
            'email' => 'Izaberite email za potvrdu',
        ],

        'ssl_server_platform' => [
            'required' => 'Izaberite tip platforme servera',
        ],

        'ssl_agreed' => [
            'required' => 'Morate se složiti da ste iskopirali CSR i privatni ključ'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'documents.*' => 'Dokumenti',
        'name' => 'Ime i Prezime',
        'company' => 'Firma',
        'subject' => 'Naslov',
        'message' => 'Poruka',
    ],

];
