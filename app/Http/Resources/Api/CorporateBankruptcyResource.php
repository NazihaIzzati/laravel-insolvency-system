<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CorporateBankruptcyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'insolvency_no' => $this->insolvency_no,
            'company_name' => $this->company_name,
            'company_registration_no' => $this->company_registration_no,
            'others' => $this->others,
            'court_case_no' => $this->court_case_no,
            'date_of_winding_up_resolution' => $this->date_of_winding_up_resolution?->format('Y-m-d'),
            'updated_date' => $this->updated_date,
            'branch' => $this->branch,
            'status' => $this->is_active ? 'active' : 'inactive',
            'formatted_updated_date' => $this->formatted_updated_date,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'record_type' => 'corporate_bankruptcy'
        ];
    }
}