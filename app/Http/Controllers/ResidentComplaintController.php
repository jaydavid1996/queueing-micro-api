<?php
namespace App\Http\Controllers;

use App\Models\Transactions\TransactionComplaint;
use Illuminate\Http\Request;

class ResidentComplaintController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/residents/{resident_id}/complaints",
     *      summary="Get all complaints",
     *      tags={"Resident Complaints"},
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
     *         *     @OA\Response(
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
     *      ),
     *    )
     *
    */
    public function index($resident_id)
    {
        $complaints = TransactionComplaint::select('id', 'resident_id', 'status', 'is_priority')
        ->where('resident_id', $resident_id);
        $complaints  = $this->paginate($complaints);
        return response()->json($complaints, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/residents/{resident_id}/complaints/{complaint_id}",
     *      summary="Get one complaint",
     *      tags={"Resident Complaints"},
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
     *          name="complaint_id",
     *          description="Complaint ID",
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
     *                     example="Complaints retrieved successfully."
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
     *                         example="true"
     *                        ),
     *
     *              )
     *          )
     *
     *        )
     *    )
     *
    */

    public function show($resident_id, $complaint_id)
    {
        $complaint = TransactionComplaint::select('id', 'resident_id', 'status', 'is_priority')
        ->where('resident_id', $resident_id)->where('id', $complaint_id)->first();
        return response()->json($complaint);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/residents/{resident_id}/complaints",
     *     summary="Create a complaint",
     *     tags={"Resident Complaints"},
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
     *                     example="Complaints retrieved successfully."
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
     *            property="complaint",
     *            type="string",
     *            example="My complaint"
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

        $complaint = TransactionComplaint::create([
            'resident_id' => $resident_id,
            'type' => TransactionComplaint::TYPE,
            'meta' => $request->all(),
            'status' => 'onqueue',
            'is_priority' => $is_priority ?? TransactionComplaint::DEFAULT_is_priority
        ]);
        //Add complaint saving on ResidentComplaint Model
        return response()->json([
            'status' => 'success',
            'message' => 'Complaint successfully created.',
            'data' => $complaint
        ], 200);
    }

      /**
     * @OA\Put(
     *     path="/api/v1/residents/{resident_id}/complaints/{complaint_id}",
     *     summary="Update a complaint",
     *     tags={"Resident Complaints"},
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
     *         name="complaint_id",
     *          description="Complaint ID",
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
     *                     example="Complaints retrieved successfully."
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
     *            property="complaint",
     *            type="string",
     *            example="My complaint"
     *         )
     *      )
     *  )
     * )
     */

    public function update(Request $request, $resident_id, $complaint_id)
    {
        //Update complaint here
        //Update complaint saving on ResidentComplaint Model

        return response()->json($complaint);
    }

    //Add Update Status Here
}
