[1mdiff --git a/app/Http/Controllers/Auth/RegisterController.php b/app/Http/Controllers/Auth/RegisterController.php[m
[1mindex 2a08600..171b510 100644[m
[1m--- a/app/Http/Controllers/Auth/RegisterController.php[m
[1m+++ b/app/Http/Controllers/Auth/RegisterController.php[m
[36m@@ -65,11 +65,12 @@[m [mclass RegisterController extends Controller[m
      */[m
     protected function create(array $data)[m
     {[m
[31m-        return User::create([[m
[31m-            'name' => $data['name'],[m
[31m-            'email' => $data['email'],[m
[31m-            'password' => Hash::make($data['password']),[m
[31m-            'isadmin' => 0,[m
[31m-        ]);[m
[32m+[m[32m        return $data;[m
[32m+[m[32m        // return User::create([[m
[32m+[m[32m        //     'name' => $data['name'],[m
[32m+[m[32m        //     'email' => $data['email'],[m
[32m+[m[32m        //     'password' => Hash::make($data['password']),[m
[32m+[m[32m        //     'isadmin' => 0,[m
[32m+[m[32m        // ]);[m
     }[m
 }[m
[1mdiff --git a/app/Http/Middleware/RedirectIfAuthenticated.php b/app/Http/Middleware/RedirectIfAuthenticated.php[m
[1mindex 2395ddc..86bff4f 100644[m
[1m--- a/app/Http/Middleware/RedirectIfAuthenticated.php[m
[1m+++ b/app/Http/Middleware/RedirectIfAuthenticated.php[m
[36m@@ -21,7 +21,6 @@[m [mclass RedirectIfAuthenticated[m
         if (Auth::guard($guard)->check()) {[m
             return redirect(RouteServiceProvider::HOME);[m
         }[m
[31m-[m
         return $next($request);[m
     }[m
 }[m
