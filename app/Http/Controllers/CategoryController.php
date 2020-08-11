<?php

namespace App\Http\Controllers;
use App\Category;
use App\Brand;
use App\Unit;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

	public function autocomplete_category(Request $request)
    {
        $data = Category::select("name")
                ->where("name","LIKE","%{$request->input('query')}%")
                ->get();
   
        return response()->json($data);
    }
    public function autocomplete_brand(Request $request)
    {
        $data = Brand::select("name")
                ->where("name","LIKE","%{$request->input('query')}%")
                ->get();
   
        return response()->json($data);
    }
    public function saveunit(Request $request)
    {
        $unit=new Unit;
        $unit->name=$request->uname;
        if($unit->save()){
          return response()->json(['success'=>'Save Unit Completed.']);
        }
    }
    public function updateunit(Request $request)
    {
        $unit=Unit::find($request->id);
        $unit->name=$request->uname;
        if($unit->save()){
          return response()->json(['success'=>'Update Unit Completed.']);
        }
    }
    public function deleteunit(Request $request)
    {
        $unit=Unit::find($request->id);
        if($unit->delete()){
          return response()->json(['success'=>'Delete Unit Completed.']);
        }
    }
    public function getunit(Request $request)
    {
      $output='';

      $units=Unit::orderBy('id','desc')->get();
      foreach ($units as $key => $unit) {
        $output .='<tr>
                      <td>'. ++$key .'</td>
                      <td>'. $unit->id .'</td>
                      <td style="font-family:khmer os system;">'. $unit->name .'</td>
                      <td>
                        <a href="" class="btn btn-warning btn-sm unit-edit" data-id="'. $unit->id .'" data-name="'. $unit->name .'"><i class="fa fa-pencil"></i></a>
                        <a href="" class="btn btn-danger btn-sm unit-delete" data-id="'. $unit->id .'" data-name="'. $unit->name .'"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>';
      }
      if($output==''){
        $output="<tr><td colspan=4>No unit found</td></tr>";
      }
      return response($output);
    }
    public function categoryset()
    {
    	$categories=Category::orderBy('id','DESC')->get();
      $units=Unit::orderBy('id','DESC')->get();
    	return view('categories.index',compact('categories','units'));
    }
    public function savecategory(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            
            'cat_name' => 'required',
            'cat_active' => 'required',
            
        ]);
    	if ($validator->passes()) {
    		$newcat=new Category;
	    	$newcat->name=$request->cat_name;
	    	$newcat->active=$request->cat_active;
	    	$newcat->save();
	    	return response()->json(['success'=>'Save Category Completed.']);
    	}
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function savebrand(Request $request)
    {
      $validator = Validator::make($request->all(), [
            
            'brand_name' => 'required',
            'brand_active' => 'required',
            'ctid' => 'required',
            
        ]);
      if ($validator->passes()) {
        $newbrand=new Brand;
        $newbrand->name=$request->brand_name;
        $newbrand->active=$request->brand_active;
        $newbrand->category_id=$request->ctid;
        $newbrand->save();
        return response()->json(['success'=>'Save Brand Completed.']);
      }
      return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function updatecategory(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            
            'cat_name' => 'required',
            'cat_active' => 'required',
            
        ]);
    	if ($validator->passes()) {
    		$newcat=Category::find($request->cat_id);
	    	$newcat->name=$request->cat_name;
	    	$newcat->active=$request->cat_active;
	    	$newcat->save();
	    	return response()->json(['success'=>'Update Category Completed.']);
    	}
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function updatebrand(Request $request)
    {
      $validator = Validator::make($request->all(), [
            
            'brand_name' => 'required',
            'brand_active' => 'required',
            'ctid' => 'required',
            
        ]);
      if ($validator->passes()) {
        $newbrand=Brand::find($request->br_id);
        $newbrand->name=$request->brand_name;
        $newbrand->active=$request->brand_active;
        $newbrand->category_id=$request->ctid;
        $newbrand->save();
        return response()->json(['success'=>'Update Brand Completed.']);
      }
      return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function delcategory(Request $request)
    {
    		$cat=Category::find($request->id);
	    	if($cat->delete()){
          $br=Brand::where('category_id',$request->id)->delete();
        }
    }
    public function delbrand(Request $request)
    {
        $br=Brand::findOrFail($request->id);
        $br->delete();
    }
    public function getcategory(Request $request)
    {
    	$output='';
   		$categories=Category::orderBy('id','DESC')->get();
   		foreach ($categories as $key => $cat) {
   				$output .='<tr style="cursor:pointer;">
		     						<td>'. ++$key .'</td>
		     						<td>'. $cat->id .'</td>
		     						<td style="font-family:khmer os system;">'. $cat->name .'</td>
		     						<td>'. $cat->active .'</td>
		     						<td>
		     							<a href="" class="btn btn-warning cate_edit" data-id="'. $cat->id .'" data-name="'. $cat->name .'" data-active="'. $cat->active .'">Edit</a>
		     							<a href="" class="btn btn-danger cate_del" data-id="'. $cat->id .'">Del
		     							</a>
		     						</td>
		     				</tr>';
   			}	
   			if($output==''){
   				$output='<tr><td colspan=5>No Category Found</td></tr>';
   			}
        $data=array(
                'table_data'=>$output,
                'cat_data'=>$categories
            );
   			return response($data);
    }
    public function getbrand(Request $request)
    {
      $output='';
      $brands=Brand::where('category_id',$request->catid)->orderBy('id','DESC')->get();
      foreach ($brands as $key => $br) {
          $output .='<tr>
                    <td>'. ++$key .'</td>
                    <td>'. $br->id .'</td>
                    <td style="font-family:khmer os system;">'. $br->name .'</td>
                    <td style="font-family:khmer os system;">'. $br->category->name .'</td>
                    <td>'. $br->active .'</td>
                    <td>
                      <a href="" class="btn btn-warning brand_edit" data-id="'. $br->id .'" data-name="'. $br->name .'" data-active="'. $br->active .'" data-catid="'. $br->category_id .'" data-catname="'. $br->category->name .'">Edit</a>
                      <a href="" class="btn btn-danger brand_del" data-id="'. $br->id .'">Del
                      </a>
                    </td>
                </tr>';
        } 
        if($output==''){
          $output='<tr><td colspan=5>No Brand Found</td></tr>';
        }
        return response($output);
    }
    public function categorysearch(Request $request)
      {
        $q=$request->q;
        $output='';
        $categories=Category::where('name','like','%'.$q.'%')->orderBy('id','DESC')->get();      
        foreach ($categories as $key => $cat) {
   				$output .='<tr style="cursor:pointer;">
		     						<td>'. ++$key .'</td>
		     						<td>'. $cat->id .'</td>
		     						<td style="font-family:khmer os system;">'. $cat->name .'</td>
		     						<td>'. $cat->active .'</td>
		     						<td>
		     							<a href="" class="btn btn-warning cate_edit" data-id="'. $cat->id .'" data-name="'. $cat->name .'" data-active="'. $cat->active .'">Edit</a>
		     							<a href="" class="btn btn-danger cate_del" data-id="'. $cat->id .'">Del
		     							</a>
		     						</td>
		     				</tr>';
   			}	
   			if($output==''){
   				$output='<tr><td colspan=5>No Category Found</td></tr>';
   			}
   			return response($output);
                  
      }   
       public function brandsearch(Request $request)
      {
        $q=$request->q;
        $output='';
        $brands=Brand::where('name','like','%'.$q.'%')->orderBy('id','DESC')->get();      
         foreach ($brands as $key => $br) {
          $output .='<tr>
                    <td>'. ++$key .'</td>
                    <td>'. $br->id .'</td>
                    <td style="font-family:khmer os system;">'. $br->name .'</td>
                    <td style="font-family:khmer os system;">'. $br->getcategoryname($br->category_id) .'</td>
                    <td>'. $br->active .'</td>
                    <td>
                      <a href="" class="btn btn-warning brand_edit" data-id="'. $br->id .'" data-name="'. $br->name .'" data-active="'. $br->active .'" data-catid="'. $br->category_id .'" data-catname="'. $br->getcategoryname($br->category_id) .'">Edit</a>
                      <a href="" class="btn btn-danger brand_del" data-id="'. $br->id .'">Del
                      </a>
                    </td>
                </tr>';
        } 
        if($output==''){
          $output='<tr><td colspan=5>No Category Found</td></tr>';
        }
        return response($output);
                  
      }   
}
