<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportUser implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return User::select("id", "firstname", "email")->get();
        return User::all();
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings()
    {
        return ["ID", "Name", "Email"];
    }
}