<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Acente;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
                    'hata' => 'Veri alınırken hata oluştu: ' . $e->getMessage()
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
        // Form validasyonları
        $validated = $request->validate([
            'acente_adi' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
            'acente_aciklama' => [
                'required',
                'string',
                'max:500',
            ],
            'sorumlu_adi' => [
                'nullable',
                'string',
                'max:255'
            ],
            'sorumlu_telefon' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]+$/' // Sadece rakam, boşluk, tire, artı ve parantez
            ],
            'slug' => [
                'required',
                'string',
                'max:100',
                'min:3',
                'regex:/^[a-z0-9\-]+$/', // Sadece küçük harf, rakam ve tire
                Rule::unique('acenteler', 'slug') // Benzersizlik kontrolü
            ],
            'durum' => [
                'required',
                'boolean'
            ]
        ], [
            // Özel hata mesajları
            'acente_adi.required' => 'Acente adı zorunludur.',
            'acente_adi.min' => 'Acente adı en az 3 karakter olmalıdır.',
            'acente_adi.max' => 'Acente adı en fazla 255 karakter olabilir.',

            'acente_aciklama.required' => 'Acente açıklaması zorunludur.',
            'acente_aciklama.max' => 'Acente açıklaması en fazla 500 karakter olabilir.',

            'sorumlu_adi.max' => 'Sorumlu adı en fazla 255 karakter olabilir.',

            'sorumlu_telefon.max' => 'Telefon numarası en fazla 20 karakter olabilir.',
            'sorumlu_telefon.regex' => 'Geçerli bir telefon numarası giriniz.',

            'slug.required' => 'Slug zorunludur.',
            'slug.min' => 'Slug en az 3 karakter olmalıdır.',
            'slug.max' => 'Slug en fazla 100 karakter olabilir.',
            'slug.regex' => 'Slug sadece küçük harf, rakam ve tire içerebilir.',
            'slug.unique' => 'Bu slug zaten kullanılmaktadır.',

            'durum.required' => 'Durum seçimi zorunludur.',
            'durum.boolean' => 'Geçerli bir durum seçiniz.'
        ]);

        // Slug'ı otomatik olarak temizle ve formatla
        $validated['slug'] = Str::slug($validated['slug']);

        do
            $kod = str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        while (Acente::where('kod', $kod)->exists());

        // Acente kaydını oluştur
        $acente = Acente::create([
            'kod' => $kod,
            'acente_adi' => $validated['acente_adi'],
            'acente_aciklama' => $validated['acente_aciklama'],
            'sorumlu_adi' => $validated['sorumlu_adi'],
            'sorumlu_telefon' => $validated['sorumlu_telefon'],
            'slug' => $validated['slug'],
            'durum' => $validated['durum'],
            'created_by' => auth()->id(), // Oluşturan kullanıcı
        ]);

        // Başarı mesajı ile yönlendir
        return redirect()
            ->route('panel.acenteler.index')
            ->with('ok', 'Acente başarıyla oluşturuldu.');
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
        $acente = Acente::find($id);
        return view('panel.acente.edit', compact('acente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $acente = Acente::find($id);

        // Form validasyonları
        $validated = $request->validate([
            'acente_adi' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
            'acente_aciklama' => [
                'required',
                'string',
                'max:500',
            ],
            'sorumlu_adi' => [
                'nullable',
                'string',
                'max:255'
            ],
            'sorumlu_telefon' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]+$/' // Sadece rakam, boşluk, tire, artı ve parantez
            ],
            'slug' => [
                'required',
                'string',
                'max:100',
                'min:3',
                'regex:/^[a-z0-9\-]+$/', // Sadece küçük harf, rakam ve tire
                Rule::unique('acenteler', 'slug')->ignore($acente->id) // Kendi kaydını devre dışı bırak
            ],
            'durum' => [
                'required',
                'boolean'
            ]
        ], [
            // Özel hata mesajları
            'acente_adi.required' => 'Acente adı zorunludur.',
            'acente_adi.min' => 'Acente adı en az 3 karakter olmalıdır.',
            'acente_adi.max' => 'Acente adı en fazla 255 karakter olabilir.',

            'acente_aciklama.required' => 'Acente açıklaması zorunludur.',
            'acente_aciklama.max' => 'Acente açıklaması en fazla 500 karakter olabilir.',

            'sorumlu_adi.max' => 'Sorumlu adı en fazla 255 karakter olabilir.',

            'sorumlu_telefon.max' => 'Telefon numarası en fazla 20 karakter olabilir.',
            'sorumlu_telefon.regex' => 'Geçerli bir telefon numarası giriniz.',

            'slug.required' => 'Slug zorunludur.',
            'slug.min' => 'Slug en az 3 karakter olmalıdır.',
            'slug.max' => 'Slug en fazla 100 karakter olabilir.',
            'slug.regex' => 'Slug sadece küçük harf, rakam ve tire içerebilir.',
            'slug.unique' => 'Bu slug zaten kullanılmaktadır.',

            'durum.required' => 'Durum seçimi zorunludur.',
            'durum.boolean' => 'Geçerli bir durum seçiniz.'
        ]);

        // Slug'ı otomatik olarak temizle ve formatla
        $validated['slug'] = Str::slug($validated['slug']);

        // Acente kaydını oluştur
        $acente->update([
            'acente_adi' => $validated['acente_adi'],
            'acente_aciklama' => $validated['acente_aciklama'],
            'sorumlu_adi' => $validated['sorumlu_adi'],
            'sorumlu_telefon' => $validated['sorumlu_telefon'],
            'slug' => $validated['slug'],
            'durum' => $validated['durum'],
            'updated_by' => auth()->id(), // Güncelleyen kullanıcı
        ]);

        // Başarı mesajı ile yönlendir
        return redirect()
            ->route('panel.acenteler.index')
            ->with('ok', 'Acente başarıyla oluşturuldu.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $acente = Acente::find($id);

        if ($acente->delete())
            return true;
        else
            return false;
    }
}
