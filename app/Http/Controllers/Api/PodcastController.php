<?php
    namespace App\Http\Controllers\Api;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Validator;
    use App\Repositories\PodcastRepository;

    /**
     * Class PodcastController
     * @package App\Http\Controllers\Api
     */
    class PodcastController extends Controller
    {
        /**
         * @var
         */
        protected $podcastRepository;

        public function __construct(Request $request, PodcastRepository $podcastRepository)
        {
            $this->request           = $request;
            $this->podcastRepository = $podcastRepository;
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse|void
         */
        public function store(Request $request)
        {
            // Let's get data from json object
            $data = $request->json()->all();
            // Need to validate date first
            $validator = Validator::make($data, [
                'name'          => 'required|min:4|max:255|unique:podcasts',
                'description'   => 'max:1000',
                'marketing_url' => 'nullable|url',
                'feed_url'      => 'required|url',
                'image'         => 'base64_image'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => $validator->errors()], 400);
            }
            // Data is validate now, let's insert into database
            try {
                $input['data']  = $request->only('name', 'description', 'marketing_url', 'feed_url');
                $input['image'] = $request->get('image');
                $podcast        = $this->podcastRepository->create($input);
                return response()->json(['status' => 'success', 'podcast' => $podcast], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 200);
            }
        }

        /**
         * @param $id
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function update($id, Request $request)
        {
            // Let's get data from json object
            $data       = $request->json()->all();
            $data['id'] = $id;
            // Need to validate date first
            $validator = Validator::make($data, [
                'id'            => 'required|exists:podcasts,id',
                'name'          => 'required|min:4|max:255|unique:podcasts,name,' . $id . ',id',
                'description'   => 'max:1000',
                'marketing_url' => 'nullable|url',
                'feed_url'      => 'required|url',
                'image'         => 'base64_image'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => $validator->errors()], 400);
            }
            // Data is validate now, let's update into database
            try {
                $input['data']  = $request->only('name', 'description', 'marketing_url', 'feed_url');
                $input['image'] = $request->get('image');
                $podcast        = $this->podcastRepository->update($input, $id);
                return response()->json(['status' => 'success', 'podcast' => $podcast], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 200);
            }
        }

        /**
         * @param $id
         * @return \Illuminate\Http\JsonResponse
         */
        public function destroy($id)
        {
            // Need to validate date first
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|exists:podcasts,id,deleted_at,NULL',
            ], ['id.exists' => 'Podcast is already deleted or invalid']);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => $validator->errors()], 400);
            }
            // Data is validate now, let's delete into database
            try {
                $this->podcastRepository->destroyById($id);
                return response()->json(['status' => 'success', 'message' => 'Podcast deleted successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 200);
            }
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function approve(Request $request)
        {
            // Let's get data from json object
            $data = $request->json()->all();
            // Need to validate date first
            $validator = Validator::make($data, [
                'id' => 'required|exists:podcasts,id,status,review',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => $validator->errors()], 400);
            }
            // Data is validate now, let's insert into database
            try {
                $input['data']['status'] = 'published';
                $podcast                 = $this->podcastRepository->update($input, $data['id']);
                return response()->json(['status' => 'success', 'podcast' => $podcast], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 200);
            }
        }

        /**
         * @param int $page
         * @return \Illuminate\Http\JsonResponse
         */
        public function getPublishedPodcast($page = 0)
        {
            $podcasts = $this->podcastRepository->getPublished($page);
            if ($podcasts->total() > 0) {
                return response()->json(['status' => 'success', 'podcasts' => $podcasts], 200);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'There are no records'], 200);
            }
        }

        /**
         * @param $id
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function getPodcastById($id, Request $request)
        {
            $comments = $request->get('comments', '0');
            // Need to validate date first
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|exists:podcasts,id,status,published',
            ], ['id.exists' => 'Podcast is invalid or not published']);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => $validator->errors()], 400);
            }
            $podcast = $this->podcastRepository->getById($id, $comments);
            if ($podcast != null) {
                return response()->json(['status' => 'success', 'podcast' => $podcast], 200);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'Requested podcast is deleted'], 200);
            }
        }
    }
