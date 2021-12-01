<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table      = 'tbl_settings';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['website_name', 'website_logo', 'email','phone', 'braintree_environment', 'braintree_merchant_id', 'braintree_public_key', 'braintree_private_key', 'charge_from_owner', 'currency', 'status', 'map_api_key', 'stripe_private_key', 'stripe_publish_key', 'radius', 'smtp_username', 'smtp_password', 'smtp_port', 'smtp_from_name', 'smtp_from_email', 'smtp_host', 'fcm_key', 'cancellation_charge', 'admin_charge', 'razorpay_key', 'razorpay_secret', 'facebook_app_id', 'facebook_app_secret', 'facebook_graph_version', 'google_client_id', 'google_client_secret', 'delivery_radius', 'payment_methods', 'service_charge'];

    protected $useTimestamps = true;
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}