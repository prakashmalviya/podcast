<?php
    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * Class PodcastComment
     * @package App
     * @property int $id
     * @property int $podcast_id
     * @property string $author_name
     * @property string $author_email
     * @property string $author_comment
     */
    class PodcastComment extends Model
    {
        use SoftDeletes;
        /**
         * @var bool
         */
        public $timestamps = true;
        /**
         * @var string
         */
        protected $table = 'podcast_comments';
        /**
         * @var array
         */
        protected $guarded = ['id'];

        /**
         * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'podcast_id',
            'author_name',
            'author_email',
            'author_comment'
        ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function podcast()
        {
            return $this->belongsTo(Podcast::class, 'podcast_id', 'id');
        }

    }
