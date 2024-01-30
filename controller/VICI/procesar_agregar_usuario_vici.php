<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['usu'])) {
        // Obtener datos del formulario
        $rut = $_POST["rut"];
        $nombre = $_POST["nombre"];
        $contrasena = $_POST["contra"];
        $grupo = $_POST["grupo"];
        $agent_choose_ingroups = 0;
        $agentonly_callbacks = 1;
        $agent_choose_blended = 0;
        $agentcall_manual = 1;
        $hotkeys_active = 1;
        $delete_users = 1;
        $delete_user_groups = 1;
        $delete_lists = 1;
        $delete_campaigns = 1;
        $delete_ingroups = 1;
        $delete_remote_agents = 1;
        $load_leads = 1;
        $campaign_detail = 1;
        $ast_admin_access = 1;
        $ast_delete_phones = 1;
        $delete_scripts = 1;
        $modify_leads = 1;
        $change_agent_campaign = 1;
        $scheduled_callbacks = 1;
        $vicidial_recording = 1;
        $vicidial_transfers = 1;
        $delete_filters = 1;
        $alter_agent_interface_options = 1;
        $delete_call_times = 1;
        $modify_call_times = 1;
        $modify_users = 1;
        $modify_campaigns = 1;
        $modify_lists = 1;
        $modify_scripts = 1;
        $modify_filters = 1;
        $modify_ingroups = 1;
        $modify_usergroups = 1;
        $modify_remoteagents = 1;
        $modify_servers = 1;
        $view_reports = 1;
        $qc_user_level = 1;
        $qc_pass = 0;
        $qc_finish = 0;
        $qc_commit = 0;
        $add_timeclock_log = 1;
        $modify_timeclock_log = 1;
        $delete_timeclock_log = 1;
        $vdc_agent_api_access = 1;
        $modify_inbound_dids = 1;
        $delete_inbound_dids = 1;
        $alert_enabled = 0;
        $download_lists = 1;
        $manager_shift_enforcement_override = 1;
        $export_reports = 1;
        $delete_from_dnc = 1;
        $callcard_admin = 1;
        $modify_shifts = 1;
        $modify_phones = 1;
        $modify_carriers = 1;
        $modify_labels = 1;
        $modify_statuses = 1;
        $modify_voicemail = 1;
        $modify_audiostore = 1;
        $modify_moh = 1;
        $modify_tts = 1;
        $modify_contacts = 1;
        $modify_same_user_level = 1;
        $modify_custom_dialplans = 1;
        $user_choose_language = 1;
        $modify_colors = 1;
        $pause_code_approval = 1;
        $tipo_usu = $_POST['usu'];


        // Realizar la inserción en la base de datos
        $bases_de_datos = array(
            array("54.87.109.210", "cron", "1234", "asterisk"),
            array("54.144.201.11", "cron", "1234", "asterisk"),
            array("52.4.122.32", "cron", "1234", "asterisk"),
            array("3.225.109.205", "cron", "1234", "asterisk"),
            array("52.542.46.29", "cron", "1234", "asterisk"),
            array("52.6.25.63", "cron", "1234", "asterisk")
            // Agrega más conjuntos de parámetros según sea necesario
        );

        foreach ($bases_de_datos as $configuracion) {
            // Obtén los parámetros de la base de datos actual
            list($servername, $username, $password, $database) = $configuracion;

            // Realiza la conexión a la base de datos actual
            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Conexión fallida con la base de datos $database: " . $conn->connect_error);
            }

            switch ($tipo_usu) {
                case "Agente":
                    $nivel = 1;
                    // Consulta SQL para insertar en la tabla vicidial_users
                    $query = "INSERT INTO vicidial_users (user, pass, full_name, user_level, user_group,agent_choose_ingroups,agentonly_callbacks,agent_choose_blended,agentcall_manual,hotkeys_active) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
                    $stmt = $conn->prepare($query);
    
                    if (!$stmt) {
                        die("Error de preparación de consulta: " . $conn->error);
                    }
    
                    $stmt->bind_param(
                        "ssssssssss",
                        $rut, $contrasena, $nombre, $nivel, $grupo, $agent_choose_ingroups,
                        $agentonly_callbacks,
                        $agent_choose_blended,
                        $agentcall_manual,
                        $hotkeys_active
                    );
    
                    $stmt->execute();
    
                    // Verificar si la inserción fue exitosa
                    if ($stmt->affected_rows > 0) {
                        echo "Usuario agregado exitosamente.";
                        // Redirigir después de la ejecución
                        header("Location: vicidial.php");
                        exit();
                    } else {
                        echo "Error al agregar usuario: " . $stmt->error;
                    }
    
                    $stmt->close();
                    break;
                case "Supervisor":
                    $nivel = 9;
                    // Consulta SQL para insertar en la tabla vicidial_users
                    $query = "INSERT INTO vicidial_users (user, 
         pass, 
         full_name, 
         user_level, 
         user_group,agent_choose_ingroups,agentonly_callbacks,
         agent_choose_blended,
         agentcall_manual,
         hotkeys_active,
        delete_users,
        delete_user_groups,	
        delete_lists,
        delete_campaigns,	
        delete_ingroups,	
        delete_remote_agents,	
        load_leads,
        campaign_detail,	
        ast_admin_access,
        ast_delete_phones,
        delete_scripts,
        modify_leads,	
        change_agent_campaign,
        scheduled_callbacks,		
        vicidial_recording,	
        vicidial_transfers,	
        delete_filters,
        alter_agent_interface_options,
        delete_call_times,
        modify_call_times,
        modify_users,
        modify_campaigns,
        modify_lists,
        modify_scripts,
        modify_filters,
        modify_ingroups,
        modify_usergroups,
        modify_remoteagents,
        modify_servers,
        view_reports,
        qc_user_level,
        qc_pass,
        qc_finish,
        qc_commit,
        add_timeclock_log,	
        modify_timeclock_log,	
        delete_timeclock_log,
        vdc_agent_api_access,
        modify_inbound_dids,
        delete_inbound_dids,
        alert_enabled,
        download_lists,
        manager_shift_enforcement_override,
        export_reports,
        delete_from_dnc,	
        callcard_admin,	
        modify_shifts,	
        modify_phones,
        modify_carriers,
        modify_labels,	
        modify_statuses,	
        modify_voicemail,	
        modify_audiostore,	
        modify_moh,	
        modify_tts,
        modify_contacts,
        modify_same_user_level,	
        modify_custom_dialplans,	
        user_choose_language,	
        modify_colors,	
        pause_code_approval) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
         , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
         , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
         , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
         , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
         , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
         , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
                    $stmt = $conn->prepare($query);
    
                    if (!$stmt) {
                        die("Error de preparación de consulta: " . $conn->error);
                    }
    
                    $stmt->bind_param(
                        "sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
                        $rut, $contrasena, $nombre, $nivel, $grupo, $agent_choose_ingroups,
                        $agentonly_callbacks,
                        $agent_choose_blended,
                        $agentcall_manual,
                        $hotkeys_active,
                        $delete_users,
                        $delete_user_groups,
                        $delete_lists,
                        $delete_campaigns,
                        $delete_ingroups,
                        $delete_remote_agents,
                        $load_leads,
                        $campaign_detail,
                        $ast_admin_access,
                        $ast_delete_phones,
                        $delete_scripts,
                        $modify_leads,
                        $change_agent_campaign,
                        $scheduled_callbacks,
                        $vicidial_recording,
                        $vicidial_transfers,
                        $delete_filters,
                        $alter_agent_interface_options,
                        $delete_call_times,
                        $modify_call_times,
                        $modify_users,
                        $modify_campaigns,
                        $modify_lists,
                        $modify_scripts,
                        $modify_filters,
                        $modify_ingroups,
                        $modify_usergroups,
                        $modify_remoteagents,
                        $modify_servers,
                        $view_reports,
                        $qc_user_level,
                        $qc_pass,
                        $qc_finish,
                        $qc_commit,
                        $add_timeclock_log,
                        $modify_timeclock_log,
                        $delete_timeclock_log,
                        $vdc_agent_api_access,
                        $modify_inbound_dids,
                        $delete_inbound_dids,
                        $alert_enabled,
                        $download_lists,
                        $manager_shift_enforcement_override,
                        $export_reports,
                        $delete_from_dnc,
                        $callcard_admin,
                        $modify_shifts,
                        $modify_phones,
                        $modify_carriers,
                        $modify_labels,
                        $modify_statuses,
                        $modify_voicemail,
                        $modify_audiostore,
                        $modify_moh,
                        $modify_tts,
                        $modify_contacts,
                        $modify_same_user_level,
                        $modify_custom_dialplans,
                        $user_choose_language,
                        $modify_colors,
                        $pause_code_approval
                    );
    
                    $stmt->execute();
    
                    // Verificar si la inserción fue exitosa
                    if ($stmt->affected_rows > 0) {
                        echo "Usuario agregado exitosamente.";
                        // Redirigir después de la ejecución
                        header("Location: ../view/dashboard.php");
                        exit();
                    } else {
                        echo "Error al agregar usuario: " . $stmt->error;
                    }
    
                    $stmt->close();
                    break;
    
                default:
                    echo "usuario no válido.";
                    exit;
            }

            // Cierra la conexión
            $conn->close();
        }

       

    
        // Cerrar la conexión
    } else {
        echo "Por favor, seleccione un tipo de usuario.";
    }
} else {
    // Redirigir en caso de acceso directo al script sin enviar datos del formulario
    header("Location: ../../view/dashboard.php");
    exit();
}
?>