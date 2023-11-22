<?php

namespace App\Http\Controllers;

use App\Models\Round;
use App\Models\Competitor;
use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RoundsController;

class CompetitorsController extends Controller
{
    public function create(Competition $competition, $id){
        $round = Round::getRoundByCompetitionAndRound($competition, $id);
        $users = UsersController::all();
        $data = [
            'competition' => $competition,
            'round' => $round,
            'users' => $users,
        ];

        return view('pages.competitors.create', compact('data'));
    }

    public function store(Request $request){
        $create_data = [
            'user_email' => $request->user_email,
            'user_firstname' => $request->user_firstname,
            'user_lastname' => $request->user_lastname,
            'round_competition_name' => $request->round_competition_name,
            'round_competition_date' => $request->round_competition_date,
            'round_competition_round' => $request->round_competition_round,
        ];

        $isAdded = Competitor::isCompetitorAdded($request->user_email, $request->round_competition_round, $request->round_competition_name, $request->round_competition_date);

        if(!$isAdded){
            $competitor = Competitor::create($create_data);
            return response()->json(['message' => 'Competitor added successfully']);
        }else{
            return response()->json(['message' => 'Competitor already added']);
        }
       
    }

    
}
