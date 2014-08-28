<?php

namespace Grafikart;

class BootForm {

    protected $form;
    protected $placeholder = false;

    public function __construct($form, $request, $session){
        $this->form = $form;
        $this->request = $request;
        $this->session = $session;
    }

    private function input($type, $name, $label = null, $value = null, $options = array()) {
        $errors = $this->session->get('errors');

        if (is_array($label)) {
            $options = $label;
            $label = null;
        }
        if (is_array($name)) {
            $options = $name;
            $name = null;
        }
        if (is_array($value)) {
            $options = $value;
            $value = null;
        }
        if ($value === null){
            $value = $this->request->old($name);
        }
        if ($this->placeholder) {
            if ($label) {
                $options['placeholder'] = $label;
            } else {
                $options['placeholder'] = trans("form.$name");
            }
        }
        if (isset($options['class'])) {
            $options['class'] .= ' form-control';
        } else {
            $options['class']  = 'form-control';
        }


        $return  = '<div class="form-group form-' . $type . ( $errors && $errors->has($name) ? ' has-error' : '' ) . '">';

        if ($label === null && !$this->placeholder) {
            $label = trans("form.$name");
            $label = trans("form.$name");
        }
        if ($label) {
            $return .= $this->form->label($name, $label, array('class' => 'form-label'));
        }
        if ($type == 'textarea') {
            $return .= $this->form->textarea($name, $value, $options);
        } else {
            $return .= $this->form->input($type, $name, $value, $options);
        }

        if ($errors && $errors->has($name)){
            $return .= '<p class="help-block">' . $errors->first($name) . '</p>';
        }

        $return .= '</div>';

        return $return;
    }

    public function open($model, array $options = array()) {
        if (is_array($model)) {
            $options = $model;
            $model = false;
        }
        if (isset($options['controller'])) {
            $options['action'] = $options['controller'] . '@store';
            if ($model->id) {
                $options['action'] = [$options['controller'] . '@update', $model->id];
            }
            $options['method'] = $model->id ? 'PUT' : 'POST';
            unset($options['controller']);
        }
        if (isset($options['placeholder']) && $options['placeholder'] === true) {
            $this->placeholder = true;
        }
        if ($model) {
            return $this->form->model($model, $options);
        } else {
            return $this->form->open($options);
        }
    }

    public function text($name, $label = null, $value = null, $options = array()) {
        return $this->input('text', $name, $label, $value, $options);
    }

    public function number($name, $label = null, $value = null, $options = array()) {
        return $this->input('number', $name, $label, $value, $options);
    }

    public function password($name, $label = null, $value = null, $options = array()) {
        return $this->input('password', $name, $label, $value, $options);
    }

    public function email($name, $label = null, $value = null, $options = array()) {
        return $this->input('email', $name, $label, $value, $options);
    }

    public function file($name, $label = null, $value = null, $options = array()) {
        return $this->input('file', $name, $label, $value, $options);
    }

    public function select($name, $label = null, $value = null, $list = array(), $options = array()) {
        $errors = $this->session->get('errors');
        $return  = '<div class="form-group form-select' . ( $errors && $errors->has($name) ? ' has-error' : '' ) . '">';
        if (is_array($value)) { $list = $value; $value = null; }
        if (is_array($label)) { $list = $label; $label = null; }
        if ($label === null){
            $label = trans("form.$name");
        }
        if ($label) {
            $options['data-placeholder'] = $label;
            $return .= $this->form->label($name, $label, array('class' => 'form-label'));
        }
        if (!isset($options['id'])) {
            $options['id'] = $name;
        }
        if (!isset($options['class'])) {
            $options['class'] = 'form-control';
        }
        if ($value === null){
            $value = $this->request->old($name);
        }

        $return .= $this->form->select($name, $list, $value, $options);
        if ($errors && $errors->has($name)){
            $return .= '<p class="help-block">' . $errors->first($name) . '</p>';
        }
        $return .= '</div>';

        return $return;
    }

