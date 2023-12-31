<?php
namespace EppRegistrar\EPP;

class eppConnection {
    /**
     * Hostname of this connection
     * @var string
     */
    protected $hostname = 'localhost';

    /**
     * Port of the connection
     * @var string
     */
    protected $port = 700;

    /**
     * Time-out value for the server connection
     * @var integer
     */
    protected $timeoutServer = 10;
	
	/**
     * Time-out value for the client connection
     * @var integer
     */
    protected $timeout = 20;

    /**
     * Username to be used in the connection
     * @var string
     */
    protected $username = 'username';

    /**
     * Password to be used in the connection
     * @var string
     */
    protected $password = 'password';

    /*
     * New password for password change procedure
     */
    protected $newpassword = null;


    /**
     * Default namespace
     * @var string
     */
    protected $defaultnamespace = array('xmlns' => 'urn:ietf:params:xml:ns:epp-1.0');

    /**
     * Base objects
     * @var array of accepted object URI's
     */
    protected $objuri = array('urn:ietf:params:xml:ns:domain-1.0' => 'domain', 'urn:ietf:params:xml:ns:contact-1.0' => 'contact', 'urn:ietf:params:xml:ns:host-1.0' => 'host');

    /**
     * Object extensions
     * @var array of accepted URI's for each object
     */
    protected $exturi;

    /**
     * Base objects
     * @var array of accepted URI's for xpath
     */
    protected $xpathuri = array('urn:ietf:params:xml:ns:epp-1.0' => 'epp', 'urn:ietf:params:xml:ns:domain-1.0' => 'domain', 'urn:ietf:params:xml:ns:contact-1.0' => 'contact', 'urn:ietf:params:xml:ns:host-1.0' => 'host');

    /**
     * These namespaces are needed in the root of the EPP object
     * @var array of accepted URI's for xpath
     */
    protected $rootspace = array();

    /**
     *
     * @var string language for epp
     */
    protected $language = 'en';

    /**
     *
     * @var string version for epp
     */
    protected $version = '';

    /**
     *
     * @var resource $connection
     */
    protected $connection;

    /**
     *
     * @var boolean $logging
     */
    protected $logging;

    /**
     * Commands and equivalent responses
     * @var array
     */
    protected $responses;

    protected $launchphase = null;

    /**
     * Path to certificate file
     * @var string
     */
    protected $local_cert_path = null;

    /**
     * Password of certificate file
     * @var string
     */
    protected $local_cert_pwd = null;

    /**
     * Allow/Deny self signed certificates
     * @var boolean
     */
    protected $allow_self_signed = null;

    protected $logentries = array();

