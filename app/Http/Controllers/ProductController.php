<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Brand;
use App\Product;
use App\FileUpload;
use App\ProductBarcode;
use App\StockProcess;
use App\Unit;
use App\product_score;
use Carbon\Carbon;
use File;
use DB;
use Validator;
class ProductController extends Controller
{
  public function getproductscorelisthistory(Request $request)
  {
    $sc=product_score::where('product_id',$request->pid)->orderBy('id','DESC')->get();
    return view('products.showscorelistbyitem',compact('sc'));
  }
  public function getinfobyscoreid(Request $request)
  {
    $sc=product_score::find($request->id);
    return response($sc);
  }
  public function postproductscore(Request $request)
  {
    //return($request->all());
    $current = Carbon::now();
    $current->timezone('Asia/Phnom_Penh');
    $ps=new product_score;
    $ps->user_id=$request->userid;
    $ps->dd=$current;
    $ps->product_id=$request->pid;
    $ps->qtyset=$request->qtyset;
    $ps->unit=$request->unit;
    $ps->qty=$request->qty;
    $ps->price=str_replace(',','',$request->price);
    $ps->cur=$request->cur;
    $ps->formonth=$request->formonth;
    $ps->foryear=$request->foryear;
    if($ps->save()){
      $id=$ps->id;
      DB::table('products')->where('id',$request->pid)
      ->update(['qty_target'=>$request->qtyset,'target_unit'=>$request->unit,'qty_score'=>$request->qty,'scoreprice'=>str_replace(',','',$request->price),'scorecur'=>$request->cur,'score_id'=>$id,'formonth'=>$request->formonth,'foryear'=>$request->foryear]);
      return response()->json(['success'=>'Save Completed.']);
    }
     return response()->json(['error'=>$validator->errors()->all()]);
  }
   public function updateproductscore(Request $request)
  {
    //return($request->all());
    $current = Carbon::now();
    $current->timezone('Asia/Phnom_Penh');
    $ps=product_score::find($request->scid);
    $ps->user_id=$request->userid;
    $ps->updated_at=$current;
    $ps->product_id=$request->pid;
    $ps->qtyset=$request->qtyset;
    $ps->unit=$request->unit;
    $ps->qty=$request->qty;
    $ps->price=str_replace(',','',$request->price);
    $ps->cur=$request->cur;
    $ps->formonth=$request->formonth;
    $ps->foryear=$request->foryear;
    if($ps->save()){
      $id=$ps->id;
      DB::table('products')->where('id',$request->pid)
      ->update(['qty_target'=>$request->qtyset,'target_unit'=>$request->unit,'qty_score'=>$request->qty,'scoreprice'=>str_replace(',','',$request->price),'scorecur'=>$request->cur,'score_id'=>$id,'formonth'=>$request->formonth,'foryear'=>$request->foryear]);
      return response()->json(['success'=>'Save Completed.']);
    }
     return response()->json(['error'=>$validator->errors()->all()]);
  }
  public function deleteproductscore(Request $request)
  {
    $sc=product_score::findOrFail($request->scid);
    if($sc->delete()){
      DB::table('products')->where('id',$request->pid)->where('score_id',$request->scid)
      ->update(['qty_target'=>'0','qty_score'=>'0','scoreprice'=>'0','score_id'=>'0','formonth'=>'0','foryear'=>'0']);
      return response()->json(['success'=>'Delete Completed.']);
    }
     return response()->json(['error'=>$validator->errors()->all()]);
  }
   public function productunit(Request $request)
    {
        //return($request->all());
        $ic=DB::table('products')
            ->join('product_barcodes','products.id','=','product_barcodes.product_id')
            ->where('products.id',$request->pid)
            ->orderBy('product_barcodes.id','ASC')
            ->get();
        return response($ic);
    }
  public function product_score()
  {
    
      $categories=Category::where('active','1')->orderBy('name')->get();
      $brands=Brand::where('active','1')->get();
      
      return view('products.product_score',compact('categories','brands'));
  }
  public function autocomplete(Request $request)
    {
        $data = Product::select("name")
                ->whereIn('status',[0,1])
                ->where("name","LIKE","%{$request->input('query')}%")
                ->get();
   
        return response()->json($data);
    }
 
