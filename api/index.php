<?php
define("DB_HOST", "localhost");
define("DB_USERNAME", "despertador_admin");
define("DB_PASSWORD", "Despertador_iot48");
define("DB_DATABASE_NAME", "despertador_iot");

header('Content-Type: application/json; charset=utf-8');

$despertador_id = null;
$despertador_radio_name = null;
$despertador_radio_url = null;
$despertador_autoGetTime = null;
$despertador_ntpCountry = null;

// variaveis para completar o json de resposta
$day = $month = $year = $hour = $minute = $second = null;
$timezone = $daylight_offset = null;
$ntp_server = $update_time = null;
$ip_address = null;

$array_alarm = array();
$arrayWeekDays = array();
for ($i = 0; $i < 8; $i++) {
    $arrayWeekDays[] = array();
}

try {
    $connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
    if ($connection->connect_errno) {
        echo "Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $connection->connect_error;
        throw new Exception("Could not connect to database. " . $connection->connect_error);
    }
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //echo "Recebido um get\n";
        //echo "ID do despertador: " . $_GET["alarmClockID"] . "\n";
        //echo "ID do user: " . $_GET["userID"] . "\n";
        // $user_id = $_GET["userID"];
        // $despertador_id = $_GET["alarmClockID"];
        // $despertador_ip = $_GET["ipAddress"];
        // $despertador_rede = $_GET["ssid"];
        // $despertador_alarms = $_GET["alarms"];
    } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //echo "Recebido um post\n";
        $_POST = json_decode(file_get_contents('php://input'), true);
        $user_id = $_POST["userID"];
        $despertador_id = $_POST["alarmClockID"];
        $despertador_ip = $_POST["ipAddress"];
        $despertador_mac = $_POST["macAddress"];
        $despertador_timezone = $_POST["timezone"];
        $despertador_offset = $_POST["offset"];
        $despertador_rede = $_POST["ssid"];
        $despertador_alarms = $_POST["alarms"];
        $despertador_autoGetTime = $_POST["autoGetTime"];
        $despertador_ntpCountry = $_POST["ntpCountry"];
        $despertador_radio_url = $_POST["radioUrl"];
        $despertador_radio_name = $_POST["radioName"];
    }

    // * verificar se o id do despertador é válido
    $sql = "SELECT id, is_atualizado FROM despertador WHERE id = $despertador_id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    $atualizado = $row["is_atualizado"];


    if (!$result) {
        echo "Invalid alarm clock ID. ";
        echo "Creating new alarm clock...\n";

        $sql = "SELECT id FROM despertador ORDER BY id DESC LIMIT 1";
        $result = $connection->query($sql);

        $row = $result->fetch_assoc();
        $despertador_id = $row["id"];
        $despertador_id++;
        $name = "Despertador " . $despertador_id;

        $sql = "INSERT INTO despertador (id, nome, ip, mac_address, data, timezone, offset, localizacao, is_atualizado, servidor_ntp, ultima_atualizacao, tempo_atualizacao, rede, id_utilizador) VALUES ($despertador_id, '$name', '$despertador_ip', '$despertador_mac', NOW(), 'Não definido', 0, 'Não definida', 0, 'Não definida', NOW(), 1200, '$despertador_rede', '$user_id')";

        $result = $connection->query($sql);

        if (!$result) {
            echo "Unable to create new alarm clock.\n";
            http_response_code(500);
            exit;
        } else {
            // echo "Created successfuly an alarm clock.\n";
        }
    } else {
        //echo "Estado atual:".$atualizado."\n";
        // * atualizar os dados vindos do ESP32 para a base de dados
        $sql = "UPDATE despertador SET ip = '$despertador_ip', mac_address = '$despertador_mac', ultima_atualizacao = NOW(), rede = '$despertador_rede' WHERE id = '$despertador_id'";
        $result = $connection->query($sql);

        // * verificar se o update funcionou
        if (!$result) {
            echo "Could not update alarm clock.\n";
            http_response_code(500);
            exit;
        } else {
            //echo "Alarm clock updated successfully.\n";
        }

        // * buscar os ids dos alarmes de um determinado despertador
        $sql = "SELECT id FROM alarme WHERE id_despertador = '$despertador_id'";
        $result = $connection->query($sql);

        // * verificar se existe alarmes daquele despertador na base de dados
        if ($result->num_rows == 0) {
            // echo "Could not get alarm clock alarms.\n";
            // echo "Alarms from ESP32: " . count($despertador_alarms) . "\n";

            // * POV - se não existir, vai apenas criar os alarmes 

            // * ler os alarmes do despertador vindos do ESP32
            foreach ($despertador_alarms as $alarm) {
                //echo "Alarm clock ID: " . $alarm["id"] . "\n";

                $sql = "SELECT id FROM alarme ORDER BY id DESC LIMIT 1";
                $result = $connection->query($sql);

                $row = $result->fetch_assoc();
                $alarme_id = $row["id"];
                $alarme_id++;

                $ss = new stdClass();
                $ss->id = $alarm["id"];
                $ss->hour = $alarm["hour"];
                $ss->weekDays = $alarm["weekDays"];
                $ss->weekDaysText = $alarm["weekDaysText"];
                $ss->isActivated = $alarm["isActivated"] == "true" ? 1 : 0;
                $ss->duration = $alarm["duration"];
                $ss->volume = $alarm["volume"];

                $sql = "INSERT INTO alarme (id, id_despertador, id_musica, hora, dias, estado, dia_semana, volume, duracao) VALUES ('$alarme_id', '$despertador_id', 5, '$ss->hour', '$ss->weekDays', $ss->isActivated, '$ss->weekDaysText', $ss->volume, $ss->duration)";
                $result = $connection->query($sql);

                if (!$result) {
                    echo "Could not create alarm " . $alarm["id"] . "\n";
                    http_response_code(500);
                    exit;
                } else {
                    // * pode ser apagado no futuro
                    // $sql = "SELECT LAST_INSERT_ID()";
                    // $result = $connection->query($sql);

                    // if ($result->num_rows > 0) {
                    //     $row = $result->fetch_assoc();
                    //     echo "Created alarm " . $row["id"] . "\n";
                    // } else {
                    //     echo "Could not get alarm ID\n";
                    //     http_response_code(500);
                    //     exit;
                    // }
                }
            }

            $atualizado = 0;
        } else {
            // * se existir alarmes na base de dados, comparar com os que estão vindos do ESP32

            // * POV - o "found" serve para verificar se o alarme que esteja no ESP32 já existe na base de dados

            $created_alarms = array(); // * array com os alarmes vindos do ESP32 criados

            // echo "Alarms found: " . $result->num_rows . "\n";
            // echo "Alarms from ESP32: " . count($despertador_alarms) . "\n";

            // * serve para verificar se esta variavel é alterada ou não no caso de um novo alarme existir na base de dados
            // * se estiver sempre a false, é porque não existe aquele alarme na base de dados
            // * se estiver a true, é porque existe aquele alarme na base de dados
            $i = 0;

            $rows = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $row) {
                $found = false;

                // echo " ----- BD Alarm clock ID: " . $row["id"] . "\n";
                $alarm_id = $row["id"];
                foreach ($despertador_alarms as $key => $alarm) {
                    // echo " - Alarm clock ID: " . $alarm["id"] . "\n";

                    $ss = new stdClass();
                    $ss->id = $alarm["id"];
                    $ss->hour = $alarm["hour"];
                    $ss->weekDays = $alarm["weekDays"];
                    $ss->weekDaysText = $alarm["weekDaysText"];
                    $ss->isActivated = $alarm["isActivated"] == "true" ? 1 : 0;
                    $ss->duration = $alarm["duration"];
                    $ss->volume = $alarm["volume"];

                    if ($ss->id == "Não definido") {
                        if (in_array($key, $created_alarms)) {
                            // echo "Alarm clock ID: " . $alarm["id"] . " already created.\n";
                            continue;
                        } else {
                            // echo "Could not get alarm " . $alarm["id"] . "\n";

                            $sql = "SELECT id FROM alarme ORDER BY id DESC LIMIT 1";
                            $result = $connection->query($sql);

                            $row = $result->fetch_assoc();
                            $alarme_id = $row["id"];
                            $alarme_id++;

                            $sql = "INSERT INTO alarme (id, id_despertador, id_musica, hora, dias, estado, dia_semana, volume, duracao) VALUES ('$alarme_id', $despertador_id, 5, '$ss->hour', '$ss->weekDays', $ss->isActivated, '$ss->weekDaysText', $ss->volume, $ss->duration)";
                            $result = $connection->query($sql);

                            if (!$result) {
                                echo "Could not 3 create alarm " . $alarm["id"] . "\n";
                                http_response_code(500);
                                exit;
                            } else {
                                // * pode ser apagado no futuro
                                // $sql = "SELECT LAST_INSERT_ID()";
                                // $result = $connection->query($sql);

                                // if ($result->num_rows > 0) {
                                //     $row = $result->fetch_assoc();

                                //     // print_r($row);

                                //     /echo "Created alarm " . $row["LAST_INSERT_ID()"] . "\n";
                                $created_alarms[] = $key;
                                // } else {
                                //     echo "Could not get alarm ID\n";
                                //     http_response_code(500);
                                //     exit;
                                // }
                            }
                        }

                        $i++;
                    } else if ($ss->id == $alarm_id) {
                        // * atualizar os dados vindos do ESP32 para a base de dados
                        $sql = "UPDATE alarme SET hora = '$ss->hour', estado = $ss->isActivated, dias = '$ss->weekDays', dia_semana = '$ss->weekDaysText' WHERE id = $ss->id";
                        $result = $connection->query($sql);

                        // * verificar se o update funcionou    
                        if (!$result) {
                            echo "Could not update alarm " . $alarm_id . "\n";
                            http_response_code(500);
                            exit;
                        } else {
                            // echo "Updated alarm " . $alarm_id . "\n";
                            $found = true;
                        }
                    } else {
                        // echo "Não é o alarme igual\n";
                    }
                }

                // print_r($created_alarms);
                // echo $found;

                // if (!$found) {
                //     $sql = "DELETE FROM alarme WHERE id = $alarm_id";
                //     $result = $connection->query($sql);

                //     if (!$result) {
                //         echo "Could not delete alarm " . $alarm_id . "\n";
                //         http_response_code(500);
                //         exit;
                //     } else {
                //         //echo "Deleted alarm " . $alarm_id . "\n";
                //     }
                // }
            }

            if ($i > 0) {
                $atualizado = 0;
            }
        }
    }

    // * como o id já é válido, pode-se fazer o select dos dados do despertador
    $sql = "SELECT * FROM despertador WHERE id = $despertador_id";
    $result = $connection->query($sql);

    // * obter os dados do despertador
    $array = array();
    while ($row = $result->fetch_assoc()) {
        //echo "id: " . $row["id"] . " - Nome: " . $row["nome"] . "\n";
        $array[] = $row;

        // * obter data do da base de dados
        $date_hour = explode(" ", $row["data"]);
        $date = explode("-", $date_hour[0]);
        $hours = explode(":", $date_hour[1]);
        $day = $date[2];
        $month =  $date[1];
        $year =  $date[0];
        $hour = $hours[0];
        $minute =  $hours[1];
        $second =  $hours[2];

        // * obter outros dados da base de dados
        $timezone = $row["timezone"];
        $daylight_offset = $row["offset"] == 1 ? true : false;
        $ntp_server = $row["servidor_ntp"];
        $update_time = $row["tempo_atualizacao"];
        $ip_address = $row["ip"];
        $mac_address = $row["mac_address"];

        $id = $row["id"];
    }

    //echo json_encode($array, JSON_PRETTY_PRINT);

    // * aceder a tabela dos alarmes e ir buscar os dados dos alarmes do despertador escolhido
    $sql = "SELECT * FROM alarme WHERE id_despertador = $despertador_id";

    $result = $connection->query($sql);

    if (!$result) {
        echo "Cannot get alarm clock alarms.\n";
    } else {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //echo "id: " . $row["id"] . " - Nome: " . $row["hora"] . "\n";
                $alarm_data = new stdClass();
                $alarm_data->id = $row["id"];
                $alarm_data->isActivated = $row["estado"] == "1" ? true : false;
                $alarm_data->hour = $row["hora"];
                $alarm_data->weekDaysText = $row["dia_semana"];
                $alarm_data->weekDays = $row["dias"];
                $alarm_data->duration = $row["duracao"];
                $alarm_data->volume = $row["volume"];

                $array_alarm[] = $alarm_data;

                for ($i = 0; $i < strlen($alarm_data->weekDays); $i++) {
                    $tt = new stdClass();
                    if ($alarm_data->weekDays[$i] == 1) {
                        $tt->id = $alarm_data->id;
                        $tt->isActivated = $alarm_data->isActivated;
                        $tt->hr = explode(":", $alarm_data->hour)[0];
                        $tt->mt = explode(":", $alarm_data->hour)[1];
                        $tt->dur = $alarm_data->duration;
                        $tt->vol = $alarm_data->volume;
                        //echo $tt->id . " ; " . $tt->hr . " " . $tt->mt . "\n";
                        $arrayWeekDays[$i][] = $tt;
                    }
                }
            }

            for ($i = 0; $i < 8; $i++) {
                usort($arrayWeekDays[$i], function ($a, $b) {
                    if (strcmp($b->hr, $a->hr) == 0) {
                        return intval($a->mt) <=> intval($b->mt);
                    }
                    return intval($a->hr) <=> intval($b->hr);
                });
            }

            // echo json_encode($array_alarm, JSON_PRETTY_PRINT);
        } else {
            //echo "No alarm clock alarms.\n";
        }
    }
    $json_to_send = new stdClass();

    $json_to_send->data = new stdClass();

    $json_to_send->data->dateHour = new stdClass();
    $json_to_send->data->dateHour->day = $day;
    $json_to_send->data->dateHour->month = $month;
    $json_to_send->data->dateHour->year = $year;
    $json_to_send->data->dateHour->hour = $hour;
    $json_to_send->data->dateHour->min = $minute;
    $json_to_send->data->dateHour->sec = $second;

    $json_to_send->data->timezone = $timezone;
    $json_to_send->data->daylightOffset = $daylight_offset == true ? 1 : 0;
    $json_to_send->data->ntpServer = $ntp_server;
    $json_to_send->data->ipAddress = $ip_address;
    $json_to_send->data->macAddress = $mac_address;
    $json_to_send->data->id = $despertador_id;

    $json_to_send->other->radio->url = $despertador_radio_url;
    $json_to_send->other->radio->name = $despertador_radio_name;
    $json_to_send->other->updateData = $update_time;
    $json_to_send->other->autoGetTime = $despertador_autoGetTime;
    $json_to_send->other->ntpCountry = $despertador_ntpCountry;
    $json_to_send->other->autoUpdateTime = "100";

    $json_to_send->data->alarms = $array_alarm;

    $json_to_send->data->weekDaysAlarms = $arrayWeekDays;

    $json_result = json_encode($json_to_send, JSON_PRETTY_PRINT);
    // $json_result = json_encode($json_to_send);

    // * quando há alteração de dados, o estado do atualizar fica a 0
    // * depois de enviar para o ESP32, o estado do atualizar fica a 1
    //echo "atualizado: " . $atualizado . "\n";
    // $atualizado = 0;
    if ($atualizado == 0) {
        //echo "O despertador está desatualizado. A enviar dados..\n";

        echo $json_result;

        $sql = "UPDATE despertador SET is_atualizado = 1 WHERE id = '$id'";
        $result = $connection->query($sql);

        if (!$result) {
            echo "Error updating record: " . $connection->error;
            http_response_code(500);
            exit;
        } else {
            // echo "Record updated successfully\n";
        }
    } else {
        echo "O despertador esta atualizado";
        http_response_code(302); // found
        exit;
    }
} else {
    echo "Method not allowed";
    http_response_code(403); // forbidden
}

mysqli_close($connection);
