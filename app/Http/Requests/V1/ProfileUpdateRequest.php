<?php

namespace App\Http\Requests\V1;

use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:png,jpg',
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

    public function update(string $id)
    {
        $validatedData = $this->except('image_url');

        $this->profile = Profile::findOrFail($id);

        $this->profile->update([
            ...$validatedData
        ]);


        $this->handleImage();

        return $this->profile->refresh();
    }

    public function handleImage(): void
    {


        // 2. Check if the 'image' field from the request is a valid base64 string
        if ($this->filled('image_url')) {
            $base64Image = json_decode($this->input('image_url'));


            // Optional: Delete the old image if it exists to save storage space
            if ($this->image_url) {
                $oldPath = str_replace(Storage::url(''), '', $this->profile->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            // 3. Decode the base64 string and get the image data and type
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $imageData = substr($base64Image, strpos($base64Image, ',') + 1);

                $type = strtolower($type[1]); // e.g., 'png', 'jpeg'



                if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                    // Handle invalid image type if necessary
                    abort(422, 'Invalid image format');
                }
                $imageData = base64_decode($imageData);
            } else {
                abort(422, 'Invalid image format');
            }

            // 4. Generate a unique filename and save the file using Storage::put()
            $path = 'profiles/' . Str::random(20) . '.' . $type;
            Storage::disk('public')->put($path, $imageData);

            // 5. Update the profile's image_url with the new public URL
            $this->profile->update([
                'image_url' => Storage::url($path)
            ]);
        }
    }
}
