<?php

class HTML {

    public static function post_value($value) {
        echo isset($_POST[$value]) ? 'value="' . $_POST[$value] . '"' : "";
    }

    public static function post_selected($i, $name, $value) {
        if (!isset($_POST[$name]) && $i == 0) {
            echo 'selected="selected" value="' . $value . '"';
        } else {
            echo (isset($_POST[$name]) && $_POST[$name] == $value) ? 'selected="selected" value="' . $value . '"' : 'value="' . $value . '"';
        }
    }

    public static function is_active($menu, $submenu = "", $return = false) {
        global $_active_page_, $_active_page_submenu_;
        $output = ($menu == $_active_page_) ? "active" : "";

        if (strlen($submenu) > 0) {
            $output = ($submenu == $_active_page_submenu_) ? "active" : "";
        }

        if ($return) {
            return $output;
        }
        echo $output;
    }

    public static function checkbox($name, $class = "", $value = "yes", $style = "", $attr = array(), $return = false, $is_checked = false) {

        $checkbox = "<input type=\"checkbox\" name=\"" . $name . "\" id=\"" . $name . "\" ";
        $checkbox .= " value=\"" . $value . "\" class=\"" . $class . "\" style=\"" . $style . "\" ";
        if ($is_checked) {
            $checkbox .= " checked=\"checked\"";
        } else {
            $checkbox .= (isset($_POST[$name]) and $_POST[$name] == $value) ? "checked=\"checked\"" : "";
        }

        $checkbox .= " />";
        if ($return) {
            return $checkbox;
        } else {
            echo $checkbox;
        }
    }

    public static function textfield($name = "", $class = "", $style = "", $attr = array(), $return = false, $value = "", $type = 'text') {

        $textfield = "<input type=\"" . $type . "\"";
        $textfield .= " name=\"" . $name . "\" id=\"" . $name . "\"";
        $textfield .= " class=\"" . $class . "\" style=\"" . $style . "\"";

        if ($value) {
            $textfield .= " value=\"" . htmlentities($value) . "\"";
        } else {
            $textfield .= isset($_POST[$name]) ? " value=\"" . $_POST[$name] . "\"" : "";
        }

        if ($attr && count($attr) > 0) {
            foreach ($attr as $atr_key => $atr_value) {
                if ($atr_value !== null) {
                    $textfield .= " " . $atr_key . "=\"" . $atr_value . "\"";
                } else {
                    $textfield .= " " . $atr_key . " ";
                }
            }
        }

        $textfield .= " />";

        if ($return) {
            return $textfield;
        } else {
            echo $textfield;
        }
    }

    public static function input_hidden($name = "", $attr = array(), $return = false, $value = null) {

        $textfield = "<input type=\"hidden\"";
        $textfield .= " name=\"" . $name . "\" id=\"" . $name . "\"";

        if ($value !== null) {
            $textfield .= " value=\"" . $value . "\"";
        } else {
            $textfield .= isset($_POST[$name]) ? " value=\"" . $_POST[$name] . "\"" : "";
        }


        $textfield .= " />";

        if ($return) {
            return $textfield;
        } else {
            echo $textfield;
        }
    }

    public static function textarea($name = "", $class = "", $style = "", $attr = array(), $return = false, $initial_text = null) {
        $textarea = "<textarea";
        $textarea .= " name=\"" . $name . "\" id=\"" . $name . "\"";
        $textarea .= " class=\"" . $class . "\" style=\"" . $style . "\"";
        $textarea .= " >";
        if ($initial_text) {
            $textarea .= $initial_text;
        } else {
            $textarea .= isset($_POST[$name]) ? $_POST[$name] : "";
        }
        $textarea .= "</textarea>";

        if ($return) {
            return $textarea;
        } else {
            echo $textarea;
        }
    }

