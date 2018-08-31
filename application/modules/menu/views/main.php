<thead>
    <tr>
        <th>Sort</th>
        <th>Name</th>
        <th>Link</th>
        <th>Parent</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      if(!$value->parent)
        $value->parent = 0;
      print '
      <tr>
        <td>'.$value->sort.'</td>
        <td><a href="'.site_url("menu/child/".$value->id_menu).'">'.$value->name.'</a></td>
        <td>'.$value->link.'</td>
        <td>'.$value->ayah.'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("menu/add-new/{$value->parent}/".$value->id_menu).'">Edit</a></li>
              <li><a href="'.site_url("menu/child/".$value->id_menu).'">Child</a></li>
              <li><a href="'.site_url("menu/delete/".$value->id_menu).'">Delete</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>
<tfoot>
  <tr>
    <td>&nbsp</td>
  </tr>
</tfoot>