<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id');
            $table->string('plan_name');
            $table->string('plan_description');
            $table->enum('status', $allowed = [
                'APPROVAL_PENDING',
                'APPROVED',
                'ACTIVE',
                'SUSPENDED',
                'CANCELLED',
                'EXPIRED'
            ]);
            $table->string('status_update_time');
            $table->string('subscription_id');
            $table->string('start_time');
            $table->json('billing_info');
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
        Schema::dropIfExists('subscriptions');
    }
}
