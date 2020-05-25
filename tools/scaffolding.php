<?php

// read from config/models
// ask if a new migration should be started and deal with it
// if table does not exist ask if pages need to be created , if so deal with it
// create the table and the model
// if table exists , alter the model and the table
// log create and alters in migrations script

if (php_sapi_name() != "cli") {
    die("Can't work on the web");
}

// lets go up and pretend
chdir("..");
include_once 'config/boot.php';

$main_dir = 'config/scaffolding/models';

$content = "";

function stringContains($haystack, $needle) {
    return strpos($haystack, $needle) !== false;
}

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

function beforeComma($string) {

    return substr($string, 0, strrpos($string, '.'));
}

function getStringsBetween($string, $start, $end) {
    $pattern = sprintf(
            '/%s(.*?)%s/', preg_quote($start), preg_quote($end)
    );
    preg_match_all($pattern, $string, $matches);

    return $matches[1];
}

function listFolderFiles($dir) {

    $supported_type = ['int', 'varchar', 'datetime', 'tinyint', 'text'];
    $attributes = ['unsigned', 'signed'];

    $ffs = scandir($dir);
    global $main_dir;
    foreach ($ffs as $ff) {

        if ($ff != '.' && $ff != '..') {

            $file_content = file_get_contents($dir . DS . $ff);
            $lines = explode("\n", trim($file_content));

            $fields = [];
            $keys = [];

            $table_name = $ff;

            foreach ($lines as $line) {

                $line = trim($line);
                $parts = explode(" ", $line);

                $name_resolved = false;
                $type_resolved = false;
                $attribute_resolved = false;
                $default_resolved = false;
                $has_default = false;
                $key_resolved = false;

                $field_name = null;
                $segments = [
                    'name' => '',
                    'type' => '',
                    'attribute' => '',
                    'null' => '',
                    'default' => '',
                    'increment' => '',
                ];

                foreach ($parts as $p) {

                    if (!$name_resolved) {
                        $name_resolved = true;
                        $segments['name'] = '`' . $p . '`';
                        $field_name = $p;
                        continue;
                    }

                    if (!$type_resolved) {
                        if (is_numeric($p)) {
                            $segments['type'] .= "(" . $p . ")";
                            $type_resolved = true;
                            continue;
                        } else if (in_array($p, $supported_type)) {
                            $segments['type'] .= $p;
                            if ($p === "varchar") {
                                $segments['attribute'] = "COLLATE utf8_general_ci";
                            }
                            continue;
                        } else {
                            $type_resolved = true;
                        }
                    }

                    if (!$attribute_resolved) {
                        $attribute_resolved = true;

                        if (in_array($p, $attributes) or startsWith($p, 'utf8')) {
                            if (in_array($p, $attributes)) {
                                $segments['attribute'] = $p;
                            } else {
                                $segments['attribute'] = "COLLATE " . $p;
                            }
                            continue;
                        }
                    }

                    if (!$default_resolved) {
                        $default_resolved = true;
                        if ($p === "default") {
                            $has_default = true;
                            continue;
                        }
                    }

                    if ($has_default) {
                        $has_default = false;
                        if ($p == "null") {
                            $segments['null'] = "";
                            $segments['default'] = "DEFAULT NULL";
                        } else {
                            $segments['null'] = "NOT NULL";
                            $segments['default'] = "DEFAULT '" . $p . "'";
                        }
                        continue;
                    }

                    if (!$key_resolved) {
                        $key_resolved = true;
                        if ($p === "primary") {
                            $segments['null'] = "NOT NULL";
                            $segments['increment'] = "AUTO_INCREMENT";
                            $keys[] = [
                                'field' => $field_name,
                                'type' => 'primary'
                            ];
                        } else if ($p === "index") {
                            $keys[] = [
                                'field' => $field_name,
                                'type' => 'index'
                            ];
                        } else if ($p === "unique") {
                            $keys[] = [
                                'field' => $field_name,
                                'type' => 'unique'
                            ];
                        }
                    }
                }

                $fields[] = $segments;
            }

            // create tables
            if (create_table($table_name, $fields, $keys)) {

                // continue with scaffolding
                // doScaffolding($table_name, $fields, $keys);
            } else {

                echo "Check if the table needs to be altered ... \n";
            }



            // this is for testing
            doScaffolding($table_name, $fields, $keys);
        }
    }
}

