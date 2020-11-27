<?php

namespace App\Http\Controllers;

use App\Mongo\Client;
use Illuminate\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JsonException;
use MongoDB\BSON\ObjectId;
use MongoDB\Database;

class ImageController extends Controller
{
    /**
     * @var Database
     */
    protected $mongo;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @param Client     $mango
     * @param Repository $config
     */
    public function __construct(Client $mango, Repository $config)
    {
        $this->config = $config;

        $this->mongo = $mango->client()->{$config['mongo.database']};
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('images');
    }

    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $data = $this->mongo->selectCollection('images')->find()->toArray();

        array_walk($data, static function ($item) {
            $item->_id = (string)$item->_id;
            $item->path = Storage::disk('public')->url($item->path);
        });

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = [];

        try {
            $predictions = json_decode($request->get('predictions'), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return response()->json([
                'success' => false,
                'error'   => 'An error occurred while decode predictions.'
            ]);
        }

        /**
         * @var UploadedFile $file
         */
        foreach ($request->allFiles() as $name => $file) {
            if (!$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'error'   => 'Image is not valid.'
                ]);
            }

            $data[] = [
                'ext'         => $ext = $file->getClientOriginalExtension(),
                'name'        => Str::beforeLast($file->getClientOriginalName(), '.' . $ext),
                'path'        => $file->store('images', 'public'),
                'predictions' => $predictions[$name] ?? [],
                'created_at'  => now()->format('Y-m-d H:i:s')
            ];
        }

        $result = $this->mongo->selectCollection('images')->insertMany($data);

        foreach ($data as $index => $datum) {
            $data[$index]['_id'] = (string)($result->getInsertedIds()[$index] ?? '0');
            $data[$index]['path'] = Storage::disk('public')->url($datum['path']);
        }

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $data = $this->mongo->selectCollection('images')->findOne(['_id' => new ObjectId($id)]);

        if ($data) {
            $data['_id'] = (string)$data['_id'];
            $data['path'] = Storage::disk('public')->url($data['path']);
        }

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        $image = $this->mongo->selectCollection('images')->findOne(['_id' => new ObjectId($id)]);

        $this->mongo->selectCollection('images')->deleteOne(['_id' => new ObjectId($id)]);

        Storage::disk('public')->delete($image['path']);

        return response()->json([
            'success' => true
        ]);
    }
}
