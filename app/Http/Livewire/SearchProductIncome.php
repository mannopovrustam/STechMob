<?php

namespace App\Http\Livewire;

use App\Helpers\ResponseError;
use App\Models\Mark;
use App\Models\Product;
use App\Models\ProductCode;
use App\Models\Warehouse;
use App\Repositories\CardProductRepository;
use Livewire\Component;

class SearchProductIncome extends Component
{
    public $searchTerm, $type = 'searchTrade';
    public $searchTermData = [];
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($type){
        $this->type = 'search'.$type;
    }

    public function render()
    {
        $this->productSearch();
        return view('livewire.search-product-income');
    }

    public function productSearch()
    {
        $type = $this->type;
        $cardProduct = new CardProductRepository();

        if (ProductCode::where('code', $this->searchTerm)->first()) { $this->addCode($this->searchTerm); }

        $this->searchTermData = $cardProduct->$type($this->searchTerm);

    }

    public function addMark($id)
    {
        $mark = Mark::find($id);
        if(!$mark) {
            return ResponseError::ERROR_404;
        }
        $cart = session()->get('mark');

        $cart[$id] = $id;

        session()->put('mark', $cart);

        $this->emit('refreshCartProductIncome');
    }

    public function addProduct($id)
    {
        $product = Product::find($id);
        if(!$product) {abort(404);}
        $cart = session()->get('product');
        if(!$cart) { $cart = [ $id => [
            "id"=>$id
        ] ]; }
        else{ $cart[$id] = [
            "id"=>$id
        ]; }
        session()->put('product', $cart);
    }

    public function addCode($code)
    {
        $product = ProductCode::find($code)->product->where('warehouse_id', Warehouse::getId());
        if(!$product) {abort(404);}
        $cart = session()->get('product_codes');
        if(!$cart) { $cart = [ $product->id => [
            "id"=>$product->id,
        ] ]; }
        else{ $cart[$product->id] = [
            "id"=>$product->id,
        ]; }

        if (in_array($cart[$product->id]['codes'], $code)){
            $cart[$product->id]['codes'][] = $code;
        }

        session()->put('product_codes', $cart);
    }

}
