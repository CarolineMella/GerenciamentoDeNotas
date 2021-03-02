<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DevNote;

class NoteController extends Controller
{
    private $array = ['error' => '', 'result' => []];
    public function all() {
        $notes = DevNote::all();

        foreach($notes as $note) {
            $this->array['result'][] = [
                'id' => $note->id,
                'title' => $note->title
            ];
        }

        return $this->array;
    }

    public function one($id) {
        $note = DevNote::find($id);


        if($note) {
            $this->array['result'] = $note;
        } else {
            $this->array['error'] = 'ID não encontrado';
        }


        return $this->array;
    }

    public function new(Request $request) {
        $title = $request->input('title');
        $body = $request->input('body');

        if($title && $body) {

            $note = new DevNote();
            $note->title = $title;
            $note->body = $body;
            $note->save();

            // Depois que criar, retornar todos os itens da nota: 
            $this->array['result'] = [
                'id' => $note->id,
                'title' => $title,
                'body' => $body
            ];

        } else {
            $this->array['error'] = 'Campos não enviados!';
        }

        return $this->array;
    }

    public function edit(Request $request, $id) {
        $title = $request->input('title');
        $body = $request->input('body');

        if($id && $title && $body) {

            $note = DevNote::find($id);
            if($note) {
                $note->title = $title;
                $note->body = $body;
                $note->save();

                $this->array['result'] = [
                    'id' => $id,
                    'title' => $title,
                    'body' => $body
                ];

            } else {
                $this->array['error'] = 'Id inexistente!';
            }

        } else {
            $this->array['error'] = 'Campos não enviados!';
        }


        return $this->array;
    }

    public function delete($id) {
        $note = DevNote::find($id);

        if($note) {
            $note->delete();
        } else {
            $this->array['error'] = 'Id inexistente!';
        }

        return $this->array;
    }
}
