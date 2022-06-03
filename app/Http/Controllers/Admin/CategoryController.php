<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCasesCategoryRequest;
use App\Models\CasesCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = CasesCategory::where('is_deleted', 0)->paginate(20);
        return view('backend.settings.categories.index', compact('categories'));
    }

    public function create(){
        return view('backend.settings.categories.create');
    }

    public function store(CreateCasesCategoryRequest $request){
        $category = new CasesCategory();
        $category->title = $request->input('title');
        $category->closed = $request->input('closed');
        $category->is_deleted = 0;
        $category->added_userid = auth()->user()->userid;
        $category->dateadd = time();
        if ($category->save()){
            return redirect()->route('admin.settings.categories')->with(['status' => 'success', 'msg' => 'تمت إضافة العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.categories')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }

    public function delete($id){
        $category = CasesCategory::find($id);
        if (!$category){
            return redirect()->route('admin.settings.categories')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $category->is_deleted = 1;
        $category->delete_userid = auth()->user()->userid;
        $category->save();
        return redirect()->route('admin.settings.categories')->with(['status' => 'success', 'msg' => 'تمت حذف العنصر بنجاح !']);
    }

    public function edit($id){
        $category = CasesCategory::find($id);
        if (!$category){
            return redirect()->route('admin.settings.categories')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        return view('backend.settings.categories.edit', compact('category'));
    }

    public function update(CreateCasesCategoryRequest $request, $id){
        $category = CasesCategory::find($id);
        if (!$category){
            return redirect()->route('admin.settings.categories')->with(['status' => 'error', 'msg' => 'العنصر المحدد غير موجود']);
        }
        $category->title = $request->input('title');
        $category->closed = $request->input('closed');
        $category->edited_userid = auth()->user()->userid;
        $category->date_updated = time();
        if ($category->save()){
            return redirect()->route('admin.settings.categories')->with(['status' => 'success', 'msg' => 'تم تعديل العنصر بنجاح !']);
        }
        return redirect()->route('admin.settings.categories')->with(['status' => 'error', 'msg' => 'حدث خطأ ما الرجاء المحاولة لاحقا']);
    }
}
