<?php
namespace Boovi\Boovicargo;
    use Boovi\Boovicargo\BooviHooks as Hooks;
    class Boovi {
        private $settings = array();
        private $db_prefix = 'shipping_boovicargo_';
        public function __construct($settings){
            include_once(DIR_CATALOG.'controller/extension/shipping/Boovi/Boovicargo/hooks.php');
            $this->settings = $settings;
            $this->hooks = new Hooks();

        }

        public function getSettingsStatus(){
            if(isset($this->settings[$this->db_prefix .'status']) && $this->settings[$this->db_prefix.'status']){
                return true;
            }
            else{
                return false;
            }
        }

        /*public function siparise_kayit_ac( $order = false, $toplu = false ) {

            $result[ 'status' ] = '0';
            $result[ 'message' ] = '';
            $result[ 'html' ] = '';
            $html = 'İşlem Başladı';
            $kargo_firma = $this->hooks->useParamControl('firma');
            
            if ( $order ) {

                $kargo_firma = 'sendeo';
                if($this->hooks->useDoubleCheck($order['pazaryeri'])){
                    $html = 'Pazaryeri Siparişine Kargo Kaydı Açılamaz ...';
                    $result[ 'message' ] = $html;
                } else {
                    $html = '<img src="' . HTTPS_CATALOG . 'image/sendeo-logo.jpg" alt="' . $kargo_firma . '" title="' . $kargo_firma . '"> <strong>#' . $order[ 'order_id' ] . ' ' . $order[ 'customer' ] . '</strong>: ';
                    if ( $kargo_firma ) {
                        $order[ 'paket' ] = $this->hooks->useGetCheck('paket','1');
                        $kargo_method = $this->cargoMethodCode($order);
                        if ( isset( $_GET[ 'iptal' ] ) ) {
                            $result = $this->kayit_iptal( $kargo_firma, $order );
                        } else {
                            $result = $this->kayit_ac(  $kargo_firma, $kargo_method, $order );
                        }

                        if ( $result[ 'status' ] ) {
                            $result[ 'data' ][ 'kargo_method' ]= $kargo_method;
                            if ( isset( $_GET[ 'iptal' ] ) ) {
                                $result[ 'data' ][ 'kargo_firma' ] = '';
                                $result[ 'data' ][ 'kargo_barcode' ] = '';
                                $result[ 'data' ][ 'kargo_talepno' ] = '';
                                $result[ 'data' ][ 'kargo_method' ] = '';
                                $result[ 'data' ][ 'kargo_url' ] = '';
                                $result[ 'data' ][ 'kargo_sonuc' ] = 'İptal Edildi';
                            }
                        }
                    } else {
                        $result[ 'message' ] = 'Hatalı Kargo Firması: ' . $kargo_firma;
                        $result[ 'html' ] .= 'Hatalı Kargo Firması: ' . $kargo_firma;
                    }
                }

                $html .= $result[ 'message' ] . '<hr>'.$result[ 'html' ];
            } else {
                $result[ 'message' ] = 'Sipariş Bilgisi Alınamadı';
                $html .= 'Sipariş Bilgisi Alınamadı<br>';
            }
            return $result;
        }

        function kayit_iptal($firma, $order){
            $result = $this->new_result();
            if(!empty($order)){
                $order = $this->adapter->fix_order_data( $order );
                $firma_data = isset($this->settings[$firma])?$this->settings[$firma]:[];
                if($firma_data) {
                    $kargo_method = $order[ 'kargo_method' ];
                    if($firma!='yurtici')$kargo_method='online_normal';

                    if(empty($kargo_method))$kargo_method='online_normal';
                    if(empty($firma_data[$kargo_method])){
                        $kargo_method='online_normal';
                    }
                    $method_data = isset($firma_data[$kargo_method])?$firma_data[$kargo_method]:[];
                    if($method_data){
                        $data[ 'kargo_method' ] = $kargo_method;
                        $data['user_name'] = $method_data['user_name'];
                        $data['user_pass'] = $method_data['user_pass'];
                        $data['user_code'] = $method_data['user_code'];
                        $data[ 'barkodlar' ] = array( $order[ 'barcode' ] );
                        $this->load_client($firma);
                        $result = $this->client->kayit_iptal( $data );
                        if ( $result[ 'status' ] ) {
                            $result[ 'data' ][ 'method' ] = '';
                            $result[ 'data' ][ 'order_id' ] = $order[ 'order_id' ];
                            $result[ 'data' ][ 'kargo_tarih' ] = '';
                            $result[ 'data' ][ 'kargo_firma' ] = '';
                            $result[ 'data' ][ 'kargo_barcode' ] = '';
                            $result[ 'data' ][ 'kargo_talepno' ] = '';
                            $result[ 'data' ][ 'kargo_durum' ] = 'İptal Edildi';
                            $result[ 'data' ][ 'order_status_id' ] = $order[ 'order_status_id' ];
                        }
                        if(defined('TEKNOKARGO_DEBUG')){
                            $result['html'] .= implode('<br>', $this->client->debug);
                        }
                    } else{
                        $result['message'] = 'Kargo metodu bilgileri alınamadı';
                    }
                } else{
                    $result['message'] = 'Kargo firması bilgileri alınamadı';
                }
            } else{
                $result['message'] = 'Sipariş bilgisi alınamadı';
            }
            return $result;
        }

        private function cargoMethodCode($order){
            $payment_code = $this->hooks->useCheck($order['payment_code'],false);
            if($payment_code && isset($this->settings['metodlar'])){
                foreach($this->settings['metodlar'] as $method_code=>$method){
                    if( isset($method['payment_code']) && $payment_code == $method['payment_code']){
                        return $method_code;
                    }
                }
            }
        }

        private function new_result(){
            $result[ 'status' ] = 0;
            $result[ 'code' ] = "";
            $result[ 'message' ] = "";
            $result[ 'html' ] = "";
            return $result;
        }*/
    }

?>