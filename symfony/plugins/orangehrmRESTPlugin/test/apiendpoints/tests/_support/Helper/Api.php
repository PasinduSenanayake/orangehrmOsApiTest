<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Symfony\Component\Yaml\Yaml;
class Api extends \Codeception\Module
{
    public function getIssueToken($I)
    {
        $config = \Codeception\Configuration::config();
        $clientId = $config['extensions']['config']['clientId'];
        $clientSecret = $config['extensions']['config']['clientSecret'];
        $I->wantTo('Get Issue Token');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('oauth/issueToken', ['grant_type' => 'client_credentials', 'client_id' => $clientId, 'client_secret' => $clientSecret]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'expires_in' => 3600,
            'token_type' => 'bearer',
            'scope' => null

        ]);

        return json_decode($I->grabResponse())->access_token;


    }

    public function insertDb($I,$testName){
        $dbData = Yaml::parse(file_get_contents("symfony/plugins/orangehrmRESTPlugin/test/apiendpoints/tests/_data/data.yml"));
        foreach ($dbData[$testName] as $tableName){
            foreach ($tableName[key($tableName)] as $dataRow) {
                $I->haveInDatabase(key($tableName), $dataRow);
            }
        }
    }

    public function deleteFromDatabase($table, $criteria)
    {
        $dbh = $this->getModule('Db')->dbh;
        $query = "delete from %s where %s";
        $params = [];
        foreach ($criteria as $k => $v) {
            $params[] = "$k = ?";
        }
        $params = implode(' AND ', $params);
        $query = sprintf($query, $table, $params);
        $this->debugSection('Query', $query, json_encode($criteria));
        $sth = $dbh->prepare($query);
        return $sth->execute(array_values($criteria));
    }


}
