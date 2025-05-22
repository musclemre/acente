<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Acente;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AcenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->datatable == 1) {
            try {
                $query = Acente::query();

                return DataTables::of($query)
                    ->editColumn('created_at', function ($acente) {
                        return $acente->created_at ? date('d/m/Y H:i', strtotime($acente->created_at)) : '-';
                    })
                    ->editColumn('durum', function ($acente) {
                        if ($acente->durum == 1) {
                            return '<span class="badge badge-success">Aktif</span>';
                        } else {
                            return '<span class="badge badge-danger">Pasif</span>';
                        }
                    })
                    ->addColumn('sorumlu', function ($acente) {
                        $sorumlu_adi = $acente->sorumlu_adi ?? 'Belirtilmemiş';
                        $sorumlu_telefon = $acente->sorumlu_telefon ?? '';
                        return $sorumlu_adi . ($sorumlu_telefon ? ' - ' . $sorumlu_telefon : '');
                    })
                    ->rawColumns(['durum']) // HTML içeriği için gerekli
                    ->make(true);

            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Veri alınırken hata oluştu: ' . $e->getMessage()
                ], 500);
            }
        }

        return view('panel.acente.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.acente.create');
    }

    public function checkSlug(Request $request)
    {
        if ($request->slug) {
            return Acente::where('slug', $request->slug)->exists();
        }

        return true;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
