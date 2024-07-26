<?php
namespace App\Http\Controllers;

use App\Models\Transactions\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{


    /**
     * @OA\Get(
     *      path="/api/v1/transactions/queue?type={type}&barangay_id={barangay_id}&status={status}&is_priority={is_priority}",
     *      summary="Get all transactions on queue",
     *      description="Returns all transactions on queue",
     *      operationId="getQueue",
     *      tags={"Transactions"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="type",
     *          in="query",
     *          description="Transaction type (Records = 1, Document = 2, Complaint = 3)",
     *          example="",
     *          required=false,
     *          allowEmptyValue=true,
     *          @OA\Schema(
     *            type="string",
     *            enum={"","1", "2", "3"},
     *            default=""
     *         )
     *      ),
     *      @OA\Parameter(
     *         name="barangay_id",
     *          in="query",
     *          description="Barangay ID",
     *          required=false,
     *          allowEmptyValue=true,
     *          @OA\Schema(
     *            type="string",
     *            format="uuid",
     *         )
     *      ),
     *      @OA\Parameter(
     *         name="status",
     *          in="query",
     *          description="status",
     *          required=false,
     *          allowEmptyValue=true,
     *          @OA\Schema(
     *            type="string",
     *            enum={"onqueue", "completed", "cancelled"},
     *            default="onqueue"
     *         )
     *      ),
     *      @OA\Parameter(
     *         name="is_priority",
     *          in="query",
     *          description="priority",
     *          required=false,
     *          allowEmptyValue=true,
     *          @OA\Schema(
     *            type="string",
     *            enum={"true", "false"},
     *         )
     *      ),
       *     @OA\Response(
     *         response=200,
     *         description="successful operation",
    *         @OA\JsonContent(
     *               type="object",
     *                  @OA\Property(
     *                    format="string",
     *                    property="current_page",
     *                    example=1
     *                  ),
     *                 @OA\Property(
     *                    format="array",
     *                    property="data",
     *                    type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              format="uuid",
     *                              property="id",
     *                              example="1"
     *                         ),
     *                      )
     *                 ),
     *                @OA\Property(
     *                    format="string",
     *                    property="first_page_url",
     *                    example="http://localhost:8000/api/v1/barangays?page=1"
     *                ),
     *                @OA\Property(
     *                    format="string",
     *                    property="from",
     *                    example= null
     *                ),
     *                @OA\Property(
     *                    format="integer",
     *                    property="last_page",
     *                    example= 1
     *                ),
     *                @OA\Property(
     *                    format="string",
     *                    property="last_page_url",
     *                     example="http://localhost:8000/api/v1/barangays?page=1"
     *                ),
     *                @OA\Property(
     *                    format="string",
     *                    property="next_page_url",
     *                    example= null
     *                ),
     *               @OA\Property(
     *                    format="integer",
     *                    property="per_page",
     *                    example= 20
     *                ),
     *                @OA\Property(
     *                    format="integer",
     *                    property="total",
     *                    example=0
     *                ),
     *        )
     *    ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notauthenticated"
     *      )
     * )
     *
    */

    public function index()
    {

        $status = 'onqueue';
        if(request()->has('status') && in_array(request()->status, ['onqueue', 'completed', 'cancelled'])) {
            $status = request()->status;
        }

        $status = (string)trim($status);
        // print_r($status);
        // exit;
        $transactions = Transaction::where('status',$status)
        ->with([
            'resident' => function($query){
                $query->select('id','first_name','middle_name','last_name','contact_number');
            }
        ]);

        if(request()->has('type') && in_array(request()->type, ['1', '2', '3'])) {
            $transactions->where('type', request()->type);
        }

        if(request()->has('barangay_id') && request()->barangay_id != '') {
            $transactions->where('barangay_id', request()->barangay_id);
        }

        if( request()->has('is_priority')
            && in_array(request()->is_priority, ['true', 'false',true,false])
            && request()->is_priority != ''
        ) {
            $condition = request()->is_priority == 'true' ? true : false;
            $transactions->where('is_priority',$condition );

        }


        $transactions->orderBy('created_at', 'asc');

        if( in_array($status, ['completed', 'cancelled']) ) {

            $transactions->orderBy('updated_at', 'asc');

        } else {
            $transactions->orderBy('created_at', 'asc');
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetched queue.',
            'data' => $transactions->get()
        ]);
    }

    public function getAll() {
        $transactions = Transaction::with('resident')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Transactions data',
            'data' => $transactions
        ], 200);
    }
    /**
     * @OA\Post(
     *     path="/api/v1/transactions/{transaction_id}/cancel",
     *     operationId="cancelTransaction",
     *     tags={"Transactions"},
     *     summary="Cancel Transaction",
     *     description="Cancel Transaction",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="transaction_id",
     *         in="path",
     *         description="Transaction ID",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           example="e4a3b2c1-3d2e-4f1a-9e9b-8c7d6a5b4c3d"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully cancelled transaction.",
     *         @OA\JsonContent(
     *            @OA\Property(
     *               property="status",
     *               type="string",
     *               example="success"
     *            ),
     *            @OA\Property(
     *               property="message",
     *               type="string",
     *               example="Successfully cancelled transaction."
     *            ),
     *         )
     *     ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notauthenticated"
     *      )
     * )
     *
     */

    public function cancelTransaction($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);

        if(!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found.',
            ], 404);
        }

        if($transaction->status != 'onqueue') {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction is not on queue.',
            ], 400);
        }

        $transaction->status = 'cancelled';
        $transaction->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully cancelled transaction.',
        ]);
    }

        /**
     * @OA\Post(
     *     path="/api/v1/transactions/{transaction_id}/complete",
     *     operationId="completeTransaction",
     *     tags={"Transactions"},
     *     summary="Complete Transaction",
     *     description="Complete Transaction",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="transaction_id",
     *         in="path",
     *         description="Transaction ID",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           example="e4a3b2c1-3d2e-4f1a-9e9b-8c7d6a5b4c3d"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully completed transaction.",
     *         @OA\JsonContent(
     *            @OA\Property(
     *               property="status",
     *               type="string",
     *               example="success"
     *            ),
     *            @OA\Property(
     *               property="message",
     *               type="string",
     *               example="Successfully completed transaction."
     *            ),
     *         )
     *     ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notauthenticated"
     *      )
     * )
     *
     */

    public function completeTransaction($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);
        if(!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found.',
            ], 404);
        }

        if($transaction->status != 'onqueue') {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction is not in progress.',
            ], 400);
        }

        $transaction->status = 'completed';
        $transaction->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully completed transaction.',
        ]);
    }
}
