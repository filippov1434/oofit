<?php

namespace App\Http\Controllers\Admin\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Return info about all rows in JSON
     * 
     * @return object $result is array of JSON for each row
     */
    public function getAllApplication(Application $application) : object {
        $result = $application->getAllApplicationInfo();     
        return response()->json([
            "data" => $result
         ], 200);
    }

    /**
     * Return info about 1 row in JSON, by id
     * 
     * @return object $result is array with JSON for 1 row
     */
    public function getApplication(int $id, Application $application) : object  {
        if (Application::where('id', $id)->exists()) {
            $result = $application->getOneApplicationInfo($id);
            return response()->json([
                "data" => $result
             ], 200);
        } else {
            return response()->json([
                "message" => "Record not found"
            ], 404);
        }
    }

    /**
     * Create new row
     * 
     * @return object response with JSON (success message)
     */
    public function createApplication(ApplicationRequest $request) : object {
        Application::create($request->input("applicationInfo"));
        return response()->json([
            "message" => "Record created"
        ], 201);
    }

    /**
     * Update row by id
     * 
     * @return object response with JSON (success message)
     */
    public function updateApplication(ApplicationRequest $request, int $id) : object {
        if (Application::where('id', $id)->exists()) {
            $data = $request->input("applicationInfo");
            Application::where('id', $id)->update($data);
            return response()->json([
                "message" => "Record updated"
            ], 200);
        } else {
            return response()->json([
                "message" => "Record not found"
            ], 404);
        }
    }

    /**
     * Delete row by id
     * 
     * @return object response with JSON (success message)
     */
    public function deleteApplication(int $id) : object {
        if (Application::where('id', $id)->exists()) {
            Application::where('id', $id)->delete();
            return response()->json([
                "message" => "Record deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Record not found"
            ], 404);
        }
    }
}
