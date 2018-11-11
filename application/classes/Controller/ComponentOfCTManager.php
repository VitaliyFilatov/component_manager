<?php defined('SYSPATH') or die('No direct script access.');


class Controller_ComponentOfCTManager extends Controller {

    public function action_save()
    {
        $body = $this->request->post();
        $user = ORM::factory('User')->where('device_id', '=', $body['deviceId'])->find();
        $modinst = Model_ComplexTypeHasComponents::getComplexTypeHasComponentByUserIdAndInnerId($user->id,
            $body['id']);
        $component = $modinst->component;
        $component->name = $body['name'];
        $component->save();
        echo json_encode($body);
    }

} // End ComponentManager
