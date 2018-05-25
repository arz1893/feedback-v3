<?php

namespace App\Http\Middleware\MasterDataCrud;

use Closure;
use Illuminate\Support\Facades\Auth;

class MasterDataCrudPermit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        switch ($request->route()->action['as']) {
            case 'product.index': {
                if(Auth::user()->user_group->getMasterDataRights->view != 1) {
                    return redirect()->route('home');
                }
                break;
            }
            case 'product.create': {
                if(Auth::user()->user_group->getMasterDataRights->create != 1) {
                    return redirect()->route('home');
                }
                break;
            }
            case 'product.store': {
                if(Auth::user()->user_group->getMasterDataRights->create != 1) {
                    abort(403, 'Unauthorized action');
                }
                break;
            }
            case 'product.edit': {
                if(Auth::user()->user_group->getMasterDataRights->edit != 1) {
                    return redirect()->route('home');
                }
                break;
            }
            case 'product.update': {
                if(Auth::user()->user_group->getMasterDataRights->edit != 1) {
                    abort(403, 'Unauthorized action');
                }
                break;
            }
            case 'service.index': {
                if(Auth::user()->user_group->getMasterDataRights->view != 1) {
                    return redirect()->route('home');
                }
                break;
            }
            case 'service.create': {
                if(Auth::user()->user_group->getMasterDataRights->create != 1) {
                    return redirect()->route('home');
                }
                break;
            }
            case 'service.store': {
                if(Auth::user()->user_group->getMasterDataRights->create != 1) {
                    abort(403, 'Unauthorized action');
                }
                break;
            }
            case 'service.edit': {
                if(Auth::user()->user_group->getMasterDataRights->edit != 1) {
                    return redirect()->route('home');
                }
                break;
            }
            case 'service.update': {
                if(Auth::user()->user_group->getMasterDataRights->edit != 1) {
                    abort(403, 'Unauthorized action');
                }
                break;
            }
        }
        return $next($request);
    }
}
