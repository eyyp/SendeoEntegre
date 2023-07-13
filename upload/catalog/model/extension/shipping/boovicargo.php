<?php

class ModelExtensionShippingBoovicargo extends Model {

    private $error = array();
    private $prefix;

    public function __construct($registry) {
        parent::__construct($registry);
        $this->prefix = (version_compare(VERSION, '3.0', '>=')) ? 'shipping_' : '';
    }


    public function getQuote($address) {
        $this->load->language('extension/shipping/boovicargo');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get($this->prefix . 'boovicargo_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

        if (!$this->config->get($this->prefix . 'boovicargo_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $title = $this->config->get($this->prefix . 'boovicargo_title');
            $description = $this->config->get($this->prefix . 'boovicargo_description');
            $quote_data = array();

            $quote_data['boovicargo'] = array(
                'code' => 'boovicargo.boovicargo',
                'title' => isset($description[$this->config->get('config_language_id')]) ? $description[$this->config->get('config_language_id')] : $this->language->get('text_description'),
                'cost' => $this->config->get($this->prefix . 'boovicargo_cost'),
                'tax_class_id' => $this->config->get($this->prefix . 'boovicargo_tax_class_id'),
                'text'  => $this->currency->format($this->tax->calculate($this->config->get($this->prefix . 'boovicargo_cost'), $this->config->get($this->prefix . 'boovicargo_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
            );

            $method_data = array(
                'code' => 'boovicargo',
                'title' => isset($title[$this->config->get('config_language_id')]) ? $title[$this->config->get('config_language_id')] : $this->language->get('text_title'),
                'quote' => $quote_data,
                'sort_order' => $this->config->get($this->prefix . 'boovicargo_sort_order'),
                'error' => false
            );
        }

        return $method_data;
    }
}
