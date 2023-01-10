<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;


class ContactsExport implements FromView
{

    use Exportable;

 /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'contacts.xlsx';

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public $query;

    public function view(): View
    {

        return view('exports.contacts',[
            'contacts' => $this->query->get()
        ]);
    }
}
