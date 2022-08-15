<?php

namespace App\Http\Livewire\Frontend\Product;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $product,$category,$prodColorSelectedQuantity;


    public function addToWishList($productId){
        if(Auth::check()){

            if(Wishlist::where('user_id',auth()->user()->id)->where('product_id',$productId)->exists()){
                session()->flash('message','Product already added to wishlist');
                return false;
            }
            else{
                Wishlist::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $productId,
                ]);
                session()->flash('message','Product added to wishlist');
            }

        }
        else{
            session()->flash('message','Please login to add to wishlist');
            return false;
        }
    }

    public function colorSelected($productColorId){

        $productColor = $this->product->productColors()->where('id',$productColorId)->first();
        $this->prodColorSelectedQuantity = $productColor->quantity;

        if($this->prodColorSelectedQuantity == 0){
            $this->prodColorSelectedQuantity = 'out of stock';
        }
    }

    public function mount($category,$product){
        $this->category = $category;
        $this->product = $product;
    }

    public function render()
    {

        return view('livewire.frontend.product.view',[
            'category' => $this->category,
            'product' => $this->product
        ]);
    }


}
