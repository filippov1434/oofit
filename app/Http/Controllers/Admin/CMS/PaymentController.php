<?php

namespace App\Http\Controllers\Admin\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Return info about all rows in JSON
     * 
     * @return object $result is array of JSON for each row
     */
    public function getAllPayment(Payment $payment) : object {
        $result = $payment->getAllPaymentInfo();     
        return response()->json([
            "data" => $result
         ], 200);
    }

    /**
     * Return info about 1 row in JSON, by id
     * 
     * @return object $result is array with JSON for 1 row
     */
    public function getPayment(int $id, Payment $payment) : object {
        if (Payment::where('id', $id)->exists()) {
            $result = $payment->getOnePaymentInfo($id);
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
    public function createPayment(PaymentRequest $request) : object {
        Payment::create($request->input('paymentInfo'));
        return response()->json([
            "message" => "Record created"
        ], 201);
    }

    /**
     * Update row by id
     * 
     * @return object response with JSON (success message)
     */
    public function updatePayment(PaymentRequest $request, int $id) : object {
        if (Payment::where('id', $id)->exists()) {
            $data = $request->input('paymentInfo');
            Payment::where('id', $id)->update($data);
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
    public function deletePayment(int $id) : object {
        if (Payment::where('id', $id)->exists()) {
            Payment::where('id', $id)->delete();
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
