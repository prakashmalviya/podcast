<?php
    namespace App\Repositories;

    use App\PodcastComment;
    use File;
    use Image;

    /**
     * Class PodcastCommentRepository
     * @package App\Repositories
     */
    class PodcastCommentRepository
    {
        /**
         * @var PodcastComment
         */
        protected $model;

        public function __construct()
        {
            $this->model = new PodcastComment();
        }

        /**
         * @param array $input
         * @return bool
         */
        public function create($input = [])
        {
            $podcast_comment = $this->model->findOrNew(0);
            try {
                $podcast_comment->fill($input['data'])->save();
                return $podcast_comment;
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
            $podcast_comment = $this->model->find($id);
            $podcast_comment->delete();
            return true;
        }

    }