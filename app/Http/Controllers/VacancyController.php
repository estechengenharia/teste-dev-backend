<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VacancyController extends Controller
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

            $vacancys = Vacancy::where($filterColumn, 'LIKE', '%' . $filter . '%')->orderBy($orderBy, $orderDirection)->paginate($perPage);

            if($vacancys->isEmpty()){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhuma vaga encontrada com os filtros especificados."
                ],200);
            }

            return response()->json($vacancys);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar requisitar as vagas. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
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
                'description'=>'required|string',
                'vacancy_type'=>'required|string|in:clt,pj,freelancer',
                'user_id'=>'required|integer',
                'opened' => 'boolean'
            ],
            ['vacancy_type.in' => 'Given data must be clt,pj ou freelancer']
            );
            
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $user = User::find($request->get('user_id'));

            if($user){
                if($user->user_type!=1){
                    return response()->json([
                        'error' => true,
                        'message' => "O usuário responsável pela vaga informado deve ser um recrutador."
                    ],400);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "O usuário responsável pela vaga informado é inexistente."
                ],400);
            }
    
            $vacancy = new Vacancy([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'vacancy_type' => $request->get('vacancy_type'),
                'user_id' => $request->get('user_id'),
                'opened' => $request->get('opened') ?? 1,
            ]);
    
            $vacancy->save();

            return [
                'success' => true,
                'message' => "Vaga cadastrada com sucesso."
            ];
    
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar cadastrar a vaga. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                // 'message' => $th->getMessage()
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

            $vacancy = Vacancy::find($id);

            if(!$vacancy){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhuma vaga encontrada com o ID especificado."
                ],200);
            }

            return response()->json($vacancy);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar requisitar a vaga. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
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
                'description'=>'required|string',
                'vacancy_type'=>'required|string|in:clt,pj,freelancer',
                'user_id'=>'required|integer',
                'opened' => 'boolean'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $user = User::find($request->get('user_id'));

            if($user){
                if($user->user_type!=1){
                    return response()->json([
                        'error' => true,
                        'message' => "O usuário responsável pela vaga informado deve ser um recrutador."
                    ],400);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "O usuário responsável pela vaga informado é inexistente."
                ],400);
            }

            
            $vacancy = Vacancy::find($id);

            if(!$vacancy){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhuma vaga encontrada com o ID especificado."
                ],200);
            }
    
            $vacancy->name = $request->get('name');
            $vacancy->description = $request->get('description');
            $vacancy->vacancy_type = $request->get('vacancy_type');
            $vacancy->user_id = $request->get('user_id');
            $vacancy->opened = $request->get('opened') ?? 1;

            $vacancy->save();

            return [
                'success' => true,
                'message' => "Vaga atualizada com sucesso."
            ];
    
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar atualizar a vaga. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                // 'message' => $th->getMessage()
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

            $vacancy = Vacancy::find($id);

            if(!$vacancy){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhuma vaga encontrada com o ID especificado."
                ],200);
            }

            $vacancy->delete();

            return [
                'success' => true,
                'message' => "Vaga removida com sucesso."
            ];

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar remover a vaga. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                //'message' => $th->getMessage()
            ],400);
        }
    }

    public function pause($id){
        try {

            $vacancy = Vacancy::find($id);

            if(!$vacancy){
                return response()->json([
                    'error' => true,
                    'message' => "Nenhuma vaga encontrada com o ID especificado."
                ],200);
            }

            $vacancy->opened = 0;

            $vacancy->save();

            return [
                'success' => true,
                'message' => "Vaga pausada com sucesso."
            ];

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar pausar a vaga. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                //'message' => $th->getMessage()
            ],400);
        }
    }
}
