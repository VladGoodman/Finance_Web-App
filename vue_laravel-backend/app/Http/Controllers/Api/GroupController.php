<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupParticipation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function getUser(Request $request)
    {
        return $request->user();
    }


    public function checkGroupAccount(Request $request)
    {
        $user = $this->getUser($request);

    }

    public function getGroupInfo(Request $request)
    {
        $user = $this->getUser($request);

        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()
            ], 400);
        }

        $group_info = DB::table('groups')
            ->where('groups.id', $request->group_id)
            ->join('users', 'users.id', '=', 'groups.creator_id')
            ->select('groups.name as group_name', 'groups.id as group_id', 'users.name as creator_name','users.id as creator_check')
            ->first();
        if($group_info){
            $subscribers_info = DB::table('group_participations')
                ->where('group_id', $group_info->group_id)
                ->join('users', 'users.id', '=', 'group_participations.user_id')
                ->select('users.name as username')
                ->get();
        }else{
            return response()->json([
                'status'=> false,
                'errors'=> 'Группа не найдена'
            ], 400);
        }
        if($user->id === $group_info->creator_check){
            $group_info->creator_check= true;
        }else{
            $group_info->creator_check= false;
        }
        return response()->json([
            'status'=>true,
            'info'=> [
                'group_info'=>$group_info,
                 'subs_info'=>$subscribers_info
                ]
        ], 200);
    }

    public function checkMyGroups(Request $request)
    {
        $user = $this->getUser($request);
        $groups = DB::table('group_participations')
            ->join('groups', 'groups.id', '=', 'group_participations.group_id')
            ->where('group_participations.user_id', $this->getUser($request)->id)
            ->select('group_participations.id as participations_id', 'groups.id as group_id', 'groups.name as group_name')
            ->get();
        return response()->json([
            'status'=>true,
            'info'=> $groups
        ], 200);
    }

    public function createGroup(Request $request)
    {
        $user = $this->getUser($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()
            ], 400);
        }
        $change = Group::create([
            'creator_id' => $user->id,
            'name' => $request->name
        ]);
        $group_participation = GroupParticipation::create([
            'user_id' => $user->id,
            'group_id' => $change->id
        ]);
        return response()->json([
            'status'=>true,
            'info'=> $group_participation
        ], 200);
    }

    public function createGroupParticipation(Request $request)
    {
        $user = $this->getUser($request);
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()
            ], 400);
        }

        if(Group::all()->where('id', $request->group_id)->first()){
            $group_participation = GroupParticipation::create([
                'user_id' => $user->id,
                'group_id' => $request->group_id
            ]);
            return response()->json([
                'status'=>true,
                'info'=> $group_participation
            ], 200);
        }else{
            return response()->json([
                'status'=> false,
                'errors'=> 'Такой группы не существует'
            ], 400);
        }
    }


    public function leaveGroup(Request $request)
    {
        $user = $this->getUser($request);

        $validator = Validator::make($request->all(), [
            'participation_id' => 'required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()
            ], 400);
        }
        $participation = GroupParticipation::all()->where('id', $request->participation_id)->first();
        if($participation){
            if($participation->user_id === $user->id){
                $participation->delete();
                return response()->json([
                    'status'=>true,
                    'info'=> 'Вы вышли из группы'
                ], 200);
            }else{
                return response()->json([
                    'status'=> false,
                    'errors'=> 'Вы не находитесь в группе'
                ], 400);
            }
        }else{
            return response()->json([
                'status'=> false,
                'errors'=> 'Ошибка идентификации группы'
            ], 400);
        }
    }
}
