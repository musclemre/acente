<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\moduller, App\Models\users_modul;
use App\Models\User;
use Hash;
use App\Libraries\Helpers;

class KullaniciController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function index(){
		
		return View('panel.kullanicilar.index');
	}
	
	public function ajaxTableKullanicilar(){
		
		$kullanicilar=User::orderBy("email","asc")->get();
		$datatables=DataTables::of($kullanicilar)
		->addColumn('durums', function($user) {
				$renk="label-success";
				$durum="Aktif";
				if($user->durum==0)
				{
					$renk="label-danger";
					$durum="Pasif";
				}
				return '<span class="label '.$renk.'">'.$durum.'</span>';
			
            }) 
		->addColumn('action', function ($user) {
			
			// $islemler="<a href='".URL('panel/gorev/duzenle',$user->id)."' class='btn btn-info btn-sm' title='Görev Düzenle'><i class='fa fa-edit'></i></a>";
			$islemler="&nbsp <a href='".URL('panel/kullanicilar/duzenle',$user->id)."' class='btn btn-success btn-sm' title='Kullanıcı Detay'><i class='fa fa-search-plus'></i></a>";
			
			return $islemler;
		})
		->rawColumns(['durums','action']);
		return $datatables->make(true);
	}
	
	public function ekle()
	{
		$data=moduller::where('durum',1)->orderBy('id','ASC')->get();
		return view("panel.kullanicilar.ekle",compact("data"));
	}
	public function eklePost(Request $request)
	{
		
		 // Doğrulama kuralları
		$rules = [
			'name'			=> 'required|max:255',
			'email'			=> 'required|max:255|unique:users,email',
			'password'		=> 'required|min:6|max:255',
			'telefon'		=> 'required|max:11',
		];
	
		// Hata mesajları
		$messages = [
			'name.required'				=> 'Ad ve Soyad alanı zorunludur.',
			'name.max'					=> 'Ad ve Soyad en fazla 255 karakter olabilir.',
			'email.required'			=> 'Kullanıcı alanı zorunludur.',
			'email.max'					=> 'Kullanıcı adı en fazla 255 karakter olabilir.',
			'email.unique'				=> 'Email daha daha önceden kullanılmış.',
			'password.required'			=> 'Şifre alanı zorunludur.',
			'password.min'				=> 'Şifre en az 6 karakter olmalıdır.',
			'password.max'				=> 'Şifre en fazla 255 karakter olabilir.',
			'telefon.required'			=> 'Telefon alanı zorunludur.',
			'telefon.min'				=> 'Şifre en az 11 karakter olmalıdır.',
		];

		$request->validate($rules, $messages);
	
		$kontrol=User::where("email",$request->email)->count();
		
		if($kontrol>0)
		{
			return redirect()->back()->with("hata","Kullanıcı Daha Önceden Mevcut...");
		}
	
		$query = User::create([
			'name' 				=> $request->name,
			'email' 			=> $request->email,
			'password' 			=> bcrypt($request->password),
			'full' 				=> $request->full_yetki,
			'telefon' 			=> $request->telefon]
			);
	
		$moduller=moduller::orderBy('id','ASC')->get();
		foreach($moduller as $dx){
			$m=$dx->prefix;
		
			if(isset($request->$m)){
				
			$crm=array('user_id'=>$query->id,'modul'=>$dx->prefix);
			foreach($request->$m as $d){
				$crm[$d]='1';
			}
			users_modul::create($crm);
			}
		}
	
		// Helpers::LogTut('Personel','Kullanıcı Eklendi',$query->id);
		return redirect("panel/kullanicilar")->with("ok","Yeni Kullanıcı Eklendi");
	}
	
	public function duzenle($id)
	{
		
		$moduller	= moduller::where('durum',1)->orderBy('id','ASC')->get();	
		$modul		= users_modul::where('user_id',$id)->get();
		$kullanici	= User::where('id',$id)->first();
		
		return View('panel.kullanicilar.duzenle')
			->with('moduller',$moduller)
			->with('kullanici',$kullanici)
			->with('modul',$modul);
	}
	
	public function duzenlePost(Request $request,$id){
		
		// Doğrulama kuralları
		$rules = [
			'name'		=> 'required|max:255',
			'telefon' 	=> 'required|regex:/^[0-9]+$/|max:11',
		];
	
		// Hata mesajları
		$messages = [
			'name.required'				=> 'Ad ve Soyad alanı zorunludur.',
			'name.max'					=> 'En fazla 255 karater girilebilir.',
			'telefon.required'			=> 'Telefon Zorunludur.',
			'telefon.regex'       		=> 'Telefon sadece rakamlardan oluşmalıdır.',
		];
	
		// Doğrulamayı çalıştır
		$request->validate($rules, $messages);
		
		
		
		$array=array(
			'name' 		=> $request->name,
			'telefon' 	=> $request->telefon,
			'full' 		=> $request->full_yetki
		);
		
		if($request->password!=NULL){	
			$array['password']=Hash::make($request->password);
		}
		
		$d = User::where('id',$request->id)->update($array);
	
		users_modul::where('user_id',$request->id)->delete();
	
		$moduller=moduller::orderBy('id','ASC')->get();
		foreach($moduller as $d){
		
		$m=$d->prefix;
		
			if(isset($request->$m)){
				echo 1;
			$crm=array('user_id'=>$request->id,'modul'=>$d->prefix);
			foreach($request->$m as $d){
				$crm[$d]='1';
			}
			users_modul::create($crm);
			}
		}
		
		// Helpers::LogTut('Personel','Kullanıcı Düzenlendi',$request->id);
		
		return redirect()->back()->with('ok', 'Kayıt Düzenlendi');
	}
	
	
}
