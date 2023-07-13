<?php
    use Boovi\Boovicargo\Boovi as Boovi;
    use Boovi\Boovicargo\BooviHooks as Hooks;
    use Boovi\Boovicargo\BooviOpenCart as OpenCart;
class ControllerExtensionShippingBoovicargo extends Controller {

    private $version = '1.0';
    private $error = array();
    private $token_var;
    private $extension_var;
    private $prefix;
    private $hooks;
    private $opencart;
    private $settings;

    public function __construct($registry) {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        parent::__construct($registry);
        $this->token_var = (version_compare(VERSION, '3.0', '>=')) ? 'user_token' : 'token';
        $this->extension_var = (version_compare(VERSION, '3.0', '>=')) ? 'marketplace' : 'extension';
        $this->prefix = (version_compare(VERSION, '3.0', '>=')) ? 'shipping_' : '';
        include_once(DIR_CATALOG.'controller/extension/shipping/Boovi/Boovicargo/boovi.php');
        include_once(DIR_CATALOG.'controller/extension/shipping/Boovi/Boovicargo/hooks.php');
        include_once(DIR_CATALOG.'controller/extension/shipping/Boovi/Boovicargo/opencart.php');
        $this->hooks = new  Hooks();
        $this->opencart = new OpenCart();
        $this->load->model('setting/setting');
        $settings = $this->model_setting_setting->getSetting( 'shipping_boovicargo' );
        $this->settings = $this->hooks->useCheck($settings,[]);
        foreach($this->opencart->getDefaultSettings() as $key=>$default)
        {
            if(!isset($this->settings[$key])){
                $this->settings[$key] = $default;
            }
        }

        $this->boovi = new Boovi($this->settings);
    }

    public function install() {

    }

    public function uninstall() {

    }

