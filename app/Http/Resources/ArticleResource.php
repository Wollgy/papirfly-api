<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            "article_id" => $this->whenNotNull($this->article_id),
            "name" => $this->name,
            "description" => $this->description,
            "category" => $this->category,
            "price" => $this->price,
            "currency" => $this->whenNotNull($this->currency)
        ];
    }
}
