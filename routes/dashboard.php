<?php
use App\Http\Controllers\Dashboard\StoreController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\EmployeesController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\SupportsController;
use App\Http\Controllers\Dashboard\DeliveryController;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware'=>['auth'],
  ],function(){
Route::get('profile',[ProfileController::class,'edit'])->name('profile.edit');
Route::patch('profile',[ProfileController::class,'update'])->name('profile.update');
// Employees Routes
Route::get('/employees/trash', [EmployeesController::class, 'trash'])->name('employees.trash');
Route::put('employees/{employee}/restore', [EmployeesController::class, 'restore'])->name('employees.restore');
Route::delete('employees/{employee}/force-delete', [EmployeesController::class, 'forceDelete'])->name('employees.force-delete');

// Categories Routes
Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
Route::put('categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
Route::delete('categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');

Route::get('/products/trash', [ProductsController::class, 'trash'])->name('products.trash');
Route::put('products/{product}/restore', [ProductsController::class, 'restore'])->name('products.restore');
Route::delete('products/{product}/force-delete',[ ProductsController::class, 'forceDelete'])->name('products.force-delete');



Route::resource('VendorAdmin/stores',StoreController::class);
Route::resource('VendorAdmin/categories', CategoriesController::class);  
Route::resource('VendorAdmin/products', ProductsController::class); 
Route::resource('VendorAdmin/employees', EmployeesController::class); 
Route::get('VendorAdmin/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('VendorAdmin/orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('VendorAdmin/supports', [SupportsController::class, 'index'])->name('supports.index');
Route::get('VendorAdmin/delivery', [DeliveryController::class, 'index'])->name('delivery.index');




});

?>