<?php

namespace App\Exports;

use App\Models\Action;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ActionsExport implements FromView
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = Action::with('promoteur');

        if (!empty($this->filters['promoteur_id'])) {
            $query->where('promoteur_id', $this->filters['promoteur_id']);
        }

        if (!empty($this->filters['date_debut']) && !empty($this->filters['date_fin'])) {
            $query->whereBetween('date_action', [$this->filters['date_debut'], $this->filters['date_fin']]);
        }

        if (isset($this->filters['entreprise_active'])) {
            $query->where('entreprise_active', $this->filters['entreprise_active']);
        }

        return view('exports.actions_excel', [
            'actions' => $query->get()
        ]);
    }
}
