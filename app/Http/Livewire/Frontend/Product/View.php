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
                $this->dispatchBrowserEvent('message', [
                    'message' => 'Already added to wish list',
                    'type' => 'warning',
                    'status' => 409,
                ]);
                return false;
            }
            else{
                Wishlist::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $productId,
                ]);
                $this->emit('wishlistAddedUpdated');
                $this->dispatchBrowserEvent('message', [
                    'message' => 'Added to wish list',
                    'type' => 'success',
                    'status' => 200,
                ]);
            }

        }
        else{
            $this->dispatchBrowserEvent('message',[
                'message' => 'Please login to add to wishlist',
                'type' => 'info',
                'status' => 401,
            ]);
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
