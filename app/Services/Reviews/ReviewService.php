<?php

namespace App\Services\Reviews;

use App\Interfaces\Reviews\ReviewInterface;
use App\Jobs\Review\MakeReview;
use App\Models\Ads;
use App\Models\Review;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReviewService implements ReviewInterface
{
    use AuthorizesRequests;
    /**
     * Summary of index
     * @return array{code: int, data: \Illuminate\Database\Eloquent\Collection<int, Review>, message: string}
     */
    public function index()
    {
        $this->authorize('viewAny', Review::class);
        $reviews = Review::with(['user', 'ad'])->orderBy('id', 'desc')->get();

        return [
            'message' => 'Successfully retrieved all reviews.',
            'data' => $reviews,
            'code' => 200
        ];
    }

    /**
     * Summary of store
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: Review, message: string}
     */
    public function store($request)
    {
        try {

            $validated = $request->validated();
            $this->authorize('create', Review::class);
            $review = new Review();
            $review->ad_id = $validated['ad_id'];
            $review->rating = $validated['rating'];
            $review->comment = $validated['comment'];
            $review->user_id = auth('api')->id();
            $review->save();
            Cache::forget('ads.all');
            Cache::forget('ads.active.visits');
            dispatch(new MakeReview($review));

            return [
                'message' => 'Successfully created new review.',
                'data' => $review,
                'code' => 201
            ];
        } catch (Exception $e) {

            throw new HttpResponseException(
                response()->json([
                    'message' => $e->getMessage(),
                ], 500)
            );
        }
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: Review|\Illuminate\Database\Eloquent\Collection<int, Review>, message: string}
     */
    public function update($id, $request)
    {
        try {
            $validated = $request->validated();

            $review = Review::find($id);

            if (!$review) {
                throw new HttpResponseException(
                    response()->json(['message' => 'Review not found.'], 404)
                );
            }
            $this->authorize('update', $review);
            $review->fill($validated);
            $review->save();

            return [
                'message' => 'Successfully updated review.',
                'data' => $review,
                'code' => 200
            ];
        } catch (Exception $e) {
            throw new HttpResponseException(
                response()->json([
                    'message' => $e->getMessage(),
                ], 500)
            );
        }
    }
    /**
     * Summary of destroy
     * @param mixed $id
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: bool, message: string}
     */
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            throw new HttpResponseException(
                response()->json(['message' => 'Review not found.'], 404)
            );
        }
        $this->authorize('delete', $review);
        $review->delete();
        Cache::forget('ads.all');
        Cache::forget('ads.active.visits');

        return [
            'message' => 'Successfully deleted review.',
            'data' => true,
            'code' => 200
        ];
    }

    /**
     * Summary of show
     * @param mixed $id
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: Review|\Illuminate\Database\Eloquent\Collection<int, Review>, message: string}
     */
    public function show($id)
    {
        $review = Review::with(['user', 'ad'])->find($id);

        if (!$review) {
            throw new HttpResponseException(
                response()->json(['message' => 'Review not found.'], 404)
            );
        }
        $this->authorize('view', $review);

        return [
            'message' => 'Successfully retrieved review.',
            'data' => $review,
            'code' => 200
        ];
    }
}
