<?php
namespace EppRegistrar\EPP;

class rnidsEppConnection extends eppConnection
{
    public function __construct($logging = false, $settingsfile = null)
    {
        // Construct the EPP connection object en specify if you want logging on or off
        parent::__construct($logging, $settingsfile);
        
//        $production = true;
        
        $local_cert = __DIR__ . '/../../eppcert.pem';
        $passphrase = 'Ui#96Mz$';
        $cafile     = __DIR__ . '/../../certnew.pem';
        parent::enableCertification($local_cert, $passphrase, $cafile, '*.rnids.rs');

        parent::setHostname(config('services.rnids.hostname'));
        parent::setUsername(config('services.rnids.username'));
        parent::setPassword(config('services.rnids.password'));
        parent::setPort(config('services.rnids.port'));
		
        // Default server configuration stuff - this varies per connected registry
        parent::addExtension('domain-rnids-ext', 'http://www.rnids.rs/epp/xml/rnids-1.0');
        parent::addExtension('contact-rnids-ext', 'http://www.rnids.rs/epp/xml/rnids-1.0');
        parent::addCommandResponse('EppRegistrar\EPP\rnidsEppCreateContactRequest', 'EppRegistrar\EPP\eppCreateResponse'); 
        parent::addCommandResponse('EppRegistrar\EPP\eppInfoContactRequest', 'EppRegistrar\EPP\rnidsEppInfoContactResponse');
        parent::addCommandResponse('EppRegistrar\EPP\rnidsEppUpdateContactRequest', 'EppRegistrar\EPP\eppUpdateContactResponse');
    }
}