    function __construct($logging = false, $settingsfile = null) {
        if ($logging) {
            $this->enableLogging();
        }
        #
        # Initialize default values for config parameters
        #
        //$this->language = 'en';
        $this->version = '1.0';
        // Default server configuration stuff - this varies per connected registry
        // Check the greeting of the server to see which of these values you need to add
        $this->setLanguage($this->language);
        $this->setVersion($this->version);
        $this->responses['EppRegistrar\\EPP\\eppHelloRequest'] = 'EppRegistrar\\EPP\\eppHelloResponse';
        $this->responses['EppRegistrar\\EPP\\eppLoginRequest'] = 'EppRegistrar\\EPP\\eppLoginResponse';
        $this->responses['EppRegistrar\\EPP\\eppLogoutRequest'] = 'EppRegistrar\\EPP\\eppLogoutResponse';
        $this->responses['EppRegistrar\\EPP\\eppPollRequest'] = 'EppRegistrar\\EPP\\eppPollResponse';
        $this->responses['EppRegistrar\\EPP\\eppCheckRequest'] = 'EppRegistrar\\EPP\\eppCheckResponse';
        $this->responses['EppRegistrar\\EPP\\eppInfoHostRequest'] = 'EppRegistrar\\EPP\\eppInfoHostResponse';
        $this->responses['EppRegistrar\\EPP\\eppInfoContactRequest'] = 'EppRegistrar\\EPP\\eppInfoContactResponse';
        $this->responses['EppRegistrar\\EPP\\eppInfoDomainRequest'] = 'EppRegistrar\\EPP\\rnidsEppInfoDomainResponse';
        $this->responses['EppRegistrar\\EPP\\eppCreateRequest'] = 'EppRegistrar\\EPP\\eppCreateResponse';
        $this->responses['EppRegistrar\\EPP\\eppCreateDomainRequest'] = 'EppRegistrar\\EPP\\eppCreateResponse';
        $this->responses['EppRegistrar\\EPP\\eppCreateContactRequest'] = 'EppRegistrar\\EPP\\eppCreateResponse';
        $this->responses['EppRegistrar\\EPP\\eppCreateHostRequest'] = 'EppRegistrar\\EPP\\eppCreateResponse';
        $this->responses['EppRegistrar\\EPP\\eppDeleteRequest'] = 'EppRegistrar\\EPP\\eppDeleteResponse';
        $this->responses['EppRegistrar\\EPP\\eppUndeleteRequest'] = 'EppRegistrar\\EPP\\eppUndeleteResponse';
        $this->responses['EppRegistrar\\EPP\\eppUpdateRequest'] = 'EppRegistrar\\EPP\\eppUpdateResponse';
        $this->responses['EppRegistrar\\EPP\\eppUpdateDomainRequest'] = 'EppRegistrar\\EPP\\eppUpdateResponse';
        $this->responses['EppRegistrar\\EPP\\eppUpdateContactRequest'] = 'EppRegistrar\\EPP\\eppUpdateResponse';
        $this->responses['EppRegistrar\\EPP\\eppUpdateHostRequest'] = 'EppRegistrar\\EPP\\eppUpdateResponse';
        $this->responses['EppRegistrar\\EPP\\eppRenewRequest'] = 'EppRegistrar\\EPP\\eppRenewResponse';
        $this->responses['EppRegistrar\\EPP\\eppTransferRequest'] = 'EppRegistrar\\EPP\\eppTransferResponse';
		$this->responses['EppRegistrar\\EPP\\eppInfoContactRequest'] = 'EppRegistrar\\EPP\\rnidsEppInfoContactResponse';

        #
        # Read settings.ini or specified settings file
        #
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $path = str_replace('EppRegistrar\EPP\\',dirname(__FILE__).'\..\..\Registries\\',get_called_class());
        } else {
            $path = str_replace('EppRegistrar\EPP\\',dirname(__FILE__).'/../../Registries/',get_called_class());
        }
        if (!$settingsfile) {
            $settingsfile = 'settings.ini';
        }
        if ($settings = $this->loadSettings($path,$settingsfile)) {
            $this->setHostname($settings['hostname']);
            $this->setUsername($settings['userid']);
            $this->setPassword($settings['password']);
            
            if (array_key_exists('port',$settings)) {
                $this->setPort($settings['port']);
            } else {
                $this->setPort(700);
            }
            if (array_key_exists('certificatefile',$settings) && array_key_exists('certificatepassword',$settings)) {
                // Enter the path to your certificate and the password here
                $this->enableCertification($path . '/' . $settings['certificatefile'], $settings['certificatepassword'], $settings['cafile'], $settings['peername']);
            }
        }
    }

    function __destruct() {
        //echo "\nMemory usage: ".memory_get_usage()." bytes \n";
        //echo "Peak memory usage: ".memory_get_peak_usage()." bytes \n\n";
        if ($this->logging) {
            $this->showLog();
        }
    }

    public function enableLaunchphase($launchphase) {
        $this->launchphase = $launchphase;
        $this->addExtension('launch','urn:ietf:params:xml:ns:launch-1.0');
        $this->responses['EppRegistrar\\EPP\\eppLaunchCheckRequest'] = 'EppRegistrar\\EPP\\eppLaunchCheckResponse';
        $this->responses['EppRegistrar\\EPP\\eppLaunchCreateDomainRequest'] = 'EppRegistrar\\EPP\\eppLaunchCreateDomainResponse';
    }

    public function getLaunchphase() {
        return $this->launchphase;
    }

    public function enableDnssec() {
        $this->addExtension('secDNS','urn:ietf:params:xml:ns:secDNS-1.1');
        $this->responses['EppRegistrar\\EPP\\eppDnssecUpdateDomainRequest'] = 'EppRegistrar\\EPP\\eppUpdateDomainResponse';
    }

    public function enableRgp() {
        $this->addExtension('rgp','urn:ietf:params:xml:ns:rgp-1.0');
    }

    public function disableRgp() {
        $this->removeExtension('urn:ietf:params:xml:ns:rgp-1.0');
    }

    public function disableDnssec() {
        $this->removeExtension('urn:ietf:params:xml:ns:secDNS-1.1');
        unset($this->responses['EppRegistrar\\EPP\\eppDnssecUpdateDomainRequest']);
    }

    public function enableCertification($certificatepath, $certificatepassword, $cafile, $peername, $selfsigned = false) {
        $this->local_cert_path = $certificatepath;
        $this->local_cert_pwd = $certificatepassword;
        $this->allow_self_signed = $selfsigned;
		$this->local_cafile = $cafile;
		$this->local_peer_name = $peername;
    }

    public function disableCertification() {
        $this->local_cert_path = null;
        $this->local_cert_pwd = null;
        $this->allow_self_signed = null;
		$this->local_cafile = null;
		$this->local_peer_name = null;
    }


    /**
     * Disconnects if connected
     * @return boolean
     */
    public function disconnect() {
        if (is_resource($this->connection)) {
            //echo "Fclosing $this->hostname\n";
            @ob_flush();
            fclose($this->connection);
        }
        return true;
    }

    /**
     * Connect to the address and port
     * @param string $address
     * @param int $port
     * @return boolean
     */
    public function connect($hostname = null, $port = null) {
        if ($hostname) {
            $this->hostname = $hostname;
        }
        if ($port) {
            $this->port = $port;
        }
        if ($this->local_cert_path) {
            $ssl = true;
            $target = sprintf('%s://%s:%d', ($ssl === true ? 'ssl' : 'tcp'), $this->hostname, $this->port);
            $errno = '';
            $errstr = '';
            $context = stream_context_create();
			if ($this->local_cafile)
			{
				stream_context_set_option($context, 'ssl', 'cafile', $this->local_cafile);
			}
			if ($this->local_peer_name)
			{
				stream_context_set_option($context, 'ssl', 'peer_name', $this->local_peer_name);
			}
            
            stream_context_set_option($context, 'ssl', 'local_cert', $this->local_cert_path);
            stream_context_set_option($context, 'ssl', 'passphrase', $this->local_cert_pwd);
            stream_context_set_option($context, 'ssl', 'allow_self_signed', $this->allow_self_signed);
            if ($this->connection = stream_socket_client($target, $errno, $errstr, $this->timeoutServer, STREAM_CLIENT_CONNECT, $context)) {
				$this->writeLog("Connection made","CONNECT");
                return true;
            } else {
                throw new eppException("Error connecting to $target: $errstr (code $errno)");
            }
        } else {
            //We don't want our error handler to kick in at this point...
            putenv('SURPRESS_ERROR_HANDLER=1');
            #echo "Connecting: $this->hostname:$this->port\n";
            #$this->writeLog("Connecting: $this->hostname:$this->port");
            $this->connection = fsockopen($this->hostname, $this->port, $errno, $errstr, $this->timeoutServer);
            putenv('SURPRESS_ERROR_HANDLER=0');
            if (is_resource($this->connection)) {
                $this->writeLog("Connection made","CONNECT");
                stream_set_blocking($this->connection, false);
                stream_set_timeout($this->connection, $this->timeout);
                if ($errno == 0) {
					return true;
                } else {
                    return false;
                }
            } else {
                $this->writeLog("Connection could not be opened: $errno $errstr","ERROR");
                return false;
            }
        }
    }


    /**
     * This will read 1 response from the connection
     * @return string
     */
    public function read() {
        putenv('SURPRESS_ERROR_HANDLER=1');
        $content = '';
        $time = time() + $this->timeout;
        $read = "";
        while ((!isset ($length)) || ($length > 0)) {
            if (feof($this->connection)) {
                putenv('SURPRESS_ERROR_HANDLER=0');
                throw new eppException ('Unexpected closed connection by remote host...');
            }
            //Check if timeout occured
            if (time() >= $time) {
                putenv('SURPRESS_ERROR_HANDLER=0');
                return false;
            }
            //If we dont know how much to read we read the first few bytes first, these contain the content-length
            //of whats to come
            if ((!isset($length)) || ($length == 0)) {
                $readLength = 4;
                $readbuffer = "";
                $read = "";
                while ($readLength > 0) {
                    if ($readbuffer = fread($this->connection, $readLength)) {
                        $readLength = $readLength - strlen($readbuffer);
                        $read .= $readbuffer;
                    }
                    //Check if timeout occured
                    if (time() >= $time) {
                        putenv('SURPRESS_ERROR_HANDLER=0');
                        return false;
                    }
                }
                $this->writeLog("Read 4 bytes for integer. (read: " . strlen($read) . "):$read","READ");
                $length = $this->readInteger($read) - 4;
                $this->writeLog("Reading next: $length bytes","READ");
            }
            if ($length > 1000000) {
                throw new eppException("Packet size is too big: $length. Closing connection");
            }
            //We know the length of what to read, so lets read the stuff
            if ((isset($length)) && ($length > 0)) {
                $time = time() + $this->timeout;
                if ($read = fread($this->connection, $length)) {
                    //$this->writeLog(print_R(socket_get_status($this->connection), true));
                    $length = $length - strlen($read);
                    $content .= $read;
                }
                if (strpos($content, 'Session limit exceeded') > 0) {
                    $read = fread($this->connection, 4);
                    $content .= $read;
                }
            }
            if (!strlen($read)) {
                usleep(100);
            }
        }
        putenv('SURPRESS_ERROR_HANDLER=0');
        #ob_flush();
        return $content;
    }

    /**
     * This parses the first 4 bytes into an integer for use to compare content-length
     *
     * @param string $content
     * @return integer
     */
    private function readInteger($content) {
        $int = unpack('N', substr($content, 0, 4));
        return $int[1];
    }

    /**
     * This adds the content-length to the content that is about to be written over the EPP Protocol
     *
     * @param string $content Your XML
     * @return string String to write
     */
    private function addInteger($content) {
        $int = pack('N', intval(strlen($content) + 4));
        return $int . $content;
    }

    /**
     * Write stuff over the EPP connection
     * @param string $content
     * @return boolean
     */
    public function write($content) {
        $this->writeLog("Writing: " . strlen($content) . " + 4 bytes","WRITE");
        $content = $this->addInteger($content);
        if (!is_resource($this->connection)) {
            throw new eppException ('Writing while no connection is made is not supported.');
        }

        putenv('SURPRESS_ERROR_HANDLER=1');
        #ob_flush();
        if (fwrite($this->connection, $content)) {
            //fpassthru($this->connection);
            putenv('SURPRESS_ERROR_HANDLER=0');
            return true;
        }
        putenv('SURPRESS_ERROR_HANDLER=0');
        return false;
    }

    /**
     * Write the content domDocument to the stream
     * Read the answer
     * Load the answer in a response domDocument
     * return the reponse
     *
     * @param eppRequest $content
     * @return eppResponse
     * @throws eppException
     */
    public function writeandread($content) {
        $requestsessionid = $content->getSessionId();
        $namespaces = $this->getDefaultNamespaces();
        if (is_array($namespaces)) {
            foreach ($namespaces as $id => $namespace) {
                $content->addExtension($id, $namespace);
            }
        }
        /*
         * $content->login is only set if this is an instance or a sub-instance of an eppLoginRequest
         */
        if ($content->login) {
            /* @var $content eppLoginRequest */
            // Set username for login request
            $content->addUsername($this->getUsername());
            // Set password for login request
            $content->addPassword($this->getPassword());
            // Set 'new password' for login request
            if ($this->getNewPassword()) {
                $content->addNewPassword($this->getNewPassword());
            }
            // Add version to this object
            $content->addVersion($this->getVersion());
            // Add language to this object
            $content->addLanguage($this->getLanguage());
            // Add services and extensions to this content
            $content->addServices($this->getServices(), $this->getExtensions());
        }
        /*
         * $content->hello is only set if this is an instance or a sub-instance of an eppHelloRequest
         */
        if (!($content->hello)) {
            /**
             * Add used namespaces to the correct places in the XML
             */
            $content->addNamespaces($this->getServices());
            $content->addNamespaces($this->getExtensions());
        }
        $response = $this->createResponse($content);
        /* @var $response /domDocument */
        if (!$response) {
            throw new eppException("No valid response from server");
        }
        $content->formatOutput = true;
        $this->writeLog($content->saveXML(null, LIBXML_NOEMPTYTAG),"WRITE");
        $content->formatOutput = false;
        if ($this->write($content->saveXML(null, LIBXML_NOEMPTYTAG))) {
            $xml = $this->read();
            if (strlen($xml)) {
				//var_dump($xml);
                if ($response->loadXML($xml)) {
                    $this->writeLog($response->saveXML(null, LIBXML_NOEMPTYTAG),"READ");
                    /*
                    ob_flush();
                    */
                    $clienttransid = $response->getClientTransactionId();
                    if (($clienttransid) && ($clienttransid != $requestsessionid)) {
                        throw new eppException("Client transaction id $requestsessionid does not match returned $clienttransid\nMessage: ".$xml);
                    }
                    $response->setXpath($this->getServices());
                    $response->setXpath($this->getExtensions());
                    $response->setXpath($this->getXpathExtensions());
                    if ($response instanceof eppHelloResponse) {
                        $response->validateServices($this->getLanguage(), $this->getVersion(), $this->getServices(), $this->getExtensions());
                    }
                    return $response;
                }
            } else {
                throw new eppException('Empty XML document when receiving data!');
            }
        } else {
            throw new eppException('Error writing content');
        }
        return null;
    }

    public function createResponse($request) {
        $response = new eppResponse();
        foreach ($this->responses as $req => $res) {
            if ($request instanceof $req) {
                $response = new $res();
            }
        }
        return $response;
    }

    public function addCommandResponse($command, $response) {
        $this->responses[$command] = $response;
    }

    public function getTimeout() {
        return $this->timeout;
    }

    public function setTimeout($timeout) {
        $this->timeout = $timeout;
    }
	
	public function getTimeoutServer() {
        return $this->timeoutServer;
    }

    public function setTimeoutServer($timeoutServer) {
        $this->timeoutServer = $timeoutServer;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getNewPassword() {
        return $this->newpassword;
    }

    public function setNewPassword($password) {
        $this->newpassword = $password;
    }

    public function getHostname() {
        return $this->hostname;
    }

    public function setHostname($hostname) {
        $this->hostname = $hostname;
    }

    public function getPort() {
        return $this->port;
    }

    public function setPort($port) {
        $this->port = $port;
    }


    public function addDefaultNamespace($xmlns, $namespace) {
        $this->defaultnamespace[$namespace] = 'xmlns:' . $xmlns;
    }

    public function getDefaultNamespaces() {
        return $this->defaultnamespace;
    }

    public function setVersion($version) {
        $this->version = $version;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setServices($services) {
        $this->objuri = $services;
    }

    public function addService($xmlns, $namespace) {
        $this->objuri[$xmlns] = $namespace;
    }

    public function getServices() {
        return $this->objuri;
    }

    public function setExtensions($extensions) {
        // Remove unusable extensions from the list
        $this->exturi = $extensions;
    }

    public function addExtension($xmlns, $namespace) {
        $this->exturi[$namespace] = $xmlns;
        // Include the extension data, request and response files
        $pos = strrpos($namespace,'/');
        if ($pos!==false) {
            $path = substr($namespace,$pos+1,999);
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $includepath = dirname(__FILE__).'\\eppExtensions\\'.$path.'\\includes.php';
            } else {
                $includepath = dirname(__FILE__).'/eppExtensions/'.$path.'/includes.php';
            }

        } else {
            $pos = strrpos($namespace,':');
            if ($pos!==false) {
                $path = substr($namespace,$pos+1,999);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $includepath = dirname(__FILE__).'\\eppExtensions\\'.$path.'\\includes.php';
                } else {
                    $includepath = dirname(__FILE__).'/eppExtensions/'.$path.'/includes.php';
                }

            } else {
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $includepath = dirname(__FILE__).'\\eppExtensions\\'.$namespace.'\\includes.php';
                } else {
                    $includepath = dirname(__FILE__).'/eppExtensions/'.$namespace.'/includes.php';
                }

            }
        }
        if (is_file($includepath)) {
            include_once($includepath);
        }
    }

    public function removeExtension($namespace) {
        unset($this->exturi[$namespace]);
    }

    public function getExtensions() {
        return $this->exturi;
    }

    public function setXpathExtensions($extensions) {
        $this->xpathuri = $extensions;
    }

    public function getXpathExtensions() {
        return $this->xpathuri;
    }

    private function enableLogging() {
        date_default_timezone_set("Europe/Belgrade");
        $this->logging = true;
    }

    private function sendLog($email, $subject) {
        mail($email, $subject, implode("\n", $this->logentries));
    }

    protected function loadSettings($directory, $settingsfile) {
        $result = array();
        if (is_readable($directory . '/'.$settingsfile)) {
            $settings = file($directory . '/'.$settingsfile, FILE_IGNORE_NEW_LINES);
            foreach ($settings as $setting) {
                list($param, $value) = explode('=', $setting);
                $result[$param] = $value;
            }
            return $result;
        }
        return null;
    }

    private function showLog() {
        echo "==== LOG ====";
        if (property_exists($this, 'logentries')) {
            foreach ($this->logentries as $logentry) {
                echo $logentry . "\n";
            }
        }
    }

    protected function writeLog($text,$action) {
        if ($this->logging) {
            //echo "-----".date("Y-m-d H:i:s")."-----".$text."-----end-----\n";
            $this->logentries[] = "-----" . $action . "-----" . date("Y-m-d H:i:s") . "-----\n" . $text . "\n-----END-----" . date("Y-m-d H:i:s") . "-----\n";
        }
    }
}
