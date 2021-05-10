<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 * Description of Notes
 *
 * @author Fco. Antonio Moreno Pérez <famphuelva@gmail.com>
 * @author David Díaz Mascareña <daviddiazmas@gmail.com>
 */
class notes extends fs_list_controller
{

    public $notes;
    public $resultados;
    public $usuarios;
    public $mensaje;

    public function __construct()
    {
        
        parent::__construct(__CLASS__, 'Notas', 'Notas');
    }

    protected function create_tabs()
    {
        $this->mensaje = false;
        $this->template = "notes";
        $notes = new note();


        $this->usuarios = $notes->get_todos_usuarios();

        if (isset($_POST["mensaje"]) && isset($_POST["color"])) {
            $notes->color = $_POST["color"];
            $notes->message = $_POST["mensaje"];
        }

        if (isset($_POST["coordenadas"])) {
            $notes->id = $_POST["id"];
            $notes->_left = $_POST["left"];
            $notes->_top = $_POST["top"];
            $notes->ancho = $_POST["ancho"];
            $notes->alto = $_POST["alto"];
            $a = $notes->get($notes->id);
            $notes->username = $a->username;
            $notes->message = $a->message;
            $notes->color = $a->color;
            $notes->save();
        }

        if (isset($_GET["delete"])) {
            $notes->id = $_GET["delete"];
            $notes->delete();
        }

        if (isset($_POST["idNota"])) {
            $notes->id = $_POST["idNota"];
            $notes->message = $_POST["textoNota"];
            $a = $notes->get($notes->id);
            $notes->username = $a->username;
            $notes->color = $a->color;
            $notes->_left = $a->_left;
            $notes->_top = $a->_top;
            $notes->alto = $a->alto;
            $notes->ancho = $a->ancho;

            $notes->save();
        }

        if (isset($_POST["guardar"])) {

            if (!$notes->existe_nota($this->user->nick, $_POST["mensaje"])) {

                $notes->message = $_POST["mensaje"];
                if ($_POST["color"]=='5'){
                  $notes->color = $_POST["colorv"];
                }
                else{
                $notes->color = $_POST["color"];
                }                
                $notes->_left = 165;
                $notes->_top = 80;
                $notes->alto = 134;
                $notes->ancho = 134;
                if (isset($_POST["usuarios"])) {
                    if ($_POST["usuarios"] == "todos") {
                        $notes->message = "Nota escrita por: " . $this->user->nick . " en fecha : " . date("d-m-y") . " - " . date("H-i-s") . " " . $_POST["mensaje"];
                        $notes->username = $this->user->nick;
                        $notes->save();
                        foreach ($this->usuarios as $us) {
                            $notes->id = null;
                            if ($us->nick != $this->user->nick) {
                                $notes->username = $us->nick;
                                $notes->save();
                            }
                        }
                    } elseif ($_POST["usuarios"] == "Ninguno") {

                        $notes->username = $this->user->nick;
                        $notes->save();
                    } else {
                        $notes->message = "Nota escrita por: " . $this->user->nick . " en fecha : " . date("d-m-y") . " - " . date("H-i-s") . " " . $_POST["mensaje"];
                        $notes->username = $_POST["usuarios"];
                        $notes->save();
                    }
                }
            }
        }


        $this->resultados = $notes->get_username($this->user->nick);
    }
}
