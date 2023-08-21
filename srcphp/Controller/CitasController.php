<?php

namespace proyecto\Controller;

use proyecto\Models\Models;
use proyecto\Models\Table;
use proyecto\Response\Success;
use proyecto\Models\Citas;
use proyecto\Models\Animales;
use proyecto\Models\Clientes;
use proyecto\Response\Failure;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class citasController
{

 
    
    function mostrarCitasPendientes()
    {
        $t = Table::query("SELECT *
        FROM citas
        WHERE DATE(fecha_cita) >= CURDATE() AND DATE(fecha_cita) <= CURDATE() + INTERVAL 2 DAY
        LIMIT 3;
        ");
        $r = new Success($t);
        $json_response = json_encode($r);

        header('Content-Type: application/json');
        echo $json_response;
    }

    function agendarcita() {



        $mail = new PHPMailer(true);

        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $cita = new Citas();
            $cita->user_regis = $dataObject->user_regis;
            $cita->fecha_registro = date('Y-m-d H:i:s');
            $cita->fecha_cita = $dataObject->fechaCita;
            $cita->id_mascota = $dataObject->id_mascota;
            $cita->estatus = $dataObject->estatus;
            $cita->motivo = $dataObject->motivo;
            $cita->save();



            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTPMail'];
            $mail->Password = $_ENV['MailPassword'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($_ENV['SMTPMail']);
            $mail->addAddress($_ENV['SMTPMail']);

            $mail->isHTML(true);
            $mail->Subject = 'Nueva cita programada!';
            $mail->Body = 'Se ha generado una nueva cita. Le agradecemos su prontitud en validarla a la brevedad posible. ✅';

            $mail->send();





            $r = new Success($cita);
            return $r->Send();
        }  catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }

    }




    function MascotasUsuario() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query("CALL MascotasUsuario ('{$dataObject->id_cliente}') ");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function ValidacionFechas() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query("SELECT * FROM ValidacionFechas ");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }


    function CitasPendientesCliente() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query(" CALL CitasPendientesCliente ('{$dataObject->id_cliente}') ");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function CitasRechazadasCliente() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query(" CALL CitasRechazadasCliente ('{$dataObject->id_cliente}') ");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }


    function citasAceptadas()
    {
        try {
            $t = Table::query("SELECT 
            citas.id,
            clientes.nombre,
            clientes.telefono1,
            citas.fecha_cita,
            citas.estatus,
            animales.raza
            from citas
                inner join animales on animales.id = citas. id_mascota
                inner join clientes on clientes.id = animales.propietario
                where citas.estatus = 'Aceptada'         
            ");
            $r = new Success($t);
            $json_response = json_encode($r);

            header('Content-Type: application/json');
            echo $json_response;
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function citasTot()
    {
        try {
            $t = Table::query("SELECT 
            citas.id,
            clientes.nombre,
            clientes.telefono1,
            citas.fecha_cita,
            citas.estatus,
            animales.raza
            from citas
                inner join animales on animales.id = citas. id_mascota
                inner join clientes on clientes.id = animales.propietario
                where citas.estatus = 'pendiente'         
            ");
            $r = new Success($t);
            $json_response = json_encode($r);

            header('Content-Type: application/json');
            echo $json_response;
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function cita_id (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $cita_id = $dataObject->cita_id;            

            $cita = $this->cita_id_query($cita_id);
            $response = ['data' => $cita];

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Procedimiento ejecutado correctamente', 'data' => $response]);
            
        } catch (\Exception $e) {
            $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
            http_response_code(500);
        }
    }

    function cita_id_query ($cita_id) {
        $r = table::queryParams("SELECT 
        citas.id,
        citas.motivo,
        clientes.nombre,
        clientes.telefono1,
        citas.fecha_registro,
        citas.fecha_cita,
        citas.estatus,
        animales.raza
        from citas
            inner join animales on animales.id = citas. id_mascota
            inner join clientes on clientes.id = animales.propietario   
        where citas.id = :cita_id",
            
            [
                'cita_id' => $cita_id,
            ]
        
        );
        return $r;

    }


    
    function correo_cita (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $cita_id = $dataObject->cita_id;            

            $cita = $this->correo_cita_query($cita_id);
            $response = ['data' => $cita];

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Procedimiento ejecutado correctamente', 'data' => $response]);
            
        } catch (\Exception $e) {
            $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
            http_response_code(500);
        }
    }

    function correo_cita_query ($cita_id) {
        $r = table::queryParams("Call obtener_correo_por_id(:cita_id)",
    [
        'cita_id' => $cita_id
    ]);
        return $r;
    }



    function rechazar_aceptar_cita (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $id_cita = $dataObject->cita_id;
            $cita_estatus = $dataObject->cita_respuesta;            

            $products = $this->rechazar_aceptar_cita_query($id_cita, $cita_estatus);
            $response = ['data' => $products];


            header('Content-Type: application/json');
            echo json_encode(['message' => 'Procedimiento ejecutado correctamente', 'data' => $response]);

        } catch (\Exception $e) {
            $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
            http_response_code(500);
        }
    }

    function rechazar_aceptar_cita_query($id_cita, $cita_estatus) {
        $r = table::queryParams("CALL cambiar_estatus_cita(:id_cita,:cita_estatus)",
            
            [
                'id_cita' => $id_cita,
                'cita_estatus' => $cita_estatus,
            ]
        
        );
        echo 'success', $r;
        return $r;
    }



    function NotiCorreo(){

        $mail = new PHPMailer(true);

        try {

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTPMail'];
            $mail->Password = $_ENV['MailPassword'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($_ENV['SMTPMail']);
            $mail->addAddress ($dataObject->correo_u);

            $mail->isHTML(true);
            $mail->Subject = 'Actualizacion sobre el Estado de tu Cita.';
            $mail->Body = 'Estimado/a cliente, <br><br><br><br> Es un placer informarte que tu cita ha sido exitosamente validada. Te invitamos cordialmente a acceder a nuestra plataforma web para verificar el estado actualizado de tu cita. Estamos comprometidos en brindarte un servicio de calidad y transparencia en cada paso del proceso. <br><br><br><br>

Si en algún momento surgieran dudas o si deseas compartir sugerencias con nosotros, no dudes en contactarnos. Estamos a tu disposición para proporcionarte la atención personalizada que mereces. Puedes comunicarte con nuestro equipo a través del número de teléfono +52-8711034602. <br><br><br><br>

Agradecemos tu confianza en nuestros servicios y esperamos brindarte la mejor experiencia posible. <br><br><br><br>

Atentamente, Veterinaria Cachorros. 🐶';

            $mail->send();
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }



    function CrearRegistroVeterinario() {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);
    
        $params = [
            'userregis'       => $dataObject->userregis,
            'p_nombre'        => $dataObject->nombre,
            'p_apellido'      => $dataObject->apellido,
            'p_telefono1'     => $dataObject->telefono1,
            'p_telefono2'     => $dataObject->telefono2,
            'p_nombre_animal' => $dataObject->nombre_animal,
            'p_especie'       => $dataObject->especie,
            'p_raza'          => $dataObject->raza,
            'p_genero'        => $dataObject->genero,
            'p_fecha_cita'    => $dataObject->fecha_cita,
            'p_estatus'       => $dataObject->estatus,
            'p_motivo'        => $dataObject->motivo
        ];
    
        try {
            $resultados = Table::queryParams("CALL CrearRegistroVeterinario(:userregis, :p_nombre, :p_apellido, :p_telefono1, :p_telefono2, :p_nombre_animal, :p_especie, :p_raza, :p_genero, :p_fecha_cita, :p_estatus, :p_motivo)", $params);
    
            $r = new Success($resultados);
            return $r->Send();
    
        } catch (PDOException $e) {
            $r = new Error($e->getMessage());
            return $r->Send();
        }
    }

    function CorreoUsuario() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query("CALL CorreoUsuario ('{$dataObject->cita_id}') ");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }
    
    
}
