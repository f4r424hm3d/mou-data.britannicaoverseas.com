<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $user_id = session('userLoggedIn.user_id');

    // Get the authenticated user
    $getUserRole = User::select('role')->where('id', $user_id)->first();

    // Check if the authenticated user has a matching record in user_matches
    if ($getUserRole->role != 'admin') {
      // If the user doesn't have access, you can redirect or abort here
      // For example, abort(403) for a forbidden response
      abort(403, 'Unauthorized access');
    }

    return $next($request);
  }
}
