<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *   title="EBOS API",
     *   version="0.0.0",
     *   @OA\Contact(
     *     email="support@example.com",
     *     name="Support Team"
     *   )
     * )
    * @OA\SecurityScheme(
    *      securityScheme="bearerAuth",
    *      in="header",
    *      name="bearerAuth",
    *      type="http",
    *      scheme="bearer",
    *      bearerFormat="JWT",
    * ),
    * @OA\Tag(
    *     name="Authentication",
    *     description="Auth endpoints",
    * ),
    */

     /**
     * @OA\RequestBody(
     *     request="AuthArray",
     *     description="Auth Paramerters",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Property(
     *              format="string",
     *              description="Email",
     *              title="Email",
     *              property="email",
     *              example="matt@gmail.com"
     *          ),
     *          @OA\Property(
     *              format="string",
     *              description="password",
     *              title="Password",
     *              property="password",
     *              example="a123456"
     *          )
     *     )
     * )
     */

      /**
     * @OA\Response(
     *     response="notauthenticated",
     *     description="Respone for Unauthenticated User",
     *             @OA\JsonContent(
     *                type="object",
     *                @OA\Property(
     *                    format="string",
     *                    property="code",
     *                    example="401"
     *                ),
     *                @OA\Property(
     *                    format="string",
     *                    property="message",
     *                    example="You're unauthorized to make a request!"
     *                ),
     *          ),
     * )
     */

      /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     operationId="loginManual",
     *     tags={"Authentication"},
     *     summary="Login Manaul",
     *     @OA\Response(
     *         response="200",
     *         description="Returns JWT",
     *     ),
     *      @OA\RequestBody(ref="#/components/requestBodies/AuthArray")
     * )
     */

         /**
     * @OA\Get(
     *     path="/api/v1/refreshtoken",
     *     operationId="refreshToken",
     *     tags={"Authentication"},
     *      security={{"bearerAuth":{}}},
     *     summary="Refresh Token",
     *     @OA\Response(
     *         response="200",
     *         description="Returns JWT",
     *     ),
     *
     * )
     */

   /**
    * @OA\Tag(
    *     name="Transactions",
    *     description="EBOS Transaction Services endpoints",
    * ),
    */


  protected function paginate($model)
  {
      $perPage = request()->input('limit', 20);
      $page = request()->input('page', 1);

      return $model->paginate(
          is_numeric($perPage) ? $perPage : 10,
          ['*'],
          'page',
          is_numeric($page) ? $page : 1
      );
  }
}
