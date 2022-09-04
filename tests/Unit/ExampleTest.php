<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
        $this->assertTrue(true);
    }
    
    public function test_user_that_named(){
        $this->assertTrue(App\Models\User::all()->count"());   
    }
    
    public function test_product_has_category(){
        $this->assertTrue(App\Models\Product::where('id',$str_random(App\Models\Product::count()))->category()->get());
    }
}
