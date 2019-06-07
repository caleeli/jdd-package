<?php

namespace JDD\Example\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Test model
 *
 * Swagger definition:
 *
 *  @OA\Schema(
 *      schema="TestEditable",
 *      @OA\Property(
 *          property="attributes",
 *          type="object",
 *          @OA\Property(property="data", type="object"),
 *          @OA\Property(property="status", type="string", enum={"ACTIVE", "COMPLETED"}),
 *      )
 *  )
 *
 *  @OA\Schema(
 *      schema="Test",
 *      allOf={
 *          @OA\Schema(
 *              @OA\Property(property="id", type="string", format="id"),
 *          ),
 *          @OA\Schema(ref="#/components/schemas/TestEditable"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="attributes",
 *                  type="object",
 *                  @OA\Property(property="created_at", type="string", format="date-time"),
 *                  @OA\Property(property="updated_at", type="string", format="date-time"),
 *                  @OA\Property(property="id", type="string", format="id"),
 *              )
 *          )
 *      }
 *  )
 */
class Test extends Model
{
    protected $attributes = [
        'data' => '{}',
        'status' => 'ACTIVE',
    ];
    protected $fillable = [
        'data',
        'status',
    ];
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Call a process with the workflow engine
     *
     * @param array $data
     *
     * @return array
     */
    public function foo($bar)
    {
        return [
            'message' => "Hello $bar",
        ];
    }
}
