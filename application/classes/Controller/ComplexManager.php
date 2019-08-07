<?php defined('SYSPATH') or die('No direct script access.');


class Controller_ComplexManager extends Controller {

    public function action_save()
    {
        $body = $this->request->post();
        $user = ORM::factory('User')->where('device_id', '=', $body['deviceId'])->find();
        $modinst = Model_Complex::getComplexByUserIdAndInnerId($user->id, $body['id']);
        $modinst->IPADDRESS = $body['ipAddress'];
        $modinst->save();
        echo json_encode($body);
    }

} // End ComponentManager
