<?php defined('SYSPATH') or die('No direct script access.');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Controller_Welcome extends Controller {

	public function action_index()
	{

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$writer = new Xlsx($spreadsheet);
		$writer->save($this->uploads_dir() . "docs/" . 'hello world.xlsx');
	}

	private function uploads_dir()
	{
		return DOCROOT . 'uploads' . DIRECTORY_SEPARATOR;
	}
	
	public function action_test()
	{
	    //echo DOCROOT;
		$users = ORM::factory('User')->find_all();
		View::bind_global('users', $users);
	    $this->response->body(View::factory('Start'));
	}

	private function parseInfo($info)
	{
		Kohana::$log->add(LOG::DEBUG, 'parse');
		if(!property_exists($info, 'deviceId'))
			return;
		$user = ORM::factory('User')->where('device_id', '=', $info->deviceId)->find();
		if(!$user->loaded())
		{
			$user->device_id = $info->deviceId;
			$user->save();
		}
		if(!property_exists($info, 'objects'))
			return;
		//save all objects (if they exist, then update)
		foreach ($info->objects as $object)
		{
			$objmod = ORM::factory('Object')->where('user_id','=', $user->id)
				->and_where('inner_id', '=', $object->id)->find();
			if(!$objmod->loaded())
			{
				$objmod->user_id = $user->id;
				$objmod->inner_id = $object->id;
			}
			$objmod->name = $object->name;
			$objmod->save();
		}
		if(!property_exists($info, 'components'))
			return;
		//save all components (if they exist, then update)
		foreach ($info->components as $component)
		{
			$commod = ORM::factory('Component')->where('user_id','=', $user->id)
				->and_where('inner_id', '=', $component->id)->find();
			if(!$commod->loaded())
			{
				$commod->user_id = $user->id;
				$commod->inner_id = $component->id;
			}
			$commod->name = $component->name;
			$commod->save();
		}

		if(!property_exists($info, 'complexTypes'))
			return;
		//save all complex types (if they exist, then update)
		foreach ($info->complexTypes as $complexType)
		{
			$modinst = ORM::factory('ComplexType')->where('user_id', '=', $user->id)
				->and_where('inner_id', '=', $complexType->id)->find();
			if(!$modinst->loaded())
			{
				$modinst->user_id = $user->id;
				$modinst->inner_id = $complexType->id;
			}
			$modinst->name = $complexType->name;
			$modinst->save();
		}

		if(!property_exists($info, 'addresses'))
			return;
		//save all addresses (if they exist, then update)
		foreach ($info->addresses as $address)
		{
			$modinst = Model_Address::getAddressByUserIdAndInnerId($user->id, $address->id);
			$modinst->inner_id = $address->id;
			$objectId = Model_Object::getObjectIdByUserIdAndInnerId($user->id, $address->objectId);
			if($objectId === false)
				continue;
			$modinst->object_id = $objectId;
			$modinst->city = $address->city;
			$modinst->street = $address->street;
			$modinst->building = $address->building;
			$modinst->save();
		}

		if(!property_exists($info, 'rooms'))
			return;
		//save all rooms (if they exist, then update)
		foreach ($info->rooms as $room)
		{
			$modinst = Model_Room::getRoomByUserIdAndInnerId($user->id, $room->id);
			$modinst->inner_id = $room->id;
			$addressId = Model_Address::getAddressIdByUserIdAndInnerId($user->id, $room->addressId);
			if($addressId === false)
				continue;
			$modinst->address_id = $addressId;
			$modinst->name = $room->name;
			$modinst->save();
		}

		if(!property_exists($info, 'complexTypeComponents'))
			return;
		//save all components of complex type (if they exist, then update)
		foreach ($info->complexTypeComponents as $complexTypeComponent)
		{
			$modinst = Model_ComplexTypeHasComponents::getComplexTypeHasComponentByUserIdAndInnerId($user->id,
				$complexTypeComponent->id);
			$modinst->inner_id = $complexTypeComponent->id;
			$complexTypeId = Model_ComplexType::getComplexTypeIdByUserIdAndInnerId($user->id,
				$complexTypeComponent->complexTypeId);
			$componentId = Model_Component::getComponentIdByUserIdAndInnerId($user->id,
				$complexTypeComponent->componentId);
			if($complexTypeId === false || $componentId === false)
				continue;
			$modinst->complex_type_id = $complexTypeId;
			$modinst->component_id = $componentId;
			$modinst->save();
		}

		if(!property_exists($info, 'complexes'))
			return;
		//save all complexes (if they exist, then update)
		foreach ($info->complexes as $complex)
		{
			$modinst = Model_Complex::getComplexByUserIdAndInnerId($user->id,
				$complex->id);
			$complexComponentModels = $modinst->complex_has_components->find_all();
			foreach($complexComponentModels as $complexComponentModel)
			{
				$complexComponentModel->delete();
			}
			$modinst->inner_id = $complex->id;
			$complexTypeId = Model_ComplexType::getComplexTypeIdByUserIdAndInnerId($user->id,
				$complex->complexTypeId);
			$addressId = Model_Address::getAddressIdByUserIdAndInnerId($user->id,
				$complex->addressId);
			$roomId = Model_Room::getRoomIdByUserIdAndInnerId($user->id,
				$complex->roomId);
			if($complexTypeId === false || $addressId === false || $roomId === false)
				continue;
			$modinst->complex_type_id = $complexTypeId;
			$modinst->address_id = $addressId;
			$modinst->room_id = $roomId;
			if(property_exists($complex, 'appendix'))
			{
				$modinst->appendix = $complex->appendix;
			}
			if(property_exists($complex, 'ipAddress'))
			{
				$modinst->IPADDRESS = $complex->ipAddress;
			}
			//$modinst->photo_path = '';
			if(property_exists($complex, 'id_by_address'))
			{
				$modinst->id_by_address = $complex->id_by_address;
			}
			$modinst->save();
		}

		if(!property_exists($info, 'complexComponents'))
			return;
		//save all components of complex type (if they exist, then update)
		foreach ($info->complexComponents as $complexComponent)
		{
			$complexId = Model_Complex::getComplexIdByUserIdAndInnerId($user->id,
				$complexComponent->complexId);
			$modinst = Model_ComplexHasComponents::getComplexHasComponentByUserIdAndInnerId($user->id,
				$complexComponent->id);
			$modinst->inner_id = $complexComponent->id;
			$componentId = Model_Component::getComponentIdByUserIdAndInnerId($user->id,
				$complexComponent->componentId);
			if($complexId === false || $componentId === false)
				continue;
			$modinst->complex_id = $complexId;
			$modinst->component_id = $componentId;
			if(property_exists($complexComponent,'code'))
			{
				$modinst->code = $complexComponent->code;
			}
			else
			{
				$modinst->code = null;
			}
			$modinst->save();
		}
	}
	
	public function action_uploadInfo()
	{
	    $body = $this->request->post();
		Kohana::$log->add(LOG::DEBUG, "BODY INFO: ".$body['info']);
		$this->parseInfo(json_decode($body['info']));
	    echo "success";
	}

	public function action_manager()
	{
		//$device_id =  $this->request->query('device_id');

		$device_id = '9dffc8adae41f076';
		$objects = Model_Object::getObjectsByDeviceId($device_id);
		View::bind_global('objects', $objects);

		$addresses = Model_Address::getAddressesByDeviceId($device_id);
		View::bind_global('addresses', $addresses);

		$rooms = Model_Room::getRoomsByDeviceId($device_id);
		View::bind_global('rooms', $rooms);

		$components = Model_Component::getComponentsByDeviceId($device_id);
		View::bind_global('components', $components);

		$complexTypes = Model_ComplexType::getComplexTypesByDeviceId($device_id);
		View::bind_global('complexTypes', $complexTypes);

		$complexes = Model_Complex::getComplexesByDeviceId($device_id);
		View::bind_global('complexes', $complexes);

		$this->response->body(View::factory('Manager'));
	}

	public function action_view()
	{
		// create template
		$this->template = View::factory('Files');

		// initialize files array
		$files = array();

		// scan uploads directory and build files array
		$uploads = new DirectoryIterator($this->uploads_dir());
		foreach ($uploads as $file) /** @var DirectoryIterator $file **/
		{
			if ($file->isFile())
			{
				$files[] = $file->getFilename();
			}
		}

		// set values to template
		$this->template->set(array(
			// files list
			'files' => $files,
			// errors from user session
			'errors' => Session::instance()->get_once('errors', array()),
			// message from user session
			'message' => Session::instance()->get_once('message'),
		));

		// render template
		$this->response->body($this->template->render());
	}

	public function action_preview()
	{
		// build image file name
		$filename = $this->uploads_dir() . $this->request->param('filename');

		// check if file exists
		if (! file_exists($filename) OR ! is_file($filename))
		{
			throw new HTTP_Exception_404('Picture not found');
		}

		/** @var Image $image **/ // trying get picture preview from cache
		if (($image = Cache::instance()->get($filename)) === NULL)
		{
			// create new picture preview
			$image = Image::factory($filename)
				->resize(100, 100)
				->render();

			// store picture in cache
			Cache::instance()->set($filename, $image, Date::MONTH);
		}

		// gets image type
		$info = getimagesize($filename);
		$mime = image_type_to_mime_type($info[2]);

		// display image
		$this->response->headers('Content-type', $mime);
		$this->response->body($image);
	}

	public function action_upload()
	{
		// check request method
		if ($this->request->method() === Request::POST)
		{
			// create validation object
			$validation = Validation::factory($_FILES)
				->label('image', 'Picture')
				->rules('image', array(
					array('Upload::not_empty'),
					array('Upload::image'),
				));

			// check input data
			if ($validation->check())
			{
				// process upload
				$uploadedfile = Upload::save($validation['image'], NULL, $this->uploads_dir());
				Kohana::$log->add(LOG::DEBUG, $uploadedfile);
				$complex_id = $this->request->headers("ComplexId");
				$device_id = $this->request->headers("DeviceId");
				$user = ORM::factory('User')->where('device_id', '=',$device_id)->find();
				if(!$user->loaded())
				{
					Kohana::$log->add(LOG::DEBUG, "user with device id ".$device_id . " doesn't exist");
				}
				$complex = Model_Complex::getComplexByUserIdAndInnerId($user->id, $complex_id);
				if(!$complex->loaded())
				{
					Kohana::$log->add(LOG::DEBUG, "complex with inner id ".$complex_id . " doesn't exist");
				}
				$parts = explode("/", $uploadedfile);
				$path = "../".$parts[count($parts)-2]."/".$parts[count($parts)-1];
				echo $path;
				$complex->photo_path = $path;
				$complex->save();
				// set user message
				//Session::instance()->set('message', 'Image is successfully uploaded');
			}

			// set user errors
			//Session::instance()->set('errors', $validation->errors('upload'));
		}

		// redirect to home page
		echo 'success';
	}

}
