<?php

namespace App\Http\Controllers;

use App\Authmetacore;
use App\Authrole;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;

class AuthroleController extends BaseController
{
	protected $index_create_allowed = true;

	protected $edit_left_md_size = 3;

	protected $edit_right_md_size = 6;

	public function view_form_fields($model = null)
	{
		return array(
			array('form_type' => 'text', 'name' => 'name', 'description' => 'Name'),
			array('form_type' => 'select', 'name' => 'type', 'description' => 'Type', 'value' => Authrole::getPossibleEnumValues('type', false)),
			array('form_type' => 'text', 'name' => 'description', 'description' => 'Description'),
		);
	}

	public function update_permission(Request $request)
	{
		try {
			$data = $request->all();
			$rightModel = new Authmetacore();
			$ret = $rightModel->update_permission($data['authmethacore_id'], $data['authmethacore_right'], $data['authmethacore_right_value']);
		} catch (\Exception $e) {
			// @ToDo: Logging the Exception
			//throw new \Exception($e->getMessage(), $e->getCode(), $e);
			$ret = $e->getMessage();
		}
		return $ret;
	}

	public function assign_permission(Request $request)
	{
		try {
			$data = $request->all();

			foreach ($data['permission'] as $permission_id => $rights) {
				$model = new Authmetacore();
				$ret = $model->assign_permission($data['role_id'], $permission_id, $rights);
			}
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage(), $e->getCode(), $e);
		}
	}
}