    public static function select($objects, $name = "", $selected_value = null, $class = "", $style = "", $attr = array(), $return = false) {
        $select = "<select";
        $select .= " name=\"" . $name . "\" id=\"" . $name . "\" ";

        foreach ($attr as $key => $value) {
            if ($value === NULL) {
                $select .= $key . ' ';
            } else {
                $select .= $key . '="' . $value . '" ';
            }
        }

        $select .= " class=\"" . $class . "\" style=\"" . $style . "\" >\n";

        foreach ($objects as $key => $value) {
            $select .= "<option value=\"" . $key . "\" ";
            if ($selected_value !== null) {
                $select .= ($selected_value == $key) ? "selected=\"selected\"" : "";
            } else {
                $select .= (isset($_POST[$name]) and $_POST[$name] == $key) ? "selected=\"selected\"" : "";
            }

            $select .= ">";
            $select .= $value;
            $select .= "</option>\n";
        }

        $select .= "</select>";

        if ($return) {
            return $select;
        } else {
            echo $select;
        }
    }

    public static function icon_tooltip($icon_class, $tooltip) {

        $attributes = [
            'data-content' => $tooltip,
            'data-placement' => 'top',
            'data-trigger' => 'hover',
            'class' => 'popovers fa ' . $icon_class
        ];

        $element_name = 'i';

        $element = "<" . $element_name . " ";

        foreach ($attributes as $key => $value) {
            $element .= $key . '="' . $value . '" ';
        }
        $element .= '></' . $element_name . '>';

        return $element;
    }

    public static function main_menu($name) {
        global $_active_page_;
        if ($name === $_active_page_) {
            echo 'active';
        } else {
            echo '';
        }
    }

    public static function sub_menu($name) {
        global $_active_page_submenu_;
        if ($name === $_active_page_submenu_) {
            echo 'active';
        } else {
            echo '';
        }
    }

    public static function anchor($text, $relative_link, $class = "", $style = "", $should_open_in_new_tab = false, $return = false) {
        $anchor = '<a href="' . URL::abs($relative_link) . '" ';
        $anchor .= " class=\"" . $class . "\" style=\"" . $style . "\" ";
        $anchor .= $should_open_in_new_tab ? ' target="_blank" ' : "";
        $anchor .= '>';

        $anchor .= $text;
        $anchor .= '</a>';

        if ($return) {
            return $anchor;
        } else {
            echo $anchor;
        }
    }

    public static function date_picker($name = "",$value = "", $format = "d M Y", $class = "form-control form-control-inline input-medium", $style = "",$attr = array('size'=>16)) {

        $value = TimeHelper::to_date($value,$format);
        $js_format = str_replace('Y', 'yyyy', $format);
        $js_format = str_replace('d', 'dd', $js_format);
                
        $textfield = "<input type=\"text\"";
        $textfield .= " name=\"" . $name . "\" id=\"" . $name . "\"";
        $textfield .= " class=\"" . $class . "\" style=\"" . $style . "\"";

        if ($value) {
            $textfield .= " value=\"" . htmlentities($value) . "\"";
        } else {
            $textfield .= isset($_POST[$name]) ? " value=\"" . $_POST[$name] . "\"" : "";
        }

        if ($attr && count($attr) > 0) {
            foreach ($attr as $atr_key => $atr_value) {
                if ($atr_value !== null) {
                    $textfield .= " " . $atr_key . "=\"" . $atr_value . "\"";
                } else {
                    $textfield .= " " . $atr_key . " ";
                }
            }
        }

        $textfield .= " />";

        $textfield .= '<script>
            $(function(){
            
                if(!$.fn.datepicker){
                    console.warn("Please include the Date Picker js and css files in your controler");
                    console.log("Head::instance()->load_css(\'../flatlab/assets/bootstrap-datepicker/css/datepicker\');");
                    console.log("Head::instance()->load_js(\'../flatlab/assets/bootstrap-datepicker/js/bootstrap-datepicker\');")
                    return;
                }

                window.prettyPrint && prettyPrint();
                $(\'#'.$name.'\').datepicker({
                    format: \''.$js_format.'\',
                    autoclose: true
                });
            });
        </script>';

        echo $textfield;
    }

}

function popover_attr($title, $class = '', $position = 'top') {

    $attributes = [
        'data-content' => htmlspecialchars($title),
        'data-placement' => $position,
        'data-trigger' => 'hover',
        'class' => 'popovers' . ' ' . $class,
    ];
    $str = "";
    foreach ($attributes as $key => $value) {
        $str .= $key . '="' . $value . '" ';
    }
    return $str;
}

function icon($class_name) {
    return '<i class="fa ' . $class_name . '"></i>';
}
