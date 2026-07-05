<?php 
namespace App\Http\Resources; 
use Illuminate\Http\Request; 
use Illuminate\Http\Resources\Json\JsonResource; 

class MenuItemResource extends JsonResource 
{ 
    /** * Transform the resource into an array. * 
     * @return array<string, mixed> 
     */ 
    public function toArray(Request $request): array 
    { 
        return 
        [ 
        'id'=>$this->id,

        'name'=>$this->name,

        'description'=>$this->description,

        'price'=>$this->price,

        'preparation_time'=>$this->preparation_time,

        'is_available'=>$this->is_available,

        'category'=>new CategoryResource(
            $this->whenLoaded('category')
        )

        ]; 
    } 
}