<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Recuperar_model extends CI_Model
{
    function recuperar_usuario($email){
        $consulta = "SELECT tu.userId, tu.name FROM tbl_users AS tu WHERE email = '$email'
            LIMIT 1";

        $query = $this->db->query($consulta);

        return $query->result();
    }

    function actualizar_token($token, $email){
        $consulta = "UPDATE tbl_users SET tokenCode = '$token' WHERE email = '$email'";

        $query = $this->db->query($consulta);

        return $query;
    }

    function actualizar_tokenDate($email, $date){
        $consulta = "UPDATE tbl_users SET tokenDate = '$date' WHERE email = '$email' ";

        $query = $this->db->query($consulta);

        return $query;
    }

    function get_usuarioById($id){
        $consulta = "SELECT tu.name, tu.email, tu.tokenCode, tu.tokenDate FROM tbl_users AS tu WHERE userId = '$id'";

        $query = $this->db->query($consulta);

        return $query->result();
    }

    function newPass($pass, $id, $code){
        $consulta = "UPDATE tbl_users SET password = '$pass' WHERE userId = '$id' AND tokenCode = '$code'";

        $query = $this->db->query($consulta);

        return $query;
    }

    function send_mail($email,$message,$subject)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host       = "smtp.office365.com";
        $mail->Port       = 587;
        $mail->AddAddress($email);
        $mail->Username="sistemas@cecaitra.org.ar";
        $mail->Password="SisCec16";
        $mail->SetFrom('sistemas@cecaitra.org.ar','Sistemas CECAITRA');
        $mail->AddReplyTo("sistemas@cecaitra.org.ar","Sistemas CECAITRA");
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }
}

?>