  public function checkexistbarcode(Request $request)
  {
      if($request->ajax()){
          $barcode=DB::table('product_barcodes')->where('product_id','<>',$request->pid)->where('barcode',$request->bk)->exists();
           if($barcode ==true){
              return response()->json(['exists'=>'this barcode already exists.']);
           }else{
              return response()->json(['notexist'=>'this barcode not exists.']);
           }
         
        }
  }
  public function getlastbarcodelist()
  {
    $units=Unit::all();
    $id = DB::table('products')->max('id');
    $pbarcodes=DB::table('product_barcodes')->where('product_id',$id)->orderBy('id','ASC')->get();
    return view('products.tblbarcodelist',compact('pbarcodes','units'));
  }
  public function Product_Create()
    {
      $current = Carbon::now();
      $current->timezone('Asia/Phnom_Penh');
     // dd($current);
    	$categories=Category::where('active','1')->orderBy('name')->get();
    	$brands=Brand::where('active','1')->get();
      $units=Unit::all();
      $products=Product::whereDate('created_at',$current)->where('status',1)->get();
      $id = DB::table('products')->max('id');
      $pbarcodes=DB::table('product_barcodes')->where('product_id',$id)->orderBy('id','ASC')->get();
      //dump($pbarcode);
      //dd($products);
    	return view('products.product_create',compact('categories','brands','products','units','pbarcodes'));
    }

