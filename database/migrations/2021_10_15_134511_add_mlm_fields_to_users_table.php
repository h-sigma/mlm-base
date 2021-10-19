<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMlmFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->foreignId('sponsor_id')->nullable()->constrained('users');
            $table->foreignId('joining_invoice_id')->nullable()->constrained('invoices');
            $table->float('balance', 12, 4)->default(0);
            $table->boolean('admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('sponsor_id');
            $table->dropForeign('joining_invoice_id');
            $table->dropColumn('balance');
            $table->dropColumn('admin');
        });
    }
}
