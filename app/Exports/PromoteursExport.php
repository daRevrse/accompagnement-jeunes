<?php

namespace App\Exports;

use App\Models\Promoteur;
use Maatwebsite\Excel\Concerns\FromCollection;

class PromoteursExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Promoteur::select('name', 'email', 'projet', 'date_entree_accompagnement')->get();
    }

    public function headings(): array
    {
        return ['Nom', 'Email', 'Projet', 'Date d\'entrée'];
    }
}
