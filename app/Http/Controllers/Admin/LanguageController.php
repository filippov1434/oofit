<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;

class LanguageController extends Controller
{
    /**
     * Return info about all rows in JSON
     * 
     * @return object $result is array of JSON for each row
     */
    public function getAllLanguage(Language $language) : object {
        $result = $language->getAllLanguageInfo();     
        return response()->json([
            "data" => $result
         ], 200);
    }

    /**
     * Return info about 1 row in JSON, by id
     * 
     * @return object $result is array with JSON for 1 row
     */
    public function getLanguage(int $id, Language $language) : object {
        if (Language::where('id', $id)->exists()) {
            $result = $language->getOneLanguageInfo($id);
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
    public function createLanguage(LanguageRequest $request) {
        Language::create($request->input('languageInfo'));
        return response()->json([
            "message" => "Record created"
        ], 201);
    }

    /**
     * Update row by id
     * 
     * @return object response with JSON (success message)
     */
    public function updateLanguage(LanguageRequest $request, int $id) : object {
        if (Language::where('id', $id)->exists()) {
            $data = $request->input('languageInfo');
            Language::where('id', $id)->update($data);
            return response()->json([
                "message" => "Record updated successfully"
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
    public function deleteLanguage(int $id) : object {
        if (Language::where('id', $id)->exists()) {
            Language::where('id', $id)->delete();

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
