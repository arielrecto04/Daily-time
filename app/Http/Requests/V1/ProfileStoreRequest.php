<?php

namespace App\Http\Requests\V1;

use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class ProfileStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    protected $profile;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'nullable',
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'mobile' => 'nullable',
            'phone' => 'nullable',
            'gender' => 'required',
            'birthday' => 'nullable',
            'street' => 'nullable',
            'street_2' => 'nullable',
            'barangay' => 'nullable',
            'city' => 'nullable',
            'region' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'work_place_id' => 'nullable|exists:work_places,id'
        ];
    }


    public function store()
    {

        $validatedData = $this->except('image_url');

        $this->profile = Profile::create([
            ...$validatedData
        ]);


        $this->handleImage();

        return $this->profile->refresh();
    }

    public function handleImage(): void
    {


        if ($this->filled('image_url')) {
            $base64Image = json_decode($this->input('image_url'));


            if ($this->image_url) {
                $oldPath = str_replace(Storage::url(''), '', $this->profile->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $imageData = substr($base64Image, strpos($base64Image, ',') + 1);

                $type = strtolower($type[1]); // e.g., 'png', 'jpeg'



                if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                    abort(422, 'Invalid image format');
                }
                $imageData = base64_decode($imageData);
            } else {
                abort(422, 'Invalid image format');
            }

            $path = 'profiles/' . Str::random(20) . '.' . $type;
            Storage::disk('public')->put($path, $imageData);

            $this->profile->update([
                'image_url' => Storage::url($path)
            ]);
        }
    }
}
