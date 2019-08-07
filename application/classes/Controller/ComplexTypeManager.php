<?php defined('SYSPATH') or die('No direct script access.');


class Controller_ComplexTypeManager extends Controller {

    public function action_save()
    {
        $body = $this->request->post();
        $user = ORM::factory('User')->where('device_id', '=', $body['deviceId'])->find();
        $modinst = ORM::factory('ComplexType', Model_ComplexType::getComplexTypeIdByUserIdAndInnerId($user->id,
            $body['id']));
        $modinst->name = $body['name'];
        $modinst->save();
        echo json_encode($body);
    }

} // End ComponentManager
