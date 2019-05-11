<?php
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePodcastCommentsTable extends Migration
    {
        /**
         * Run the migrations.
         * @return void
         */
        public function up()
        {
            Schema::create('podcast_comments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('podcast_id')->unsigned();
                $table->foreign('podcast_id')->references('id')->on('podcasts')->onDelete('cascade');
                $table->string('author_name');
                $table->string('author_email');
                $table->string('author_comment');
                $table->unique(['author_name', 'author_email', 'author_comment']);
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
            Schema::dropIfExists('podcast_comments');
        }
    }
