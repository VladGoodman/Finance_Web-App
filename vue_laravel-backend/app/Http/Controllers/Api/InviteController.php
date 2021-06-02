<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupParticipation;
use App\Models\Invite;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class InviteController extends Controller
{
    public function getUser(Request $request)
    {
        return $request->user();
    }

    public function createInvite(Request $request)
    {
        $user = $this->getUser($request);

        $validator = Validator::make($request->all(), [
            'recipient_id' => 'required|numeric',
            'group_id' => 'required|numeric'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()
            ], 400);
        }

        if(User::all()->where('id', $request->recipient_id)->first()){
            if (Group::all()->where('id', $request->group_id)->first()){

                $change = Invite::create([
                    'group_id' => $request->group_id,
                    'creator_id' => $user->id,
                    'recipient_id' => $request->recipient_id,
                ]);

                return response()->json([
                    'status'=>true,
                    'info'=> $change
                ], 200);
            }else{
                return response()->json([
                    'status'=>false,
                    'error'=> 'Такой группы не существует'
                ], 400);
            }
        }else{
            return response()->json([
                'status'=>false,
                'error'=> 'Такого пользователя не существует'
            ], 400);
        }
    }

    public function getInvites(Request $request){
        $user = $this->getUser($request);
        $invites = DB::table('invites')
            ->join('users', 'users.id', '=', 'invites.creator_id')
            ->where('invites.recipient_id', '=', $request->recipient_id)
            ->orWhere('invites.creator_id', '=', $user->id)
            ->orWhere('invites.recipient_id', '=', $user->id)
            ->orWhere('invites.creator_id', '=', $request->recipient_id)

            ->join('groups', 'invites.group_id', '=', 'groups.id')
            ->select('invites.id as invite_id','users.name as creator', 'groups.name as group_name')
            ->get();

        return response()->json([
            'status'=>true,
            'info'=> $invites
        ], 200);
    }

    public function acceptInvite(Request $request){
        $user = $this->getUser($request);

        $validator = Validator::make($request->all(), [
            'invite_id' => 'required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()
            ], 400);
        }

        $invite = Invite::all()
            ->where('id', $request->invite_id)
            ->first();

        if($invite){
            $accept = GroupParticipation::create([
                'user_id'=> $user->id,
                'group_id'=>$invite->group_id
            ]);
            $invite->delete();
            return response()->json([
                'status'=>true,
                'info'=> $accept
            ], 200);
        }else{
            return response()->json([
                'status'=> false,
                'errors'=> 'Приглашение не найдено'
            ], 400);
        }
    }

    public function rejectInvite(Request $request)
    {
        $user = $this->getUser($request);

        $validator = Validator::make($request->all(), [
            'invite_id' => 'required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()
            ], 400);
        }
        $invite = Invite::all()->where('id', $request->invite_id)->first();
        if($invite){
            if($invite->recipient_id === $user->id){
                $invite->delete();
                return response()->json([
                    'status'=>true,
                    'info'=> 'Приглашение отклонено'
                ], 200);
            }else{
                return response()->json([
                    'status'=> false,
                    'errors'=> 'Это приглашение вам не пренадлежит'
                ], 400);
            }
        }else{
            return response()->json([
                'status'=> false,
                'errors'=> 'Ошибка идентификации приглашения'
            ], 400);
        }
    }
}
