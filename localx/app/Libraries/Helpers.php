<?php
namespace  App\Libraries;

use Auth;
use DB;
use App\Models\loglar;
use Session;

class Helpers {



	public static function YetkiTuru($data){ 
		if($data==0){
			return "Kısıtlı";
		} else {return "Tam Yetkili";}
	} 
	
	public static function seola($tr1){ 
		$turkce=array("ş","Ş","ı","(",")","'","ü","Ü","ö", "Ö","ç","Ç"," ","/","*","?","ş","Ş","ı","ğ","Ğ","İ","ö","Ö","Ç","ç", "ü","Ü"); 
		$duzgun=array("s","S","i","","","","u","U","o","O" ,"c","C","-","-","-","","s","S","i","g","G","I","o","O","C","c","u"," U"); 
		$tr1=str_replace($turkce,$duzgun,$tr1); 
		$tr1 = preg_replace("@[^A-Za-z0-9\-_]+@i","",$tr1);
		return strtolower($tr1);
	} 
	
	
	
	public static function TumuBuyuk($veri){
			$veri=str_replace('i','İ',$veri);
			return mb_strtoupper($veri, "UTF-8");
	}
	public static function TumuKucuk($veri){
			$veri=str_replace('İ','i',$veri);
			$veri=str_replace('Ü','ü',$veri);
			return mb_strtolower($veri, "UTF-8");
	}
	
	
	public static function OnlyTime( $value ) {
		try{
		return \Carbon\Carbon::parse( $value )->format( 'H:i' ); 
		} catch(\Exception $e){
		}
	}
	public static function OnlyDate( $value ) {
		try{
		return \Carbon\Carbon::parse( $value )->format( 'd.m.Y' ); 
		} catch(\Exception $e){
		}
	}
	
	
	
	
	public static function LogTut($tag,$id){
		loglar::create(array('user_id'=>Auth::user()->id,'name'=>Auth::user()->name,'ip'=>$_SERVER['REMOTE_ADDR'],'tag'=>$tag,'i_id'=>$id));	
	}
	
	public static function AdminMenu($name,$link,$modul_adi,$yetki_no,$icon=NULL,$target=NULL){
	
		if($target!=NULL){
			$target="target=\"".$target."\" ";
		}
		
		if((Auth::user()->full==1) or (Helpers::Modul($modul_adi,$yetki_no)) or ($modul_adi=="muaf")){
		$active	= (\Request::is($link) ? ' active ' : '');
		$icon	= ($icon ? $icon : '<i class="icon-action-redo"></i>');
		echo '<li class="nav-item'.$active.'"><a '.$target.'href="'.url($link).'" class="nav-link ">'.$icon.'<span class="title">'.$name.'</span></a></li>';
		}
			
	}
	
	public static function Modul($veri,$yetki_no=NULL){
	
		$data=DB::table('moduller')->where('prefix',$veri)->first();
		if(!isset($data->durum)){
			return 0;
		}	
		if($data->durum==0){
			return 0;
		} else {
		
		if(Auth::user()['full']==1){
			return 1;
		} else {
		
		if($yetki_no==NULL){
		
			if(isset(Session::get('modul')[$veri])){
				return 1;
			} else {
				return 0;
			}
		
		} else {
			
			
		
			$return=0;
			
			$yetki=explode('|',$yetki_no);
			foreach($yetki as $y){
				
				if(isset(Session::get('modul')[$veri]->$y)){
				if(Session::get('modul')[$veri]->$y==1){
					$return=1;
				}
				}
			}
			return $return;
			
			
			
		}
		
		}
		
		}
	}
	
	public static function Modul_Full($veri){
		
		if(Auth::user()->full==1){
			
			return 1;
			
		} else {
	
		$data=DB::table('users_modul')->where('user_id',Auth::id())->where('modul',$veri)->first();
		
		if(count($data)){
		return $data->full;
		} else {
			return "";
		}
		
		}
		
	}
	





}
?>