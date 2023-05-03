<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!Auth::check()) {
            return $response;
        }

        $user = Auth::user();
        $activity = '';

        switch ($request->method()) {
            case 'GET':
                $activity = 'view';
                break;
            case 'POST':
                $activity = 'create';
                break;
            case 'PUT':
            case 'PATCH':
                $activity = 'update';
                break;
            case 'DELETE':
                $activity = 'delete';
                break;
        }

        $loggable = null;
        $changes = null;

        // You can customize this part to log specific user actions.
        // Here, we're logging any changes to shipment details.
        if ($request->routeIs('shipments.update')) {
            $shipment = $request->route('shipment');
            $loggable = $shipment;
            $changes = $shipment->getChanges();
        }

        if ($activity && $loggable) {
            ActivityLog::create([
                'user_id' => $user->id,
                'loggable_id' => $loggable->id,
                'loggable_type' => get_class($loggable),
                'activity' => $activity,
                'changes' => $changes,
            ]);
        }

        return $response;
    }
}
