<?php
require __DIR__ . '/../config/conexionReporte.php'; // Asegúrate de que esta ruta es correcta
require __DIR__ . '/../vendor/autoload.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '../../phpmailer/Exception.php';
require __DIR__ . '../../phpmailer/PHPMailer.php';
require __DIR__ . '../../phpmailer/SMTP.php';

class MyChat implements MessageComponentInterface
{
    protected $clients;
    protected $clientCount = 0;
    protected $dbConnection;
    protected $groupData;
    protected $groupUserData;
    protected $allTicket;
    protected $asigedUserTicket;
    protected $resolvedTicket;
    protected $updateTicket;
    protected $reupdateTicket;
    protected $rutToConnectionMap = [];
    protected $AllState;
    protected $AllStateFinishCombobox;

    protected $countTickets;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();

        $this->dbConnection = new ConnectionOne("konexnet");
        $this->loadComboboxGroupTicket();
        $this->GetAllstate();
        $this->GetAllstateFinishCombobox();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clientCount++;

        echo "Nuevo cliente conectado. Total de clientes: {$this->clientCount}\n";

        // Almacenar la nueva conexión
        $this->clients->attach($conn);

        // Enviar datos de grupos con tipo "group_data"
        $groupDataMessage = [
            "type" => "alldate",
            "getAllGroup" => $this->groupData, // Aquí colocas los datos de grupos
            "getAllState" => $this->AllState,
            //but combobox 
            "getAllStateFinishCombobox" => $this->AllStateFinishCombobox
        ];

        $conn->send(json_encode($groupDataMessage));

    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // echo "Mensaje recibido: " . $msg . "\n"; 


