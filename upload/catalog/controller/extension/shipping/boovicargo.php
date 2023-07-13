<?php

class ControllerExtensionShippingBoovicargo extends Controller {

    private $error = array();
    private $prefix;

    public function __construct($registry) {
        parent::__construct($registry);
        $this->prefix = (version_compare(VERSION, '3.0', '>=')) ? 'shipping_' : '';
    }

    public function index() {
        if ($this->config->get($this->prefix . 'boovicargo_status')) {
            $data = $this->load->language('extension/shipping/boovicargo');

            $this->load->model('extension/shipping/boovicargo');

            $data['aciklama_alani_test'] = $this->config->get($this->prefix . 'boovicargo_aciklama_alani_test');
            $data['yardim_test_alani'] = $this->config->get($this->prefix . 'boovicargo_yardim_test_alani');
            $data['cargo_mail_notifications'] = $this->config->get($this->prefix . 'boovicargo_cargo_mail_notifications');
            $data['sendeo_user_id'] = $this->config->get($this->prefix . 'boovicargo_sendeo_user_id');
            $data['field_new'] = $this->config->get($this->prefix . 'boovicargo_field_new');
            $data['mail_content'] = html_entity_decode($this->config->get($this->prefix . 'boovicargo_mail_content'), ENT_QUOTES, 'UTF-8');
            $data['sendeo_user_key'] = $this->config->get($this->prefix . 'boovicargo_sendeo_user_key');
            $data['shipping_complete_order_status'] = $this->config->get($this->prefix . 'boovicargo_shipping_complete_order_status');
            $data['shipping_return_order_status'] = $this->config->get($this->prefix . 'boovicargo_shipping_return_order_status');
            $data['payment_type'] = $this->config->get($this->prefix . 'boovicargo_payment_type');
            $data['new_order_status'] = $this->config->get($this->prefix . 'boovicargo_new_order_status');
            $data['order_status_type'] = $this->config->get($this->prefix . 'boovicargo_order_status_type');
            $data['cargo_barcode_type'] = $this->config->get($this->prefix . 'boovicargo_cargo_barcode_type');
            return $this->load->view('extension/shipping/boovicargo', $data);
        }
    }

}
