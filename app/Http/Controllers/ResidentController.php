<?php
namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function __construct() {
        $this->middleware('role:admin|moderator',['only' => ['getAll', 'getOne']]);
        $this->middleware('role:admin|moderator',['only' => ['create', 'update']]);
    }

    /**
    * @OA\Tag(
    *     name="Residents",
    *     description="EBOS Resident Services endpoints",
    * ),
    */
        /**
    * @OA\Tag(
    *     name="Resident Records",
    *     description="EBOS Resident Services endpoints",
    * ),
    */

    /**
    * @OA\Tag(
    *     name="Resident Documents",
    *     description="EBOS Resident Services endpoints",
    * ),
    */


    /**
    * @OA\Tag(
    *     name="Resident Complaints",
    *     description="EBOS Resident Services endpoints",
    * ),
    */

    /**
     * @OA\Get(
     *  path="/api/v1/residents",
     *  operationId="getAllResident",
     *  tags={"Residents"},
     *  security={{"bearerAuth":{}}},
     *  summary="Get All Resident",
     *      @OA\Response(
     *         respons     *        *     @OA\Response(
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
     */
    public function getAll() {
        $residents = Resident::select();
        $residents = $this->paginate($residents);
        return response()->json($residents, 200);
    }
    /**
     * @OA\Get(
     *  path="/api/v1/residents/{resident_id}",
     *  operationId="getOneResident",
     *  tags={"Residents"},
     *  security={{"bearerAuth":{}}},
     *  summary="Get Specific Resident",
     *      @OA\Response(
     *         response="200",
     *         description="Returns Success Message",
     *             @OA\JsonContent(
     *                type="object",
     *                @OA\Property(
     *                    format="string",
     *                    property="status",
     *                    example="success"
     *                ),
     *                @OA\Property(
     *                    format="string",
     *                    property="message",
     *                    example="Resident data"
     *                ),
     *                @OA\Property(
     *                    format="object",
     *                      property="data",
     *                      @OA\Property(
     *                          format="string",
     *                          property="resident_id",
     *                          example="00000-0000000-0000-00-00000"
     *                      ),
     *                      @OA\Property(
     *                          format="string",
     *                           property="first_name",
     *                              example="Juan"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="last_name",
     *                              example="Dela Cruz"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="middle_name",
     *                              example="Dela Cruz"
     *                          ),
     *                          @OA\Property(
     *                             format="string",
     *                              property="email",
     *                              example="example@emai.com"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="contact_number",
     *                              example="09123456789"
     *                          ),
     *                     @OA\Property(
     *                          format="string",
     *                          property="address1",
     *                          example="Address 1"
     *                      ),
     *                      @OA\Property(
     *                          format="string",
     *                          property="address2",
     *                          example="Address 2"
     *                      )
     *                 )
     *            )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notauthenticated"
     *      ),
     *      @OA\Parameter(
     *          name="resident_id",
     *          in="path",
     *          required=true,
     *          description="Resident ID",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     )
     * )
     */

     public function getOne($resident_id) {

        $resident = Resident::find($resident_id);
        if ($resident) {
            return response()->json([
                'status' => 'success',
                'message' => 'Resident data',
                'data' => [
                    'resident_id' => $resident->id,
                    'barangay_id' => $resident->barangay_id,
                    'first_name' => $resident->first_name,
                    'middle_name' => $resident->middle_name,
                    'last_name' => $resident->last_name,
                    'address_1' => $resident->address_1,
                    'address_2' => $resident->address_2,
                    'email' => $resident->email,
                    'image_url' => $resident->image_url,
                    'occupation' => $resident->occupation,
                    'marital_status' => $resident->marital_status,
                    'government_grant' => $resident->government_grant,
                    'vaccination_status' => $resident->vaccination_status,
                    'foreigner' => $resident->foreigner,
                    'pet_owner' => $resident->pet_owner,
                    'pet_type' => $resident->pet_type,
                    'contact_number' => $resident->contact_number,
                ]
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Resident not found',
                'resident_id' => $resident_id,
            ], 404);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/v1/residents",
     *  operationId="addResident",
     *  tags={"Residents"},
     *  security={{"bearerAuth":{}}},
     *  summary="Add Resident",
     *      @OA\Response(
     *         response="200",
     *         description="Returns Success Message",
     *             @OA\JsonContent(
     *                type="object",
     *                @OA\Property(
     *                    format="string",
     *                    property="status",
     *                    example="success"
     *                ),
     *                @OA\Property(
     *                    format="string",
     *                    property="message",
     *                    example="Resident data"
     *                ),
     *                @OA\Property(
     *                    format="object",
     *                      property="data",
     *                      @OA\Property(
     *                          format="string",
     *                          property="resident_id",
     *                          example="00000-0000000-0000-00-00000"
     *                      ),

     *                             @OA\Property(
     *                              format="string",
     *                              property="first_name",
     *                              example="Juan"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="last_name",
     *                              example="Dela Cruz"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="middle_name",
     *                              example="Dela Cruz"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="email",
     *                              example="example@email.com"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="contact_number",
     *                              example="09123456789"
     *                          ),
     *                     @OA\Property(
     *                          format="string",
     *                          property="address1",
     *                          example="Address 1"
     *                      ),
     *                      @OA\Property(
     *                          format="string",
     *                          property="address2",
     *                          example="Address 2"
     *                      )
     *                 )
     *            )
     *      ),
     *      @OA\RequestBody(
     *          description="Add Resident",
     *          @OA\JsonContent(
     *                      @OA\Property(
     *                          format="string",
     *                           property="first_name",
     *                              example="Juan"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="last_name",
     *                              example="Dela Cruz"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="middle_name",
     *                              example="Dela Cruz"
     *                          ),
     *              @OA\Property(
     *                  format="string",
     *                  property="address1",
     *                  example="Address 1"
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  property="address2",
     *                  example="Address 2"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notauthenticated"
     *      ),
     * )
     */
    public function create(Request $request) {
        $resident = new Resident();
        $resident->first_name = $request->first_name;
        $resident->middle_name = $request->middle_name;
        $resident->last_name = $request->last_name;
        $resident->address_1 = $request->address1;
        $resident->address_2 = $request->address2;
        $resident->email = $request->email;
        $resident->image_url = $request->image_url;
        $resident->occupation = $request->occupation;
        $resident->marital_status = $request->marital_status;
        $resident->government_grant = $request->government_grant;
        $resident->vaccination_status = $request->vaccination_status;
        $resident->foreigner = $request->foreigner;
        $resident->pet_owner = $request->pet_owner;
        $resident->pet_type = $request->pet_type;
        $resident->contact_number = $request->contact_number;
        $resident->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Resident data',
            'data' => [
                'resident_id' => $resident->id,
                'barangay_id' => $resident->barangay_id,
                'first_name' => $resident->first_name,
                'middle_name' => $resident->middle_name,
                'last_name' => $resident->last_name,
                'address_1' => $resident->address_1,
                'address_2' => $resident->address_2,
                'email' => $resident->email,
                'image_url' => $resident->image_url,
                'occupation' => $resident->occupation,
                'marital_status' => $resident->marital_status,
                'government_grant' => $resident->government_grant,
                'vaccination_status' => $resident->vaccination_status,
                'foreigner' => $resident->foreigner,
                'pet_owner' => $resident->pet_owner,
                'pet_type' => $resident->pet_type,
                'contact_number' => $resident->contact_number,
            ]
        ], 200);
    }
        /**
     * @OA\Put(
     *  path="/api/v1/residents/{resident_id}",
     *  operationId="updateResident",
     *  tags={"Residents"},
     *  security={{"bearerAuth":{}}},
     *  summary="Update Resident",
     *      @OA\Response(
     *         response="200",
     *         description="Returns Success Message",
     *             @OA\JsonContent(
     *                type="object",
     *                @OA\Property(
     *                    format="string",
     *                    property="status",
     *                    example="success"
     *                ),
     *                @OA\Property(
     *                    format="string",
     *                    property="message",
     *                    example="Resident data"
     *                ),
     *                @OA\Property(
     *                    format="object",
     *                      property="data",
     *                      @OA\Property(
     *                          format="string",
     *                          property="resident_id",
     *                          example="00000-0000000-0000-00-00000"
     *                      ),
     *                         @OA\Property(
     *                              format="string",
     *                              property="first_name",
     *                              example="Juan"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="last_name",
     *                              example="Dela Cruz"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="middle_name",
     *                              example="Dela Cruz"
     *                          ),
     *                          @OA\Property(
     *                             format="string",
     *                              property="email",
     *                              example="example@email.com"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="contact_number",
     *                              example="09123456789"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="address1",
     *                              example="Address 1"
     *                          ),
     *                          @OA\Property(
     *                              format="string",
     *                              property="address2",
     *                              example="Address 2"
     *                          )
     *                 )
     *            )
     *      ),
     *      @OA\RequestBody(
     *          description="Update Resident",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                  format="string",
     *                  property="name",
     *                  example="Juan Dela Cruz"
     *             ),
     *              @OA\Property(
     *                  format="string",
     *                  property="address1",
     *                  example="Address 1"
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  property="address2",
     *                  example="Address 2"
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  property="first_name",
     *                  example="Juan"
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  property="last_name",
     *                  example="Dela Cruz"
     *               ),
     *               @OA\Property(
     *                  format="string",
     *                  property="middle_name",
     *                  example="Dela Cruz"
     *               ),
     *               @OA\Property(
     *                  format="string",
     *                  property="email",
     *                  example="example@email.com"
     *               ),
     *               @OA\Property(
     *                  format="string",
     *                  property="contact_number",
     *                  example="09123456789"
     *               ),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="resident_id",
     *          in="path",
     *          required=true,
     *          description="Resident ID",
     *          @OA\Schema(
     *          type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notauthenticated"
     *      ),
     * )
     */
    public function update(Request $request, $resident_id) {
        $resident = Resident::find($resident_id);
        if ($resident) {

            $resident->first_name = $request->first_name ?? $resident->first_name;
            $resident->middle_name = $request->middle_name ?? $resident->middle_name;
            $resident->last_name = $request->last_name ?? $resident->last_name;
            $resident->address_1 = $request->address_1 ?? $resident->address_1;
            $resident->address_2 = $request->address_2 ?? $resident->address_2;
            $resident->email = $request->email ?? $resident->email;
            $resident->image_url = $request->image_url ?? $resident->image_url;
            $resident->occupation = $request->occupation ?? $resident->occupation;
            $resident->marital_status = $request->marital_status ?? $resident->marital_status;
            $resident->government_grant = $request->government_grant ?? $resident->government_grant;
            $resident->vaccination_status = $request->vaccination_status ?? $resident->vaccination_status;
            $resident->foreigner = $request->foreigner ?? $resident->foreigner;
            $resident->pet_owner = $request->pet_owner ?? $resident->pet_owner;
            $resident->pet_type = $request->pet_type ?? $resident->pet_type;
            $resident->contact_number = $request->contact_number ?? $resident->contact_number;

            $resident->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Resident data',
                'data' => [
                    'resident_id' => $resident->id,
                    'first_name' => $resident->first_name,
                    'last_name' => $resident->last_name,
                    'middle_name' => $resident->middle_name,
                    'email' => $resident->email,
                    'contact_number' => $resident->contact_number,
                    'address1' => $resident->address_1,
                    'address2' => $resident->address_2
                ]
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Resident not found',
                'resident_id' => $resident_id,
            ], 404);
        }
    }
}
