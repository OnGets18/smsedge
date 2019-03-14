<?php
/**
 * Created by PhpStorm.
 * User: ongets
 * Date: 13/03/2019
 * Time: 20:13
 */

namespace App\Http\Controllers;

use App\country;
use App\User;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController
{
    public function index()
    {
        return view('welcome')->with(array(
            'users' => User::all(),
            'countries' => country::all()
        ));
    }


    //Task 1 (PHP): create Model Class for getting aggregated by date information from the send_log. Function should receive parameters:
    //	date_from (Y-m-d, required)
    //	date_to (Y-m-d, required)
    //	cnt_id (optional filter)
    //	usr_id (optional filter)
    public function gettingAggregatedByDate($filter = [])
    {
        $from = $filter['from'];
        $to = $filter['to'];
        $user_id = $filter['user_id'];
        $country_id = $filter['country_id'];

        if (!($from && $to))
            return [];

        $sql = "SELECT send_logs.`created_at` as date, COUNT(*) as counter,log_success  FROM send_logs
                LEFT JOIN users ON send_logs.user_id = users.id
                LEFT JOIN numbers ON send_logs.num_id = numbers.id
                LEFT JOIN countries on numbers.country_id = countries.id
                where  '$from' < send_logs.created_at and '$to' > send_logs.created_at or
                (countries.id ='$country_id' or users.id = '$user_id')
                GROUP BY send_logs.created_at,send_logs.log_success";
        return DB::select(DB::raw($sql));
    }

    //Task 2 (Front-End): create web page for displaying of the aggregated log.
    // Page should contain form with filters (selectors): country, user and dates.
    public function filter(Request $request)
    {
        $data = $this->gettingAggregatedByDate($request->all());

        return view('welcome')->with(array(
            'message' => $this->margeDate($data),
            'users' => User::all(),
            'countries' => country::all()
        ));
    }

    private function margeDate($data)
    {
        $temp = [];

        foreach ($data as $dt) {
            $temp[$dt->date][$dt->log_success ? "success" : "fail"] = $dt->counter;
        };

        return $temp;
    }
}