<?php

use yii\db\Migration;

class m171116_131439_addcolumRole extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'role', $this->integer()->after('email'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171116_131439_addcolumnorder_details cannot be reverted.\n";

        return false;
    }
    */
}
