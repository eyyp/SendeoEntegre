<?php
namespace Boovi\Boovicargo;
    class BooviOpenCart {
         public function __construct(){

        }
        private $db_prefix = 'shipping_boovicargo_';
        public function getDefaultSettings(){
            return [
                'shipping_boovicargo_sendeo_user_key' => '',
                'shipping_boovicargo_field_new'=> '',
                'shipping_boovicargo_sendeo_user_id' => '',
                'shipping_boovicargo_cargo_barcode_type' => 1,
                'shipping_boovicargo_shipping_return_order_status' => 1,
                'shipping_boovicargo_mail_content' => 1,
                'shipping_boovicargo_shipping_complete_order_status' => 1,
                'shipping_boovicargo_cargo_mail_notifications'=> 1,
                'shipping_boovicargo_order_status_type' => 1,
                'shipping_boovicargo_payment_type' => [],
                'shipping_boovicargo_new_order_status' => 1,
                'shipping_boovicargo_status' => 1,
                'shipping_boovicargo_aciklama_alani_test' => '',
                'shipping_boovicargo_yardim_test_alani' => '' 
            ];
        }
    }
?>