<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Supplier;
use DB;
use Carbon\Carbon;
use App\Company;
use Image;
use Illuminate\Support\Facades\File;
class SupplierController extends Controller
{
    Public function autocompletecustomercode(Request $request){
        if ($request->q) {
           $q=$request->q;
           $data=DB::table('suppliers')->where('customercode','like','%'.$q.'%')->get();
           $output='<ul class="dropdown-menu" style="display:block;position:relative;padding-left:10px;">';
           foreach ($data as $row) {
                $output .='<li class="liclick"><a href="#">'. $row->customercode .'</a></li>';

           }
           $output .='</ul>';
           return response($output);
        }
        
    }
	public function autocomplete(Request $request)
    {
    	if($request->active==2){
    		$data = Supplier::select("name")
        		->where('active','<>',$request->active)
        		->where('type',$request->type)
                ->whereIn('active',[0,1])
                ->where("name","LIKE","%{$request->input('query')}%")
                ->get();
    	}else{
    		$data = Supplier::select("name")
        		->where('active',$request->active)
        		->where('type',$request->type)
                ->whereIn('active',[0,1])
                ->where("name","LIKE","%{$request->input('query')}%")
                ->get();
    	}
        
   
        return response()->json($data);
    }

    
    public function supplierregister($status)
    {
    	if ($status==0) {
    		$text=['pagetitle'=>'Supplier','heading'=>'Supplier Register','title'=>'តារាងឈ្មោះអ្នកផ្គត់ផ្គង់','coltype'=>'0'];
    	}else if($status==1){
    		$text=['pagetitle'=>'Customer','heading'=>'Customer Register','title'=>'តារាងឈ្មោះអតិថិជន','coltype'=>'1'];
    	}
    	
    	$sups=Supplier::where('type',$status)->where('active',1)->orderBy('id','DESC')->get();
    	return view('suppliers.supplier',compact('sups','text'));
    }
    public function savesupplier(Request $request)
    {
    	$validator = Validator::make($request->all(), [
        'supplier_name' => 'required',
        
      ]);
    	if ($validator->passes()) {
    		$sup=new Supplier;
    		$sup->name=$request->supplier_name;
    		$sup->sex=$request->sex;
    		$sup->active=$request->active;
    		$sup->type=$request->coltype;
    		$sup->tel=$request->tel;
    		$sup->email=$request->email;
            if ($request->coltype==1) {
                $sup->customercode=$request->customercode;
                $sup->customerprice=$request->customerprice;
            }
    		$sup->address=$request->address;
    		$sup->save();
    		return response()->json(['success'=>'Save Completed.']);
    	}
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function updatesupplier(Request $request)
    {
        $sup=Supplier::find($request->supid);
    	$validator = Validator::make($request->all(), [
        'supplier_name' => 'required',
        
      ]);
    	if ($validator->passes()) {
    		
    		$sup->name=$request->supplier_name;
    		$sup->sex=$request->sex;
    		$sup->active=$request->active;
    		$sup->type=$request->coltype;
    		$sup->tel=$request->tel;
    		$sup->email=$request->email;
            if ($request->coltype==1) {
                $sup->customercode=$request->customercode;
                $sup->customerprice=$request->customerprice;
            }
    		$sup->address=$request->address;
    		$sup->save();
    		return response()->json(['success'=>'update Completed.']);
    	}
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function deletesupplier(Request $request)
    {
    	$current = Carbon::now();
      	$current->timezone('Asia/Phnom_Penh');
    	$buy=DB::table('purchases')->where('supplier_id', $request->supid)->exists();
    	$sale=DB::table('sales')->where('supplier_id', $request->supid)->exists();
    	if($buy || $sale){
    		DB::table('suppliers')->where('id',$request->supid)->update(['active'=>'0','updated_at'=>$current]);
    	}else{
    		DB::table('suppliers')->where('id',$request->supid)->delete();
    	}
    }
    public function restoresupplier(Request $request)
    {
    	$current = Carbon::now();
      	$current->timezone('Asia/Phnom_Penh');
    	DB::table('suppliers')->where('id',$request->supid)->update(['active'=>'1','updated_at'=>$current]);
    }
    public function supplierdata(Request $request)
    {
    	if($request->active==2){
    		$sups=Supplier::where('type',$request->coltype)->whereIn('active',[0,1])->orderBy('id','DESC')->get();
    	}else{
    		$sups=Supplier::where('type',$request->coltype)->where('active',$request->active)->orderBy('id','DESC')->get();
    	}
    	return view('suppliers.supplier-list',compact('sups'));
    	
    }
    public function suppliersearch(Request $request)
    {
    	if($request->active==2){
    		$sups=Supplier::where('type',$request->type)->where('name','like','%'.$request->name.'%')->where('active','<>',$request->active)->orderBy('id','DESC')->get();
    	}else{
    		$sups=Supplier::where('type',$request->type)->where('name','like','%'.$request->name.'%')->where('active',$request->active)->orderBy('id','DESC')->get();
    	}
    	
    	return view('suppliers.supplier-list',compact('sups'));
    	
    }

    //------------------company setup------------------------
    public function companyregister()
    {
        $companies=Company::all();
        return view('suppliers.company',compact('companies'));
    }
    public function savecompany(Request $request)
    {
        //return($request->all());
        $validator = Validator::make($request->all(), [
        'companyname' => 'required|',
        'subname'=>'required',
        'tel'=>'required',
        'address'=>'required',
        // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
      ]);


     if ($validator->passes()) {
          $current = Carbon::now();
          $current->timezone('Asia/Phnom_Penh');
          $nb=new Company;
          $nb->name=$request->companyname;
          $nb->subname=$request->subname;
          $nb->tel=$request->tel;
          $nb->email=$request->email;
          $nb->website=$request->website;
          $nb->address=$request->address;
          
          $nb->created_at=$current;
          $nb->updated_at=$current;
          $imgname='';
          if($request->hasFile('image')){
            $image = $request->file('image');
            $imgname = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('logo'), $imgname);
            
          }
          $nb->logo=$imgname;
          $nb->save();
          return response()->json(['success'=>'Save Company Completed.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
     public function updatecompany(Request $request)
    {
        //return($request->all());
        $validator = Validator::make($request->all(), [
        'companyname' => 'required|',
        'subname'=>'required',
        'tel'=>'required',
        'address'=>'required',
        // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
      ]);

        $nb=Company::find($request->comid);
     if ($validator->passes()) {
          $current = Carbon::now();
          $current->timezone('Asia/Phnom_Penh');
         
          $nb->name=$request->companyname;
          $nb->subname=$request->subname;
          $nb->tel=$request->tel;
          $nb->email=$request->email;
          $nb->website=$request->website;
          $nb->address=$request->address;
          $nb->updated_at=$current;

          $old_image=$request->old_image;
          $image=$request->file('image');
          if($image){
            File::delete(public_path('logo/'.$old_image));
            $imgname=time().'-'.$image->getClientOriginalName();
            $image->move(public_path('logo/'),$imgname);
          }else
            {
                $imgname=$old_image;
            }
          $nb->logo=$imgname;

          $nb->save();
          return response()->json(['success'=>'Update Company Completed.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function companydata(Request $request)  
    {
        $companies=Company::all();
        return view('suppliers.companylist',compact('companies'));
    }
    public function getcompanyinfobyid(Request $request)
    {
        $coms=Company::where('id',$request->id)->first();
        return response($coms);
    }
    public function destroycompany(Request $request)
    {
        $com=Company::find($request->id);
        if($com->delete()){
            File::delete(public_path('logo/'.$request->logo));
        }
    }
}