    public function radio($name, $label = null, $value = null, $list = array(), $options = array()) {
        $errors = $this->session->get('errors');
        $return  = '<div class="form-group form-radio' . ( $errors && $errors->has($name) ? ' has-error' : '' ) . '">';
        if (is_array($value)) { $list = $value; $value = null; }
        if (is_array($label)) { $list = $label; $label = null; }
        if ($label === null){
            $label = trans("form.$name");
        }
        if ($label) {
            $options['data-placeholder'] = $label;
            $return .= $this->form->label($name, $label, array('class' => 'form-label'));
        }
        if (!isset($options['id'])) {
            $options['id'] = $name;
        }
        if ($value === null){
            $value = $this->request->old($name);
        }


        $return .= '<div class="form-radios">';

        foreach($list as $k => $v) {
            $return .= "<label for='form-$name-$k'>";
            $return .= $this->form->radio($name, $k, $value == $k, ['id' => "form-$name-$k"]);
            $return .= "<span>$v</span></label>";
        }

        $return .= '</div>';

        if ($errors && $errors->has($name)){
            $return .= '<p class="help-block">' . $errors->first($name) . '</p>';
        }
        $return .= '</div>';

        return $return;
    }

    public function checkbox($name, $label = null, $value = null, $list = array(), $options = array()) {
        $errors = $this->session->get('errors');
        $return  = '<div class="form-group form-checkbox' . ( $errors && $errors->has($name) ? ' has-error' : '' ) . '">';
        if (is_array($value)) { $list = $value; $value = null; }
        if (is_array($label)) { $list = $label; $label = null; }
        if ($label === null){
            $label = trans("form.$name");
        }
        if ($label) {
            $options['data-placeholder'] = $label;
            $return .= $this->form->label($name, $label, array('class' => 'form-label'));
        }
        if (!isset($options['id'])) {
            $options['id'] = $name;
        }
        if ($value === null){
            $value = $this->request->old($name);
        }


        $return .= '<div class="form-checkboxes">';

        foreach($list as $k => $v) {
            $return .= "<label for='form-$name-$k'>";
            $return .= $this->form->checkbox($name, $k, $value == $k, ['id' => "form-$name-$k"]);
            $return .= "<span>$v</span></label>";
        }

        $return .= '</div>';

        if ($errors && $errors->has($name)){
            $return .= '<p class="help-block">' . $errors->first($name) . '</p>';
        }
        $return .= '</div>';

        return $return;
    }

    public function textarea($name, $label = null, $value = null, $options = array()) {
        return $this->input('textarea', $name, $label, $value, $options);
    }

    public function submit($name = null, $options = []) {
        if (is_null($name)) {
            $name = trans('form.submit');
        }
        if (!isset($options['class'])) {
            $options['class'] = "btn btn-primary btn-submit";
        }
        return '<div class="form-submit"><button type="submit" class="' . $options["class"] . '">' . $name . '</button></div>';
    }

    public function close() {
        return $this->form->close();
    }

    public function hidden( $name,  $value = null,  $options = array()) {
        if (!isset($options['id'])) {
            $options['id'] = $name;
        }
        return $this->form->hidden($name, $value, $options);
    }

    /**
    * EDIT in place
    **/
    public function dropable($entity, $field, $attrs = array()) {
        return '<span ' . $this->inline_attrs($attrs) . ' data-drop="' . $field . '">' . \HTML::image($entity[$field]->url()) . '</span>';
    }
    public function editable($entity, $field, $default = '', $attrs = array()) {
        if (is_array($default)) {
            $attrs = $default;
            $default = '';
        }
        return '<span ' . $this->inline_attrs($attrs) . ' data-edit="' . $field . '">' . ($entity[$field] ? $entity[$field] : $default) . '</span>';
    }

    private function inline_attrs(array $attrs) {
        $return = array();
        foreach($attrs as $k => $v){
            $return[] = "$k=\"$v\"";
        }
        return implode(' ', $return);
    }


}