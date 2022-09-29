<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use DB;


class AgendamentoController extends Controller
{
    public function agendamento(){

        $agendamentos = DB::table('agendamentos')->get();



        return view('agendamento', compact('agendamentos'));
    }

    public function create(Request $request){

        $name = $request->input('name');
        $date = $request->input('date');
        $cel = $request->input('cel');
        $type = $request->input('type');
        $birthday = $request->input('birthday');
        $paid = 0;
        $note = $request->input('note');

       $agenda = DB::table('agendamentos')->insert(
            [
            'name' => $name,
            'date' => $date,
            'cel' => $cel,
            'typepayment' => $type,
            'paid' => $paid,
            'note' => $note,
            ]
        );
        // check registro no DB        

        $cadastrapaciente = DB::table('pacientes')->insert(
            [
                'name' => $name,
                'birthday' => $birthday,
                'celphone' => $cel,
                'ultimaconsulta' => $date,
                
            ]
        );

        if($agenda && $cadastrapaciente) {
            return redirect()->route('homepage');
            } else {

                return view('error');
            }
            
    }
    public function edit($id, Request $request){


        $name = $request->input('editarName');
        $date = $request->input('editarDate');
        $cel = $request->input('editarCel');
        $type = $request->input('editarType');
        $note = $request->input('editarNote');
        $paid = 0;

        $editarAgendamento = DB::table('agendamentos')->where('id', '=', $id)
            ->update(
                [
                'name' => $name,
                'date' => $date,
                'cel' => $cel,
                'typepayment' => $type,
                'paid' => $paid,
                'note' => $note,
                ]
            );
        // $data = array(
        //     'name' => $name,
        //     'date' => $date,
        //     'cel' => $cel,
        //     'type' => $type,
        //     'paid' => $paid,
        //     'note' => $note,

        // );

        if($editarAgendamento) {
            return redirect()->route('homepage');
            } else {

                return Redirect::route('homepage')->with(['type' => 'error','message' => 'Ocorreu um Erro']);
            }
    }
    public function remove($id) {

        $removebook = DB::table('agendamentos')->whereId($id)->delete();
        if($removebook) {

            return redirect()->route('homepage');
        } else {
            return Redirect::route('homepage')->with(['type' => 'error','message' => 'Ocorreu um Erro']);
        }
    }
    public function bulk_remove($id) {

        $removeall = DB::table('agendamentos')->whereId($id)->delete();
        if($removebook) {

            return redirect()->route('homepage');
        } else {
            return Redirect::route('homepage')->with(['type' => 'error','message' => 'Ocorreu um Erro']);
        }
    }
}
