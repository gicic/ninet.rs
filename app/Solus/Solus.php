<?php

namespace App\Solus;

use App\Password;
use Exception;
use Illuminate\Support\Collection;

class Solus
{
    private $url;
    private $id;
    private $key;

    /**
     * Solus constructor.
     * @param $url
     * @param $id
     * @param $key
     */
    function __construct($url, $id, $key)
    {
        $this->url = $url;
        $this->id = $id;
        $this->key = $key;
    }

    public function getParameters()
    {
        return [
            'url' => $this->url,
            'id' => $this->id,
            'key' => $this->key,
        ];
    }

    /**
     * @param $serverID
     * @param $access
     * @param $time
     * @return mixed
     * @throws Exception
     */
    public function console($serverID, $access, $time)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-console", "vserverid" => $serverID, "access" => $access, "time" => $time));
    }

    /**
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    private function execute(array $params)
    {
        $params["id"] = $this->id;
        $params["key"] = $this->key;
        $params["rdtype"] = "json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . "/command.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception("Error: " . curl_error($ch) . ' ' . curl_errno($ch));
        }
        $response = json_decode($response);
        curl_close($ch);
        if (!empty($response->status) && $response->status === 'error')
            throw new Exception("Service error: " . $response->statusmsg);
        return $response;
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function disableTUN($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-tun-disable", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function enableTUN($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-tun-enable", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @param $pae
     * @return mixed
     * @throws Exception
     */
    public function paestatus($serverID, $pae)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-pae", "vserverid" => $serverID, "pae" => $pae));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function reboot($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-reboot", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function boot($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-boot", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function shutdown($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-shutdown", "vserverid" => $serverID));
    }

    /**
     * @param $type
     * @return mixed
     * @throws Exception
     */
    public function listISO($type)
    {
        if (!in_array($type, array("xen hvm", "kvm", "xen", "openvz")))
            throw new Exception("Invalid Type");
        return $this->execute(array("action" => "listiso", "type" => $type));
    }

    /**
     * @param $serverID
     * @param $iso
     * @return mixed
     * @throws Exception
     */
    public function mountISO($serverID, $iso)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-mountiso", "vserverid" => $serverID, "iso" => $iso));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function unmountISO($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-unmountiso", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @param $bootOrder
     * @return mixed
     * @throws Exception
     */
    public function changeBootOrder($serverID, $bootOrder)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        if (!in_array($bootOrder, array("cd", "dc", "c", "d")))
            throw new Exception("Invalid bootorder");
        return $this->execute(array("action" => "vserver-bootorder", "vserverid" => $serverID, "bootorder" => $bootOrder));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function getVNC($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-vnc", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function getServerInfo($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-info", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @param $nostatus
     * @param $nographs
     * @return mixed
     * @throws Exception
     */
    public function getServerState($serverID, $nostatus, $nographs)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-infoall", "vserverid" => $serverID, "nostatus" => $nostatus, "nographs" => $nographs));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function getServerStatus($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-status", "vserverid" => $serverID));
    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     * @throws Exception
     */
    public function authenticateClient($username, $password)
    {
        if (!ctype_alnum($username))
            throw new Exception("Invalid Username");
        return $this->execute(array("action" => "vserver-authenticate", "username" => $username, "password" => $password));
    }

    /**
     * @param $serverID
     * @param $hostname
     * @return mixed
     * @throws Exception
     */
    public function changeHostname($serverID, $hostname)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        if (!preg_match('/[\w-.]+/', $hostname))
            throw new Exception("Invalid Hostname");
        return $this->execute(array("action" => "vserver-hostname", "vserverid" => $serverID, "hostname" => $hostname));
    }

    /**
     * @param $clientData
     * @return mixed
     * @throws Exception
     */
    public function createClient($clientData)
    {
        $mandatoryFields = ['email', 'firstname', 'lastname'];

        foreach ($mandatoryFields as $field) {
            if (empty($clientData[$field])) throw new Exception("Field {$field} is mandatory");
        }

        return $this->execute([
            'action' => 'client-create',
            'username' => $this->generateUserName($clientData['firstname'], $clientData['lastname']),
            'password' => $clientData['password'] ?? Password::generateStrongPassword(),
            'email' => $clientData['email'],
            'firstname' => $clientData['firstname'],
            'lastname' => $clientData['lastname'],
            'company' => $clientData['company'] ?? null,
        ]);
    }

    /**
     * @param $clientData
     * @return mixed
     * @throws Exception
     */
    public function getByEmailOrCreateNew($clientData)
    {
        $existingClient = $this->getClientByEmail($clientData['email']);
        if(!empty($existingClient)) {
            return $existingClient;
        }

        return $this->createClient($clientData);
    }

    /**
     * @param $email
     * @return null
     * @throws Exception
     */
    public function getClientByEmail($email)
    {
        $clients = $this->listClients();
        foreach ($clients->clients as $client) {
            if ($client->email === $email) {
                return $client;
            }
        }
        return null;
    }

    /**
     * @param $fName
     * @param $lName
     * @return string
     * @throws Exception
     */
    public function generateUserName($fName, $lName)
    {
        $usernames = $this->listUserNames();

        $initial = strtolower($fName . substr($lName, 0, 1));
        $username = $initial;

        $counter = 1;
        while (in_array($username, $usernames)) {
            $username = $initial . (string)$counter;
            $counter++;
        }
        return $username;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function listUserNames()
    {
        $clients = $this->listClients();

        $usernames = [];
        foreach ($clients->clients as $client) {
            $usernames[] = $client->username;
        }
        return $usernames;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function listEmails()
    {
        $clients = $this->listClients();

        $emails = [];
        foreach ($clients->clients as $client) {
            $emails[$client->username] = $client->email;
        }
        return $emails;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function listClients()
    {
        return $this->execute(array("action" => "client-list"));
    }

    /**
     * @param $nodeid
     * @return mixed
     * @throws Exception
     */
    public function listServers($nodeid)
    {
        if (!is_numeric($nodeid))
            throw new Exception("Invalid NodeID");
        return $this->execute(array("action" => "node-virtualservers", "nodeid" => $nodeid));
    }

    /**
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function createVserver($data)
    {

        $usernames = $this->listUserNames();
        if (!in_array($data['username'], $usernames)) throw new Exception("Username {$data['username']} does not exist on solus.");

        $result = $this->execute([
            'action' => 'vserver-create',
            'type' => 'openvz',
            'node' => $data['node'] ?? 'localhost',
            'nodegroup' => $data['nodegroup'] ?? 0,
            'hostname' => $data['hostname'] ?? 'localhost',
            'username' => $data['username'],
            'plan' => $data['plan'],
            'template' => !empty($data['template']) || $data['template'] === '' ? $data['template'] : 'debian-8.0-x86_64-minimal',
            'password' => $data['password'] ?? Password::generateStrongPassword(),
            'ips' => $data['ip_number'] ?? 1,
        ]);

        return $result;
    }

    /**
     * @param string $type
     * @param bool $listpipefriendly
     * @return Collection
     * @throws Exception
     */
    public function listTemplates($type = 'openvz', $listpipefriendly = true)
    {
        if (!in_array($type, array("xen hvm", "kvm", "xen", "openvz")))
            throw new Exception("Invalid Type");
        $result = $this->execute(array("action" => "listtemplates", "type" => $type, "listpipefriendly" => $listpipefriendly));
        $result = explode(',', $result->templates);

        $collection = new Collection();

        foreach ($result as $item) {
            if($item === '--none--') continue;
            $itemParts = explode('|', $item);
            if(count($itemParts) == 1) {
                $collection->push((object)['filename' => $itemParts[0]]);
            } else {
                $collection->push((object)[
                    'filename' => $itemParts[0],
                    'name'     => $itemParts[1],
                ]);
            }
        }
        return $collection;
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function vserverExists($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-checkexists", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @param int $ipv4addr
     * @param int $forceaddip
     * @return mixed
     * @throws Exception
     */
    public function addIP($serverID, $ipv4addr = 0, $forceaddip = 0)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        $args = array(
            "action" => "vserver-addip",
            "vserverid" => $serverID
        );
        if ($ipv4addr) {
            if (filter_var($ipv4addr, FILTER_VALIDATE_IP) === false)
                throw new Exception("Invalid IPv4 Address");
            if (filter_var($forceaddip, FILTER_VALIDATE_BOOLEAN) === false)
                throw new Exception("forceaddip must be boolean");
            $args['ipv4addr'] = $ipv4addr;
            $args['forceaddip'] = $forceaddip;
        }
        return $this->execute($args);
    }

    /**
     * @param $serverID
     * @param $ipaddr
     * @return mixed
     * @throws Exception
     */
    public function deleteIP($serverID, $ipaddr)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        if (filter_var($ipaddr, FILTER_VALIDATE_IP) === false)
            throw new Exception("Invalid IPv4 Address");
        return $this->execute(array("action" => "vserver-delip", "vserverid" => $serverID, "ipaddr" => $ipaddr));
    }

    /**
     * @param $serverID
     * @param $clientID
     * @return mixed
     * @throws Exception
     */
    public function changeOwner($serverID, $clientID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        if (!is_numeric($clientID))
            throw new Exception("Invalid ClientID");
        return $this->execute(array("action" => "vserver-changeowner", "vserverid" => $serverID, "clientid" => $clientID));
    }

    /**
     * @param $serverID
     * @param $plan
     * @param bool $changeHDD
     * @return mixed
     * @throws Exception
     */
    public function changePlan($serverID, $plan, $changeHDD = false)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        if (filter_var($changeHDD, FILTER_VALIDATE_BOOLEAN) === false)
            throw new Exception("changeHDD must be boolean");
        return $this->execute(array("action" => "vserver-change", "vserverid" => $serverID, "plan" => $plan, "changehdd" => $changeHDD));
    }

    /**
     * @param $serverID
     * @param bool $deleteclient
     * @return mixed
     * @throws Exception
     */
    public function terminate($serverID, $deleteclient = false)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        if (filter_var($deleteclient, FILTER_VALIDATE_BOOLEAN) === false)
            throw new Exception("deleteclient must be boolean");
        return $this->execute(array("action" => "vserver-terminate", "vserverid" => $serverID, "deleteclient" => $deleteclient));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function suspend($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-suspend", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @return mixed
     * @throws Exception
     */
    public function unsuspend($serverID)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-unsuspend", "vserverid" => $serverID));
    }

    /**
     * @param $serverID
     * @param $limit
     * @param $overlimit
     * @return mixed
     * @throws Exception
     */
    public function changeBandwidth($serverID, $limit, $overlimit)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        if (!is_numeric($limit))
            throw new Exception("Invalid Limit");
        if (!is_numeric($overlimit))
            throw new Exception("Invalid OverLimit");
        return $this->execute(array("action" => "vserver-bandwidth", "vserverid" => $serverID, "limit" => $limit, "overlimit" => $overlimit));
    }

    /**
     * @param $serverID
     * @param $memory
     * @return mixed
     * @throws Exception
     */
    public function changeMemory($serverID, $memory)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        if (!is_numeric($memory))
            throw new Exception("Invalid Memory");
        return $this->execute(array("action" => "vserver-change-memory", "vserverid" => $serverID, "memory" => $memory));
    }

    /**
     * @param $serverID
     * @param $hdd
     * @return mixed
     * @throws Exception
     */
    public function changeDiskSize($serverID, $hdd)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        if (!is_numeric($hdd))
            throw new Exception("Invalid HDD");
        return $this->execute(array("action" => "vserver-change-hdd", "vserverid" => $serverID, "hdd" => $hdd));
    }

    /**
     * @param $serverID
     * @param $template
     * @return mixed
     * @throws Exception
     */
    public function rebuild($serverID, $template)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-rebuild", "vserverid" => $serverID, "template" => $template));
    }

    /**
     * @param $serverID
     * @param $rootpassword
     * @return mixed
     * @throws Exception
     */
    public function changeRootPassword($serverID, $rootpassword)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-rootpassword", "vserverid" => $serverID, "rootpassword" => $rootpassword));
    }

    /**
     * @param $serverID
     * @param $vncpassword
     * @return mixed
     * @throws Exception
     */
    public function changeVNCpassword($serverID, $vncpassword)
    {
        if (!is_numeric($serverID))
            throw new Exception("Invalid ServerID");
        return $this->execute(array("action" => "vserver-vncpass", "vserverid" => $serverID, "vncpassword" => $vncpassword));
    }

    /**
     * @param $type
     * @return Collection|\Tightenco\Collect\Support\Collection
     * @throws Exception
     */
    public function listPlans($type)
    {
        if (!in_array($type, array("xen hvm", "kvm", "xen", "openvz")))
            throw new Exception("Invalid Type");
        $result = $this->execute(array("action" => "listplans", "type" => $type));

        return collect(explode(',', $result->plans));
    }

    /**
     * @param $type
     * @return mixed
     * @throws Exception
     */
    public function listNodesByID($type)
    {
        if (!in_array($type, array("xen hvm", "kvm", "xen", "openvz")))
            throw new Exception("Invalid Type");
        return $this->execute(array("action" => "node-idlist", "type" => $type));
    }

    /**
     * @param $type
     * @return mixed
     * @throws Exception
     */
    public function listNodesByName($type)
    {
        if (!in_array($type, array("xen hvm", "kvm", "xen", "openvz")))
            throw new Exception("Invalid Type");
        return $this->execute(array("action" => "listnodes", "type" => $type));
    }

    /**
     * @param $nodeid
     * @return mixed
     * @throws Exception
     */
    public function getNodeIPs($nodeid)
    {
        if (!is_numeric($nodeid))
            throw new Exception("Invalid NodeID");
        return $this->execute(array("action" => "node-iplist", "nodeid" => $nodeid));
    }

    /**
     * @param $type
     * @return mixed
     * @throws Exception
     */
    public function listNodeGroups($type)
    {
        if (!in_array($type, array("xen hvm", "kvm")))
            throw new Exception("Invalid Type");
        return $this->execute(array("action" => "listnodegroups", "type" => $type));
    }
}