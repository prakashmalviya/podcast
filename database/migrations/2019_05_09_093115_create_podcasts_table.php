<?php
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePodcastsTable extends Migration
    {
        /**
         * Run the migrations.
         * @return void
         */
        public function up()
        {
            Schema::create('podcasts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->text('marketing_url')->nullable();
                $table->text('feed_url');
                $table->string('image')->nullable();
                $table->enum('status', ['review', 'published'])->default('review');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        /**
         * Reverse the migrations.
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('podcasts');
        }
    }
