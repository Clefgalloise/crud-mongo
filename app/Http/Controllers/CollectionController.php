<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string  $collection
     * @param Request $request
     *
     * @return Response
     */
    public function index(string $collection, Request $request)
    {
        $page = (int)$request->get('p', 1);

        $dbname = config()->get('mongo.database');

        $collection = (new Client())->{$dbname}->{$collection};

        $count = $collection->countDocuments();

        $filters = [];

        if ($date = $request->get('date-input')) {
            $filters['last_scraped'] = $date;
        }

        $datas = $collection->find($filters, ['skip' => $page * 10, 'limit' => 10])->toArray();

        foreach ($datas as $index => $data) {
            foreach ((array)$data as $_index => $datum) {
                $datas[$index][$_index] = Str::limit(strip_tags((string)$datum));
            }
        }

        return view('list', compact('datas'), [
            'collection' => $collection->getCollectionName(),
            'pages'      => $count / 10,
            'current'    => $page,
            'prev'       => $page - 1,
            'next'       => $page + 1,
            'date'       => $date
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $collection
     * @param string $id
     *
     * @return mixed
     */
    public function show(string $collection, string $id)
    {
        $dbname = config()->get('mongo.database');

        $collection = (new Client())->{$dbname}->{$collection};

        $data = $collection->findOne(['_id' => new ObjectId($id)]);

        return view('view', compact('data'), [
            'collection' => $collection->getCollectionName()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $collection
     * @param string $id
     *
     * @return mixed
     */
    public function edit(string $collection, string $id)
    {
        $dbname = config()->get('mongo.database');

        $collection = (new Client())->{$dbname}->{$collection};

        $data = $collection->findOne(['_id' => new ObjectId($id)]);

        return view('edit', compact('data'), [
            'collection' => $collection->getCollectionName()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string  $collection
     * @param string  $id
     *
     * @return mixed
     */
    public function update(Request $request, string $collection, string $id)
    {
        $data = $request->except('_method', '_token', '_id', 'id');

        $dbname = config()->get('mongo.database');

        $collection = (new Client())->{$dbname}->{$collection};

        $collection->updateOne(['_id' => new ObjectId($id)], ['$set' => $data]);

        return \response()->redirectToRoute('{collection}.edit', [
            'collection' => $collection->getCollectionName(),
            'id'         => $id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $collection
     * @param string $id
     *
     * @return mixed
     */
    public function destroy(string $collection, string $id)
    {
        $dbname = config()->get('mongo.database');

        $collection = (new Client())->{$dbname}->{$collection};

        $collection->deleteOne(['_id' => new ObjectId($id)]);

        return \response()->redirectToRoute('{collection}.index', [
            'collection' => $collection->getCollectionName()
        ]);
    }
}
