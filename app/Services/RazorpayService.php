<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class RazorpayService
{
    protected Api $api;

    public function __construct()
    {
        $keyId = config('services.razorpay.key_id');
        $keySecret = config('services.razorpay.key_secret');

        if (! $keyId || ! $keySecret) {
            throw new Exception('Razorpay credentials not configured. Please set RAZORPAY_KEY_ID and RAZORPAY_KEY_SECRET in your .env file.');
        }

        $this->api = new Api($keyId, $keySecret);
    }

    /**
     * Create a Razorpay order
     */
    public function createOrder(array $data): array
    {
        try {
            $orderData = [
                'receipt' => $data['receipt'] ?? 'order_'.time(),
                'amount' => $data['amount'] * 100, // Convert to paise
                'currency' => $data['currency'] ?? 'INR',
                'notes' => $data['notes'] ?? [],
            ];

            $order = $this->api->order->create($orderData);

            return [
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'receipt' => $order['receipt'],
            ];
        } catch (Exception $e) {
            Log::error('Razorpay Order Creation Failed: '.$e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify Razorpay payment signature
     */
    public function verifyPayment(array $attributes): bool
    {
        try {
            $this->api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $attributes['razorpay_order_id'],
                'razorpay_payment_id' => $attributes['razorpay_payment_id'],
                'razorpay_signature' => $attributes['razorpay_signature'],
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Razorpay Payment Verification Failed: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Fetch payment details
     */
    public function fetchPayment(string $paymentId): ?array
    {
        try {
            $payment = $this->api->payment->fetch($paymentId);

            return $payment->toArray();
        } catch (Exception $e) {
            Log::error('Razorpay Payment Fetch Failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Fetch order details
     */
    public function fetchOrder(string $orderId): ?array
    {
        try {
            $order = $this->api->order->fetch($orderId);

            return $order->toArray();
        } catch (Exception $e) {
            Log::error('Razorpay Order Fetch Failed: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Refund a payment
     */
    public function refundPayment(string $paymentId, ?float $amount = null): array
    {
        try {
            $refundData = [];
            if ($amount !== null) {
                $refundData['amount'] = $amount * 100; // Convert to paise
            }

            $refund = $this->api->payment->fetch($paymentId)->refund($refundData);

            return [
                'success' => true,
                'refund_id' => $refund['id'],
                'amount' => $refund['amount'] / 100,
                'status' => $refund['status'],
            ];
        } catch (Exception $e) {
            Log::error('Razorpay Refund Failed: '.$e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
