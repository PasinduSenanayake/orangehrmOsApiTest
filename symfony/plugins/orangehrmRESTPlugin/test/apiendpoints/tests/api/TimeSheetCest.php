<?php

class TimeSheetCest
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


    public function saveCustomer(ApiTester $I)
    {
        $I->wantTo('Test Save Customer');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('api/v1/customer', ['name' => 'TestCustomerAPI', 'description' => 'TestCustomerAPIDescription']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Saved"
        ]);
        $customerId = json_decode($I->grabResponse())->customerId;
        $I->seeInDatabase('ohrm_customer', array('customer_id' => $customerId, 'name' => 'TestCustomerAPI', 'description' => 'TestCustomerAPIDescription', 'is_deleted' => 0));
        $I->deleteFromDatabase('ohrm_customer', array('customer_id' => $customerId, 'name' => 'TestCustomerAPI', 'description' => 'TestCustomerAPIDescription', 'is_deleted' => 0));

    }

    public function updateCustomer(ApiTester $I)
    {
        $I->wantTo('Test Update Customer');
        $I->insertDb($I, "updateCustomer");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPUT('api/v1/customer', ['name' => 'TestCustomerAPIUpdated', 'description' => 'TestCustomerAPIDescriptionUpdated', 'customerId' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Updated"
        ]);
        $I->seeInDatabase('ohrm_customer', array('customer_id' => 1, 'name' => 'TestCustomerAPIUpdated', 'description' => 'TestCustomerAPIDescriptionUpdated', 'is_deleted' => 0));
        $I->deleteFromDatabase('ohrm_customer', array('customer_id' => 1, 'name' => 'TestCustomerAPIUpdated', 'description' => 'TestCustomerAPIDescriptionUpdated', 'is_deleted' => 0));

    }

    public function getCustomer(ApiTester $I)
    {
        $I->wantTo('Test Get Customer');
        $I->insertDb($I, "getCustomer");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/customer');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data" => [[
                "customerId" => '1',
                "isDeleted" => "0",
                "name" => "TestCustomer",
                "description" => "TestCustomerAPIDescription"
            ], [
                "customerId" => '2',
                "isDeleted" => "0",
                "name" => "TestCustomer2",
                "description" => "TestCustomerAPIDescription2"
            ]
            ]
        ]);

    }

    public function deleteCustomer(ApiTester $I)
    {
        $I->wantTo('Test Delete Customer');
        $I->insertDb($I, "deleteCustomer");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendDELETE('api/v1/customer', ['customerId' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Deleted"
        ]);
        $I->seeInDatabase('ohrm_customer', array( 'customer_id'=> '1', 'name'=> 'TestCustomer','is_deleted' => 1));

    }

    public function saveProject(ApiTester $I)
    {
        $I->wantTo('Test Save Project');
        $I->insertDb($I, "saveProject");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('api/v1/project', ['customerId' => 1, 'name' => 'TestProjectAPI', 'description' => 'TestProjectAPIDescription']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([

            "success" => "Successfully Saved"

        ]);
        $projectId = json_decode($I->grabResponse())->projectId;
        $I->seeInDatabase('ohrm_project', array('customer_id' => 1, 'project_id' => $projectId, 'name' => 'TestProjectAPI', 'description' => 'TestProjectAPIDescription', 'is_deleted' => 0));
        $I->deleteFromDatabase('ohrm_project', array('customer_id' => 1, 'project_id' => $projectId, 'name' => 'TestProjectAPI', 'description' => 'TestProjectAPIDescription', 'is_deleted' => 0));

    }

    public function updateProject(ApiTester $I)
    {
        $I->wantTo('Test Update Project');
        $I->insertDb($I, "updateProject");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPUT('api/v1/customer', ['customerId' => 1, 'name' => 'TestProjectAPI', 'description' => 'TestProjectAPIDescription', 'projectId' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Updated"
        ]);
        $I->seeInDatabase('ohrm_project', array('customer_id' => 1, 'project_id' => 1, 'name' => 'TestProjectAPI', 'description' => 'TestProjectAPIDescription', 'is_deleted' => 0));
        $I->deleteFromDatabase('ohrm_project', array('customer_id' => 1, 'project_id' => 1, 'name' => 'TestProjectAPI', 'description' => 'TestProjectAPIDescription', 'is_deleted' => 0));

    }

    public function getProject(ApiTester $I)
    {
        $I->wantTo('Test Get Project');
        $I->insertDb($I, "getProject");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/project');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data" => [
                "projectId" => 1,
                "projectName" => "TestProjectAPI",
                "customerId" => 1,
                "customerName" => "TestCustomer",
                "description" => "TestProjectAPIDescription",
                "isDeleted" => "0",
                "admins" => "",
                "activities" => [

                    "id" => 1,
                    "name" => "TestProjectActivityAPI",
                    "isDeleted" => "0"

                ]
            ]
        ]);

    }

    public function deleteProject(ApiTester $I)
    {
        $I->wantTo('Test Delete Project');
        $I->insertDb($I, "deleteProject");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendDELETE('api/v1/project', ['projectId' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Deleted"
        ]);
        $I->seeInDatabase('ohrm_project', array( 'customer_id'=> '1','project_id'=> '1', 'name'=> 'TestProjectAPI','is_deleted' => 1));

    }

    public function saveActivity(ApiTester $I)
    {
        $I->wantTo('Test Save Activity');
        $I->insertDb($I, "saveActivity");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('api/v1/activity', ['projectId' => 1, 'name' => 'TestActivityAPI']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Saved"
        ]);
        $activityId = json_decode($I->grabResponse())->activityId;

        $I->seeInDatabase('ohrm_project_activity', array('activity_id' => $activityId, 'project_id' => 1, 'name' => 'TestActivityAPI', 'is_deleted' => 0));
        $I->deleteFromDatabase('ohrm_project_activity', array('activity_id' => $activityId, 'project_id' => 1, 'name' => 'TestActivityAPI', 'is_deleted' => 0));

    }

    public function updateActivity(ApiTester $I)
    {
        $I->wantTo('Test Update Activity');
        $I->insertDb($I, "updateActivity");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPUT('api/v1/activity', ['projectId' => 1, 'name' => 'TestActivityAPI', 'activityId' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Updated"
        ]);
        $I->seeInDatabase('ohrm_project_activity', array('activity_id' => 1, 'project_id' => 1, 'name' => 'TestActivityAPI', 'is_deleted' => 0));
        $I->deleteFromDatabase('ohrm_project_activity', array('activity_id' => 1, 'project_id' => 1, 'name' => 'TestActivityAPI', 'is_deleted' => 0));
    }


    public function getActivity(ApiTester $I)
    {
        $I->wantTo('Test Get Activity');
        $I->insertDb($I, "getActivity");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/activity?id=1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data" => [
                "id" => '1',
                "isDeleted" => "0",
                "name" => "TestActivityAPI"
            ]
        ]);

    }

    public function deleteActivity(ApiTester $I)
    {
        $I->wantTo('Test Delete Activity');
        $I->insertDb($I, "deleteActivity");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendDELETE('api/v1/activity', ['projectId' => 1, 'activityId' => 1, 'name' => 'TestActivityAPI']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Deleted"
        ]);

        $I->seeInDatabase('ohrm_project_activity', array('activity_id' => '1',  'project_id'=> '1', 'name'=> 'TestActivityAPI','is_deleted' => 1));

    }


    public function saveTimeSheet(ApiTester $I)
    {

        $I->wantTo('Test Save TimeSheet');
        $I->insertDb($I, "saveTimeSheet");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('api/v1/employee/1/timesheet', ['startDate' => date("Y-m-d", time())]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => 'Successfully Created'
        ]);
        $timesheetId = json_decode($I->grabResponse())->timesheetId;
        $I->seeInDatabase('ohrm_timesheet', array('timesheet_id' => $timesheetId, 'state' => 'NOT SUBMITTED'));
        $I->deleteFromDatabase('ohrm_timesheet', array('timesheet_id' => $timesheetId, 'state' => 'NOT SUBMITTED'));

    }

    public function updateTimeSheet(ApiTester $I)
    {
        $I->wantTo('Test Update TimeSheet');
        $I->insertDb($I, "updateTimeSheet");
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPUT('api/v1/employee/1/timesheet', ['startDate' => '2017-02-13', "state" => "CREATED", "comment" => "cdv",
            "timeSheetItems" => [
                [
                    "projectId" => "1",
                    "projectActivityId" => "1",
                    '0' => '1:00',
                    'TimesheetItemId0' => '',
                    '1' => '1:00',
                    'TimesheetItemId1' => '',
                    '2' => '1:00',
                    'TimesheetItemId2' => '',
                    '3' => '1:00',
                    'TimesheetItemId3' => '',
                    '4' => '1:00',
                    'TimesheetItemId4' => '',
                    '5' => '1:00',
                    'TimesheetItemId5' => '',
                    '6' => '1:00',
                    'TimesheetItemId6' => '',

                ]]

        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Updated"
        ]);

        $I->seeInDatabase('ohrm_timesheet', array('timesheet_id' => 1, 'state' => 'CREATED'));
        $I->seeInDatabase('ohrm_timesheet_item', array('duration' => '3600', 'timesheet_id' => 1));
        $I->deleteFromDatabase('ohrm_timesheet_item', array('duration' => '3600', 'timesheet_id' => 1));
        $I->deleteFromDatabase('ohrm_timesheet', array('timesheet_id' => 1, 'state' => 'NOT SUBMITTED'));


    }

    public function getTimeSheet(ApiTester $I)
    {
        $I->wantTo('Test Get TimeSheet');
        $I->insertDb($I, "getTimeSheet");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendGET('api/v1/employee/1/timesheet?2017-02-13');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data" => [

                "timeSheetId" => "1",
                "employeeId" => "1",
                "startDate" => "2017-02-13",
                "endDate" => "2017-02-20",
                "state" => "CREATED",
                "timeSheetItems" => [
                    [
                        "timesheetItemId" => "1",
                        "projectName" => "TestProjectAPI",
                        "projectId" => 1,
                        "activityName" => "TestProjectActivityAPI",
                        "activityId" => 1,
                        "date" => "2017-02-13",
                        "duration" => "3600",
                        "comment" => "TestComment"
                    ],

                ]
            ]

        ]);

    }

    public function deleteTimeSheetRow(ApiTester $I)
    {
        $I->wantTo('Test Delete Time Sheet Row');
        $I->insertDb($I, "deleteTimeSheetRow");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendDELETE('api/v1/employee/1/timesheet/row_delete', ['projectId' => 1, 'activityId' => 1, 'timesheetId' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Deleted"
        ]);

        $I->dontSeeInDatabase('ohrm_timesheet_item', array('timesheet_item_id' => '1', 'date' => '2017-02-13',  'project_id'=> '1', 'employee_id'=> '1', 'activity_id'=> '1'));

    }


}
