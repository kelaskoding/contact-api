<?php

class ContactController extends Controller{

    function index(){
        $this->data = 'Welcome to Contact Api, Copyright 2017 KelasKoding.com';
    }

    function findAll(){
        $contact = new Contact($this->db);
        $filter = array();
        $options = array(
            'order'=>'id'
        );
        $list = array_map(array($contact,'cast'),$contact->find($filter,$options));
        $this->data = $list;
    }

    function search(){
        $post = json_decode($this->f3->get('BODY'),true);
        $searchKey = $post['searchKey'];
        $contact = new Contact($this->db);
        $filter = array(
            'full_name like ?',
            '%'.$searchKey.'%'
        );
        $options = array(
            'order'=>'id'
        );
        $list = array_map(array($contact,'cast'),$contact->find($filter,$options));
        $this->data = $list;
    }

    function save(){
        $post = json_decode($this->f3->get('BODY'),true);
        $contact = new Contact($this->db);
        $contact->full_name = $post['full_name'];
        $contact->address = $post['address'];
        $contact->phone = $post['phone'];
        $contact->email = $post['email'];
        $contact->photo = $post['photo'];
        $contact->save();
        $list = array_map(array($contact,'cast'),$contact->find(array('id=?',$contact->id),array()));
        $this->data = $list;
    }

    function update(){
        $post = json_decode($this->f3->get('BODY'),true);
        $contact = new Contact($this->db);
        $contact->load(array('id=?',$post['id']));
        $contact->full_name = $post['full_name'];
        $contact->address = $post['address'];
        $contact->phone = $post['phone'];
        $contact->email = $post['email'];
        $contact->photo = $post['photo'];
        $contact->save();
        $list = array_map(array($contact,'cast'),$contact->find(array('id=?',$contact->id),array()));
        $this->data = $list;
    }

    function remove(){
        $id = $this->f3->get('PARAMS.id'); 
        $contact = new Contact($this->db);
        $contact->load(array('id=?',$id));
        $status = false;
        if(!$contact->dry()){
            $contact->erase();
            $status = true;
        }
        $this->data = array('status'=>$status);
    }
}