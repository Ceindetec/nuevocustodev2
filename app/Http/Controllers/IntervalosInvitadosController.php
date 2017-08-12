<?php

namespace App\Http\Controllers;

use App\Intervaloinvitado;
use App\Puerta;
use App\IntervaloInvitadoPuerta;
use Illuminate\Http\Request;
use Session;
use Redirect;

class IntervalosInvitadosController extends Controller
{

    /**
     * No hace nada en concreto solo llama a la vista create
     *
     * @author Edwin Sandoval
     * @return \Illuminate\Http\Response devuelve la vista create de intervalos_invitados
     * y le paso
     * $invitado_id id del invitado al que pertenece
     * $puertasNormales una coleccion con todas las puestas normales
     * $puertasEspeciales una coleccion con todas las puertas especiales
     * @param integer $seccion_id id del invitado al que va pertenecer el invitado
     */
    public function create($invitado_id)
    {
        //creo una coleccion con todas las puertas especiales
        $puertasEspeciales = Puerta::All()->where('puerta_especial',1);
        //creo una coleccion con todas las puestas normales
        $puertasNormales = Puerta::All()->where('puerta_especial',0);

        return view('intervalos_invitados.create',['invitado_id'=>$invitado_id,'puertasNormales'=>$puertasNormales,'puertasEspeciales'=>$puertasEspeciales]);
    }

    /**
     * Crea un nuevo intervalo con los datos que recibe del formulario
     * y lo asocia al invitado relacionado al $invitado_id que llega como parametro
     * Tambien relaciono el intervalo que se crear con todas las puertas selecionadas
     *
     * @author Edwin Sandoval
     * @return \Illuminate\Http\Response redirecciona a la vista edit del invitado a la que pertenece el intervalo
     * @param Request $request con los datos del formulario
     * @param integer $invitado_id id del invitado al que va pertenecer el intervalo
     */
    public function store(Request $request,$invitado_id)
    {
        Intervaloinvitado::create([
            'desde'=> $request['desde'],
            'hasta'=> $request['hasta'],
            'targeta_rfid' => $request['targeta_rfid'],
            'invitado_id'=> $invitado_id,
        ]);

        //obtengo la ultima seccion que se creo es decir la que acabamos de crear
        $intervalo = Intervaloinvitado::orderBy('created_at', 'desc')->first();

        //Relaciono el intervalo que se acabo de crear con todas las puertas selecionadas
        $todasPuertas = Puerta::all();
        foreach($todasPuertas as $puerta){
            //Si la puerta fue seclecionada en el check se guarda en la relacion secionn-puerta con un 1
            // indicando que esta seccion tiene permiso sobre ella
            if($request[$puerta->id]!=null) {
                IntervaloInvitadoPuerta::create([
                    'intervalo_invitado_id' => $intervalo->id,
                    'puerta_id' => $puerta->id,
                ]);
            }
        }
        return redirect('/invitados/'.$invitado_id.'/edit')->with('message','El intervalo se ha registrado correctamente');
    }

    /**
     *  llama a la vista show de intervalos_invitados la cual muestra la informacion relacionada a un intervalo
     *
     * @author Edwin Sandoval
     * @return \Illuminate\Http\Response devuelve la vista edit de los intervalos_invitados
     * y le paso
     * $intervalo objeto del intervalo que se quiere mostrar
     * $puertasNormales una coleccion con todas las puestas normales asociadas al intervalo
     * $puertasEspeciales una coleccion con todas las puertas especiales normales asociadas al intervalo
     * @param integer $id id del intervalo que se va a mostrar
     */
    public function show($id)
    {
        $intervalo = Intervaloinvitado::find($id);
        $puertasNormales = Intervaloinvitado::find($id)->puertas()->where('puerta_especial',0)->get();
        $puertasEspeciales = Intervaloinvitado::find($id)->puertas()->where('puerta_especial',1)->get();
        //devuelve la vista edit de los intervalos_invitados
        return view('intervalos_invitados.show',['intervalo'=>$intervalo,'puertasEspeciales'=>$puertasEspeciales,'puertasNormales'=>$puertasNormales]);
    }


    /**
     *  Elimina un intervalo asociado al $id que llega como parametro
     * Tambien elimina todas las interrelaciones entre las puertas y dicho intervalo
     *
     * @author Edwin Sandoval
     * @return \Illuminate\Http\Response devuelve la vista edit de los invitados
     * @param integer $id id del intervalo que se va a eliminar
     */
    public function destroy($id)
    {
        $puertasIntervalo = IntervaloInvitadoPuerta::all()->where('intervalo_id',$id);

        foreach($puertasIntervalo as $puerta){
            $puerta->delete();
        }
        $invitado_id = Intervaloinvitado::find($id)->invitado_id;
        Intervaloinvitado::destroy($id);
        //devuelve la vista edit de los intervalos_invitados
        return redirect('/invitados/'.$invitado_id.'/edit');
    }
}