        $this->Crud($msg, $from);
        //enviar a las personas 
        /*foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }*/
        $data = json_decode($msg, true);
        print_r($data);
        // Comprobar si el mensaje es de tipo 'ladding' y contiene información del usuario
        if (isset($data['action']) && $data['action'] === 'ladding' && isset($data['data']['rut'])) {
            // Obtener el RUT del usuario
            $userRut = $data['data']['rut'];

            // Asociar la conexión con el RUT del usuario
            $this->rutToConnectionMap[$userRut] = $from;

            // Resto de tu lógica de manejo de mensajes...
        }



    }

    protected function Crud($data, $from)
    {
        $data = json_decode($data, true);

        if (is_array($data) && isset($data['action'])) {
            switch ($data['action']) {
                case 'ladding':
                    $data = $data["data"];
                    print_r($data);

                    $this->getAllTickets($data["idgrupoibelong"]);

                    $this->loadComboboxUserGroup($data["idgrupoibelong"]);

                    $this->assignedTicketsUser($data["rut"]);

                    //count amount of ticket finish
                    $this->finishTicketsUser($data["idgrupoibelong"]);


                    //count amount of ticket
                    $this->countTickets($data["idgrupoibelong"]);


                    // $this->resolvedTickets($data["idestado"]);


                    $response = [
                        "allTickets" => $this->allTicket,
                        "allUserGroup" => $this->groupUserData,
                        "allAsingadoUser" => $this->asigedUserTicket,
                        "AllrevolvedTticket" => $this->resolvedTicket,
                        "status" => "success",
                        "message" => "Ticket con éxito",
                        "type" => "ticket_data"
                    ];

                    $from->send(json_encode($response));

                    break;
                case 'createTicket':
                    $this->createTicket($data['data'], $from);

                    break;
                case 'deleteTicket':

                    $this->deleteTicket($data['data'], $from);
                    break;
                case 'AssigUserTickets':

                    $this->assignedUserTicketFirst($data["data"], $from);

                    break;
                case 'stopState':
                    $stop = 1;
                    $this->stopTicket($data["data"], $stop, $from);

                    break;
                case 'resolvedTicket':

                    $this->stopTicket($data["data"], $from);

                    break;
                case 'reopenTicket':

                    $this->stopTicket($data["data"], $from);

                    break;

                case 'finishTicket':

                    $this->ticketUserFinalished($data["data"], $from);

                    break;
                default:
                    echo "Acción no reconocida";
                    break;


            }
        } else {
            echo "El mensaje recibido no es un JSON válido o no contiene 'action'";
        }
    }

    protected function createTicket($data, $from)
    {
       print_r($data);
        try {
            // Asumiendo que los nombres de las claves en $data coinciden con los campos de tu tabla
            //generar ticket
            $idgt = uniqid(); //sirve para ambos
            $rut = $data['rut'];
            //parametro del grupo que se enviar la data
            date_default_timezone_set('America/Santiago');
            $fecha_start = date("Y-m-d H:i:s"); // Formato "YYYY-MM-DD HH:MM:SS"
            $asig_groupEmail = $data['asig_group'];

            //detalles de los ticket
            $asunto = $data['asunto'];
            $tipo = $data['tipo'];
            $urgencia = $data['urgencia'];
            $titulo = $data['titulo'];
            $applicant = $data["applicant"];
            $name = $data["name"];
            $archivo = $data["archivo"];

            ///
            $id_grupo = $data["idgrupo"];  //parametro del grupo al que pertenesco

            $idgrupoSend = $data['id_grupo_send'];


            // insertamos a la base solo la creacion de generar ticket
            $query1 = "INSERT INTO Generar_Ticket (idticket,idUsuario, idgrupo,idstate,dateStart,asignado,createState,idrol) VALUES (?,?,?,?,?,?,?,?)";
            $params1 = [$idgt, $rut, $idgrupoSend, 1, $fecha_start, $asig_groupEmail, 1, 6];
            $this->dbConnection->queryExe($query1, $params1);


            $query2 = "INSERT INTO  Detalles_Ticket ( texto,tipo,urgencia,titulo,idticket) VALUES (?,?,?,?,?)";
            $params2 = [$asunto, $tipo, $urgencia, $titulo, $idgt];
            $this->dbConnection->queryExe($query2, $params2);

            $query3 = "INSERT INTO Historial_Ticket (idTicket, idState, idUser, dateStart) VALUES (?, ?, ?, ?)";
            $params3 = [$idgt, 1, $rut, $fecha_start]; // Asume que el estado inicial es 1
            $this->dbConnection->queryExe($query3, $params3);



            // Cargar y combinar los datos de los grupos
            $this->loadComboboxUserGroup($id_grupo);
            $groupDataIdGrupo = $this->groupUserData;

            $this->loadComboboxUserGroup($idgrupoSend);
            $groupDataAsigGroupEmail = $this->groupUserData;




            // Combinar los RUTs de ambos grupos
            $combinedGroupRUTs = array_merge(array_column($groupDataIdGrupo, 'Rut'), array_column($groupDataAsigGroupEmail, 'Rut'));
            $combinedGroupRUTs = array_unique($combinedGroupRUTs);

            $this->getAllTickets($idgrupoSend);
            $this->loadComboboxUserGroup($idgrupoSend);

            // Preparar la respuesta
            $response = [
                "allTickets" => $this->allTicket,
                "allUserGroup" => $this->groupUserData,
                "status" => "success",
                "message" => "Ticket creado con éxito",
                "type" => "ticket_data"
            ];


            // Convertir el mensaje a formato JSON
            $jsonResponse = json_encode($response);

            // Enviar el mensaje a todos los clientes que pertenecen a los grupos
            foreach ($combinedGroupRUTs as $rut) {
                // Verificar si el RUT tiene una conexión activa en rutToConnectionMap
                if (array_key_exists($rut, $this->rutToConnectionMap)) {
                    // Obtener la conexión del usuario y enviar el mensaje
                    $connection = $this->rutToConnectionMap[$rut];
                    $connection->send($jsonResponse);
                }
            }
            $this->getAllTickets($id_grupo);
            $this->loadComboboxUserGroup($id_grupo);
            $response1 = [
                "allTickets" => $this->allTicket,
                "allUserGroup" => $this->groupUserData,
                "status" => "success",
                "message" => "Ticket creado con éxito",
                "type" => "ticket_data"
            ];


            $from->send(json_encode($response1));

            $this->sendMailing($idgt, $asig_groupEmail, $applicant, $fecha_start, $titulo, $name, $asunto, $archivo);


        } catch (\Exception $e) {
            // Enviar mensaje de error al cliente
            $from->send(json_encode(["status" => "error", "message" => $e->getMessage()]));
        }
    }
    //assigned ticket four first 
    protected function assignedUserTicketFirst($data, $from)
    {

        //datos que ingresamos para Ticket Asignados
        $idAssigned = uniqid();
        $idUser = $data['Rut'];  //enviado
        $rutIbelong = $data["rutibelong"] ?? '';
        $idTicketAssig = $data['idticket']; //el id del ticket que le quieres asignar
        $asunto = $data["asunto"];  // perticion 
        date_default_timezone_set('America/Santiago');
        $fechaStart = date("Y-m-d H:i:s"); // Formato "YYYY-MM-DD HH:MM:SS" fecha de asignacion 
        $email = $data["asig_email"];
        $idstate = $data["idstate"];
        $rol = $data["rol"];
        print_r($data);
        $id_grupo_send = $data["id_grupo_send"];
        $idgroupibelong = $data["idgroupibelong"];

        $Correo = $data["Correo"];
        //end 



        if (!empty($rutIbelong)) {
            // Usar consultas preparadas para prevenir inyección SQL
            $queryone = "UPDATE Ticket_Asignados ta SET ta.tassign = 0 WHERE ta.idticket = ? AND ta.idUsuario = ?";
            $param = [$idTicketAssig, $rutIbelong];
            $this->updateTicket = $this->dbConnection->queryExe($queryone, $param);
        }

        // Preparar la primera consulta para Ticket_Asignados
        $query2 = "INSERT INTO Ticket_Asignados(idAssign,idUsuario,idticket,asunto,tassign) VALUES(?,?,?,?,?)";
        $params2 = [$idAssigned, $idUser, $idTicketAssig, $asunto, 1];
        $this->updateTicket = $this->dbConnection->queryExe($query2, $params2);

        $query3 = "UPDATE Generar_Ticket gt SET gt.asignado = '$email' WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($query3);

        $queryfour = "UPDATE Generar_Ticket gt  SET gt.idstate = $idstate WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfour);

        $queryfive = "UPDATE Generar_Ticket gt SET gt.idrol = $rol  WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfive);

        $querysix = "UPDATE Historial_Ticket set dateEnd = '$fechaStart'  WHERE idTicket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($querysix);

        $queryseven = "INSERT INTO Historial_Ticket (idTicket, idState, idUser, dateStart) VALUES (?, ?, ?, ?)";
        $params3 = [$idTicketAssig, $idstate, $idUser, $fechaStart]; // Asume que el estado inicial es 1
        $this->dbConnection->queryExe($queryseven, $params3);



        // Cargar y combinar los datos de los grupos
        $this->loadComboboxUserGroup($id_grupo_send);
        $groupDataAsigGroupEmail = $this->groupUserData;
        $this->loadComboboxUserGroup($idgroupibelong);
        $groupDataIdGrupo = $this->groupUserData;



        // Combinar los RUTs de ambos grupos
        $combinedGroupRUTs = array_merge(array_column($groupDataIdGrupo, 'Rut'), array_column($groupDataAsigGroupEmail, 'Rut'));
        $combinedGroupRUTs = array_unique($combinedGroupRUTs);


        $this->getAllTickets($id_grupo_send);
        $this->loadComboboxUserGroup($id_grupo_send);

        // Preparar la respuesta
        $response = [
            "allTickets" => $this->allTicket,
            "allUserGroup" => $this->groupUserData,
            "status" => "success",
            "message" => "Ticket creado con éxito",
            "type" => "ticket_data"
        ];

        // Convertir el mensaje a formato JSON
        $jsonResponse = json_encode($response);

        // Enviar el mensaje a todos los clientes que pertenecen a los grupos
        foreach ($combinedGroupRUTs as $rut) {
            // Verificar si el RUT tiene una conexión activa en rutToConnectionMap
            if (array_key_exists($rut, $this->rutToConnectionMap)) {
                // Obtener la conexión del usuario y enviar el mensaje
                $connection = $this->rutToConnectionMap[$rut];
                $connection->send($jsonResponse);
            }
        }


        $this->getAllTickets($idgroupibelong);
        $this->loadComboboxUserGroup($idgroupibelong);
        $this->assignedTicketsUser($rutIbelong);

        $response1 = [
            "allTickets" => $this->allTicket,
            "allUserGroup" => $this->groupUserData,
            "allAsingadoUser" => $this->asigedUserTicket,
            "status" => "success",
            "message" => "Ticket creado con éxito",
            "type" => "ticket_data"
        ];


        $from->send(json_encode($response1));

        $this->AsiganacionMailing($idTicketAssig, $Correo, $email, $asunto, $archivos);
    }
    //ticket count
    //not
    protected function reAssigTicketSecond($data, $from)
    {
        $idAssigned = uniqid();
        $idUser = $data['Rut'];  //enviado
        $idTicketAssig = $data["idticket"]; //enviado  //para actualizar y assignar
        $asunto = $data["asunto"];

        date_default_timezone_set('America/Santiago');
        $fechaStart = date("Y-m-d H:i:s");
        $idstate = $data["idstate"]; // enviados
        date_default_timezone_set('America/Santiago');
        $fechaEnd = date("Y-m-d H:i:s");
        $email = $data["asig_email"];
        $rol = $data["rol"];

        // para enviar al grupo que perte
        $idgroupibelong = $data["idgroupibelong"];
        $id_grupo_send = $data["id_grupo_send"];

        //update para cambiar la asignacion 

        $queryfive = "UPDATE Generar_Ticket gt SET gt.idrol = $rol  WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfive);

        $queryone = "UPDATE Ticket_Asignados ta SET ta.assignState = 0 WHERE ta.idticket = '$idTicketAssig'";
        $this->reupdateTicket = $this->dbConnection->queryExe($queryone);

        $query3 = "UPDATE Generar_Ticket gt SET gt.asignado = '$email' WHERE gt.idticket = '$idTicketAssig'";
        $this->reupdateTicket = $this->dbConnection->queryExe($query3);

        $queryfour = "UPDATE Generar_Ticket gt  SET gt.idstate = $idstate WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfour);

        //se le finaliza al 
        $queryfour = "UPDATE Ticket_Asignados ta SET ta.dateEnd = '$fechaEnd' WHERE ta.idticket = '$idTicketAssig'";
        $this->reupdateTicket = $this->dbConnection->queryExe($queryfour);


        $query2 = "INSERT INTO Ticket_Asignados(idAssign,idUsuario,idticket,asunto,dateStart,assignState,idstate) VALUES(?,?,?,?,?,?,?)";
        $params2 = [$idAssigned, $idUser, $idTicketAssig, $asunto, $fechaStart, 1, $idstate];

        $this->reupdateTicket = $this->dbConnection->queryExe($query2, $params2);





        //assigned ticket
        $this->assignedTicketsUser($idgroupibelong);
        $this->assignedTicketsUser($id_grupo_send);

        $this->getAllTickets($id_grupo_send);
        $this->loadComboboxUserGroup($idgroupibelong);
        $this->loadComboboxUserGroup($id_grupo_send);

        // Cargar y combinar los datos de los grupos
        $this->loadComboboxUserGroup($idgroupibelong);
        $groupDataIdGrupo = $this->groupUserData;

        $this->loadComboboxUserGroup($id_grupo_send);
        $groupDataAsigGroupEmail = $this->groupUserData;

        // Combinar los RUTs de ambos grupos
        $combinedGroupRUTs = array_merge(array_column($groupDataIdGrupo, 'Rut'), array_column($groupDataAsigGroupEmail, 'Rut'));
        $combinedGroupRUTs = array_unique($combinedGroupRUTs);

        // Preparar la respuesta
        $response = [
            "allTickets" => $this->allTicket,
            "allUserGroup" => $this->groupUserData,
            "allAsingadoUser" => $this->asigedUserTicket,
            "status" => "success",
            "message" => "Ticket creado con éxito",
            "type" => "ticket_data"
        ];

        // Convertir el mensaje a formato JSON
        $jsonResponse = json_encode($response);

        // Enviar el mensaje a todos los clientes que pertenecen a los grupos
        foreach ($combinedGroupRUTs as $rut) {
            // Verificar si el RUT tiene una conexión activa en rutToConnectionMap
            if (array_key_exists($rut, $this->rutToConnectionMap)) {
                // Obtener la conexión del usuario y enviar el mensaje
                $connection = $this->rutToConnectionMap[$rut];
                $connection->send($jsonResponse);
            }
        }
        $from->send(json_encode($response));

    }
    protected function ticketUserFinalished($data, $from)
    {
        $idAssigned = uniqid();
        $idUser = $data['Rut'];  //enviado
        $idTicketAssig = $data['idticket']; //el id del ticket que le quieres asignar
        $asunto = $data["asunto"];  // perticion 
        date_default_timezone_set('America/Santiago');
        $fechaStart = date("Y-m-d H:i:s"); // Formato "YYYY-MM-DD HH:MM:SS" fecha de asignacion 
        $email = $data["asig_email"];

        $idstate = $data["idstate"];
        $rol = $data["rol"];
        //end 
        $id_grupo_send = $data["id_grupo_send"];
        $idgroupibelong = $data["idgroupibelong"];
        $Correo = $data["Correo"];



        $query3 = "UPDATE Generar_Ticket gt SET gt.asignado = '$email' WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($query3);

        $queryfour = "UPDATE Generar_Ticket gt  SET gt.idstate = $idstate WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfour);

        $queryfive = "UPDATE Generar_Ticket gt SET gt.idrol = $rol  WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfive);

        $queryfive = "UPDATE Ticket_Asignados ta SET ta.asunto = '$asunto'  WHERE ta.idUsuario = '$idUser'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfive);

        $querysix = "UPDATE Historial_Ticket set dateEnd = '$fechaStart'  WHERE idTicket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($querysix);


        $query3 = "INSERT INTO Historial_Ticket (idTicket, idState, idUser, dateStart,dateEnd) VALUES (?, ?, ?, ?,?)";
        $params3 = [$idTicketAssig, $idstate, $idUser, $fechaStart, $fechaStart]; // Asume que el estado inicial es 1
        $this->dbConnection->queryExe($query3, $params3);


        // Cargar y combinar los datos de los grupos
        $this->loadComboboxUserGroup($idgroupibelong);
        $groupDataIdGrupo = $this->groupUserData;

        $this->loadComboboxUserGroup($id_grupo_send);
        $groupDataAsigGroupEmail = $this->groupUserData;



        // Combinar los RUTs de ambos grupos
        $combinedGroupRUTs = array_merge(array_column($groupDataIdGrupo, 'Rut'), array_column($groupDataAsigGroupEmail, 'Rut'));
        $combinedGroupRUTs = array_unique($combinedGroupRUTs);

        $this->getAllTickets($id_grupo_send);
        $this->loadComboboxUserGroup($id_grupo_send);
        $this->finishTicketsUser($id_grupo_send);

        // Preparar la respuesta
        $response = [
            "allTickets" => $this->allTicket,
            "allUserGroup" => $this->groupUserData,
            "AllrevolvedTticket" => $this->resolvedTicket,
            "status" => "success",
            "message" => "Ticket creado con éxito",
            "type" => "ticket_data"
        ];

        // Convertir el mensaje a formato JSON
        $jsonResponse = json_encode($response);

        // Enviar el mensaje a todos los clientes que pertenecen a los grupos
        foreach ($combinedGroupRUTs as $rut) {
            // Verificar si el RUT tiene una conexión activa en rutToConnectionMap
            if (array_key_exists($rut, $this->rutToConnectionMap)) {
                // Obtener la conexión del usuario y enviar el mensaje
                $connection = $this->rutToConnectionMap[$rut];
                $connection->send($jsonResponse);
            }
        }

        $this->getAllTickets($idgroupibelong);
        $this->loadComboboxUserGroup($idgroupibelong);

        // Preparar la respuesta
        $response1 = [
            "allTickets" => $this->allTicket,
            "allUserGroup" => $this->groupUserData,
            "status" => "success",
            "message" => "Ticket creado con éxito",
            "type" => "ticket_data"
        ];

        $from->send(json_encode($response1));

    }
    protected function assignedTicketsUser($rut)
    {
        $asignedTickets = "SELECT u.Rut, u.Nombre, u.Correo,u.idgrupo AS groupFirst,gt.idgrupo AS groupSecond,
        dt.idticket, 
        gt.dateStart,gt.asignado,e.estado, 
        e.id_estado,
        dt.tipo,dt.urgencia,dt.titulo,
        ta.asunto,
        dt.texto,
        gt.idrol,
        ta.idUsuario,
        ta.tassign
        FROM Ticket_Asignados ta 
                INNER JOIN Generar_Ticket gt ON ta.idticket = gt.idticket
                INNER JOIN roles r ON gt.idrol = r.idrol
                INNER JOIN Estados e ON gt.idstate = e.id_estado
                INNER JOIN Usuarios u ON gt.idUsuario = u.Rut
                INNER JOIN Detalles_Ticket dt ON gt.idticket = dt.idticket
                WHERE ta.idUsuario = 8888 AND ta.tassign = 1 AND gt.idstate <> 6";

        $this->asigedUserTicket = $this->dbConnection->queryExe($asignedTickets);

    }

    protected function reopenTicket($data, $from)
    {


        //  $query2 = "INSERT INTO Ticket_Asignados(idAssign,idUsuario,idticket,asunto,dateStart,assignState) VALUES(?,?,?,?,?,?)";
        // $params2 = [$idAssigned, $idUser, $idTicketAssig, $asunto, $fechaStart, 1];

        // $this->reupdateTicket = $this->dbConnection->queryExe($query2, $params2);

    }

    protected function stopTicket($data, $stop, $from)
    {

        //datos que ingresamos para Ticket Asignados
        $idAssigned = uniqid();
        $idUser = $data['Rut'];  //enviado
        $idTicketAssig = $data['idticket']; //el id del ticket que le quieres asignar
        $asunto = $data["asunto"];  // perticion 
        date_default_timezone_set('America/Santiago');
        $fecha_Start = date("Y-m-d H:i:s"); // Formato "YYYY-MM-DD HH:MM:SS" fecha de asignacion 
        $email = $data["asig_email"];
        $idstate = $data["idstate"];
        $rol = $data["rol"];
        $Correo = $data["Correo"];

        //end 

        $id_grupo_send = $data["id_grupo_send"];
        $idgroupibelong = $data["idgroupibelong"];

        $queryOne = "UPDATE Generar_Ticket gt SET gt.userAssign ='$idUser'  WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($queryOne);

        $query3 = "UPDATE Generar_Ticket gt SET gt.asignado = '$email' WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($query3);

        $queryfour = "UPDATE Generar_Ticket gt  SET gt.idstate = $idstate WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfour);

        $queryfive = "UPDATE Generar_Ticket gt SET gt.idrol = $rol  WHERE gt.idticket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfive);

        $queryfive = "UPDATE Ticket_Asignados ta SET ta.asunto = '$asunto'  WHERE ta.idUsuario = '$idUser'";
        $this->updateTicket = $this->dbConnection->queryExe($queryfive);

        $querysix = "UPDATE Historial_Ticket set dateEnd = '$fecha_Start'  WHERE idTicket = '$idTicketAssig'";
        $this->updateTicket = $this->dbConnection->queryExe($querysix);


        $query3 = "INSERT INTO Historial_Ticket (idTicket, idState, idUser, dateStart) VALUES (?, ?, ?, ?)";
        $params3 = [$idTicketAssig, $idstate, $idUser, $fecha_Start]; // Asume que el estado inicial es 1
        $this->dbConnection->queryExe($query3, $params3);






        $this->loadComboboxUserGroup($id_grupo_send);
        $groupDataAsigGroupEmail = $this->groupUserData;

        // Cargar y combinar los datos de los grupos
        $this->loadComboboxUserGroup($idgroupibelong);
        $groupDataIdGrupo = $this->groupUserData;


        // Combinar los RUTs de ambos grupos
        $combinedGroupRUTs = array_merge(array_column($groupDataIdGrupo, 'Rut'), array_column($groupDataAsigGroupEmail, 'Rut'));
        $combinedGroupRUTs = array_unique($combinedGroupRUTs);


        //grupos para donde enviamos
        $this->getAllTickets($id_grupo_send);
        $this->loadComboboxUserGroup($id_grupo_send);
        // Preparar la respuesta
        $response = [
            "allTickets" => $this->allTicket,
            "allUserGroup" => $this->groupUserData,
            "status" => "success",
            "message" => "Ticket creado con éxito",
            "type" => "ticket_data"
        ];

        // Convertir el mensaje a formato JSON
        $jsonResponse = json_encode($response);

        // Enviar el mensaje a todos los clientes que pertenecen a los grupos
        foreach ($combinedGroupRUTs as $rut) {
            // Verificar si el RUT tiene una conexión activa en rutToConnectionMap
            if (array_key_exists($rut, $this->rutToConnectionMap)) {
                // Obtener la conexión del usuario y enviar el mensaje
                $connection = $this->rutToConnectionMap[$rut];
                $connection->send($jsonResponse);
            }
        }

        $this->getAllTickets($idgroupibelong);
        $this->loadComboboxUserGroup($idgroupibelong);
        $this->assignedTicketsUser($idUser);

        $response1 = [
            "allTickets" => $this->allTicket,
            "allUserGroup" => $this->groupUserData,
            "allAsingadoUser" => $this->asigedUserTicket,
            "status" => "success",
            "message" => "Ticket creado con éxito",
            "type" => "ticket_data"
        ];

        $from->send(json_encode($response1));
        $stop ?? '';
        if (!empty($stop == 1)) {
            $this->stopMailing($idTicketAssig, $Correo, $guporAsignEmail, $asunto);
        }
    }
    //search users assigned ticket
    protected function searchTicketAssig($data)
    {
        $idTicketAssig = $data["idticket"];
        // Preparar la consulta con parámetros
        $query = "SELECT * FROM Ticket_Asignados ta WHERE ta.idticket = ?";
        $param = [$idTicketAssig];
        // Ejecutar la consulta con el parámetro
        $result = $this->dbConnection->queryExe($query, $param);

        // Verificar si hay resultados
        if (is_array($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    //delete tickets 
    protected function deleteTicket($data, $from)
    {
        // Usar marcador de posición en la consulta
        try {
            //code...
            $id = $data['id'];
            $rut = $data['rut'];
            $idgrupo = $data['idgrupo'];
            $query = "DELETE FROM ticket WHERE id = ?";
            $params = [$id];

            // Ejecutar la consulta
            $this->dbConnection->queryExe($query, $params);

            $this->getAllTickets($idgrupo);
            $this->loadComboboxUserGroup($idgrupo);

            $response = [
                "allTickets" => $this->allTicket,
                "allUserGroup" => $this->groupUserData,
                "status" => "success",
                "message" => "Ticket eliminado con éxito",
                "type" => "ticket_data"
            ];
            $from->send(json_encode($response));

        } catch (\Exception $e) {
            //throw $th;
            $from->send(json_encode(["status" => "error", "message" => $e->getMessage()]));
        }

    }

    //get all ticktets users
    protected function getAllTickets($idIbelongGroup)
    {
        $Ticketquery = "SELECT u.Rut, u.Nombre, u.Correo,u.idgrupo AS groupFirst,
        gt.idgrupo AS groupSecond, dt.idticket, 
        gt.idUsuario, gt.idstate,gt.dateStart,gt.asignado, e.id_estado,e.estado, 
        dt.tipo, dt.urgencia,dt.titulo, dt.texto,gt.createState,gt.idrol
        FROM Usuarios u INNER JOIN Generar_Ticket gt ON u.Rut = gt.idUsuario
        INNER JOIN Estados e ON gt.idstate = e.id_estado
        INNER JOIN Detalles_Ticket dt ON gt.idticket = dt.idticket  
        WHERE (u.idgrupo = $idIbelongGroup OR gt.idgrupo = $idIbelongGroup) AND
        gt.idstate NOT IN(6)  ORDER BY  gt.dateStart DESC";

        $this->allTicket = $this->dbConnection->queryExe($Ticketquery);
        // Obtener todos los tickets existentes desde la base de datos
    }
    //comentadiros dfsksdfdkk

    protected function finishTicketsUser($idgrupo)
    {
        $ticketFinish = "SELECT *  FROM Generar_Ticket gt 
        INNER JOIN Usuarios u ON gt.idUsuario = u.Rut
        INNER JOIN Detalles_Ticket dt ON gt.idticket = dt.idticket
        INNER JOIN Estados e ON gt.idstate = e.id_estado 
        WHERE e.id_estado = 6 AND gt.idgrupo = $idgrupo";

        $this->resolvedTicket = $this->dbConnection->queryExe($ticketFinish);
    }


    protected function GetAllstateFinishCombobox()
    {
        $allState = "SELECT * FROM Estados e WHERE e.id_estado IN(6,7)";

        $this->AllStateFinishCombobox = $this->dbConnection->queryExe($allState);

    }


    protected function GetAllstate()
    {
        $allState = "SELECT * FROM Estados e WHERE e.id_estado NOT IN(1,7,6)";

        $this->AllState = $this->dbConnection->queryExe($allState);

    }
    protected function loadComboboxGroupTicket()
    {
        $Groupquery = "SELECT * FROM Grupos";
        $this->groupData = $this->dbConnection->queryExe($Groupquery);
    }

    protected function loadComboboxUserGroup($idGroup)
    {
        $GroupUserquery = "SELECT * FROM Usuarios WHERE idgrupo = $idGroup";
        $this->groupUserData = $this->dbConnection->queryExe($GroupUserquery);
    }

    protected function sendMailing($id, $asig_groupEmail, $email, $fecha, $titulo, $nombre, $glosa, $archivos)
    {

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'mail.grupokonectados.cl';
            $mail->SMTPAuth = true;
            $mail->Username = 'prueba@grupokonectados.cl';
            $mail->Password = 'Diciembre2023';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // o 'ssl' dependiendo de tu configuración
            $mail->Port = 465; // o el puerto que estés utilizando


            $mail->setFrom('prueba@grupokonectados.cl', 'Soporte Kon3ctados');
            $mail->addAddress($asig_groupEmail);
            $mail->addAddress('soporte@grupokonectados.cl');

            $mail->isHTML(true);
            $mail->Subject = '[K3#' . $id . '] Ticket Generado ' . $titulo;

            $bodyContent = 'URL: http://192.168.1.147/KON3CTADOS/index.php <br>Nombre: ' . $nombre . '<br>Fecha de apertura: ' . $fecha . '<br>Correo del solicitante: ' . $email . '<br>Descripcion: ' . $glosa;

            // Nuevo: Crear un array para almacenar los chunks de cada archivo
            $archivosCompletos = [];

            foreach ($archivos as $chunk) {
                if (!isset($chunk['base64']) || !isset($chunk['nombre'])) {
                    continue; // Saltar este chunk si no tiene los datos necesarios
                }
            
                if (!array_key_exists($chunk['nombre'], $archivosCompletos)) {
                    $archivosCompletos[$chunk['nombre']] = '';
                }
                $archivosCompletos[$chunk['nombre']] .= $chunk['base64'];
            }

            foreach ($archivosCompletos as $nombre => $contenidoBase64) {
                $data = base64_decode($contenidoBase64);
                $tmpFilePath = sys_get_temp_dir() . '/' . $nombre;

                if (file_put_contents($tmpFilePath, $data)) {
                    // Adjuntar el archivo reconstruido
                    $mail->addAttachment($tmpFilePath, $nombre);
                } else {
                    echo "Error al escribir el archivo: " . $nombre;
                }
            }

            $mail->Body = $bodyContent;
            $mail->send();
        } catch (Exception $e) {
            echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
        }
    }



    protected function AsiganacionMailing($idTicketAssig, $Correo, $email, $asunto, $archivos)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'mail.grupokonectados.cl';
            $mail->SMTPAuth = true;
            $mail->Username = 'prueba@grupokonectados.cl';
            $mail->Password = 'Diciembre2023';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // o 'ssl' dependiendo de tu configuración
            $mail->Port = 465; // o el puerto que estés utilizando

            $mail->setFrom('prueba@grupokonectados.cl', 'Soporte Kon3ctados');
            $mail->Subject = 'Cambio de estado de ticket';


            $mail->isHTML(true);
            // Enviar correo al cliente
            //soporte solo a los personas 
            $mail->addAddress($Correo);
            $mail->Subject = 'Cambio de estado de ticket';
            $mail->Body = 'El ticket con ID ' . $idTicketAssig . ' ha cambiado de estado. <br>
            Asignado a:' . $email;
            $mail->send();


            // Limpiar destinatarios y enviar correo a People
            $mail->clearAddresses();
            $mail->addAddress($email);
            $bodyContent = 'Se le asigno el siguiente ticket ' . $idTicketAssig . '<br>' . $asunto . '<br>';



            foreach ($archivos as $archivo) {
                // Decodificar el archivo de base64
                $data = base64_decode($archivo['base64']);
                $tmpFilePath = sys_get_temp_dir() . '/' . $archivo['nombre'];

                // Verificar y escribir datos en el archivo temporal
                if (file_put_contents($tmpFilePath, $data)) {
                    // Adjuntar archivo o incrustar imagen
                    if (strpos($archivo['tipo'], 'image/') === 0) {
                        $bodyContent .= '<br><img src="data:' . $archivo['tipo'] . ';base64,' . $archivo['base64'] . '" style="max-width:100%;">';
                    } else {
                        $mail->addAttachment($tmpFilePath, $archivo['nombre']);
                        $bodyContent .= '<br>Archivo adjunto: ' . $archivo['nombre'];
                    }
                } else {
                    // Manejar el error en caso de que el archivo no se pueda escribir
                    echo "Error al escribir el archivo: " . $archivo['nombre'];
                }
            }

            $email->Body = $bodyContent;
            $mail->send();
            // Limpiar destinatarios y enviar correo a People


        } catch (Exception $e) {
            echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
        }
    }

    protected function countTickets($idgrupo)
    {
        $query = "SELECT  COUNT(gt.idticket) FROM Generar_Ticket gt  WHERE gt.idgrupo = $idgrupo";
        $this->countTickets = $this->dbConnection->queryExe($query);

    }


    public function onClose(ConnectionInterface $conn)
    {
        // Eliminar la conexión cerrada
        $this->clients->detach($conn);
        $this->clientCount--;
        echo "Cliente desconectado. Total de clientes: {$this->clientCount}\n";

    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }


}
?>