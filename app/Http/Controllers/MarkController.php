<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\MarkRepositoryInterface;
use App\Contracts\Services\MarkServiceInterface;
use App\Imports\MarksImport;
use App\Models\Brand;
use App\Models\Mark;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class MarkController extends Controller
{
    private $markRepository, $markService;
    public function __construct(MarkRepositoryInterface $markRepository, MarkServiceInterface $markService)
    {
        $this->markService = $markService;
        $this->markRepository = $markRepository;
    }

    public function index()
    {
        $types = Type::all();
        $brands = Brand::all();
        $marks = $this->markRepository->paginate(15);
        return view('admin.product.add_mark', ['all_type' => $types, 'all_brand' => $brands, 'marks' => $marks]);
    }

    public function store(Request $request)
    {
        $values = Arr::except($request->all(), 'data_id','excel');
        if ($request->hasFile('excel')){
            Excel::import(new MarksImport, $request->excel);
        }else{
            Mark::upsert($values, 'id');
        }
        return back();
    }
}
