<?php

class ModelExtensionShippingBoovicargo extends Model {

    public function getOrderOne($id){
        $query = $this->db->query("SELECT * FROM `".DB_PREFIX."order` WHERE `order_id`=".(int)$id);
        if($query->num_rows){
            $order = array_merge($query->row, $order);
        }
        return $order;
    }
}
