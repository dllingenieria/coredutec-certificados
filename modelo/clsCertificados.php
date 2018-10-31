<?php
require("../controlador/session.php");
set_time_limit(0);
/**
 * Clase para procedimientos que se pueden usar en toda la aplicacion
 *
 * @author John James Granados Restrepo
 */
class clsCertificados {
    
   //----- Función para buscar un certificado por # de registro -----//
   public function consultarCertificadosPorRegistro($param) {
        extract($param);
        $resultado = array();
        $registro = array();
        $rs = null;
        $conexion->getPDO()->query("SET NAMES 'utf8'");
        $sql = "CALL SPCONSULTARCERTIFICADOPORNUMERO('$pCodigoCertificado');";
        if ($rs = $conexion->getPDO()->query($sql)) {
            if ($filas = $rs->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($filas as $fila) {
                    foreach ($fila as $key => $value) {
                        array_push($registro, $value);
                    }
                    array_push($resultado, $registro);
                    $registro = array();
                }
            $rs->closeCursor();
            }else{
                $resultado = 0;
            }
        } else {
            $resultado = 0;
        }
        echo json_encode($resultado);
    }

    //----- Función para buscar un certificado por # de documento -----//
   public function consultarCertificadosPorDocumento($param) {
        extract($param);
        $resultado = array();
        $registro = array();
        $rs = null;
        $conexion->getPDO()->query("SET NAMES 'utf8'");
        $sql = "CALL SPCONSULTARCERTIFICADOPORDOCUMENTO($pTipoDocumento,$pDocumento);";
        if ($rs = $conexion->getPDO()->query($sql)) {
            if ($filas = $rs->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($filas as $fila) {
                    foreach ($fila as $key => $value) {
                        array_push($registro, $value);
                    }
                    array_push($resultado, $registro);
                    $registro = array();
                }
            $rs->closeCursor();
            // Se crea el certificado
            }else{
                $resultado = 0;
            }
        } else {
            $resultado = 0;
        }
        echo json_encode($resultado);
    }

    //----- Función para buscar un certificado por Id -----//
    public function consultarCertificadoPorId($param){
        extract($param);
        $rs = null;
        $conexion->getPDO()->query("SET NAMES 'utf8'");
        $sql = "CALL SPCONSULTARCERTIFICADOPORID($pIdCertificado)";
        if ($rs = $conexion->getPDO()->query($sql)) {
            if ($filas = $rs->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($filas as $fila) {
                    $array[] = $fila;
                }
            $rs->closeCursor();
            }
        } else {
            $array = 0;
        }
        echo json_encode($array);
    }

    //----- Función para guardar la informacion de un oferente -----//
    public function guardarOferente($param){
        extract($param);
        $IdUsuario = $_SESSION['idUsuario'];
        $rs = null;
        $conexion->getPDO()->query("SET NAMES 'utf8'");
        $sql = "CALL SPAGREGAROFERENTE($pTipoIdentificacion,$pNumeroIdentificacion,$pExpedicion,'$pNombres','$pApellidos','$pFechaN',$pSexo,$pEstadoCivil,$pGradoEscolaridad,$pTelefono1,$pTelefono2,$pTelefono3,'$pDireccion','$pEmail1','$pEmail2',$pLocalidad,$pCiudad,".$IdUsuario.");";
        if ($rs = $conexion->getPDO()->query($sql)) {
            if ($filas = $rs->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($filas as $fila) {
                    $array[] = $fila;
                }
            $rs->closeCursor();
            }
        } else {
            $array = 0;
        }
        echo json_encode($array);
    }

    //----- Función para guardar la nueva asignacion -----//
   public function guardarAsignacion($param){
        extract($param);
        $IdUsuario = $_SESSION['idUsuario'];
        $rs = null;
        $conexion->getPDO()->query("SET NAMES 'utf8'");
        $sql = "CALL SPAGREGARASIGNACION($pIdTablaGeneral,'$pArchivo','$pFechaAsignacion',$pAgenciaEmpleo,$pServicioCapacitacion,$pConvocatoria,$pInstitutoCapacitacion,$pMunicipioCapacitacion,'$pRuta','$pCodigoCurso','$pCodigoModulo',$pEstadoParticipante,$pTipoIdentificacion,$pNumeroIdentificacion,".$IdUsuario.");";
        //print_r($sql);
        if ($rs = $conexion->getPDO()->query($sql)) {
            if ($filas = $rs->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($filas as $fila) {
                    $array[] = $fila;
                }
            $rs->closeCursor();
            }
        } else {
            $array = 0;
        }
        echo json_encode($array);
    }
}
?>
