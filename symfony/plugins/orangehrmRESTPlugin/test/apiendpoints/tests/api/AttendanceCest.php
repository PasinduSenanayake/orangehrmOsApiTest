<?php


class AttendanceCest
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



    public function punchIn(ApiTester $I)
    {
        $I->wantTo('Test Punch In');
        $I->insertDb($I, "punchIn");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('api/v1/employee/1/punch-in', ['timezone' => 'Europe/London','note'=>'Test API Note','datetime'=>'2005-12-30 01:02']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([

            "success"=> "Successfully Punched In",
        ]);
        $punchId = json_decode($I->grabResponse())->id;
        $I->seeInDatabase('ohrm_attendance_record', array('id' => $punchId , 'punch_in_note' => 'Test API Note', 'punch_in_utc_time' => '2005-12-30 00:02:00', 'employee_id' => 1));
        $I->deleteFromDatabase('ohrm_attendance_record', array('id' => $punchId , 'punch_in_note' => 'Test API Note', 'punch_in_utc_time' => '2005-12-30 00:02:00', 'employee_id' => 1));

    }

    public function punchOut(ApiTester $I)
    {
        $I->wantTo('Test Punch Out');
        $I->insertDb($I, "punchOut");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($this->accessToken);
        $I->sendPOST('api/v1/employee/1/punch-out', ['timezone' => 'Europe/London','note'=>'Test Note','datetime'=>'2005-12-30 01:15']);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "success" => "Successfully Punched Out",
        ]);

        $I->seeInDatabase('ohrm_attendance_record', array('id' => 1 , 'punch_out_note' => 'Test Note', 'punch_out_utc_time' => '2005-12-30 00:15:00', 'employee_id' => 1));

    }
}
