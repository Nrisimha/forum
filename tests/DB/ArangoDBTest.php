<?php

namespace Tests\DB;
use Tests\DB\GenericModel;
use triagens\ArangoDb\Document;

use triagens\ArangoDb\Connection;
use triagens\ArangoDb\ConnectionOptions;
use triagens\ArangoDb\UpdatePolicy;

/**
 * Class UnitTest
 */
class ArangoTest extends \UnitTestCase
{
    public function test_IsThere()
    {
        $usermodel = new GenericModel($this->connection());

        $this->assertEquals(
            true,
            $usermodel->isThere('data','exist'),
            "Pharango isThere function failed to produce TRUE"
        );

        $this->assertEquals(
            false,
            $usermodel->isThere('data','not_exist'),
            "Pharango isThere function failed to produce FALSE"
        );
    }

    public function test_findOne(){
        $model = new GenericModel($this->connection());

        $model->findOne(['data'=>'not_exist']);

        $this->assertEquals(
            null,
            $model->get('name'),
            "Pharango findOne not returned null for not existed record"
        );

        $model->findOne(['data'=>'exist']);
        
        $this->assertEquals(
            "Cake",
            $model->get('name'),
            "Pharango findOne not returned data"
        );
    }

    private function connection() {
        $connectionOptions = array(
            ConnectionOptions::OPTION_ENDPOINT => 'tcp://127.0.0.1:8529',
            ConnectionOptions::OPTION_AUTH_TYPE => 'Basic', // only option is Basic
            ConnectionOptions::OPTION_AUTH_USER => 'root',
            ConnectionOptions::OPTION_AUTH_PASSWD => '',
            ConnectionOptions::OPTION_CONNECTION => 'Keep-Alive', // Close or Keep-Alive
            ConnectionOptions::OPTION_TIMEOUT => 3, // seconds
            ConnectionOptions::OPTION_RECONNECT => true,
            // optionally create new collections when inserting documents
            ConnectionOptions::OPTION_CREATE => true,
            ConnectionOptions::OPTION_UPDATE_POLICY => UpdatePolicy::LAST,
        );
    return new Connection($connectionOptions);
    }
}