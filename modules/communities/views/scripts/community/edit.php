<?php

echo '<h1>' . $this->PAGE->label . '</h1>';

echo '<center>';
echo '<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr>';
echo '<td><b>Nombre (*):</b></td>';
echo '<td>';
echo '<input type="text" name="label" size="15" maxlength="64" value="' . $this->community->label . '" />';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td><b>Modalidad (*):</b></td>';
echo '<td>' . $this->mode('mode', $this->community->mode) . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td><b>Avatar:</b></td>';
echo '<td>' . $this->formFile('file') . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td><b>Etiquetas (**):</b></td>';
echo '<td><input name="tags" value="' . $this->tags . '" maxlength="128" /></td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="2"><b>Descripción :</b></td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="2">';
echo '<textarea name="description" cols="50" rows="5">' . $this->community->description . '</textarea>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="2">(*) Campos obligatorios.</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="2">(**) Las etiquetas deben separarse con comas.</td>';
echo '</tr>';
echo '<tr>';
echo '<td>&nbsp;</td>';
echo '<td>';
echo '<input type="submit" value="Editar comunidad" /> ';
echo '<a href="' . $this->lastPage() . '">Cancelar</a>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</form>';
echo '</center>';
