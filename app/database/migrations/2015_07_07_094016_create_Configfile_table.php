<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configfile', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('text');
			$table->enum('type', array('generic', 'network', 'vendor', 'user'));
			$table->enum('device', array('cm', 'mta'));
			$table->enum('public', array('yes', 'no'));
			$table->integer('parent_id')->unsigned();
			$table->boolean('is_dummy')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});

		# insert a dummy for each enum value
		$enum_devices = array(
			1 => 'cm',
			2 => 'mta',
		);
		foreach($enum_devices as $i => $v) {
			DB::update("INSERT INTO configfile (name, device, is_dummy, deleted_at) VALUES('dummy-cfg-".$v."',".$i.",1,NOW());");
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('configfile');

		// remove all config files
		$files = glob('/tftpboot/cm/*');              // get all files in dir
		foreach ($files as $file) 
		{
			if(is_file($file))
			unlink($file);
		}
	}

}
