<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {	

        for ($i=0; $i < 3 ; $i++) { 
            $marketer = ['Wai Yan Tun','Pai Phyo','Shwe Sin'];

            App\Marketer::create([
                'name' => $marketer[$i]
            ]);

        }



        //region table
        App\Region::create([
            'name' => 'Yangon'
        ]);

        // City Table

        for ($i=1; $i <= 3 ; $i++) { 
            $cities = ['Yangon','Mandalay','Pyin Oo Lwin'];

            App\City::create([
                'name' => $cities[$i-1],
                'region_id' => '1'
            ]);
        }

    	// Categories Table
        for ($i=1; $i <= 3; $i++) { 
        	App\Category::create([
        	'name' => 'Category'.$i
        	]);
        }


        // Subcategories Table
        for ($i=1; $i <= 3; $i++) { 
        	$category = App\Category::all();
        	$id = $category[$i-1]->id;
        	$name= $category[$i-1]->name;
        	for ($j=1; $j <= 3 ; $j++) { 
        		App\Subcategory::create([
        			'category_id' => $id,
        			'name' => $name.' Subcategory '.$j
        		]);
        	}  	
        }

        


        // Customer Table

        for ($i=0; $i < 3; $i++) { 
        	$name = ['Pwint Oo','Shwe Light','Myo Ma'];
        	$city = App\City::all();
        	$city_id = $city[$i]->id;
            $marketer = App\Marketer::all();
            $way = ['Than Lynn way','Pyay way','May Myo way'];
            $delivery_gate = ['Aung Myint','Mingalar','Yoma'];

        	App\Customer::create([
        		'name' => $name[$i],
        		'city_id' => $city_id,
        		'phone' => '097878787,0909090909',
        		'address' => $city[$i]->name,
                'way' => $way[$i],
                'marketer_id' => $i+1,
                'delivery_gate' => $delivery_gate[$i],
                'delivery_phone' => '0909090900,38993829',
                'address'   => "somewhere"

        	]);
        }

        // Branch Table

        for ($i=0; $i < 2; $i++) { 
        	$branch = ['Yangon' , 'Mandalay'];
        	App\Branch::create([
        		'name' => $branch[$i],
        		'phone' => '090909090',
        		'address' => $branch[$i]
        	]);
        }

        // Products Table

        for ($i=1; $i <= 3; $i++) { 
        	$subcategory = App\Subcategory::all();
        	$subcategory_id = $subcategory[$i]->id;

        	for ($j=0; $j < 2; $j++) { 
        		App\Product::create([
                    'code_no' => "P000".($j+$i),
        			'name' => 'C'.($i).'S'.($i).' product '.($j+1),
        			'Subcategory_id' => $subcategory_id,
                    'order_price' => '10.01',
                    'sale_price' => '16000'

        		]);
        	}
        }


        // Stocks Table
        $branch = App\Branch::all();
        $branch_count = $branch->count();
        for ($i=0; $i < $branch_count; $i++) { 
        	
        	$branch_id = $branch[$i]->id;
        	$product = App\Product::all();
        	$product_count = $product->count();
        	
        	for ($j=0; $j < $product_count ; $j++) { 
        		App\Stock::create([
        			'quantity' => 300,
        			'product_id' => $product[$j]->id,
        			'branch_id' => $branch_id
        		]);
        	}
        }




    }
}
