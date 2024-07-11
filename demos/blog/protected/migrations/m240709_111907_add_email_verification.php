<?php

class m240709_111907_add_email_verification extends CDbMigration
{
	public function up()
    {
        $this->addColumn('tbl_user', 'email_verification_token', 'string NOT NULL');
        $this->addColumn('tbl_user', 'is_verified', 'boolean NOT NULL DEFAULT 0');
    }


    public function down()
    {
        $this->dropColumn('tbl_user', 'email_verification_token');
        $this->dropColumn('tbl_user', 'is_verified');
    }


	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}