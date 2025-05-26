<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\moduller, App\Models\users_modul;
use App\Models\User,App\Models\musteriler;
use App\Libraries\Helpers;
use Hash;

class MusteriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function index(){
		
		return View('panel.musteriler.index');
	}
	
	public function ajaxTableMusteriler(){
		
		$musteriler=musteriler::orderBy("id","asc")->get();
		$datatables=DataTables::of($musteriler)
		->addColumn('durums', function($user) {
				$renk="label-success";
				$durum="Aktif";
				if($user->enable==0)
				{
					$renk="label-danger";
					$durum="Pasif";
				}
				return '<span class="label '.$renk.'">'.$durum.'</span>';
			
            }) 
		->addColumn('action', function ($user) {
			
			// $islemler="<a href='".URL('panel/gorev/duzenle',$user->id)."' class='btn btn-info btn-sm' title='Görev Düzenle'><i class='fa fa-edit'></i></a>";
			$islemler="&nbsp <a href='".URL('panel/musteriler/duzenle',$user->id)."' class='btn btn-success btn-sm' title='Kullanıcı Detay'><i class='fa fa-search-plus'></i></a>";
			
			return $islemler;
		})
		->rawColumns(['durums','action']);
		return $datatables->make(true);
	}
	
	public function ekle()
	{
		return view("panel.musteriler.ekle");
	}
	public function eklePost(Request $request)
	{
		
		$request->validate([
			'tc'		=> 'required|digits:11|unique:musteriler,tc',
			'name'		=> 'required|max:255',
			'telefon'	=> 'required|digits:11',
			'email'		=> 'required|email|max:255|unique:musteriler,email'
		], [
			'tc.required'  		=> 'Tc alanı zorunludur.',
			'tc.digits'    		=> 'Tc numarası 11 haneli olmalıdır.',
			'tc.unique'      	=> 'Tc daha önceden var. Farklı bir tc deneyiniz.',
			
			'name.required'     => 'Ad Soyad alanı zorunludur.',
			'name.max'          => 'Ad Soyad en fazla 255 karakter olabilir.',
		
			'telefon.required'  => 'Telefon alanı zorunludur.',
			'telefon.digits'    => 'Telefon numarası 11 haneli olmalıdır.',
		
			'email.required'    => 'Email alanı zorunludur.',
			'email.email'       => 'Geçerli bir email adresi giriniz.',
			'email.max'         => 'Email en fazla 255 karakter olabilir.',
			'email.unique'      => 'Email daha önceden var. Farklı bir mail adresi deneyiniz.',
		]);

		
		$kontrol=musteriler::where("email",$request->email)->count();
		
		if($kontrol>0)
		{
			return redirect()->back()->with("hata","Kullanıcı Daha Önceden Mevcut...");
		}
	
		$query = musteriler::create([
			'tc' 			=> $request->tc,
			'ad_soyad' 		=> $request->name,
			'email' 		=> $request->email,
			'telefon' 		=> $request->telefon,
			'adres' 		=> $request->adres
			]);
	
		// Helpers::LogTut('Personel','Kullanıcı Eklendi',$query->id);
		return redirect("panel/musteriler")->with("ok","Müşteri Eklendi");
	}
	
	public function duzenle($id)
	{
		
		$musteri = musteriler::where('id',$id)->first();
		
		return View('panel.musteriler.duzenle',compact('musteri'));
	}
	
	public function duzenlePost(Request $request,$id){
		
		$request->validate([
			'tc'		=> 'required|digits:11',
			'name'		=> 'required|max:255',
			'telefon'	=> 'required|digits:11',
			'email'		=> 'required|email|max:255'
		], [
			'tc.required'  		=> 'Tc alanı zorunludur.',
			'tc.digits'    		=> 'Tc numarası 11 haneli olmalıdır.',
			
			'name.required'     => 'Ad Soyad alanı zorunludur.',
			'name.max'          => 'Ad Soyad en fazla 255 karakter olabilir.',
		
			'telefon.required'  => 'Telefon alanı zorunludur.',
			'telefon.digits'    => 'Telefon numarası 11 haneli olmalıdır.',
		
			'email.required'    => 'Email alanı zorunludur.',
			'email.email'       => 'Geçerli bir email adresi giriniz.',
			'email.max'         => 'Email en fazla 255 karakter olabilir.',
		]);
		
		$kontrol=musteriler::where("id","<>",$id)->where("tc",$request->tc)->count();
		if($kontrol>0)
		{
			return redirect()->back()->with('hata', 'Tc daha önceden mevcut');
		}
		
		$kontrol2=musteriler::where("id","<>",$id)->where("email",$request->email)->count();
		if($kontrol2>0)
		{
			return redirect()->back()->with('hata', 'Email daha önceden mevcut');
		}
		
		$array=array(
			'tc' 			=> $request->tc,
			'ad_soyad' 		=> $request->name,
			'email' 		=> $request->email,
			'telefon' 		=> $request->telefon,
			'adres' 		=> $request->adres
		);
		
		
		$d = musteriler::where('id',$request->id)->update($array);
		
		// Helpers::LogTut('Personel','Kullanıcı Düzenlendi',$request->id);
		
		return redirect()->back()->with('ok', 'Kayıt Düzenlendi');
	}
	
	
}
