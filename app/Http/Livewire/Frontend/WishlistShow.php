<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Wishlist;

class WishlistShow extends Component
{
    public function removeWishlistItem(int $wishlistId){


        Wishlist::where('user_id',auth()->user()->id)->where('id',$wishlistId)->delete();

        $this->dispatchBrowserEvent('message', [
            'message' => 'Product removed from wishlist',
            'type' => 'success',
            'status' => 409,
        ]);
    }

    public function render()
    {
        $wishlist = Wishlist::where('user_id',auth()->user()->id)->get();
        return view('livewire.frontend.wishlist-show',[
            'wishlist'=>$wishlist
        ]);
    }

}
