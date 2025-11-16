<?php

namespace App\Livewire\Forms\Incentive;

use Livewire\Form;
use App\Models\Incentive;
use Livewire\WithFileUploads;
use App\Repository\IncentiveRepository;

class AddIncentiveForm extends Form
{
    use WithFileUploads;
    public $name;

    public $points_required;

    public $description;

    public $image;

    public bool $is_active = false;
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'points_required' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ];
    }
    public function submit(): Incentive|bool
    {
        $this->validate();
        try {
            $repo = new IncentiveRepository();
            if ($this->image) {
                $this->image = $this->image->store('incentive', 'public');
            }
            $incentive = $repo->create($this->all());
            $this->reset();
            sweetalert('Add Incentive Success', title: 'Success');
            return $incentive;
        } catch (\Throwable $th) {

            sweetalert($th->getMessage(), title: 'Failed', type: 'error');
            return false;
        }
    }
}