function create_table($table_name, $fields, $keys) {

    $query = " SELECT * FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "' AND table_name = '" . $table_name . "' LIMIT 1; ";
    $row = Model::db()->query_first_row($query);

    if ($row) {
        echo "Table already exists\n";
        return false;
    } else {

        $query = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (\n";

        $field_strings = [];

        foreach ($fields as $fs) {
            $field_strings[] = implode(' ', array_values($fs));
        }

        foreach ($keys as $key) {

            if ($key['type'] === "primary") {
                $field_strings[] = "PRIMARY KEY (`" . $key['field'] . "`)";
            } else if ($key['type'] === "index") {
                $field_strings[] = "KEY (`" . $key['field'] . "`)";
            } else if ($key['type'] === "unique") {
                $field_strings[] = "UNIQUE KEY (`" . $key['field'] . "`)";
            }
        }


        $query .= "\t" . implode(",\n\t", $field_strings);
        $query .= "\n) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ";

        Model::db()->query($query);
        return true;
    }
}

function doScaffolding($table_name, $fields, $keys) {

    Load::script('classes/inflect');

    $controler = ucfirst(Inflect::pluralize($table_name)) . "Controller";
    $controler_file = strtolower(Inflect::pluralize($table_name));
    $model = ucfirst(Inflect::singularize($table_name));
    $model_name = strtolower($model);
    $model_filename = strtolower(Inflect::pluralize($table_name));
    $entities = strtolower(Inflect::pluralize($table_name));
    $url = $entities;

    // table_name , 
    // id
    // db_fields
    // properties

    foreach ($keys as $key) {
        if ($key['type'] == "primary") {
            $id = $key['field'];
            $index = "`" . $key['field'] . "`";
        }
    }

    $post_fields = '';
    $db_fields = [];
    $properties = "";
    $table_header = '';
    $table_body = '';
    $form_controls = '';
    
    foreach ($fields as $field) {
        $name = trim($field['name'], '`');
        if ($field['name'] !== $index and $name !== 'created_at') {
            
            $post_fields .= "\t\t\$" . $model_name . '->' . $name . " = \$this->get_post('" . $name . "');\n";
            
            $form_controls .= '<div class="form-group">
                        <label for="'.$name.'" class="col-lg-2 col-sm-2 control-label ">'.$name.'</label>
                        <div class="col-lg-10">
                            <?php HTML::textfield(\''.$name.'\', \'form-control\', null, null, false, $'.$model_name.'->'.$name.' ); ?>
                        </div>
                    </div>';
            
        }
        $db_fields[] = $name;
        $properties .= "\tpublic $".$name.";\n";
        $table_header .= "\t\t\t<th>".$name."</th>\n";
        $table_body .= "\t\t\t\t<td><?php echo \$".$model_name."->".$name."; ?></td>\n";
        
    }

    if (!file_exists('controllers/' . $controler_file . '.php')) {
        
        $controllerContent = file_get_contents('config/scaffolding/templates/controller');

        $controllerContent = str_replace('{controler}', $controler, $controllerContent);
        $controllerContent = str_replace('{model}', $model, $controllerContent);
        $controllerContent = str_replace('{model_name}', $model_name, $controllerContent);
        $controllerContent = str_replace('{entities}', $entities, $controllerContent);
        $controllerContent = str_replace('{url}', $url, $controllerContent);
        $controllerContent = str_replace('{post_fields}', $post_fields, $controllerContent);

        file_put_contents('controllers/' . $controler_file . '.php', $controllerContent);

    }
    
    if (!file_exists('models/' . $model_name . '.php')) {
        
        $modelContent = file_get_contents('config/scaffolding/templates/model');

        $modelContent = str_replace('{table_name}', $table_name, $modelContent);
        $modelContent = str_replace('{model}', $model, $modelContent);
        $modelContent = str_replace('{id}', $id, $modelContent);
        $modelContent = str_replace('{db_fields}', "'".implode("','", $db_fields)."'", $modelContent);
        $modelContent = str_replace('{properties}', $properties, $modelContent);

        file_put_contents('models/' . $model_name . '.php', $modelContent);
    }
    
    if (!file_exists('views/' . $model_filename .'/'. 'list.php')) {
        
        if (!file_exists('views/' . $model_filename)) {
            mkdir('views/' . $model_filename, 0777, true);
        }
        
        $content = file_get_contents('config/scaffolding/templates/list');

        $content = str_replace('{model_name}', $model_name, $content);
        $content = str_replace('{model}', $model, $content);
        $content = str_replace('{id}', $id, $content);
        $content = str_replace('{table_header}', $table_header, $content);
        $content = str_replace('{table_body}', $table_body, $content);
        $content = str_replace('{entities}', $entities, $content);
        $content = str_replace('{url}', $url, $content);
        $content = str_replace('{form_controls}', $form_controls, $content);

        file_put_contents('views/' . $model_filename .'/'. 'list.php', $content);
    }
    
    if (!file_exists('views/' . $model_filename .'/'. 'add.php')) {
        
        if (!file_exists('views/' . $model_filename)) {
            mkdir('views/' . $model_filename, 0777, true);
        }
        
        $content = file_get_contents('config/scaffolding/templates/add');

        $content = str_replace('{model_name}', $model_name, $content);
        $content = str_replace('{model}', $model, $content);
        $content = str_replace('{form_controls}', $form_controls, $content);
        $content = str_replace('{post_fields}', $post_fields, $content);
//        $content = str_replace('{table_body}', $table_body, $content);
//        $content = str_replace('{entities}', $entities, $content);

        file_put_contents('views/' . $model_filename .'/'. 'add.php', $content);
    }
        
}

listFolderFiles($main_dir);



//////////////////////////////////////////// lets do this an other time
//
//$query = " SHOW COLUMNS FROM keywords ";
//$result = Model::db()->query($query);
//
//while($row = Model::db()->fetch_assoc($result)){
//    // Field Type Null Key Default Extra
//    
//    $name = $row['Field'];
//    $type = $row['Type'];
//    $null = $row['Null'];
//    $key = $row['Key'];
//    $default = $row['Default'];
//    $extra = $row['Extra'];
//    
//}

