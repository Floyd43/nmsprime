<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends BaseMigration {

	private $dir = '/tftpboot/bill';
	protected $tablename = 'company';
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// creates directory for bill templates of the companies
		if(!is_dir($this->dir))
			mkdir ($this->dir, '0744');
		system("/bin/chown -R apache ".$this->dir);

		Schema::create('company', function(Blueprint $table)
		{
			$this->up_table_generic($table);

			$table->string('name');
			$table->string('street');
			$table->string('zip', 16);
			$table->string('city');

			$table->string('phone');
			$table->string('fax');
			$table->string('web');
			$table->string('mail');

			$table->string('registration_court_1');		// Registergericht
			$table->string('registration_court_2');
			$table->string('registration_court_3');
			
			$table->string('management');		// Vorstand
			
			$table->string('directorate');		// Aufsichtsrat, Geschäftsleitung

			$table->string('tax_id_nr');
			$table->string('tax_nr');

			$table->string('logo');
			$table->string('template');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (is_dir($this->dir))
			system("rm -rf ".$this->dir);

		Schema::drop('company');
	}

}
