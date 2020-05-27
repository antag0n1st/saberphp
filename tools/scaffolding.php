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

$mode = str_replace('--mode=', '', $argv[1]);
$model_file_name = str_replace('--model_name=', '', $argv[2]);

if (!$model_file_name) {
    $model_file_name = 'none';
}

echo "\n";
echo "=====================================\n";
echo "Selected model: " . $model_file_name;
echo "\n";
echo "=====================================\n";

$overwrite = false;
$recreate_table = false;
$delete = false;
$model_and_table = false;

if ($mode === "o" or $mode === "overwrite") {
    $overwrite = true;
    $recreate_table = true;
} else if ($mode === "d" or $mode === "delete") {
    $delete = true;
}else if ($mode === "m") {
    $model_and_table = true;
    $recreate_table  = true;
} else { // mode == r , or default
    $recreate_table = true;
}

function listFolderFiles($dir) {

    $supported_type = ['int', 'varchar', 'datetime', 'tinyint', 'text' , 'date'];
    $attributes = ['unsigned', 'signed'];

    $ffs = scandir($dir);
    global $main_dir, $model_file_name, $delete;
    foreach ($ffs as $ff) {

        if ($ff != '.' && $ff != '..') {

            echo "\n";
            echo "\n";
            echo "Found model: " . $ff;
            echo "\n";

            if ($model_file_name === "all" or $model_file_name === $ff) {

                echo "Working on model: " . $ff;
                echo "\n";
            } else if ($model_file_name === "none") {
                echo "\n";
                echo "Aborting beause no model was selected";
                echo "\n";
                return;
            } else {
                echo "Skipping ...";
                echo "\n";
                echo "\n";
                continue;
            }

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
                    'type' => 'int',
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
                            if ($segments['type'] !== "varchar(255)") {
                                $segments['type'] .= "(" . $p . ")";
                            }
                            $type_resolved = true;
                            continue;
                        } else if (in_array($p, $supported_type)) {
                            $segments['type'] = $p;
                            if ($p === "varchar") {
                                $segments['type'] = 'varchar(255)';
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
                
            } else if (!$delete) {
                echo "TODO - Check if the table needs to be altered ... \n";
            }

            doScaffolding($table_name, $fields, $keys);
        }
    }
}

function create_table($table_name, $fields, $keys) {

    global $overwrite, $recreate_table, $delete;

    $query = " SELECT * FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "' AND table_name = '" . $table_name . "' LIMIT 1; ";
    $row = Model::db()->query_first_row($query);

    if ($row) {
        echo "Table already exists\n";

        if ($overwrite or $recreate_table or $delete) {
            // drop it first

            $query = "DROP TABLE `" . $table_name . "` ";
            Model::db()->query($query);
            echo "Table Dropped!\n";
        } else {
            return false;
        }
    }

    if ($delete) {
        echo "Table " . $table_name . " removed ...\n";
        return false;
    }

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
    echo "Table " . $table_name . " created!\n";
    return true;
}

