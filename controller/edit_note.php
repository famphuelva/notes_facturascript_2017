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

class edit_note extends fs_edit_controller
{

    public function __construct($name = __CLASS__, $title = 'note', $folder = 'note')
    {
        parent::__construct($name, $title, $folder);
    }

    public function get_model_class_name()
    {
        return 'note';
    }

    protected function set_edit_columns()
    {
        //$this->form->add_column('id','integer','Id');
        $usuarios = $this->sql_distinct('fs_users', 'nick');
        
        $this->form->add_column_select('username', $usuarios, 'Usuario', 3, true);
        
        //$this->form->add_column('username', 'string', 'Usuario');
        $this->form->add_column('message', 'string', 'Mensaje');
        $this->form->add_column('color', 'string', 'Color');
        $this->form->add_column('_left', 'string', 'Izquierda');
        $this->form->add_column('_top', 'string', 'Arriba');
    }
}
