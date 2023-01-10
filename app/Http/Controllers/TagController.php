<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends Controller
{

    public function index(Request $request)
    {
        $query =  Tag::query()
            ->limit($request->input('limit',100))
            ->offset($request->input('offset',0));


        $total = $query->count();
        return [
            'data' => $query->get(),
            'total' => $total
        ];
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'text' => 'required',
                'color' => 'string',
            ]
        );

        $tag =Tag::create($request->all());

        return $this->show($tag->id);
    }

    public function show($id)
    {
        $tag = Tag::query()->where(['id' => $id])->get();
        if ($tag->isEmpty()) {
            return response()->json('Not found', 404);
        }
        return $tag[0];
    }

    public function update($id, Request $request)
    {
        $tag = Tag::query()->where(['id' => $id])->get();
        if ($tag->isEmpty()) {
            return response()->json('Not found', 404);
        }
        $request->validate(
            [
                'text' => 'required',
                'color' => 'string',
            ]
        );

        $tag[0]->update($request->all());

        return response()->json('ok');
    }

    public function destroy($id)
    {
        $tag = Tag::query()->where(['id' => $id])->get();
        if ($tag->isEmpty()) {
            return response()->json('Not found', 404);
        }

        $tag[0]->delete();

        return response()->json('ok');
    }
}
