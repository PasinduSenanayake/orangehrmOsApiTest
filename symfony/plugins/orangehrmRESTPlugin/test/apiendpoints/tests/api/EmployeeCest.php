<?php


class EmployeeCest
{
    private $accessToken;

    public function _before(ApiTester $I)
    {

    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    /*public function getIssueToken(ApiTester $I)
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
        $this->accessToken = json_decode($I->grabResponse())->access_token;
    }


    /* public function saveEmployee(ApiTester $I)
     {
         $I->wantTo('Test Add Employee');
         $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
         $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
         $I->amBearerAuthenticated($this->accessToken);
         $I->sendPOST('api/v1/employee/1', ['firstName' => 'FirstNameTest', 'middleName' => 'MiddleNameTest', 'lastName' => 'LastNameTest']);
         $I->seeResponseCodeIs(200);
         $I->seeResponseIsJson();
         $I->seeResponseContainsJson([
             "success" => "Successfully Saved",
         ]);
         $I->seeInDatabase('hs_hr_employee', array('emp_lastname' => 'LastNameTest', 'emp_firstname' => 'FirstNameTest', 'emp_middle_name' => 'MiddleNameTest'));
     }

     public function getEmployee(ApiTester $I)
     {
         $I->wantTo('Test Get Employee');
         $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
         $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
         $I->amBearerAuthenticated($this->accessToken);
         $I->sendGET('api/v1/employee/1');
         $I->seeResponseCodeIs(200);
         $I->seeResponseIsJson();
         $I->seeResponseContainsJson([
             "data" => [
                 "firstName" => "Pasindu",
                 "middleName" => "TestMiddle",
                 "lastName" => "Senanayake",
                 "code" => "0001",
                 "employeeId" => "1",
                 "fullName" => "Pasindu TestMiddle Senanayake",
                 "status" => null,
                 "dob" => null,
                 "driversLicenseNumber" => "",
                 "licenseExpiryDate" => null,
                 "maritalStatus" => null,
                 "gender" => null,
                 "otherId" => "",
                 "nationality" => null,
                 "unit" => null,
                 "jobTitle" => null,
                 "supervisor" => null
             ]
         ]);
     }

     public function updateEmployee(ApiTester $I)
     {
         $I->wantTo('Test Update Employee');
         $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
         $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
         $I->amBearerAuthenticated($this->accessToken);
         $I->sendPUT('api/v1/employee/1',['middleName'=>'TestMiddle']);
         $I->seeResponseCodeIs(200);
         $I->seeResponseIsJson();
         $I->seeResponseContainsJson([
             "success" => "Successfully Updated",
         ]);
         $I->seeInDatabase('hs_hr_employee', array('emp_lastname' => 'Senanayake', 'emp_firstname' => 'Pasindu', 'emp_middle_name' => 'TestMiddle'));

     }

     public function terminateEmployee(ApiTester $I)
     {
         $I->wantTo('Test Terminate Employee');
         $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
         $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
         $I->amBearerAuthenticated($this->accessToken);
         $I->sendPOST('api/v1/employee/7/action/terminate',['date'=>'2005-12-30','reason'=>'Other','note'=>'optional Note']);
         $I->seeResponseCodeIs(200);
         $I->seeResponseIsJson();
         $I->seeResponseContainsJson([
             "success" => "Successfully Terminated",
         ]);

     }

    public function searchEmployee(ApiTester $I)
    {
        $I->wantTo('Test Search Employee');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/employee/search');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data" => [
                "firstName" => "Pasindu",
                "middleName" => "TestMiddle",
                "lastName" => "Senanayake",
                "code" => "0001",
                "employeeId" => "1",
                "fullName" => "Pasindu TestMiddle Senanayake",
                "status" => null,
                "dob" => null,
                "driversLicenseNumber" => "",
                "licenseExpiryDate" => null,
                "maritalStatus" => null,
                "gender" => null,
                "otherId" => "",
                "nationality" => null,
                "unit" => null,
                "jobTitle" => null,
                "supervisor" => null
            ]
        ]);
    }

    public function getEmployeeContactDetails(ApiTester $I)
    {
        $I->wantTo('Test get Employee Contact Details');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/employee/1/contact-detail');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data" => [
                "id" => "1",
                "code" => "0001",
                "fullName" => "Pasindu TestMiddle Senanayake",
                "addressStreet1" => "",
                "addressStreet2" => "",
                "city" => "",
                "state" => "",
                "zip" => null,
                "county" => "",
                "homeTelephone" => null,
                "workTelephone" => null,
                "mobile" => null,
                "workEmail" => null,
                "otherEmail" => null
            ]
        ]);
    }

    public function saveEmployeeContactDetails(ApiTester $I)
     {
         $I->wantTo('Test Save Employee Contact Details');
         $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
         $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
         $I->amBearerAuthenticated($this->accessToken);
         $I->sendPOST('api/v1/employee/1/contact-detail', ['addressStreet1' => 'TestAddress1', 'addressStreet2' => 'TestAddress2', 'city' => 'TestCity'
                                                                , 'state' => 'TestState','zip' => 'TestZip','workEmail'=>'pasinduath@gmail.com']);
         $I->seeResponseCodeIs(200);
         $I->seeResponseIsJson();
         $I->seeResponseContainsJson([
             "success" => "Successfully Saved",
         ]);
         $I->seeInDatabase('hs_hr_employee', array('emp_lastname' => 'Senanayake', 'emp_firstname' => 'Pasindu', 'emp_middle_name' => 'TestMiddle','emp_street1' =>'TestAddress1', 'emp_street2' => 'TestAddress2', 'city_code' => 'TestCity'
         , 'provin_code' => 'TestState','emp_zipcode' => 'TestZip',
             'emp_work_email'=>'pasinduath@gmail.com'));
     }

    public function updateEmployeeContactDetails(ApiTester $I)
    {
        $I->wantTo('Test Update Employee Contact Details');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPUT('api/v1/employee/1/contact-detail', ['addressStreet1' => 'TestAddress1', 'addressStreet2' => 'TestAddress2', 'city' => 'TestCity'
            , 'state' => 'TestState','zip' => 'TestZip','workEmail'=>'pasinduath@gmail.com']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Updated",
        ]);
        $I->seeInDatabase('hs_hr_employee', array('emp_lastname' => 'Senanayake', 'emp_firstname' => 'Pasindu', 'emp_middle_name' => 'TestMiddle','emp_street1' =>'TestAddress1', 'emp_street2' => 'TestAddress2', 'city_code' => 'TestCity'
        , 'provin_code' => 'TestState','emp_zipcode' => 'TestZip',
            'emp_work_email'=>'pasinduath@gmail.com'));
    }

    public function getEmployeeDependencies(ApiTester $I)
    {
        $I->wantTo('Test Get Employee Dependencies');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/employee/1/dependent');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data"=> [
                [
                "name"=> "TestName",
            "relationship"=> "TestRelationShip",
            "dob"=> "2009-09-02",
            "sequenceNumber"=> "2"
                    ],
                [
            "name"=> "TestName",
            "relationship"=> "TestRelationShip",
            "dob"=> "2009-09-02",
            "sequenceNumber"=> "3"
                ],
                ]
        ]);

    }

    public function saveEmployeeDependencies(ApiTester $I)
    {
        $I->wantTo('Test Save Employee Dependencies');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('api/v1/employee/1/dependent',['name'=>'TestName','relationship'=>'TestRelationShip','dob'=>'2009-09-02']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
                    "success" => "Successfully Saved",
        ]);
        $I->seeInDatabase('hs_hr_emp_dependents', array('emp_number' => '1', 'ed_seqno' => '2', 'ed_name' => 'TestName','ed_relationship'=>'TestRelationShip','ed_date_of_birth'=>'2009-09-02'));

    }


    public function putEmployeeDependencies(ApiTester $I)
    {
        $I->wantTo('Test Update Employee Dependencies');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPUT('api/v1/employee/1/dependent',['name'=>'TestName','relationship'=>'TestRelationShip','dob'=>'2009-09-02','sequenceNumber'=>'2']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Updated",
        ]);
        $I->seeInDatabase('hs_hr_emp_dependents', array('emp_number' => '1', 'ed_seqno' => '2', 'ed_name' => 'TestName','ed_relationship'=>'TestRelationShip','ed_date_of_birth'=>'2009-09-02'));

    }

    public function deleteEmployeeDependencies(ApiTester $I)
    {
        $I->wantTo('Test Delete Employee Dependencies');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendDELETE('api/v1/employee/1/dependent',['sequenceNumber'=>'1']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Deleted",
        ]);

    }

    public function saveEmployeeJobDetails(ApiTester $I)
    {
        $I->wantTo('Test Save Employee Job Details');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('api/v1/employee/1/job-detail',['title'=>'1','category'=>'1','status'=>'Teststate',
                                                            'subunit'=>'TestSubunit','location'=>'TestLocation',
                                                            'joinedDate'=>'2019-08-10','startDate'=>'2010-08-12',
                                                                'endDate'=>'2010-01-22']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Saved",
        ]);

    }

    /*public function updateEmployeeJobDetails(ApiTester $I)
    {
        $I->wantTo('Test Update Employee Job Details');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/employee/1/job-detail');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data"=> [
                [
                    "name"=> "TestName",
                    "relationship"=> "TestRelationShip",
                    "dob"=> "2009-09-02",
                    "sequenceNumber"=> "2"
                ],
                [
                    "name"=> "TestName",
                    "relationship"=> "TestRelationShip",
                    "dob"=> "2009-09-02",
                    "sequenceNumber"=> "3"
                ],
            ]
        ]);

    }


    public function getEmployeeJobDetails(ApiTester $I)
    {
        $I->wantTo('Test Get Employee Job Details');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer ' . $this->accessToken);
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/employee/1/job-detail');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data"=> [
                "title"=> null,
                "category"=> null,
                "status"=> "",
                "subunit"=> null,
                "location"=> null,
                "joinedDate"=> null,
                "startDate"=> "",
                "endDate"=> ""
            ]
        ]);

    }

*/




}
