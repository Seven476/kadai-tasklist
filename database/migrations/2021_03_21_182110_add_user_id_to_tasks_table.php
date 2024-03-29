<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTasksTable extends Migration
{
     
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBiginteger('user_id');
        
            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users');
        
        });
            
    }

    public function down()
    {
        
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('tasks_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }

}
