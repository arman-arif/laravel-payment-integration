<?php

namespace App\Livewire;

use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentManager extends Component
{
    use WithPagination;

    public $name = '';
    public $email = '';
    public $description = '';
    public $amount = '';
    public $currency = 'DKK';
    public $is_paid = false;
    public $editingPaymentId = null;
    public $showForm = false;
    public $search = '';
    public $showDeleteConfirmation = false;
    public $paymentToDelete = null;
    public $showViewModal = false;
    public $viewingPayment = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'description' => 'required|string',
        'amount' => 'required|numeric|min:0.01',
        'currency' => 'required|string|size:3',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function hideForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->description = '';
        $this->amount = '';
        $this->currency = 'DKK';
        $this->is_paid = false;
        $this->editingPaymentId = null;
        $this->showDeleteConfirmation = false;
        $this->paymentToDelete = null;
        $this->showViewModal = false;
        $this->viewingPayment = null;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        if ($this->editingPaymentId) {
            $payment = Payment::find($this->editingPaymentId);
            $payment->update([
                'name' => $this->name,
                'email' => $this->email,
                'description' => $this->description,
                'amount' => $this->amount,
                'currency' => $this->currency,
                'is_paid' => $this->is_paid,
            ]);
            $this->dispatch('toast', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Payment updated successfully!'
            ]);
        } else {
            Payment::create([
                'name' => $this->name,
                'email' => $this->email,
                'description' => $this->description,
                'amount' => $this->amount,
                'currency' => $this->currency,
                'is_paid' => $this->is_paid,
            ]);
            $this->dispatch('toast', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Payment created successfully!'
            ]);
        }

        $this->hideForm();
    }

    public function edit($paymentId)
    {
        $payment = Payment::find($paymentId);
        $this->editingPaymentId = $payment->id;
        $this->name = $payment->name;
        $this->email = $payment->email;
        $this->description = $payment->description;
        $this->amount = $payment->amount;
        $this->currency = $payment->currency;
        $this->is_paid = $payment->is_paid;
        $this->showForm = true;
    }

    public function confirmDelete($paymentId)
    {
        $this->paymentToDelete = $paymentId;
        $this->showDeleteConfirmation = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteConfirmation = false;
        $this->paymentToDelete = null;
    }

    public function delete()
    {
        if ($this->paymentToDelete) {
            Payment::find($this->paymentToDelete)->delete();
            $this->dispatch('toast', [
                'type' => 'success',
                'title' => 'Deleted!',
                'message' => 'Payment deleted successfully!'
            ]);
            $this->showDeleteConfirmation = false;
            $this->paymentToDelete = null;
        }
    }

    public function togglePaymentStatus($paymentId)
    {
        $payment = Payment::find($paymentId);
        $payment->update(['is_paid' => !$payment->is_paid]);
        
        $status = $payment->is_paid ? 'paid' : 'unpaid';
        $this->dispatch('toast', [
            'type' => 'success',
            'title' => 'Status Updated!',
            'message' => "Payment marked as {$status}!"
        ]);
    }

    public function viewPayment($paymentId)
    {
        $this->viewingPayment = Payment::find($paymentId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewingPayment = null;
    }

    #[Layout('layouts.app', ['page' => 'payments'])]
    public function render()
    {
        $payments = Payment::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.payment-manager', compact('payments'));
    }
}
