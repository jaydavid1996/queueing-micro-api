<?php
namespace App\Http\Controllers;

use App\Models\Transactions\TransactionRecord;
use Illuminate\Http\Request;

class ResidentRecordController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/residents/{resident_id}/records",
     *      summary="Get all records",
     *      tags={"Resident Records"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="resident_id",
     *          description="Resident ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *         )
     *     ),
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
     *    )
     *
    */
    public function index($resident_id)
    {
        $records = TransactionRecord::select('id', 'resident_id', 'status', 'is_priority')
        ->where('resident_id', $resident_id);
        $records =  $this->paginate($records);
        return response()->json($records, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/residents/{resident_id}/records/{record_id}",
     *      summary="Get one record",
     *      tags={"Resident Records"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="resident_id",
     *          description="Resident ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="record_id",
     *          description="Record ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *               type="object",
     *                  @OA\Property(
     *                    format="string",
     *                    property="status",
     *                    example="success"
     *                  ),
     *                 @OA\Property(
     *                    format="string",
     *                    property="message",
     *                     example="Records retrieved successfully."
     *                 ),
     *                  @OA\Property(
     *                      type="object",
     *                      property="data",
     *
     *                        @OA\Property(
     *                            property="id",
     *                            format="uuid",
     *                            example="d0b0c8c0-5f5a-4a5a-9b1a-3c1b0f7f5f1a"
     *                        ),
     *                        @OA\Property(
     *                           property="resident_id",
     *                           format="uuid",
     *                           example="d0b0c8c0-5f5a-4a5a-9b1a-3c1b0f7f5f1a"
     *                        ),
     *                        @OA\Property(
     *                           property="status",
     *                           format="string",
     *                           example="(onqueue/inprogress/complete/cancelled)"
     *                        ),
     *                          @OA\Property(
     *                          property="is_priority",
     *                         format="boolean",
     *                         example="1"
     *                        ),
     *
     *              )
     *          )
     *
     *        )
     *    )
     *
    */

    public function show($resident_id, $record_id)
    {
        $record = TransactionRecord::select('id', 'resident_id', 'status', 'is_priority')
        ->where('resident_id', $resident_id)->where('id', $record_id)->first();
        return response()->json($record);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/residents/{resident_id}/records",
     *     summary="Create a record",
     *     tags={"Resident Records"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="resident_id",
     *          description="Resident ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *          type="string",
     *          format="uuid"
     *       )
     *    ),
     *      @OA\Response(
     *         response=200,
     *         description="Successfully Queued",
     *         @OA\JsonContent(
     *               type="object",
     *                  @OA\Property(
     *                    format="string",
     *                    property="status",
     *                    example="success"
     *                  ),
     *                 @OA\Property(
     *                    format="string",
     *                    property="message",
     *                     example="Records retrieved successfully."
     *                 ),
     *                  @OA\Property(
     *                      type="object",
     *                      property="data",
     *
     *                        @OA\Property(
     *                            property="id",
     *                            format="uuid",
     *                            example="d0b0c8c0-5f5a-4a5a-9b1a-3c1b0f7f5f1a"
     *                        ),
     *                        @OA\Property(
     *                           property="resident_id",
     *                           format="uuid",
     *                           example="d0b0c8c0-5f5a-4a5a-9b1a-3c1b0f7f5f1a"
     *                        ),
     *                        @OA\Property(
     *                           property="status",
     *                           format="string",
     *                           example="onqueue"
     *                        ),
     *                          @OA\Property(
     *                          property="is_priority",
     *                         format="boolean",
     *                         example="1"
     *                      ),
     *
     *              )
     *          )
     *
     *     ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Pass queue",
     *      @OA\JsonContent(
     *          @OA\Property(
     *            property="record",
     *            type="string",
     *            example="My record"
     *         )
     *      )
     *  )
     * )
     */

    public function store(Request $request, $resident_id)
    {
        if ($request->filled('is_priority')) {
            $is_priority = $request->is_priority;
            $request->request->remove('is_priority');
        }

        $record = TransactionRecord::create([
            'resident_id' => $resident_id,
            'type' => TransactionRecord::TYPE,
            'meta' => $request->all(),
            'status' => 'onqueue',
            'is_priority' => $is_priority ?? TransactionRecord::DEFAULT_is_priority
        ]);
        //Add record saving on Resident Record Model
        return response()->json([
            'status' => 'success',
            'message' => 'Record successfully created.',
            'data' => $record
        ], 200);
    }

      /**
     * @OA\Put(
     *     path="/api/v1/residents/{resident_id}/records/{record_id}",
     *     summary="Update a record",
     *     tags={"Resident Records"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="resident_id",
     *          description="Resident ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *          type="string",
     *          format="uuid"
     *       )
     *    ),
     *     @OA\Parameter(
     *         name="record_id",
     *          description="Record ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *          type="string",
     *          format="uuid"
     *       )
     *    ),
     *      @OA\Response(
     *         response=200,
     *         description="Successfully Updated",
     *         @OA\JsonContent(
     *               type="object",
     *                  @OA\Property(
     *                    format="string",
     *                    property="status",
     *                    example="success"
     *                  ),
     *                 @OA\Property(
     *                    format="string",
     *                    property="message",
     *                     example="Records retrieved successfully."
     *                 ),
     *                  @OA\Property(
     *                      type="object",
     *                      property="data",
     *
     *                        @OA\Property(
     *                            property="id",
     *                            format="uuid",
     *                            example="d0b0c8c0-5f5a-4a5a-9b1a-3c1b0f7f5f1a"
     *                        ),
     *                        @OA\Property(
     *                           property="resident_id",
     *                           format="uuid",
     *                           example="d0b0c8c0-5f5a-4a5a-9b1a-3c1b0f7f5f1a"
     *                        ),
     *                        @OA\Property(
     *                           property="status",
     *                           format="string",
     *                           example="onqueue"
     *                        ),
     *                          @OA\Property(
     *                          property="is_priority",
     *                         format="boolean",
     *                         example="1"
     *                      ),
     *
     *              )
     *          )
     *
     *     ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Pass queue",
     *      @OA\JsonContent(
     *          @OA\Property(
     *            property="record",
     *            type="string",
     *            example="My record"
     *         )
     *      )
     *  )
     * )
     */

    public function update(Request $request, $resident_id, $record_id)
    {
        //Update record here
        //Update record saving on ResidentRecord Model

        return response()->json($record);
    }

    //Add Update Status Here
}
