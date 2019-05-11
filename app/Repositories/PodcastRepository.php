<?php
    /**
     * Created by PhpStorm.
     * User: pv
     * Date: 09-05-2019
     * Time: PM 03:41
     */
    namespace App\Repositories;

    use App\Podcast;
    use File;
    use Image;

    /**
     * Class PodcastRepository
     * @package Repositories
     */
    class PodcastRepository
    {
        /**
         * @var Podcast
         */
        protected $model;

        public function __construct()
        {
            $this->model = new Podcast();
        }

        /**
         * @return mixed
         */
        public function getAll()
        {
            return $this->model->active()->get();
        }

        /**
         * @param array $input
         * @return bool
         */
        public function create($input = [])
        {
            $podcast = $this->model->findOrNew(0);
            try {
                $podcast->fill($input['data'])->save();
                return $this->manageImage($input, $podcast);
            } catch (\Exception $e) {
                return false;
            }
        }

        /**
         * @param array $input
         * @param int $id
         * @return array|bool
         */
        public function update($input = [], $id = 0)
        {
            $podcast = $this->model->findOrNew($id);
            try {
                $podcast->fill($input['data'])->save();
                return $this->manageImage($input, $podcast);
            } catch (\Exception $e) {
                return false;
            }
        }

        /**
         * @param $id
         * @return bool
         */
        public function destroyById($id)
        {
            $podcast = $this->model->find($id);
            if (!empty($podcast->image)) {
                $this->removeImage($podcast->image);
            }
            $podcast->delete();
            return true;
        }

        /**
         * @param array $input
         * @param array $podcast
         * @return array
         */
        public function manageImage($input = [], $podcast = [])
        {
            if (isset($input['image']) && $input['image'] != null) {
                if (!empty($podcast->image)) {
                    $this->removeImage($podcast->image);
                }
                $image_name     = $this->uploadImage($input['image']);
                $podcast->image = $image_name;
                $podcast->save();
                return $podcast;
            }
            return $podcast;
        }

        /**
         * @param string $img_name
         * @return bool
         */
        public function removeImage($img_name = '')
        {
            if ($img_name) {
                $img_name = explode('/', $img_name);
                $file     = config('config.podcast.img_dir_original') . $img_name[4];
                if (File::exists($file)) {
                    // Check if Image gets deleted or not.
                    if (!File::delete($file)) {
                        return false;
                    }
                    return true;
                }
            }
            return false;
        }

        /**
         * @param string $image_data
         * @return bool|string
         */
        public function uploadImage($image_data = '')
        {
            $filename = "podcast_" . time() . ".png";
            $path     = config('config.podcast.img_dir_original');
            $image    = Image::make($image_data)->save($path . $filename);
            if (!$image) {
                return false;
            }
            return $filename;
        }

        /**
         * @return mixed
         */
        public function getPublished()
        {
            return $this->model->select('id', 'name', 'description', 'marketing_url', 'feed_url', 'image', 'status',
                'created_at', 'updated_at')->whereStatus('published')->paginate(12);
        }

        /**
         * @param $id
         * @param $comments
         * @return mixed
         */
        public function getById($id, $comments)
        {
            return $this->model->when($comments == 1, function ($q) {
                $q->with('comments');
            })->select('id', 'name', 'description', 'marketing_url', 'feed_url', 'image', 'status',
               'created_at', 'updated_at')->whereId($id)->whereStatus('published')->first();
        }
    }