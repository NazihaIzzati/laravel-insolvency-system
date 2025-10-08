<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnulmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ic_no' => $this->ic_no,
            'others' => $this->others,
            'court_case_no' => $this->court_case_no,
            'release_date' => $this->release_date?->format('Y-m-d'),
            'updated_date' => $this->updated_date,
            'release_type' => $this->release_type,
            'branch' => $this->branch,
            'status' => $this->is_active ? 'active' : 'inactive',
            'formatted_updated_date' => $this->formatted_updated_date,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'record_type' => 'annulment'
        ];
    }
}