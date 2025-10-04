<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Utiliser 'name' (correct pour la table users)
        return User::select('name', 'email', 'role', 'created_at')->get();
    }

    /**
     * Définir les en-têtes du fichier Excel
     */
    public function headings(): array
    {
        return [
            'Nom',
            'Email',
            'Rôle',
            'Date de création'
        ];
    }
}
