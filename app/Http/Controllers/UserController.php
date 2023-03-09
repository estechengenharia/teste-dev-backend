<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

            if(auth()->user()->user_type == 'recrutador'){
                $users = Cache::tags('users')->remember("$perPage$filterColumn$filter$orderBy$orderDirection", now()->addMinutes(60),function () use ($filterColumn,$filter,$orderBy, $orderDirection,$perPage){
                    return User::where($filterColumn, 'LIKE', '%' . $filter . '%')->orderBy($orderBy, $orderDirection)->paginate($perPage);
                });
            } else {
                $users = Cache::remember("user".auth()->user()->id, now()->addMinutes(60),function (){
                    return User::where('id',auth()->user()->id)->paginate();
                });
            }          
             
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
                'cpf'=>'required|unique:user|string|size:11',
                'user_type'=>'required|string|in:recrutador,candidato',
                'email' => 'required|unique:user|email',
                'senha' => 'required'
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
                'senha'=> Hash::make($request->get('senha')),
            ]);
    
            $user->save();

            Cache::tags('users')->flush();

            $token = $user->createToken('access-token')->plainTextToken;

            return [
                'success' => true,
                'message' => "Usuário cadastrado com sucesso.",
                'token' => $token
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

            $user = Cache::remember("user".$id, now()->addMinutes(60),function () use ($id){ 
                return User::find($id);
            });

            if(!$user){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhum usuário encontrado com o ID especificado."
                ],200);
            }

            if(auth()->user()->user_type == 'recrutador' || auth()->user()->id == $id ){
                return response()->json($user);
            } else{
                return response()->json([
                    'error' => true,
                    'message' => "Usuário autenticado não tem permissão para acessar os dados solicitados."
                ],401);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar requisitar o usuário. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
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
                'cpf'=>"required|unique:user,id,{$id}|string|size:11",
                'user_type'=>'required|string|in:recrutador,candidato',
                'email' => "required|unique:user,id,{$id}|email",
                'senha' => 'required'
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

            if(auth()->user()->user_type == 'recrutador' || auth()->user()->id == $id){
                $user->cpf = $request->get('cpf');
                $user->name = $request->get('name');
                $user->user_type = $request->get('user_type');
                $user->professional_resume = $request->get('professional_resume');
                $user->email = $request->get('email');
                $user->senha = Hash::make($request->get('senha'));
        
                $user->save();

                Cache::forget("user$id");
                Cache::tags('users')->flush();
    
                return [
                    'success' => true,
                    'message' => "Usuário atualizado com sucesso."
                ];
            } else{
                return response()->json([
                    'error' => true,
                    'message' => "Usuário autenticado não corresponde ao usuário do ID informado!"
                ],401);
            }
    
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                // 'message' => "Ocorreu uma falha ao tentar atualizar o usuário. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                'message' => $th->getMessage()
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


            if(auth()->user()->user_type == 'recrutador' || auth()->user()->id == $id){

                $user = User::find($id);

                if(!$user){
                    return response()->json([
                        'error' => true,
                        'message' => "Nenhum usuário encontrado com o ID especificado."
                    ],200);
                }

                $user->delete();

                Cache::forget("user$id");
                Cache::tags('users')->flush();

                return [
                    'success' => true,
                    'message' => "Usuário removido com sucesso."
                ];

            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Usuário autenticado não corresponde ao usuário do ID informado!"
                ],401);
    
            }

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar remover o usuário. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                //'message' => $th->getMessage()
            ],400);
        }
    }

    /**
     * Remove multiples specified resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchDestroy(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'ids'=>'required|array',
                'ids.*'=>'sometimes|integer',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            if(auth()->user()->user_type == 'recrutador'){

                $ids = $request->get('ids');

                DB::beginTransaction();

                foreach ($ids as $id) {
                    $user = User::find($id);

                    if(!$user){
                        return response()->json([
                            'error' => true,
                            'message' => "Nenhum usuário encontrado com o ID $id especificado. Operação em lote cancelada!"
                        ],200);
                        DB::rollback();
                    }

                    $user->delete();

                    Cache::forget("user$id");
                }

                Cache::tags('users')->flush();

            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Exclusão de usuários em lote só pode ser realizar por um recrutador"
                ],401);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => "Usuários removidos com sucesso.",
                'ids_removed' => $ids
            ];

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar remover os usuários. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                //'message' => $th->getMessage()
            ],400);
        }
    }
}
