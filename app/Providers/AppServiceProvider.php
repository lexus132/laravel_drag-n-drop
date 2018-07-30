<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('myPrint', function($perem){
	    return "<?php echo '<pre>'; print_r($perem); echo '</pre>'; ?>";
	});
	
//	DB::listen(function ($query) {
//	    print('<script type="text/javascript">' .
//		'console.log('.json_encode($query->sql).'); ' .
//		'</script> ');
//	    dump($query->sql);
//	    $query->bindings;
//	    $query->time;
//	});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
