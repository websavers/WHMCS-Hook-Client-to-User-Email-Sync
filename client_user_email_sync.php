<?php
if (!defined('WHMCS')) {
        exit('This file cannot be accessed directly');
}

use WHMCS\Authentication\CurrentUser;
use WHMCS\Session;

add_hook('UserEdit', 5, 'sync_user_to_client');
add_hook('ClientEdit', 5, 'sync_client_to_user');

function sync_user_to_client($vars) {

    $newmail=$vars['email'];
    $oldmail=$vars['olddata']['email'];

    // check to see if email address updated
    if ($newmail != $oldmail) {
        //find the client account
        $api_updateclient = localAPI('UpdateClient', array(
            'clientemail' => $oldmail,
            'email' => $newmail,
        ));
        if ($api_updateclient['result']=="success") {
            logActivity("Sync User to Client Update - Client ID  {$api_updateclient['clientid']} updated email from $oldmail to $newmail");
        }
    }
}

function sync_client_to_user($vars) {
    
    $newmail=$vars['email'];
    $oldmail=$vars['olddata']['email'];

    // check to see if email address updated
    if ($newmail != $oldmail) {

        // Ensure the user logged in is the owner of the account
        $user = CurrentUser::user();
        $client = CurrentUser::client();
        if ($user && $client && $user->isOwner($client)) {

            // find the user account
            $api_getusers = localAPI('GetUsers', array('search' => $oldmail));
            $user_id = $api_getusers['users'][0]['id'];

            if ($user_id == Session::get('uid')){
                $api_updateuser = localAPI('UpdateUser', array(
                    'user_id' => $user_id,
                    'email' => $newmail,
                ));
                if ($api_updateuser['result']=="success") {
                    logActivity("Sync Client to User Update - User ID  $user_id updated email from $oldmail to $newmail");
                }
            }
        }
    
    }



}