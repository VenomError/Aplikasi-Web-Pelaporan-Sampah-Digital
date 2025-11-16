<?php

namespace App\Livewire\Forms\Incentive;

use Livewire\Form;
use App\Models\Incentive;
use Livewire\Attributes\Validate;
use App\Repository\IncentiveRepository;

class EditIncentiveForm extends Form
{
    public $name;

    public $points_required;

    public $description;

    public $image;

    public bool $is_active = false;
    public Incentive $incentive;
    public function setIncentive(Incentive $incentive)
    {
        $this->incentive = $incentive;
        $this->name = $incentive->name;
        $this->points_required = $incentive->points_required;
        $this->description = $incentive->description;
        $this->is_active = $incentive->is_active;
    }
    public function rules()
    {
        return [
            'incentive.id' => 'required|exists:incentives,id',
            'name' => 'required|string|max:255',
            'points_required' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ];
    }

    public function submit()
    {
        $this->validate();
        try {
            $repo = new IncentiveRepository();
            if ($this->image) {
                $this->image = $this->image->store('incentive', 'public');
            }
            $updated = $repo->update($this->incentive, $this->all());
            sweetalert('Update Incentive Success', title: 'Success');
            return $updated;
        } catch (\Throwable $th) {
            sweetalert($th->getMessage(), title: 'Failed', type: 'error');
            return false;
        }
    }
}
