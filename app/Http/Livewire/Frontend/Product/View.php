<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $product,$category,$prodColorSelectedQuantity,$quantityCount = 1,$productColorId;


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


        $this->productColorId = $productColorId;
        $productColor = $this->product->productColors()->where('id',$productColorId)->first();
        $this->prodColorSelectedQuantity = $productColor->quantity;

        if($this->prodColorSelectedQuantity == 0){
            $this->prodColorSelectedQuantity = 'out of stock';
        }
    }

    public function decrementQuantity(){
        if($this->quantityCount > 1){
            $this->quantityCount--;
        }
        else{
            $this->dispatchBrowserEvent('message',[
                'message' => 'Quantity cannot be less than 1',
                'type' => 'info',
                'status' => 401,
            ]);
        }
    }

    public function incrementQuantity(){

        $this->quantityCount++;
    }

    public function addToCart(int $productId){
        if(Auth::check())
        {
            if($this->product->where('id',$productId)->where('status','0')->exists()){
                //Check for product color quantity and add to cart
                if($this->product->productColors()->count() > 1){
                    if($this->prodColorSelectedQuantity != null){

                        if(Cart::where('user_id',auth()->user()->id)
                                ->where('product_id',$productId)
                                ->where('product_color_id',$this->productColorId)
                                ->exists())
                        {
                            $this->dispatchBrowserEvent('message',[
                                'message' => 'Product already added to cart',
                                'type' => 'warning',
                                'status' => 200,
                            ]);
                        }
                        else
                        {
                            $productColor = $this->product->productColors()->where('id',$this->productColorId)->first();

                        if($productColor->quantity > 0){

                            if($productColor->quantity > $this->quantityCount){

                                //Insert product to card
                                Cart::create([
                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'product_color_id' => $this->productColorId,
                                    'quantity' => $this->quantityCount,
                                ]);

                                $this->emit('CartAddedUpdated');

                                $this->dispatchBrowserEvent('message',[
                                    'message' => 'Product added to cart',
                                    'type' => 'success',
                                    'status' => 200,
                                ]);
                            }
                            else{
                                $this->dispatchBrowserEvent('message',[
                                    'message' => 'Only '.$productColor->quantity.' quantity available',
                                    'type' => 'info',
                                    'status' => 401,
                                ]);
                            }
                        }
                        else{
                            $this->dispatchBrowserEvent('message',[
                                'message' => 'Out of stock',
                                'type' => 'warning',
                                'status' => 404,
                            ]);
                        }
                        }




                    }
                    else{
                        $this->dispatchBrowserEvent('message',[
                            'message' => 'Select your product color',
                            'type' => 'info',
                            'status' => 401,
                        ]);
                    }
                }
                else{
                    if(Cart::where('user_id',auth()->user()->id)->where('product_id',$productId)->exists()){
                        $this->dispatchBrowserEvent('message',[
                            'message' => 'Product already added to cart',
                            'type' => 'warning',
                            'status' => 200,
                        ]);
                    }
                    else{
                        if($this->product->quantity > 0){
                            if($this->product->quantity > $this->quantityCount){
                                //Insert product to card
                                Cart::create([
                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'quantity' => $this->quantityCount,
                                ]);

                                $this->emit('CartAddedUpdated');

                                $this->dispatchBrowserEvent('message',[
                                    'message' => 'Product added to cart',
                                    'type' => 'success',
                                    'status' => 200,
                                ]);
                            }
                            else{
                                $this->dispatchBrowserEvent('message',[
                                    'message' => 'Only'.$this->product->quantity.'quantity available',
                                    'type' => 'info',
                                    'status' => 401,
                                ]);
                            }
                        }
                        else{
                            $this->dispatchBrowserEvent('message',[
                                'message' => 'Product out of stock',
                                'type' => 'info',
                                'status' => 401,
                            ]);
                        }
                    }

                }

            }
            else{
                $this->dispatchBrowserEvent('message',[
                    'message' => 'Product is not available',
                    'type' => 'info',
                    'status' => 401,
                ]);
            }
        }
        else
        {
            $this->dispatchBrowserEvent('message',[
                'message' => 'Please login to add to cart',
                'type' => 'info',
                'status' => 401,
            ]);
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
