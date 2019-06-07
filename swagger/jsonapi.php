<?php
/**
 *  @OA\Get(
 *      tags={"jdd-test"},
 *      path="/api/data/test",
 *      summary="List some test records",
 *      @OA\Response(
 *          response=200,
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/Test"),
 *              )
 *          ),
 *          description="List some test records.",
 *      )
 *  )
 *
 *  @OA\Post(
 *      tags={"jdd-test"},
 *      path="/api/data/test",
 *      summary="Save a test record",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *                  ref="#/components/schemas/TestEditable"
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="success",
 *          @OA\JsonContent(ref="#/components/schemas/Test")
 *      ),
 *  )
 *
 */
