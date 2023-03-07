<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $perPage = $request->perPage ?? 20;
            $filterColumn = $request->filterCollumn ?? 'name';
            $filter = $request->filter ?? '';
            $orderBy = $request->orderBy ?? 'id';
            $orderDirection = $request->orderDirection ?? 'asc';

            $users = User::where($filterColumn, 'LIKE', '%' . $filter . '%')->orderBy($orderBy, $orderDirection)->paginate($perPage);

            if($users->isEmpty()){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhum usuário encontrado com os filtros especificados."
                ],200);
            }

            return response()->json($users);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar requisitar os usuários. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                // 'message' => $th->getMessage()
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'=>'required|string|max:255',
                'cpf'=>'required|string|size:11',
                'user_type'=>'required|string|in:recrutador,candidato',
                'email' => 'required|email'
            ],
            ['user_type.in' => 'Given data must be recrutador or candidato']
        );
            
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 400);
            }
    
            $user = new User([
                'cpf' =>  $request->get('cpf'),
                'name' => $request->get('name'),
                'user_type' => $request->get('user_type'),
                'professional_resume' => $request->get('professional_resume'),
                'email' => $request->get('email'),
            ]);
    
            $user->save();

            return [
                'success' => true,
                'message' => "Usuário cadastrado com sucesso."
            ];
    
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar cadastrar o usuário. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                //'message' => $th->getMessage()
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $user = User::find($id);

            if(!$user){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhum usuário encontrado com o ID especificado."
                ],200);
            }

            return response()->json($user);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar requisitar os usuários. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                // 'message' => $th->getMessage()
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'=>'required|string|max:255',
                'cpf'=>'required|string|size:11',
                'user_type'=>'required|string|in:recrutador,candidato',
                'email' => 'required|email'
            ],
            ['user_type.in' => 'Given data must be recrutador or candidato']
            );
            
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $user = User::find($id);

            if(!$user){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhum usuário encontrado com o ID especificado."
                ],200);
            }
    
            $user->cpf = $request->get('cpf');
            $user->name = $request->get('name');
            $user->user_type = $request->get('user_type');
            $user->professional_resume = $request->get('professional_resume');
            $user->email = $request->get('email');
    
            $user->save();

            return [
                'success' => true,
                'message' => "Usuário atualizado com sucesso."
            ];
    
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar atualizar o usuário. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                //'message' => $th->getMessage()
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $user = User::find($id);

            if(!$user){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhum usuário encontrado com o ID especificado."
                ],200);
            }

            $user->delete();

            return [
                'success' => true,
                'message' => "Usuário removido com sucesso."
            ];

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar remover o usuário. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                //'message' => $th->getMessage()
            ],400);
        }
    }
}
