<?php

namespace Modules\BillingBase\Entities;
use Storage;

class Company extends \BaseModel {

	// The associated SQL table for this Model
	public $table = 'company';

    // public $guarded = ['upload'];
    public $guarded = ['logo_upload'];


	// Add your validation rules here
	public static function rules($id = null)
	{
		return array(
			// 'name' => 'required|unique:cmts,hostname,'.$id.',id,deleted_at,NULL'  	// unique: table, column, exception , (where clause)
			'name' 		=> 'required',
			'street' 	=> 'required',
			'zip'	 	=> 'required',
			'city'	 	=> 'required',
		);
	}


	/**
	 * View related stuff
	 */

	// Name of View
	public static function view_headline()
	{
		return 'Company';
	}

	// link title in index view
	public function view_index_label()
	{
		return $this->name;
	}

	public function view_has_many ()
	{
		return ['SepaAccount' => $this->accounts];
	}

	/**
	 * Relationships:
	 */

	public function accounts ()
	{
		return $this->hasMany('Modules\BillingBase\Entities\SepaAccount');
	}


	/*
	 * Init Observers
	 */
	public static function boot()
	{
		// Company::observe(new CompanyObserver);
		parent::boot();
	}


	/**
	 * Returns all available logo files (via directory listing)
	 * @author Nino Ryschawy
	 */
	public function logos() 
	{
		// get all available files
		// $files_raw  = glob("/tftpboot/bill/logo/*");
		$files_raw  = Storage::files('config/billingbase/logo/');
		$files 		= array(null => "None");

		// $files_raw = glob("/tftpboot/bill/*");
		// $pic = ['png', 'eps', 'pdf', 'jpg'];
		// $doc = ['tex', 'odt', 'sxw'];

		// extract filename
		// foreach ($files_raw as $file)
		// {		
		// 	if (is_file($file))
		// 	{
		// 		$parts = explode("/", $file);
		// 		$filename = array_pop($parts);
		// 		$ending = explode('.', $filename);
		// 		$end = end($ending);
		
		// 		if (in_array($end, $pic))
		// 			$files['logo'][$filename] = $filename;
		// 		else if (in_array($end, $doc))
		// 			$files['template'][$filename] = $filename;
		// 	}
		// }

		// extract filename
		foreach ($files_raw as $file) 
		{
			if (is_file(storage_path('app/'.$file)))
			{
				$parts = explode("/", $file);
				$filename = array_pop($parts);
				$files[$filename] = $filename;
			}
		}

		return $files;
	}
}