<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class InfluencerManager extends Component
{
    public $influencers;
    public $showModal = false;
    public $editingId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $commission_percent = 10;
    public $discount_percent = 10;
    public $is_active = true;

    public function mount()
    {
        $this->loadInfluencers();
    }

    public function loadInfluencers()
    {
        $this->influencers = User::where('role', 'influencer')->latest()->get();
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $this->editingId = $id;
            $influencer = User::find($id);
            $this->name = $influencer->name;
            $this->email = $influencer->email;
            $this->commission_percent = $influencer->commission_percent ?? 10;
            $this->discount_percent = $influencer->discount_percent ?? 10;
            $this->is_active = $influencer->is_active;
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->commission_percent = 10;
        $this->discount_percent = 10;
        $this->is_active = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editingId,
            'password' => $this->editingId ? 'nullable|min:8' : 'required|min:8',
            'commission_percent' => 'required|numeric|min:0|max:100',
            'discount_percent' => 'required|numeric|min:0|max:100',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => 'influencer',
            'commission_percent' => $this->commission_percent,
            'discount_percent' => $this->discount_percent,
            'is_active' => $this->is_active,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->editingId) {
            $influencer = User::find($this->editingId);
            $influencer->update($data);
            session()->flash('message', 'Influencer actualizado exitosamente.');
        } else {
            // Generate referral code for new influencer
            $data['referral_code'] = User::generateReferralCode();
            $data['password'] = bcrypt($this->password);
            User::create($data);
            session()->flash('message', 'Influencer creado exitosamente.');
        }

        $this->loadInfluencers();
        $this->closeModal();
    }

    public function toggleActive($id)
    {
        $influencer = User::find($id);
        $influencer->update(['is_active' => !$influencer->is_active]);
        $this->loadInfluencers();
        session()->flash('message', 'Estado del influencer actualizado.');
    }

    public function render()
    {
        return view('livewire.admin.influencer-manager');
    }
}


