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
    public $paid_at = '';
    public $payment_id = '';
    public $payment_gateway = '';
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
        'payment_id' => 'nullable|string|max:255',
        'payment_gateway' => 'nullable|string|max:255',
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
        $this->paid_at = '';
        $this->payment_id = '';
        $this->payment_gateway = '';
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
            $payment = Payment::where('id', $this->editingPaymentId)->first();
            $payment->update([
                'name' => $this->name,
                'email' => $this->email,
                'description' => $this->description,
                'amount' => $this->amount,
                'currency' => $this->currency,
                'is_paid' => $this->is_paid,
                'paid_at' => $this->is_paid && !$payment->paid_at ? now() : ($this->is_paid ? $payment->paid_at : null),
                'payment_id' => $this->payment_id,
                'payment_gateway' => $this->payment_gateway,
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
                'paid_at' => $this->is_paid ? now() : null,
            ]);
            $this->dispatch('toast', ...[
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Payment created successfully!'
            ]);
        }

        $this->hideForm();
    }

    public function edit($id)
    {
        $payment = Payment::where('id', $id)->first();
        $this->editingPaymentId = $payment->id;
        $this->name = $payment->name;
        $this->email = $payment->email;
        $this->description = $payment->description;
        $this->amount = $payment->amount;
        $this->currency = $payment->currency;
        $this->is_paid = $payment->is_paid;
        $this->payment_id = $payment->payment_id ?? '';
        $this->payment_gateway = $payment->payment_gateway ?? '';
        $this->showForm = true;
        $this->showViewModal = false;
    }

    public function confirmDelete($id)
    {
        $this->paymentToDelete = $id;
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
            Payment::where('id', $this->paymentToDelete)->delete();
            $this->dispatch('toast', [
                'type' => 'success',
                'title' => 'Deleted!',
                'message' => 'Payment deleted successfully!'
            ]);
            $this->showDeleteConfirmation = false;
            $this->paymentToDelete = null;
        }
    }

    public function togglePaymentStatus($id)
    {
        $payment = Payment::where('id', $id)->first();
        $newStatus = !$payment->is_paid;
        $payment->update([
            'is_paid' => $newStatus,
            'paid_at' => $newStatus ? now() : null
        ]);

        $status = $payment->is_paid ? 'paid' : 'unpaid';
        $this->dispatch('toast', ...[
            'type' => 'success',
            'title' => 'Status Updated!',
            'message' => "Payment marked as {$status}!"
        ]);
    }

    public function viewPayment($id)
    {
        $this->viewingPayment = Payment::where('id', $id)->first();
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
