<?php

use Helper\Api;
class DestinatarioCest
{
    public function _before(ApiTester $I,Api $api)
    {
        $I->wantTo('Login');
        $token = $api->generarToken();
        $I->amBearerAuthenticated($token);
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }
}
