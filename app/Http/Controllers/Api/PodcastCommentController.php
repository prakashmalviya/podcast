<?php
    namespace App\Http\Controllers\Api;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Validator;
    use App\Repositories\PodcastCommentRepository;
    use Illuminate\Validation\Rule;

    /**
     * Class PodcastCommentController
     * @package App\Http\Controllers\Api
     */
    class PodcastCommentController extends Controller
    {
        /**
         * @var
         */
        protected $podcastCommentRepository;

        public function __construct(Request $request, PodcastCommentRepository $podcastCommentRepository)
        {
            $this->request                  = $request;
            $this->podcastCommentRepository = $podcastCommentRepository;
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
                'podcast_id'     => 'required|exists:podcasts,id|unique_comment',
                'author_name'    => [
                    'required',
                    Rule::unique('podcast_comments')->where(function ($query) use ($data) {
                        return $query->whereAuthorName($data['author_name'])
                                     ->whereAuthorEmail($data['author_email'])
                                     ->whereAuthorComment($data['author_comment']);
                    }),
                ],
                'author_email'   => 'required|email',
                'author_comment' => 'required|max:255'
            ], ['author_name.unique' => 'Auther name, email and comment must have unique']);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => $validator->errors()], 400);
            }
            // Data is validate now, let's insert into database
            try {
                $input['data'] = $request->only('podcast_id', 'author_name', 'author_email', 'author_comment');
                $podcast       = $this->podcastCommentRepository->create($input);
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
                'id' => 'required|exists:podcast_comments,id,deleted_at,NULL',
            ], ['id.exists' => 'Comment is already deleted or invalid']);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => $validator->errors()], 400);
            }
            // Data is validate now, let's delete into database
            try {
                $this->podcastCommentRepository->destroyById($id);
                return response()->json(['status' => 'success', 'message' => 'Comment deleted successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 200);
            }
        }

    }
