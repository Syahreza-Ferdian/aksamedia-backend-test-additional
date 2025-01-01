<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $sqlDump = database_path('./nilai.sql');
        if (file_exists($sqlDump)) {
            $sql = file_get_contents($sqlDump);
            DB::unprepared($sql);
        } else {
            throw new Exception('File nilai.sql not found');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('nilai');
    }
};