    public function index() {
        $data = $this->load->language('extension/shipping/boovicargo');

        $heading_title = preg_replace('/^.*?\|\s?/ius', '', $this->language->get('heading_title'));
        $data['heading_title'] = $heading_title;
        $this->document->setTitle($heading_title);

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting($this->prefix . 'boovicargo', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['apply'])) {
                $this->response->redirect($this->url->link('extension/shipping/boovicargo', $this->token_var . '=' . $this->session->data[$this->token_var], true));
            } else {
                $this->response->redirect($this->url->link($this->extension_var . '/extension', $this->token_var . '=' . $this->session->data[$this->token_var] . '&type=shipping', true));
            }
        }

        $this->document->addStyle('view/javascript/summernote/summernote.css');
        $this->document->addScript('view/javascript/summernote/summernote.js');
        $this->document->addScript('view/javascript/summernote/opencart.js');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->error['new_order_status'])) {
            $data['error_new_order_status'] = $this->error['new_order_status'];
        } else {
            $data['error_new_order_status'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', $this->token_var . '=' . $this->session->data[$this->token_var], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link($this->extension_var . '/extension', $this->token_var . '=' . $this->session->data[$this->token_var] . '&type=shipping', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $heading_title,
            'href' => $this->url->link('extension/shipping/boovicargo', $this->token_var . '=' . $this->session->data[$this->token_var], true)
        );

        $this->load->model('extension/shipping/boovicargo');

        $data['prefix'] = $this->prefix;
        $data['token_var'] = $this->token_var;
        $data[$this->token_var] = $this->session->data[$this->token_var];
        $data['action'] = $this->url->link('extension/shipping/boovicargo', $this->token_var . '=' . $this->session->data[$this->token_var], true);
        $data['cancel'] = $this->url->link($this->extension_var . '/extension', $this->token_var . '=' . $this->session->data[$this->token_var] . '&type=shipping', true);
        $data['text_info'] = sprintf($this->language->get('text_info'), $this->version);

        if (isset($this->request->post[$this->prefix . 'boovicargo_aciklama_alani_test'])) {
            $data[$this->prefix . 'boovicargo_aciklama_alani_test'] = $this->request->post[$this->prefix . 'boovicargo_aciklama_alani_test'];
        } else {
            $data[$this->prefix . 'boovicargo_aciklama_alani_test'] = $this->config->get($this->prefix . 'boovicargo_aciklama_alani_test');
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_yardim_test_alani'])) {
            $data[$this->prefix . 'boovicargo_yardim_test_alani'] = $this->request->post[$this->prefix . 'boovicargo_yardim_test_alani'];
        } else {
            $data[$this->prefix . 'boovicargo_yardim_test_alani'] = $this->config->get($this->prefix . 'boovicargo_yardim_test_alani');
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_cargo_mail_notifications'])) {
            $data[$this->prefix . 'boovicargo_cargo_mail_notifications'] = $this->request->post[$this->prefix . 'boovicargo_cargo_mail_notifications'];
        } else {
            $data[$this->prefix . 'boovicargo_cargo_mail_notifications'] = $this->config->get($this->prefix . 'boovicargo_cargo_mail_notifications');
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_sendeo_user_id'])) {
            $data[$this->prefix . 'boovicargo_sendeo_user_id'] = $this->request->post[$this->prefix . 'boovicargo_sendeo_user_id'];
        } else {
            $data[$this->prefix . 'boovicargo_sendeo_user_id'] = $this->config->get($this->prefix . 'boovicargo_sendeo_user_id');
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_field_new'])) {
            $data[$this->prefix . 'boovicargo_field_new'] = $this->request->post[$this->prefix . 'boovicargo_field_new'];
        } else {
            $data[$this->prefix . 'boovicargo_field_new'] = $this->config->get($this->prefix . 'boovicargo_field_new');
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_mail_content'])) {
            $data[$this->prefix . 'boovicargo_mail_content'] = $this->request->post[$this->prefix . 'boovicargo_mail_content'];
        } else {
            $data[$this->prefix . 'boovicargo_mail_content'] = $this->config->get($this->prefix . 'boovicargo_mail_content');
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_sendeo_user_key'])) {
            $data[$this->prefix . 'boovicargo_sendeo_user_key'] = $this->request->post[$this->prefix . 'boovicargo_sendeo_user_key'];
        } else {
            $data[$this->prefix . 'boovicargo_sendeo_user_key'] = $this->config->get($this->prefix . 'boovicargo_sendeo_user_key');
        }
        $this->load->model('localisation/order_status');

        $order_status_all = $this->model_localisation_order_status->getOrderStatuses(array());
        $data['order_status_all'] = array();


        if ($order_status_all) { 
            foreach ($order_status_all as $item) { 
                $data['order_status_all'][] = array(
                    'order_status_id' => $item['order_status_id'],
                    'name' => $item['name']
                );
            }
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_shipping_complete_order_status'])) {
            $data[$this->prefix . 'boovicargo_shipping_complete_order_status'] = $this->request->post[$this->prefix . 'boovicargo_shipping_complete_order_status'];
        } else {
            $data[$this->prefix . 'boovicargo_shipping_complete_order_status'] = $this->config->get($this->prefix . 'boovicargo_shipping_complete_order_status');
        }
        $this->load->model('localisation/order_status');

        $order_status_all = $this->model_localisation_order_status->getOrderStatuses(array());
        $data['order_status_all'] = array();


        if ($order_status_all) { 
            foreach ($order_status_all as $item) { 
                $data['order_status_all'][] = array(
                    'order_status_id' => $item['order_status_id'],
                    'name' => $item['name']
                );
            }
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_shipping_return_order_status'])) {
            $data[$this->prefix . 'boovicargo_shipping_return_order_status'] = $this->request->post[$this->prefix . 'boovicargo_shipping_return_order_status'];
        } else {
            $data[$this->prefix . 'boovicargo_shipping_return_order_status'] = $this->config->get($this->prefix . 'boovicargo_shipping_return_order_status');
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_status'])) {
            $data[$this->prefix . 'boovicargo_status'] = $this->request->post[$this->prefix . 'boovicargo_status'];
        } else {
            $data[$this->prefix . 'boovicargo_status'] = $this->config->get($this->prefix . 'boovicargo_status');
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_payment_type'])) {
            $data[$this->prefix . 'boovicargo_payment_type'] = $this->request->post[$this->prefix . 'boovicargo_payment_type'];
        } else {
            $data[$this->prefix . 'boovicargo_payment_type'] = $this->config->get($this->prefix . 'boovicargo_payment_type');
        }
        $this->load->model('localisation/order_status');

        $order_status_all = $this->model_localisation_order_status->getOrderStatuses(array());
        $data['order_status_all'] = array();


        if ($order_status_all) { 
            foreach ($order_status_all as $item) { 
                $data['order_status_all'][] = array(
                    'order_status_id' => $item['order_status_id'],
                    'name' => $item['name']
                );
            }
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_new_order_status'])) {
            $data[$this->prefix . 'boovicargo_new_order_status'] = $this->request->post[$this->prefix . 'boovicargo_new_order_status'];
        } else {
            $data[$this->prefix . 'boovicargo_new_order_status'] = $this->config->get($this->prefix . 'boovicargo_new_order_status');
        }
        $this->load->model('localisation/order_status');

        $order_status_all = $this->model_localisation_order_status->getOrderStatuses(array());
        $data['order_status_all'] = array();


        if ($order_status_all) { 
            foreach ($order_status_all as $item) { 
                $data['order_status_all'][] = array(
                    'order_status_id' => $item['order_status_id'],
                    'name' => $item['name']
                );
            }
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_order_status_type'])) {
            $data[$this->prefix . 'boovicargo_order_status_type'] = $this->request->post[$this->prefix . 'boovicargo_order_status_type'];
        } else {
            $data[$this->prefix . 'boovicargo_order_status_type'] = $this->config->get($this->prefix . 'boovicargo_order_status_type');
        }
        if (isset($this->request->post[$this->prefix . 'boovicargo_cargo_barcode_type'])) {
            $data[$this->prefix . 'boovicargo_cargo_barcode_type'] = $this->request->post[$this->prefix . 'boovicargo_cargo_barcode_type'];
        } else {
            $data[$this->prefix . 'boovicargo_cargo_barcode_type'] = $this->config->get($this->prefix . 'boovicargo_cargo_barcode_type');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/boovicargo', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/boovicargo')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post[$this->prefix . 'boovicargo_new_order_status'])) {
            $this->error['new_order_status'] = $this->language->get('error_new_order_status');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    public function sendeoButton($order){
        $html = '';
        $this->load->model('extension/shipping/boovicargo');
        if(!$this->boovi->getSettingsStatus())
        {
            return $html;
        }
        if(!isset($order['shipping_method'])){
            $order = $this->model_extension_shipping_boovicargo->getOrderOne($order['order_id']);
        }
        if(!isset($order['shipping_method'])){
            return '!';
        }

        $src = HTTPS_CATALOG . 'image/sendeo-logo.jpeg';
        $defaultButton  = ' <a class="btn btn-success" tittle = "">
                                <img src="'. $src .'" alt="sendeo logo" class="img-fluid" >
                            </a>';
        $shippingMethod = 'sendeo';
        $href =  $this->url->link( 'extension/shipping/boovicargo/newRecord', TOKEN_KEY.'=' . $this->session->data[ 'user_token' ] . '&order_id=' . $order[ 'order_id' ],true);
        $defaultButton='<a class="btn btn-success" 
                            tittle = "" 
                            data-href ="'.$href.'" 
                            data-costumer ="'.$order['customer'].'" 
                            data-order_id="'.$order['order_id'].'" 
                            data-firma="'.$shippingMethod.'" >
                                <img src="'. $src .'" alt="sendeo logo" class="img-fluid" >
                        </a>';
        $src = HTTPS_CATALOG. 'image/barcode.png';
        $href= $this->url->link('extension/shipping/boovicargo/baroceWrite',TOKEN_KEY.'=' . $this->session->data[ 'user_token' ] . '&order_id=' . $order[ 'order_id' ], true );
        $buttons[] =  '<a class="btn btn-success" 
                            tittle = "" 
                            data-href ="'.$href.'" 
                            data-costumer ="'.$order['customer'].'" 
                            data-order_id="'.$order['order_id'].'">
                                <img src="'. $src .'" alt="barcode" class="img-fluid" >
                        </a>';
        $src = HTTPS_CATALOG. 'image/change.png';
        $href = $this->url->link( 'extension/shipping/boovicargo/changeTrackingCode', TOKEN_KEY.'=' . $this->session->data[ 'user_token' ] . '&order_id=' . $order[ 'order_id' ], true );
        $buttons[] = '<a class="btn btn-success" 
                        tittle = "" 
                        data-href ="'.$href.'" 
                        data-costumer ="'.$order['customer'].'" 
                        data-order_id="'.$order['order_id'].'">
                            <img src="'. $src .'" alt="barcode" class="img-fluid" >
                    </a>';
        $html = '<div class="btn-group"> ' . $default . implode( '', $buttons ).'</div>';

        return $html;
    }

    /*public function kayit_ac( $order_id = false, $toplu = false ) {

       $data['order_id'] = $this->hooks->useGetControl('order_id','');

        $this->load->model( 'sale/order' );
        $this->load->model('setting/setting');
        $this->load->model('localisation/zone');
        $this->load->model('extension/shipping/boovicargo');
        $this->load->model( 'extension/module/teknokargo' );
        $order = $this->model_sale_order->getOrder( $data[ 'order_id' ] );
        if($order){
	        $order = $this->model_extension_shipping_boovicargo->getOrderOne($order['order_id']);
	        
	        $result = $this->boovi->siparise_kayit_ac( $order, $toplu ) ;
	        if(isset($result['data'])){
		        $result = $this->model_extension_module_teknokargo->kayitacma_sonrasi_islemleri($result, $this->teknokargo->settings);
		        $html = isset($result['message'])?$result['message']:'';
	        } else {
		        $html = 'Geçersiz işlem. Lütfen tekrar deneyiniz...';
	        }
        } else {
	        $result = [
	            'status'=>0,
		        'message'=>'Sipariş bulunamadı',
		        'html'=>''
	        ];
	        $html = '';
        }

        if ( $toplu ) return $html;
        die( json_encode( $result ) );
    }*/

}
?>
