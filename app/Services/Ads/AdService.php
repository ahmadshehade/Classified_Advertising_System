<?php

namespace App\Services\Ads;

use App\Interfaces\Ads\AdInterface;
use App\Jobs\NewAdsJob;
use App\Jobs\UpdateAdsJob;
use App\Jobs\UserUpdateInfoJob;
use App\Models\Ad;
use App\Traits\ManagmentFiles;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdService implements AdInterface
{
    use AuthorizesRequests, ManagmentFiles;

    /**
     * Summary of index
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: mixed, message: string}
     */
    public function index()
    {
        $this->authorize('viewAny', Ad::class);

        if (auth('api')->user()->role == "admin") {
            $ads = Cache::remember('ads.all', now()->addMinutes(60), function () {
                return Ad::withRelations()->get();
            });
        } elseif (auth('api')->user()->role == "user") {
            $ads = Cache::remember('ads.active.visits', now()->addMinutes(60), function () {
                return Ad::withRelations()
                    ->active()
                    ->orderByDesc('reviews_count')
                    ->take(5)
                    ->get();
            });
        } else {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Unauthorized'
                ], 403)
            );
        }

        return [
            'message' => 'All ads retrieved successfully.',
            'data' => $ads,
            'code' => 200,
        ];
    }


    /**
     * Summary of store
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: Ad, message: string}
     */
    public function store($request)
    {
        try {
            DB::beginTransaction();
            $validate = $request->validated();
            $this->authorize('create', Ad::class);
            $ads = new Ad();
            $ads->title = $validate['title'];
            $ads->description = $validate['description'];
            $ads->price = $validate['price'];
            $ads->user_id = auth('api')->user()->id;
            $ads->category_id = $validate['category_id'];
            if (isset($validate['status']) && auth('api')->user()->role == 'admin') {
                $ads->status = $validate['status'];
            }
            $ads->save();
            Cache::forget('ads.all');
            Cache::forget('ads.active');
            $this->uploadImages(
                $request,
                'images',
                Ad::class,
                $ads->id,
                'Ads/' . $ads->title . '_' . $ads->id
            );
            DB::commit();
            if ($ads->wasRecentlyCreated) {
                dispatch(new NewAdsJob($ads));
            }
            $data = [
                'message' => 'Successfully create Ads',
                'data' => $ads->loadRelations(),
                'code' => 201
            ];
            return $data;
        } catch (Exception  $e) {
            throw new HttpResponseException(
                response()->json([
                    'message' => $e->getMessage()
                ], 500)
            );
        }
    }

    /**
     * Summary of show
     * @param mixed $id
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: Ad|mixed, message: string}
     */
    public function show($id)
    {
        $ads = Ad::withRelations()->find($id);
        if (!$ads) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Ads not Found'
                ], 404)
            );
        }
        $this->authorize('view', $ads);
        $data = [
            'message' => 'Successfully get Ads',
            'data' => $ads->loadRelations(),
            'code' => 200
        ];
        return $data;
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: Ad|mixed, message: string}
     */
    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            $validate = $request->validated();
            $ads = Ad::find($id);
            if (!$ads) {
                throw new HttpResponseException(
                    response()->json([
                        'message' => 'Ads not Found'
                    ], 404)
                );
            }
            $this->authorize('update', $ads);
            if (isset($validate['title'])) {
                $ads->title = $validate['title'];
            }
            if (isset($validate['description'])) {
                $ads->description = $validate['description'];
            }
            if (isset($validate['price'])) {
                $ads->price = $validate['price'];
            }
            if (isset($validate['category_id'])) {
                $ads->category_id = $validate['category_id'];
            }
            if (isset($validate['status']) && auth('api')->user()->role == "admin") {
                $ads->status = $validate['status'];
                if ($ads->isDirty('status')) {
                    dispatch(new UpdateAdsJob($ads));
                }
            } else {
                dispatch(new UserUpdateInfoJob($ads));
            }
            $ads->save();


            if ($request->hasFile('newImages')) {
                if ($ads->images->count() > 0) {
                    $imagesId = $ads->images()->pluck('id')->toArray();
                    $this->deleteImages(
                        Ad::class,
                        $ads->id,
                        $imagesId
                    );
                }
                $this->uploadImages(
                    $request,
                    'newImages',
                    Ad::class,
                    $ads->id,
                    'Ads/' . $ads->title . '_' . $ads->id
                );
            }

            DB::commit();
            $data = [
                'message' => 'Successfully Update Ads',
                'data' => $ads->loadRelations(),
                'code' => 200
            ];
            return $data;
        } catch (Exception  $e) {
            throw new HttpResponseException(
                response()->json([
                    'message' => $e->getMessage()
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
        $ads = Ad::find($id);
        if (!$ads) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Ads not Found'
                ], 404)
            );
        }
        $this->authorize('delete', $ads);
        if ($ads->images->count() > 0) {
            $imagesId = $ads->images()->pluck('id')->toArray();
            $this->deleteImages(
                Ad::class,
                $ads->id,
                $imagesId
            );
        }
        $ads->delete();
        Cache::forget('ads.all');
        Cache::forget('ads.active');
        Cache::forget('ads.all');
        Cache::forget('ads.active');
        $data = [
            'message' => 'Successfully Deleted Ads',
            'data' => true,
            'code' => 200
        ];
        return $data;
    }
    /**
     * Summary of filter
     * @param array $filters
     * @return array{code: int, data: \Illuminate\Database\Eloquent\Collection<int, Ad>, message: string}
     */
    public function filter(array $filters)
    {
        $this->authorize('viewAny', Ad::class);

        $ads = Ad::withRelations();

        if (!empty($filters['user_id'])) {
            $ads = $ads->whereHas('user', function ($query) use ($filters) {
                $query->where('id', $filters['user_id']);
            });
        }

        if (!empty($filters['category_id'])) {
            $ads = $ads->whereHas('category', function ($query) use ($filters) {
                $query->where('id', $filters['category_id']);
            });
        }

        if (auth('api')->user()->role == 'user') {
            $ads = $ads->active();
        }

        return [
            'message' => 'Filtered Ads retrieved successfully.',
            'data' => $ads->get(),
            'code' => 200,
        ];
    }
}
