<?php

namespace App\Imports;

use App\Models\Annuaires;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ExcelImportAnnuaire implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Annuaires([
            'societe'=> $row['societe'],
            'prenom_et_nom'   => $row['prenom_et_nom'],
            'poste_de_responsabilite'   => $row['poste_de_responsabilite'],
            'telephone'   => $row['telephone'],
            'email'   => $row['email'],
        ]);
    }
}
