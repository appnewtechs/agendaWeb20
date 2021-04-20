<?php

namespace App\Listener;

use App\Events\AgendaExcluida;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Notifications\AgendaDelete;
use App\Models\usuario;

class AgendaExcluidaListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AgendaExcluida  $event
     * @return void
     */
    public function handle(AgendaExcluida $event)
    {
        $request = $event->request;
        if($request->status=="1"){
            $user = usuario::find($request->id_usuario);
            if($user->notificacao_agenda=="S"){

                $empresa = DB::table('usuario_empresa')
                        ->where([
                            ['id_usuario', '=', $request->id_usuario],
                            ['id_empresa', '=', $request->empresa],
                        ])->first();

                if($empresa->status==0){
                    $user->email = $empresa->email;
                    $user->notify( new AgendaDelete($request) );
                }
            }
        }
    }
}
