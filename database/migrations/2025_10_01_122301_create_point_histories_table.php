<?php

use App\Models\Member;
use App\Enum\PointHistoryType;
use App\Models\PointRedemtion;
use App\Models\Report;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('point_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Member::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Report::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PointRedemtion::class)->constrained()->cascadeOnDelete();
            $table->integer('points_change')->default(0);
            $table->enum('type', PointHistoryType::cases());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_histories');
    }
};
