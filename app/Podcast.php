<?php
    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * Class Podcast
     * @package App
     * @property int $id
     * @property string $name
     * @property string $description
     * @property string $marketing_url
     * @property string $feed_url
     * @property string $image
     * @property boolean $status
     */
    class Podcast extends Model
    {
        use SoftDeletes;
        /**
         * @var bool
         */
        public $timestamps = true;
        /**
         * @var string
         */
        protected $table = 'podcasts';
        /**
         * @var array
         */
        protected $guarded = ['id'];

        /**
         * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'name',
            'description',
            'marketing_url',
            'feed_url',
            'image',
            'status'
        ];

        /**
         * @param $value
         * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
         */
        public function getImageAttribute($value)
        {
            return $value != '' ? url(config('config.podcast.img_dir') . $value) : null;
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function comments()
        {
            return $this->hasMany(PodcastComment::class, 'podcast_id', 'id');
        }

    }
