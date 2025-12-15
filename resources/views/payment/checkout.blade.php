@extends('layouts.master')
@section('title', 'Checkout')
@section('main-container')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Checkout</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('subscription-plan.plans') }}">Plans</a></li>
                            <li class="breadcrumb-item active">Checkout</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.badge')

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Complete Your Purchase</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">Plan Details</h6>
                                <div class="border rounded p-3 mb-3">
                                    <h5 class="mb-2">{{ $plan->name }}</h5>
                                    <p class="text-muted mb-2">{{ $plan->description }}</p>
                                    <div class="d-flex align-items-center mb-2">
                                        @if($plan->offer_price)
                                            <span class="text-decoration-line-through text-muted me-2">₹{{ number_format($plan->price, 2) }}</span>
                                            <h4 class="mb-0 text-primary">₹{{ number_format($amount, 2) }}</h4>
                                        @else
                                            <h4 class="mb-0 text-primary">₹{{ number_format($amount, 2) }}</h4>
                                        @endif
                                        <span class="ms-2 text-muted">/ {{ ucfirst($plan->type) }}</span>
                                    </div>
                                    @if($plan->features && is_array($plan->features))
                                        <ul class="list-unstyled mt-3">
                                            @foreach($plan->features as $feature)
                                                <li class="mb-2">
                                                    <i class="ri-checkbox-circle-line text-success me-2"></i>
                                                    {{ $feature }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">School Information</h6>
                                <div class="border rounded p-3 mb-3">
                                    <p class="mb-2"><strong>School:</strong> {{ $school->name }}</p>
                                    <p class="mb-2"><strong>Email:</strong> {{ $school->email }}</p>
                                    <p class="mb-0"><strong>Phone:</strong> {{ $school->phone }}</p>
                                </div>

                                <div class="border rounded p-3">
                                    <h6 class="mb-3">Payment Summary</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Plan Price:</span>
                                        <strong>₹{{ number_format($amount, 2) }}</strong>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">Total Amount:</span>
                                        <strong class="text-primary fs-5">₹{{ number_format($amount, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="button" id="pay-button" class="btn btn-primary btn-lg">
                                <i class="ri-money-rupee-circle-line me-2"></i>
                                Pay ₹{{ number_format($amount, 2) }}
                            </button>
                            <a href="{{ route('subscription-plan.plans') }}" class="btn btn-secondary btn-lg ms-2">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        const button = this;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

        // Create order
        fetch('{{ route('payment.create-order') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                plan_id: {{ $plan->id }}
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Failed to create payment order. Please try again.');
                button.disabled = false;
                button.innerHTML = '<i class="ri-money-rupee-circle-line me-2"></i>Pay ₹{{ number_format($amount, 2) }}';
                return;
            }

            // Razorpay options
            const options = {
                key: data.key_id,
                amount: data.amount,
                currency: data.currency,
                name: '{{ $school->name }}',
                description: '{{ $plan->name }} Subscription',
                order_id: data.order_id,
                handler: function(response) {
                    // Redirect to success page with payment details
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('payment.success') }}';

                    const fields = {
                        'razorpay_order_id': response.razorpay_order_id,
                        'razorpay_payment_id': response.razorpay_payment_id,
                        'razorpay_signature': response.razorpay_signature,
                        'transaction_id': data.transaction_id,
                        '_token': '{{ csrf_token() }}'
                    };

                    for (const key in fields) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = fields[key];
                        form.appendChild(input);
                    }

                    document.body.appendChild(form);
                    form.submit();
                },
                prefill: {
                    name: '{{ $school->name }}',
                    email: '{{ $school->email }}',
                    contact: '{{ $school->phone }}'
                },
                theme: {
                    color: '#3B82F6'
                },
                modal: {
                    ondismiss: function() {
                        button.disabled = false;
                        button.innerHTML = '<i class="ri-money-rupee-circle-line me-2"></i>Pay ₹{{ number_format($amount, 2) }}';
                    }
                }
            };

            const razorpay = new Razorpay(options);
            razorpay.open();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            button.disabled = false;
            button.innerHTML = '<i class="ri-money-rupee-circle-line me-2"></i>Pay ₹{{ number_format($amount, 2) }}';
        });
    });
</script>

@endsection

