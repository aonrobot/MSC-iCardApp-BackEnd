<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Adldap\Adldap;

class LDAPController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function checkAuth(Request $request){ // $username, $password

        $user = $request->input('username');
        $pwd = $request->input('password');
        
        // Construct new Adldap instance.
        $ad = new Adldap();

        // Create a configuration array.
        $config = [
            'account_suffix' => "@metrosystems.co.th",
            // The domain controllers option is an array of your LDAP hosts. You can
            // use the either the host name or the IP address of your host.
            'domain_controllers'    => ['metrosystems.co.th',],
            
            // The base distinguished name of your domain.
            'base_dn'               => 'dc=metrosystems,dc=co,dc=th',
            
            // The account to use for querying / modifying LDAP records. This
            // does not need to be an actual admin account. This can also
            // be a full distinguished name of the user account.
            'admin_username'        => 'mis',
            'admin_password'        => 'MSCmis2014',
        ];

        // Add a connection provider to Adldap.
        $ad->addProvider($config);

        try {

            $provider = $ad->connect();

            if ($provider->auth()->attempt($user, $pwd)) {
                return response()->json(['status' => '200', 'event' => 'check AD Auth', 'result' => true], 200);
            } else {
                return response()->json(['status' => '200', 'event' => 'check AD Auth', 'result' => false], 200);
            }
            
        } catch (\Adldap\Auth\BindException $e) {
        
            // There was an issue binding / connecting to the server.
        
        }
    }

    //
}
