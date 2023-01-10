<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Tag;
use App\Models\ContactTag;
use Illuminate\Http\Request;
use App\Exports\ContactsExport;
use App\Imports\ContactsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Throwable;

class ContactController extends Controller
{

    protected function createQuery(Request $request){
        $query = Contact::query()
            ->with('tags')
            ->limit($request->input('limit', 100))
            ->offset($request->input('offset', 0));


        $tagIds = $request->input('tagid', null);

        if ($tagIds) {
            $query->whereHas('tags', function ($query) use ($tagIds) {
                $query->where(['tag_id' => array_shift($tagIds)]);
                foreach ($tagIds as $tagId) {
                    $query->orWhere(['tag_id' => $tagId]);
                }
            });
        }

        $tagNames = $request->input('tag', null);
        if ($tagNames) {
            $query->whereHas('tags', function ($query) use ($tagNames) {
                $query->where('text', 'ILIKE', '%' . array_shift($tagNames) . '%');
                foreach ($tagNames as $tagName) {
                    $query->orWhere('text', 'ilike', '%' . $tagName . '%');
                }
            });
        }
        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->createQuery($request);

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
                'firstname' => 'string',
                'lastname' => 'string',
                'patrony' => 'string',
                'email' => 'string',
                'phone' => 'string',
            ]
        );

        $contact = Contact::create($request->all());
        foreach ($request->all()['tags'] as $tag){
            ContactTag::create(['contact_id'=>$contact->id,'tag_id'=>$tag['id']]);
        }
        return $this->show($contact->id);
    }

    public function show($id)
    {
        $contact = Contact::query()
            ->with('tags')->where(['id' => $id])->get();
        if ($contact->isEmpty()) {
            return response()->json('Not found', 404);
        }
        return $contact[0];
    }


    public function update($id, Request $request)
    {
        $contact = Contact::query()
            ->with('tags')->where(['id' => $id])->get();
        if ($contact->isEmpty()) {
            return response()->json('Not found', 404);
        }

        $request->validate(
            [
                'firstname' => 'string',
                'lastname' => 'string',
                'patrony' => 'string',
                'email' => 'string',
                'phone' => 'string',
            ]
        );

        $contact[0]->update($request->all());
        ContactTag::destroy(
            array_map(function ($v) {
                return $v['id'];
            },ContactTag::query()->where(['contact_id'=>$contact[0]->id])->get()->toArray()));

        foreach ($request->all()['tags'] as $tag){
            ContactTag::create(['contact_id'=>$contact[0]->id,'tag_id'=>$tag['id']]);
        }

        return $this->show($contact[0]->id);
    }

    public function destroy($id)
    {
        $contact = Contact::query()
            ->with('tags')->where(['id' => $id])->get();
        if ($contact->isEmpty()) {
            return response()->json('Not found', 404);
        }
        $contact[0]->delete();

        return response()->json('ok');
    }

    public function export(Request $request)
    {
        $query = $this->createQuery($request);
        $export = new ContactsExport();
        $export->query = $query;
        return Excel::download($export, 'contacts.xlsx');
    }

    public function import(Request $request)
    {
        try {
            $import = new ContactsImport();
            $import->initTag();
            Excel::import($import, $request->file('contacts'), null, \Maatwebsite\Excel\Excel::XLSX);

            return \response()->json('ok');
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 400);
        }

        return response()->json('ok');
    }

}
