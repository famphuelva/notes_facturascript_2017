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

class note extends fs_extended_model
{
    public $id;
    public $username;
    public $message;
    public $color;
    public $_left;
    public $_top;
    public $ancho;
    public $alto;
    
    public function __construct($data = FALSE)
    {
        parent::__construct('notes', $data); /// aquí indicamos el NOMBRE DE LA TABLA
    }

    public function model_class_name()
    {
        return 'note';
    }

    public function primary_column()
    {
        return 'id';
    }
    
    public function url($type='auto'){
        
        if($type === 'list'){
            return 'index.php?page=notes';
        }
        
        return  parent::url($type);
    }
    
    public function get_username($user)
    {
      return $this->parse($this->db->select("SELECT * FROM {$this->table_name} where username= '".$user ."'"), true);
    }
    public function existe_nota($user, $mensaje)
    {
      $data = $this->db->select("SELECT * FROM {$this->table_name} where username= '".$user ."' AND message = '".$mensaje."'");
      if($data)
      {
          return true;
      }
      
      return false;
    }
    
     public function parse($items, $array = false)
    {
        if (count($items) > 1 || $array) {
            $list = array();
            foreach ($items as $item) {
                $list[] = new note($item);
            }
            return $list;
        } else if (count($items) == 1) {
            return new note($items[0]);
        }
        return null;
    }
    
    public function get_todos_usuarios(){
        return $this->parse($this->db->select("SELECT * FROM fs_users"), true);
    }
}