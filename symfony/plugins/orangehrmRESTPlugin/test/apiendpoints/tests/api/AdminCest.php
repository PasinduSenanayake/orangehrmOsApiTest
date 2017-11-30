<?php


class AdminCest
{
    private $accessToken;
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function getAuthToken(ApiTester $I)
    {
        $this->accessToken = $I->getIssueToken($I);
    }


    public function getUsers(ApiTester $I)
    {

        $I->wantTo('Get OrangeHRM User');
        $I->insertDb($I, "getUsers");
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/user');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data"=> [[

            "userName" => "Admin",
            "userRole" => "Admin",
            "status" => "Enabled",
            "employeeName" => "",
            "employeeId"=> null
        ],
        [
            "userName"=> "Pasindu",
            "userRole"=> "ESS",
            "status"=> "Enabled",
            "employeeName"=> "Pasindu Heshan Senanayake",
            "employeeId"=> "1"
        ]
    ],

        ]);
    }

    public function loginUser(ApiTester $I)
    {

        $I->wantTo('Login User');
        $I->insertDb($I, "loginUser");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('api/v1/login',['username'=>'pasindu','password'=>'1234']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'login' => true,
        ]);
    }

   /* public function getOrganizationInfo(ApiTester $I)
    {

        $I->wantTo('Get OrangeHRM Organization Details');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/organization');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data"=> [[

                "userName" => "Admin",
                "userRole" => "Admin",
                "status" => "Enabled",
                "employeeName" => "",
                "employeeId"=> null
            ],
                [
                    "userName"=> "Pasindu",
                    "userRole"=> "ESS",
                    "status"=> "Enabled",
                    "employeeName"=> "Pasindu Senanayake",
                    "employeeId"=> "1"
                ]
            ],

        ]);
    }*/


}
