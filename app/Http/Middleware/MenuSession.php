<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class MenuSession
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, $menu): Response
  {
    $userPermissions = Session::get('menu');

    if (in_array($menu, $userPermissions) || Session::get('role') == 1) {
      return $next($request);
    } else {
      return redirect('/access-denied/404');
    }
  }
}
