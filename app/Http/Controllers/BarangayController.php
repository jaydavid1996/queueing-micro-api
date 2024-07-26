<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangay;
use Illuminate\Support\Facades\Validator;

class BarangayController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/api/v1/barangays",
     *      tags={"Barangay"},
     *     summary="Get all barangays",
     *     operationId="getBarangays",
     *     security={{"bearerAuth":{}}},
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
     *     @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notauthenticated"
     *      )
     * )
    */

    public function index()
    {   
        $barangays = Barangay::select();
        $barangays = $this->paginate($barangays);
        return response()->json($barangays, 200);
    }

      /**
     * @OA\Get(
     *      path="/api/v1/barangays/{barangay_id}",
     *      summary="Get one barangay",
     *      tags={"Barangay"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="barangay_id",
     *          description="Barangay ID",
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
     *                     example="Barangay retrieved successfully."
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
     *
     *              )
     *          )
     *
     *        )
     *    )
     *
    */

    public function show($barangay_id)
    {
        $barangay = Barangay::find($barangay_id);
        return response()->json([
            'status' => 'success',
            'message' => 'Barangay retrieved successfully.',
            'data' => $barangay
        ], 200);
    }

     /**
     * @OA\Post(
     *     path="/api/v1/barangays",
     *     summary="Create a Barangay",
     *     tags={"Barangay"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Response(
     *         response=200,
     *         description="Successfully Added Barangay.",
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
     *                           property="name",
     *                           format="string",
     *                           example="Angeles City"
     *                        ),
     *                          @OA\Property(
     *                          property="address",
     *                          format="string",
     *                          example="123 Street"
     *                      ),
     *
     *              )
     *          )
     *
     *     ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Pass barangay information",
     *      @OA\JsonContent(
     *          @OA\Property(
     *            property="name",
     *            type="string",
     *            example="Angels City"
     *         ),
    *          @OA\Property(
     *            property="address",
     *            type="string",
     *            example="123 Street"
     *         )
     *      )
     *  )
     * )
     */

    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        if ($validated->fails()) {
            return response()->json(['message' => 'Invalid information', 'errors' => $validated->errors()]);
        }

        $barangay = new Barangay();
        $barangay->name = $request->input('name');
        $barangay->address = $request->input('address');
        $barangay->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Barangay created successfully!'
        ]);
    }

         /**
     * @OA\Put(
     *     path="/api/v1/barangays/{barangay_id}",
     *     summary="Update a Barangay",
     *     tags={"Barangay"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="barangay_id",
     *         description="Barangay ID",
     *         required=true,
     *         in="path",
     * ),
     *      @OA\Response(
     *         response=200,
     *         description="Successfully Updated Barangay.",
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
     *                           property="name",
     *                           format="string",
     *                           example="Angeles City"
     *                        ),
     *                          @OA\Property(
     *                          property="address",
     *                          format="string",
     *                          example="123 Street"
     *                      ),
     *
     *              )
     *          )
     *
     *     ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Pass barangay information",
     *      @OA\JsonContent(
     *          @OA\Property(
     *            property="name",
     *            type="string",
     *            example="Angels City"
     *         ),
    *          @OA\Property(
     *            property="address",
     *            type="string",
     *            example="123 Street"
     *         )
     *      )
     *  )
     * )
     */

    public function update(Request $request, $barangay_id)
    {
        $barangay = Barangay::find($barangay_id);
        $barangay->name = $request->input('name') ?? $barangay->name;
        $barangay->address = $request->input('address') ?? $barangay->address;
        $barangay->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Barangay updated successfully!'
        ]);
    }
    
}