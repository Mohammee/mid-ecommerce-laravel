<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;

class DataTypesTableSeederCustom extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $dataType = $this->dataType('slug', 'products');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'products',
                'display_name_singular' => 'Product',
                'display_name_plural'   => 'Products',
                'icon'                  => 'voyager-bag',
                'model_name'            => 'App\Models\Product',
                'policy_name'           => null,
                'controller'            => 'App\Http\Controllers\Voyager\ProductsController',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }


        $dataType = $this->dataType('slug', 'coupons');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'coupons',
                'display_name_singular' => 'Coupon',
                'display_name_plural'   => 'Coupons',
                'icon'                  => 'voyager-dollar',
                'model_name'            => 'App\Models\Coupon',
                'policy_name'           => null,
                'controller'            => '',
                'generate_permissions'  => 0,
                'description'           => ''
            ])->save();
        }



        $dataType = $this->dataType('slug', 'category');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'category',
                'display_name_singular' => 'category',
                'display_name_plural'   => 'categories',
                'icon'                  => 'voyager-tag',
                'model_name'            => 'App\Models\Category',
                'policy_name'           => null,
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => ''
            ])->save();
        }




        $dataType = $this->dataType('slug', 'category-product');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'category_product',
                'display_name_singular' => 'Category Product',
                'display_name_plural'   => 'Categories Products',
                'icon'                  => 'voyager-categories',
                'model_name'            => 'App\Models\CategoryProduct',
                'policy_name'           => null,
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => ''
            ])->save();
        }

        $dataType = $this->dataType('slug', 'orders');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'orders',
                'display_name_singular' => 'Order',
                'display_name_plural'   => 'Orders',
                'icon'                  => 'voyager-receipt',
                'model_name'            => 'App\Models\Order',
                'policy_name'           => null,
                'controller'            => 'App\Http\Controllers\Voyager\OrdersController',
                'generate_permissions'  => 1,
                'description'           => ''
            ])->save();
        }


    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
