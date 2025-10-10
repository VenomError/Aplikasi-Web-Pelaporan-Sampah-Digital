<?php

use App\Models\Member;
use App\Models\Incentive;
use App\Enum\RedemtionStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('point_redemtions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Member::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Incentive::class)->constrained()->cascadeOnDelete();
            $table->integer('points_redeemed')->default(0);
            $table->enum('status', RedemtionStatus::cases())->default(RedemtionStatus::SUBMITTED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_redemtions');
    }
};