    public function getsavedproduct(Request $request)
    {
       $current = Carbon::now();
       $current->timezone('Asia/Phnom_Penh');
       $products=Product::whereDate('created_at',$current)->where('status',1)->get();
       return view('products.productlist',compact('products'));
    }
    public function getproductbycategory(Request $request)
    {
      if($request->status==0){
          if($request->brid==0){
              $products=Product::where('category_id',$request->catid)->where('status',$request->status)->orderBy('updated_at','DESC')->get();
           }else{
              $products=Product::where('category_id',$request->catid)->where('brand_id',$request->brid)->where('status',$request->status)->orderBy('updated_at','DESC')->get();
           }
           return view('products.bin',compact('products'));
      }else{
          if($request->brid==0){
              $products=Product::where('category_id',$request->catid)->where('status',$request->status)->orderBy('code')->get();
           }else{
              $products=Product::where('category_id',$request->catid)->where('brand_id',$request->brid)->where('status',$request->status)->orderBy('code')->get();
           }
           return view('products.productlist',compact('products'));
      }
       
    }
    public function getproductbycategoryscore(Request $request)
    {
      
          if($request->brid==0){
              $products=Product::where('category_id',$request->catid)->where('status',$request->status)->orderBy('code')->get();
           }else{
              $products=Product::where('category_id',$request->catid)->where('brand_id',$request->brid)->where('status',$request->status)->orderBy('code')->get();
           }
           return view('products.productlistscore',compact('products'));
      
       
    }
    public function getproductallcategory(Request $request)
    {
       if($request->status==1){
          $products=Product::where('status',1)->orderBy('category_id')->orderBy('brand_id')->orderBy('code')->get();
          return view('products.productlist',compact('products'));
       }else if($request->status==0){
          $products=Product::where('status',0)->orderBy('updated_at','DESC')->get();
          return view('products.bin',compact('products'));
       }
       
    }
     public function getproductallcategoryscore(Request $request)
    {
       if($request->status==1){
          $products=Product::where('status',1)->orderBy('category_id')->orderBy('brand_id')->orderBy('code')->get();
          return view('products.productlistscore',compact('products'));
       }
       
    }
    public function getbrandid(Request $request)
    {
        $brands=Brand::where('category_id',$request->catid)->orderBy('name')->get();
        return response($brands);
    }
    //-----------------------------------------------
  public function category_add(Request $request)
    {
    	if($request->ajax()){
    		 //return response($request->all());
    		return response(Category::create($request->all()));
    	}
    }
    //--------------------------------------------------
  public function brand_add(Request $request)
    {
    	if($request->ajax()){
    		 //return response($request->all());
    		return response(Brand::create($request->all()));
    	}
    }
  public function unit_add(Request $request)
    {
      if($request->ajax()){
         //return response($request->all());
        return response(Unit::create($request->all()));
      }
    }
  //--------------------------------------------------------------------
  public function Store(Request $request)
    {
     //return($request->all());
     $validator = Validator::make($request->all(), [
        'productcode' => 'required|unique:products,code,NULL,id,deleted_at,NULL',
        'productname' => 'required|',
        'barcode.*'=> 'required|unique:product_barcodes,barcode',
        'selunit'=>'required',
        'sel_category'=>'required',
        'sel_brand'=>'required',
        'stockqty'=>'required',
        'unitprice'=>'required'
        
      ]);

     if ($validator->passes()) {
          $current = Carbon::now();
          $current->timezone('Asia/Phnom_Penh');
          $np=new Product;
          $np->code=$request->productcode;
          $np->name=$request->productname;
          $np->user_id=$request->user_id;
          $np->category_id=$request->sel_category;
          $np->brand_id=$request->sel_brand;
          $np->description=$request->description;
          $np->stock=$request->stockqty;
          $np->itemunit=$request->selunit;
          $np->costprice=str_replace(',','',$request->unitprice);
          $np->cur=$request->cur1;
          $np->created_at=$current;
          $np->updated_at=$current;
          //$np->image=FileUpload::uploadphoto($request,'photo','photo');
          $imgname='';
          if($request->hasFile('image')){
            $image = $request->file('image');
            $imgname = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('photo'), $imgname);
            
          }
          $np->image=$imgname;
          //dump($np);
          if($np->save()){
            
            $id=$np->id;
            $stock=array('dd'=>$current,
                          'user_id'=>$request->user_id,
                          'product_id'=>$id,
                          'mode'=>'0',
                          'desr'=>'Stock Begining',
                          'quantity'=>$request->stockqty,
                          'unit'=>$request->selunit,
                          // 'amount'=>str_replace(',','',str_replace($request->cur1,'',$request->amount1)),
                          'amount'=>(float) $request->stockqty * (float) str_replace(',','',$request->unitprice),
                          'cur'=>$request->cur1,
                          'active'=>1,
                          'created_at'=>$current,
                          'updated_at'=>$current
                        );
            StockProcess::insert($stock);
            foreach ($request->barcode as $key => $value) {
              $data=array('product_id'=>$id,
                    'barcode'=>$value,
                    'unit'=>$request->unit[$key],
                    'price'=>str_replace(',','',$request->price[$key]),
                    'cur'=>$request->cur[$key],
                    'dealer'=>str_replace(',','',$request->dealer[$key]),
                    'member'=>str_replace(',','',$request->member[$key]),
                    'vip'=>str_replace(',','',$request->vip[$key]),
                    'suppervip'=>str_replace(',','',$request->suppervip[$key]),
                    'multiple'=>$request->multi[$key]);
              ProductBarcode::insert($data);
            }
          }
           return response()->json(['success'=>'Save New Product Completed.']);
       }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
//edit product
  public function edit(Request $request)
      {
        $product=Product::join('product_barcodes','products.id','=','product_barcodes.product_id')
                        ->where('products.id',$request->id)
                        ->select('products.*','product_barcodes.*','products.cur as buycur')
                        ->orderBy('product_barcodes.id','asc')
                        ->get();
        
        return response($product);
      }
//update product
  public function update1(Request $request)
    {
      //dump($request->all());
      $np= Product::findOrFail($request->product_id);
     
      $validator = Validator::make($request->all(), [
        'productcode' => 'required|unique:products,code,'.$np->id.',id,deleted_at,NULL',
        'productname' => 'required',
        'unit'=>'required',
        'selunit'=>'required',
        'sel_category'=>'required',
        'sel_brand'=>'required'
      ]);

       if ($validator->passes()) {
          $np->code=$request->productcode;
          $np->name=$request->productname;
          $np->user_id=$request->user_id;
          $np->category_id=$request->sel_category;
          $np->brand_id=$request->sel_brand;
          $np->description=$request->description;
          $np->itemunit=$request->selunit;
          //$np->cur=$request->cur1;
          $old_image=$request->old_image;
          $image=$request->file('image');
          if($image){
            File::delete(public_path('photo/'.$old_image));
            $imgname=time().'-'.$image->getClientOriginalName();
            $image->move(public_path('photo/'),$imgname);
          }else
            {
                $imgname=$old_image;
            }
          $np->image=$imgname;
          //dump($np);
          if($np->save()){
            $id=$request->product_id;
            $pb = ProductBarcode::where('product_id',$id);
            $pb->delete();
            
            foreach ($request->barcode as $key => $value) {
              $data=array('product_id'=>$id,
                    'barcode'=>$value,
                    'unit'=>$request->unit[$key],
                    'price'=>str_replace(',','',$request->price[$key]),
                    'cur'=>$request->cur[$key],
                    'dealer'=>str_replace(',','',$request->dealer[$key]),
                    'member'=>str_replace(',','',$request->member[$key]),
                    'vip'=>str_replace(',','',$request->vip[$key]),
                    'suppervip'=>str_replace(',','',$request->suppervip[$key]),
                    'multiple'=>$request->multi[$key]);
              ProductBarcode::insert($data);
            }
          }
           return response()->json(['success'=>'Update Product Completed.']);
       }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
    //-----------------------------------------------------
  public function destroy(Request $request)
    {
        // $p=Product::findOrFail($request->id);
        // if($p->delete()){

        //     $pb = ProductBarcode::where('product_id',$request->id);
        //     $pb->delete();
        //     File::delete(public_path('photo/'.$p->image));
          
        // }
      $current = Carbon::now();
      $current->timezone('Asia/Phnom_Penh');
      $p=Product::where('id',$request->id)->update(['status'=>'0','updated_at'=>$current]);
    }
    public function productrestore(Request $request)
    {
      $current = Carbon::now();
      $current->timezone('Asia/Phnom_Penh');
      $p=Product::where('id',$request->id)->update(['status'=>'1','updated_at'=>$current]);
    }
    public function deletefrombin(Request $request)
    {
      $current = Carbon::now();
      $current->timezone('Asia/Phnom_Penh');
      $psp1=DB::table('purchase_details')->where('product_id',$request->id)->exists();
      $psp2=DB::table('sale_details')->where('product_id',$request->id)->exists();
      $psp3=DB::table('stock_processes')->where('product_id',$request->id)->where('mode','<>','0')->exists();
      if($psp1 || $psp2 || $psp3){
          Product::where('id',$request->id)->update(['status'=>'-1','updated_at'=>$current]);
      }else{
          Product::where('id',$request->id)->delete();
          File::delete(public_path('photo/'.$request->img));
      }

    }
    //---------------------------------------------------------------
  public function checkproductcode(Request $request)
    {
        $p=Product::where('code',$request->prcode)
                  ->where('id','<>',$request->prid)
                  ->get();
       if($p){
          return response($p);
       }
    }
    //---------------------------------------------------
  public function allproduct(Request $request)
    {
        if ($request->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));
            $data=Product::join('categories','products.category_id','=','categories.id')
                        ->join('brands','products.brand_id','=','brands.id')
                        ->where('status',1)
                        ->select(DB::raw('@rownum := 0 r'))
                        ->select(DB::raw('@rownum := @rownum +1 AS rank'), 'products.*','categories.name as categoryname','brands.name as brandname')
                        ->get();
            return Datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="/product_edit/'. $row->id .'" class="edit btn btn-primary btn-sm" target="_blank" data-id="'. $row->id .'" title="Edit">E</a>';
                           $btn .='&nbsp;';
                           $btn .= '<a href="#" class="showbarcode btn btn-success btn-sm" target="_blank" data-id="'. $row->id .'" data-code="'. $row->code .'" data-name="'. $row->name .'"title="View Barcode">B</a>';
                           $btn .='&nbsp;';
                           $btn .= '<a href="#" class="remove btn btn-danger btn-sm" data-id="'. $row->id .'" title="Remove">R</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                     //dump($data);
         }
        return view('products.all_product');
    }
    //------------------------------------------------------------------------------
  public function product_edit($id)
     {
          $categories=Category::where('active','1')->get();
          $brands=Brand::where('active','1')->get();
          $product=Product::findOrFail($id);
          $units=Unit::all();
          $prcode=ProductBarcode::where('product_id',$id)->orderBy('id','asc')->get();
          //dd($products);
          return view('products.product_edit',compact('categories','brands','product','prcode','units'));
     }
  public function viewbarcode(Request $request)
     {
        $barcodelist=ProductBarcode::where('product_id',$request->id)->get();
        return view('products.barcodelist',compact('barcodelist'));
     }
    
  public function productsearch(Request $request)
      {
        $q=$request->q;
        
        if($request->status==0){
          $products=Product::where('products.name','like','%'.$q.'%')->where('status',0)->Orwhere('products.code','=',$q)->where('status',0)->get(); 
          return view('products.bin',compact('products'));
        }else{
          $products=Product::where('products.name','like','%'.$q.'%')->where('status',1)->Orwhere('products.code','=',$q)->where('status',1)->get();      
          return view('products.productlist',compact('products'));
        }
        
      }   

  public function productsearchscore(Request $request)
      {
          $q=$request->q;
          $products=Product::where('products.name','like','%'.$q.'%')->where('status',1)->Orwhere('products.code','=',$q)->where('status',1)->get();      
          return view('products.productlistscore',compact('products'));
      }   
   
}

