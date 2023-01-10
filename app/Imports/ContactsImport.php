<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\ContactTag;
use App\Models\Tag;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;

class ContactsImport implements WithEvents, WithStartRow, OnEachRow

{

    public $date = null;
    public $tag = null;

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function initTag(){
        $this->date = date('d.m.Y H:i');
        $this->tag = Tag::firstOrCreate(['text'=>"импорт " . $this->date]);
        $this->tag->color  = "#00FF00" ;
        $this->tag->save();
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $tagsList = $row[6] ?? '';
        $tagsList = array_map(function ($v) {
            return trim($v);
        },
            explode(',', $tagsList));

        $tagList = [];
        if (!empty($tagsList)){
            foreach ($tagsList as $tagEntity){
                $tagList[] = Tag::firstOrCreate(['text'=>$tagEntity]);
            }
        }


        $contact = new Contact(
            [
               'firstname'=>$row[1],
               'lastname' =>$row[2],
                'patrony'=>$row[3],
                'email'=>$row[4],
                'phone' => $row[5],
            ]
        );
        $contact->save();
        ContactTag::updateOrCreate(['tag_id' => $this->tag->id, 'contact_id' => $contact->id]);
        foreach ($tagList as $tag) {
            ContactTag::updateOrCreate(['tag_id' => $tag->id, 'contact_id' => $contact->id]);
        }
    }

    public function registerEvents(): array
    {
        return [

            AfterImport::class => [self::class, 'afterImport'],

        ];
    }

   public static function afterImport(AfterImport $event)
    {
        //
    }
}