function doScaffolding($table_name, $fields, $keys) {

    global $overwrite, $delete , $model_and_table;

    Load::script('classes/inflect');

    $names = explode('_', $table_name);
    $controller_class_name = '';
    $model_name = '';
    $title_entities = '';
    $title_entity = '';
    foreach ($names as $name) {
        $controller_class_name .= ucfirst($name);
        $title_entities .= ucfirst($name) . " ";
        $model_name .= ucfirst(Inflect::singularize($name));
        $title_entity .= ucfirst(Inflect::singularize($name)) . " ";
    }
    $title_entities = trim($title_entities);
    $title_entity = trim($title_entity);

    $controler = ucfirst(Inflect::pluralize($controller_class_name));
    $controler_file = strtolower(Inflect::pluralize($table_name));
    $model = $model_name; //ucfirst(Inflect::singularize($table_name));
    $model_instance = strtolower(Inflect::singularize($table_name));
    $model_filename = strtolower(Inflect::pluralize($table_name));
    $entities = strtolower(Inflect::pluralize($table_name));
    $url = $entities;

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

            $post_fields .= "\t\t\$" . $model_instance . '->' . $name . " = \$this->get_post('" . $name . "');\n";

            $form_controls .= '<div class="form-group">
                        <label for="' . $name . '" class="col-lg-2 col-sm-2 control-label ">' . $name . '</label>
                        <div class="col-lg-10">
                            <?php HTML::textfield(\'' . $name . '\', \'form-control\', null, null, false, $' . $model_instance . '->' . $name . ' ); ?>
                        </div>
                    </div>';
        }
        $db_fields[] = $name;
        $properties .= "\tpublic $" . $name . ";\n";
        $table_header .= "\t\t\t<th>" . $name . "</th>\n";
        $table_body .= "\t\t\t\t<td><?php echo \$" . $model_instance . "->" . $name . "; ?></td>\n";
    }

    
    if($model_and_table or $overwrite){

        $file_name = 'models/' . $model_instance . '.php';

        $content = file_get_contents('config/scaffolding/templates/model');

        $content = str_replace('{table_name}', $table_name, $content);
        $content = str_replace('{model}', $model, $content);
        $content = str_replace('{id}', $id, $content);
        $content = str_replace('{db_fields}', "'" . implode("','", $db_fields) . "'", $content);
        $content = str_replace('{properties}', $properties, $content);

        file_put_contents($file_name, $content);

        echo "Writing to " . $file_name;
        echo "\n";
    }

    if ($overwrite) {

        $file_name = 'controllers/' . $controler_file . '.php';

        $content = file_get_contents('config/scaffolding/templates/controller');

        $content = str_replace('{controler}', $controler, $content);
        $content = str_replace('{model}', $model, $content);
        $content = str_replace('{model_name}', $model_instance, $content);
        $content = str_replace('{entities}', $entities, $content);
        $content = str_replace('{url}', $url, $content);
        $content = str_replace('{post_fields}', $post_fields, $content);

        file_put_contents($file_name, $content);

        echo "Writing to " . $file_name;
        echo "\n";

        ////////////////////////////////

        $file_name = 'views/' . $model_filename . '/' . 'list.php';

        if (!file_exists('views/' . $model_filename)) {
            mkdir('views/' . $model_filename, 0777, true);
        }

        $content = file_get_contents('config/scaffolding/templates/list');

        $content = str_replace('{title_entities}', $title_entities, $content);
        $content = str_replace('{controler}', $controler, $content);
        $content = str_replace('{model_name}', $model_instance, $content);
        $content = str_replace('{model}', $model, $content);
        $content = str_replace('{id}', $id, $content);
        $content = str_replace('{table_header}', $table_header, $content);
        $content = str_replace('{table_body}', $table_body, $content);
        $content = str_replace('{entities}', $entities, $content);
        $content = str_replace('{url}', $url, $content);
        $content = str_replace('{form_controls}', $form_controls, $content);

        file_put_contents($file_name, $content);

        echo "Writing to " . $file_name;
        echo "\n";

        //////////////////////////////////////////

        $file_name = 'views/' . $model_filename . '/' . 'add.php';

        if (!file_exists('views/' . $model_filename)) {
            mkdir('views/' . $model_filename, 0777, true);
        }

        $content = file_get_contents('config/scaffolding/templates/add');

        $content = str_replace('{title_entity}', $title_entity, $content);
        $content = str_replace('{model_name}', $model_instance, $content);
        $content = str_replace('{model}', $model, $content);
        $content = str_replace('{form_controls}', $form_controls, $content);
        $content = str_replace('{post_fields}', $post_fields, $content);

        file_put_contents($file_name, $content);

        echo "Writing to " . $file_name;
        echo "\n";
    } else if ($delete) {

        $file_name = 'controllers/' . $controler_file . '.php';
        delete_file($file_name);

        $file_name = 'models/' . $model_instance . '.php';
        delete_file($file_name);

        $file_name = 'views/' . $model_filename . '/' . 'list.php';
        delete_file($file_name);

        $file_name = 'views/' . $model_filename . '/' . 'add.php';
        delete_file($file_name);

        $file_name = 'views/' . $model_filename;
        if (file_exists($file_name)) {
            rmdir($file_name);
            echo "Deleting " . 'views/' . $model_filename;
            echo "\n";
            echo "\n";
        } else {
            echo "Already deleted " . $file_name;
            echo "\n";
        }
    }
}

function delete_file($file) {
    if (file_exists($file)) {
        unlink($file);
        echo "Deleting " . $file;
        echo "\n";
    } else {
        echo "Already deleted " . $file;
        echo "\n";
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

