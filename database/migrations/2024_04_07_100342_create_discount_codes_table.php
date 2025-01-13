<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id(); 
            $table->string('code', 50)->index(); 
            $table->enum('discount_type', ['percent', 'fixed']); 
            $table->decimal('discount_value', 10); 
            $table->integer('usage_limit')->nullable();
            $table->integer('times_used')->default(0);
            $table->timestamp('start_date'); 
            $table->timestamp('end_date')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_codes');
    }
}
