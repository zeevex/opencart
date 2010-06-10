<?php 
class ControllerPaymentZXStandard extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/zx_standard');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('zx_standard', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment');
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_sale'] = $this->language->get('text_sale');
		
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_transaction'] = $this->language->get('entry_transaction');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');	
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/payment',
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=payment/zx_standard',
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/zx_standard';
		
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment';
		
		if (isset($this->request->post['zx_standard_email'])) {
			$this->data['zx_standard_email'] = $this->request->post['zx_standard_email'];
		} else {
			$this->data['zx_standard_email'] = $this->config->get('zx_standard_email');
		}

		if (isset($this->request->post['zx_standard_test'])) {
			$this->data['zx_standard_test'] = $this->request->post['zx_standard_test'];
		} else {
			$this->data['zx_standard_test'] = $this->config->get('zx_standard_test');
		}
		
		if (isset($this->request->post['zx_standard_transaction'])) {
			$this->data['zx_standard_transaction'] = $this->request->post['zx_standard_transaction'];
		} else {
			$this->data['zx_standard_transaction'] = $this->config->get('zx_standard_transaction');
		}
		
		if (isset($this->request->post['zx_standard_order_status_id'])) {
			$this->data['zx_standard_order_status_id'] = $this->request->post['zx_standard_order_status_id'];
		} else {
			$this->data['zx_standard_order_status_id'] = $this->config->get('zx_standard_order_status_id');
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['zx_standard_geo_zone_id'])) {
			$this->data['zx_standard_geo_zone_id'] = $this->request->post['zx_standard_geo_zone_id'];
		} else {
			$this->data['zx_standard_geo_zone_id'] = $this->config->get('zx_standard_geo_zone_id');
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['zx_standard_status'])) {
			$this->data['zx_standard_status'] = $this->request->post['zx_standard_status'];
		} else {
			$this->data['zx_standard_status'] = $this->config->get('zx_standard_status');
		}
		
		if (isset($this->request->post['zx_standard_sort_order'])) {
			$this->data['zx_standard_sort_order'] = $this->request->post['zx_standard_sort_order'];
		} else {
			$this->data['zx_standard_sort_order'] = $this->config->get('zx_standard_sort_order');
		}
		
		$this->template = 'payment/zx_standard.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/zx_standard')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['zx_standard_email']) {
			$this->error['email'] = $this->language->get('error_email');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>