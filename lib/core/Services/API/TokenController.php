<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER['SCRIPT_NAME'], basename(__FILE__)) !== false) {
    header('location: index.php');
    exit;
}

class Services_API_TokenController
{
    private $lib;

    public function setUp()
    {
        Services_Exception_Denied::checkGlobal('admin');
        $this->lib = TikiLib::lib('api_token');
    }

    public function action_list()
    {
        $tokens = $this->lib->getTokens(['type' => 'manual']);
        return [
            'title' => '',
            'tokens' => $tokens,
        ];
    }

    public function action_new($input)
    {
        return [
            'title' => tr('New API Token'),
            'modal' => $input->modal->int(),
        ];
    }

    public function action_create($input)
    {
        $user = $this->get_user_from_input($input);
        $expireAfter = $input->expireAfter->int();

        $util = new Services_Utilities();
        if (! $util->isActionPost()) {
            throw new Services_Exception_Denied();
        }

        $token = $this->lib->createToken([
            'type' => 'manual',
            'user' => $user,
            'expireAfter' => $expireAfter,
        ]);

        Feedback::success(tr('New API token successfully created.'));

        return $token;
    }

    public function action_edit($input)
    {
        $token = $this->lib->getToken($input->tokenId->int());
        return [
            'title' => tr('Edit API Token'),
            'token' => $token,
            'modal' => $input->modal->int(),
        ];
    }

    public function action_update($input)
    {
        $token = $this->lib->getToken($input->tokenId->int());

        $user = $this->get_user_from_input($input);
        $expireAfter = $input->expireAfter->int();

        $util = new Services_Utilities();
        if (! $util->isActionPost()) {
            throw new Services_Exception_Denied();
        }

        if (empty($token)) {
            throw new Services_Exception_NotFound();
        }

        $token = $this->lib->updateToken($token['tokenId'], [
            'user' => $user,
            'expireAfter' => $expireAfter,
        ]);

        Feedback::success(tr('API token successfully updated.'));

        return $token;
    }

    public function action_delete($input)
    {
        $tokenId = $input->tokenId->int();
        $this->lib->deleteToken($tokenId);
        return [
            'status' => 'OK',
        ];
    }

    private function get_user_from_input($input)
    {
        $users = TikiLib::lib('user')->extract_users($input->user->text(), false);
        return $users[0] ?? null;
    }
}
