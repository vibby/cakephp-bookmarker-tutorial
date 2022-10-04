<?php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Http\Response;

class DataResetController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Auth->allow('dbReset');
    }

    public function dbReset()
    {
        $conn = ConnectionManager::get('default');
        $conn->execute(file_get_contents(__DIR__.'/../../../config/schema/app.sql'));
        $conn->execute(file_get_contents(__DIR__.'/../../../config/schema/i18n.sql'));
        $conn->execute(file_get_contents(__DIR__.'/../../../config/schema/sessions.sql'));

        return new Response();
    }

    public function isAuthorized()
    {
        return true;
    }
}
