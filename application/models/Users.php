<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Export Controller
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model {
  // declare private variable
  private $_userID;
  private $_fname;
  private $_lname;
  private $_userName;
  private $_email;
  private $_password;
  private $_status;
  private $_country;
  private $_state;
  private $_city;
  private $_postcode;
  private $_address;
  private $_phone;
  private $_itemName;
  private $_itemPrice;

  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->library('form_validation');
  }
  public function setUserID($userID) {
    $this->_userID = $userID;
  }
  public function setfName($fname) {
    $this->_fname = $fname;
  }
  public function setlName($lname) {
    $this->_lname = $lname;
  }
  public function setUserName($userName) {
    $this->_userName = $userName;
  }
  public function setEmail($email) {
    $this->_email = $email;
  }
  public function setPassword($password) {
    $this->_password = $password;
  }
  public function setStatus($status) {
    $this->_status = $status;
  }
  public function setCountry($country) {
    $this->_country = $country;
  } 
  public function setState($state) {
    $this->_state = $state;
  }
  public function setCity($city) {
    $this->_city = $city;
  }
  public function setAddress($address) {
    $this->_address = $address;
  }
  public function setPhone($phone) {
    $this->_phone = $phone;
  }
  public function setPostcode($postcode) {
    $this->_postcode = $postcode;
  }
  public function setItemName($itemName) {
    $this->_itemName = $itemName;
  }
  public function setItemPrice($itemPrice) {
    $this->_itemPrice = $itemPrice;
  }
    //insert users table
    public function createUser() {
        $dataUser = array(
            'fname' => $this->_fname,
            'lname' => $this->_lname,
            'email' => $this->_email,
            'username' => $this->_userName,
            'password' => $this->_password,
            'status' => $this->_status,
        );
        $this->db->insert('users', $dataUser);
        return $this->db->insert_id();
    }
    //insert order table
    public function generateOrder() {
      $dataOrder = array(
           'user_id' => $this->_userID,
           'item_name' => $this->_itemName,
           'item_price' => $this->_itemPrice,
           'customer_fname' => $this->_fname,
           'customer_lname' => $this->_lname,
           'customer_phone' => $this->_phone,
           'customer_email' => $this->_email,
           'customer_address' => $this->_address,
           'customer_country' => $this->_country,
           'customer_state' => $this->_state,
           'customer_city' => $this->_city,
           'customer_postcode' => $this->_postcode,
           'order_status' => 'paid',
           'order_date' => date('Y-m-d H:i:s')
      );
      $this->db->insert('orders', $dataOrder);
      $session_order = array(
        'item_name' => $this->_itemName,
        'item_price' => $this->_itemPrice
      );
      $this->session->set_userdata('order_details', $session_order);
        return $this->db->insert_id();
    }
    // Read data using username and password
    public function login($data) {

      $condition = "email =" . "'" . $data['email'] . "' AND " . "password =" . "'" . md5($data['password']) . "'";
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where($condition);
      $this->db->limit(1);
      $query = $this->db->get();
      
      if ($query->num_rows() == 1) {
      return true;
      } else {
      return false;
      }
    }
    // Read data from database to show data in admin page
    public function read_user_information($email) {

      $condition = "email =" . "'" . $email . "'";
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where($condition);
      $this->db->limit(1);
      $query = $this->db->get();

      if ($query->num_rows() == 1) {
      return $query->result();
      } else {
      return false;
      }
    }
}
?>